<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Media;
use App\Models\Option;
use App\Models\Product;
use App\Models\Size;
use App\Models\ZivoApiKey;
use App\Models\ZivoWebhookEvent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ZivoIntegrationTest extends TestCase
{
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        config([
            'zivo.public_url' => 'https://store.example',
            'zivo.store_id' => 'orbitlink-test',
            'zivo.allow_local_http' => false,
            'zivo.webhooks.enabled' => false,
            'zivo.webhooks.url' => 'https://receiver.example/zivo',
            'zivo.webhooks.secret' => str_repeat('s', 64),
        ]);
        Http::preventStrayRequests();
        $this->travelTo(now()->setDate(2026, 9, 28)->setTime(10, 0, 0));

        // Run the real catalogue/integration migrations; legacy options has no migration.
        $files = [
            '2023_06_27_062914_create_categories_table.php',
            '2023_06_27_062914_create_sub_categories_table.php',
            '2024_08_21_182236_create_products_table.php',
            '2024_11_22_100128_create_medias_table.php',
            '2024_11_22_162325_add_media_type_to_media_table.php',
            '2024_12_05_142648_add_product_id_to_media_table.php',
            '2024_12_05_151150_add_has_price_to_products_table.php',
            '2025_01_10_065059_add_marked_price_to_products_table.php',
            '2025_02_13_102817_add_product_type_to_products_table.php',
            '2025_02_17_051521_create_sizes_table.php',
            '2026_08_25_000002_add_trade_fields_to_products_table.php',
            '2026_09_28_000001_create_zivo_integration_tables.php',
        ];
        $this->artisan('migrate', [
            '--path' => array_map(fn ($file) => database_path('migrations/'.$file), $files),
            '--realpath' => true,
            '--force' => true,
        ])->assertSuccessful();
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('option_key')->unique();
            $table->text('option_value')->nullable();
        });
        $this->token = 'zivo_'.str_repeat('a', 64);
        ZivoApiKey::create([
            'name' => 'test', 'store_id' => config('zivo.store_id'),
            'key_hash' => hash('sha256', $this->token), 'expires_at' => now()->addDay(),
        ]);
    }

    protected function tearDown(): void
    {
        $this->travelBack();
        parent::tearDown();
    }

    public function test_requires_valid_unexpired_unrevoked_store_key(): void
    {
        $this->getJson($this->url())->assertUnauthorized();
        $this->withToken('invalid')->getJson($this->url())->assertUnauthorized();
        $this->withToken($this->token)->getJson($this->url())->assertOk();
        $key = ZivoApiKey::first();
        $key->update(['expires_at' => now()->subSecond()]);
        $this->getJson($this->url())->assertUnauthorized();
        $key->update(['expires_at' => null, 'revoked_at' => now()]);
        $this->getJson($this->url())->assertUnauthorized();
        $key->update(['revoked_at' => null, 'store_id' => 'other-store']);
        $this->getJson($this->url())->assertUnauthorized();
    }

    public function test_requires_https_and_exposes_only_read_routes(): void
    {
        $this->withToken($this->token)->getJson('http://store.example/api/zivo/v1/products')->assertForbidden();
        $this->postJson($this->url(), ['name' => 'Injected'])->assertStatus(405);
        $this->deleteJson($this->url('/products/1'))->assertStatus(405);
        $this->get($this->url('/products/999'))->assertNotFound()->assertJson(['message' => 'Not Found']);
        $this->getJson($this->url('/orders'))->assertNotFound();
        $this->assertGuest();
        $this->assertSame(0, Product::count());
    }

    public function test_returns_public_product_schema_with_specs_and_real_urls(): void
    {
        $product = $this->product(['quantity' => 12, 'photo' => 'https://cdn.example/router.jpg']);
        save_product_additional_information($product->id, 'Ports: 8');
        $response = $this->withToken($this->token)->getJson($this->url('/products/'.$product->id));
        $response->assertOk()->assertJsonPath('data.id', (string) $product->id)
            ->assertJsonPath('data.sku', $product->sku)
            ->assertJsonPath('data.price', '6600.00')->assertJsonPath('data.currency', 'KES')
            ->assertJsonPath('data.description', "Example router\nEight ports")
            ->assertJsonPath('data.tax_included', null)->assertJsonPath('data.availability', 'in_stock')
            ->assertJsonPath('data.stock_quantity', 12)->assertJsonPath('data.category', 'Networking')
            ->assertJsonPath('data.specifications.Ports', '8')
            ->assertJsonPath('data.product_url', 'https://store.example/product/'.$product->slug)
            ->assertJsonPath('data.image_url', 'https://cdn.example/router.jpg')
            ->assertJsonPath('data.updated_at', '2026-09-28T10:00:00Z')
            ->assertJsonPath('data.is_active', true)->assertJsonPath('data.deleted_at', null);
        $this->assertArrayNotHasKey('installer_price', $response->json('data'));
        $this->assertArrayNotHasKey('user_id', $response->json('data'));
        $this->assertTrue($response->headers->hasCacheControlDirective('no-store'));
    }

    public function test_unknown_values_are_not_zero_or_invented_variant_values(): void
    {
        $product = $this->product(['has_price' => false, 'quantity' => null, 'stock' => 0]);
        $size = Size::create(['product_id' => $product->id, 'name' => '8 ports']);
        $response = $this->withToken($this->token)->getJson($this->url('/products/'.$product->id));
        $response->assertOk()->assertJsonPath('data.price', null)
            ->assertJsonPath('data.stock_quantity', null)->assertJsonPath('data.availability', null)
            ->assertJsonPath('data.image_url', null)->assertJsonPath('data.variants.0.id', (string) $size->id)
            ->assertJsonPath('data.variants.0.sku', null)->assertJsonPath('data.variants.0.price', null)
            ->assertJsonPath('data.variants.0.availability', null)
            ->assertJsonPath('data.variants.0.options.size', '8 ports');
        $this->assertStringContainsString('"specifications":{}', $response->getContent());
        $product->update(['has_price' => true, 'price' => 0, 'quantity' => 0]);
        $this->getJson($this->url('/products/'.$product->id))
            ->assertJsonPath('data.price', '0.00')->assertJsonPath('data.stock_quantity', 0)
            ->assertJsonPath('data.availability', 'out_of_stock');
    }

    public function test_search_pagination_and_non_catalogue_exclusion(): void
    {
        $first = $this->product(['name' => 'Router One', 'sku' => 'ROUTER-001']);
        $this->product(['name' => 'Router Two']);
        $this->product(['name' => 'Custom Router', 'product_type' => 'design']);
        $this->withToken($this->token)->getJson($this->url().'?search=router&per_page=1&page=1')
            ->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('meta.total', 2)
            ->assertJsonPath('meta.last_page', 2)->assertJsonPath('data.0.id', (string) $first->id);
        $this->getJson($this->url().'?search=ROUTER-001')->assertJsonCount(1, 'data');
        $this->getJson($this->url().'?search=%25')->assertJsonCount(0, 'data');
        $this->getJson($this->url().'?page=2&per_page=1')->assertJsonPath('meta.page', 2)->assertJsonCount(1, 'data');
    }

    public function test_incremental_window_and_cursor_do_not_skip_unmodified_rows(): void
    {
        $first = $this->product();
        $second = $this->product();
        $third = $this->product();
        $response = $this->withToken($this->token)->getJson($this->url().'?per_page=1');
        $response->assertOk()->assertJsonPath('data.0.id', (string) $first->id);
        $next = $response->json('links.next');
        $this->travel(10)->seconds();
        $first->update(['price' => 7000]);
        $second->update(['price' => 7100]);
        $this->getJson($next)->assertOk()->assertJsonPath('data.0.id', (string) $third->id)
            ->assertJsonPath('links.next', null);
        $this->getJson($this->url().'?updated_since=2026-09-28T13%3A00%3A09%2B03%3A00')
            ->assertOk()->assertJsonCount(2, 'data');
        $this->getJson($this->url().'?updated_since=2026-09-28T10%3A00%3A10Z')
            ->assertJsonCount(2, 'data');
    }

    public function test_rejects_invalid_parameters_with_json_errors(): void
    {
        $this->withToken($this->token);
        foreach (['page=0', 'per_page=101', 'search[]=router', 'updated_since=yesterday',
            'updated_since=2026-02-30T10:00:00Z', 'updated_since=2026-09-28T10:00:00',
            'updated_since=2027-09-28T10:00:00Z', 'after_id=-1'] as $query) {
            $this->getJson($this->url().'?'.$query)->assertUnprocessable()->assertJsonStructure(['errors']);
        }
    }

    public function test_deleted_and_inactive_products_can_be_removed_by_sync(): void
    {
        $product = $this->product();
        $this->travel(2)->seconds();
        $product->delete();
        $this->withToken($this->token)->getJson($this->url().'?updated_since=2026-09-28T10:00:01Z')
            ->assertJsonCount(1, 'data')->assertJsonPath('data.0.is_active', false)
            ->assertJsonPath('data.0.deleted_at', '2026-09-28T10:00:02Z');
        $product->restore();
        $product->update(['is_active' => false]);
        $this->getJson($this->url('/products/'.$product->id))
            ->assertJsonPath('data.is_active', false)->assertJsonPath('data.deleted_at', null);
    }

    public function test_policies_use_public_contacts_and_mark_quote_required_charges(): void
    {
        Option::create(['option_key' => 'contact_email', 'option_value' => 'support@example.test']);
        Option::create(['option_key' => 'private_setting', 'option_value' => 'never-expose']);
        $this->withToken($this->token)->getJson($this->url('/store/policies'))
            ->assertOk()->assertJsonPath('data.support_contacts.email', 'support@example.test')
            ->assertJsonPath('data.support_contacts.phone', null)
            ->assertJsonPath('data.delivery_pricing_rules.0.requires_quotation', true)
            ->assertJsonPath('data.delivery_pricing_rules.0.amount', null)
            ->assertJsonPath('data.warranty', null)->assertDontSee('never-expose');
    }

    public function test_rate_limit_returns_retry_after_and_recovers(): void
    {
        config(['zivo.rate_limit' => 2]);
        $this->withToken($this->token)->getJson($this->url())->assertOk();
        $this->getJson($this->url())->assertOk();
        $this->getJson($this->url())->assertStatus(429)->assertHeader('Retry-After');
        $this->travel(61)->seconds();
        $this->getJson($this->url())->assertOk();
    }

    public function test_key_commands_store_only_hashes_and_revoke_immediately(): void
    {
        $this->app->offsetUnset(\Illuminate\Console\OutputStyle::class);
        $buffer = new \Symfony\Component\Console\Output\BufferedOutput;
        Artisan::call('zivo:key-create', ['name' => 'Connector test', '--days' => 7], $buffer);
        preg_match('/zivo_[a-f0-9]{64}/', $buffer->fetch(), $match);
        $key = ZivoApiKey::where('name', 'Connector test')->firstOrFail();
        $this->assertSame(hash('sha256', $match[0]), $key->key_hash);
        $this->assertStringNotContainsString($match[0], $key->toJson());
        $this->withToken($match[0])->getJson($this->url())->assertOk();
        $this->artisan('zivo:key-revoke', ['id' => $key->id])->assertSuccessful();
        $this->getJson($this->url())->assertUnauthorized();
    }

    public function test_product_events_are_persistent_transactional_and_never_send_inline(): void
    {
        config(['zivo.webhooks.enabled' => true]);
        Http::fake();
        $product = $this->product();
        $product->update(['quantity' => 5]);
        $product->delete();
        $this->assertSame(['product.created', 'product.updated', 'inventory.updated', 'product.deleted'],
            ZivoWebhookEvent::orderBy('created_at')->get()->pluck('type')->all());
        $count = ZivoWebhookEvent::count();
        DB::beginTransaction();
        $rolledBack = $this->product();
        DB::rollBack();
        $this->assertSame($count, ZivoWebhookEvent::count());
        $this->assertNull(Product::find($rolledBack->id));
        Http::assertNothingSent();
    }

    public function test_related_changes_emit_events_even_within_the_same_second(): void
    {
        config(['zivo.webhooks.enabled' => true]);
        $product = $this->product();
        $size = Size::create(['product_id' => $product->id, 'name' => 'Large']);
        $size->update(['name' => 'Small']);
        $size->delete();
        save_product_additional_information($product->id, 'Ports: 8');
        save_product_additional_information($product->id, null);
        Media::create(['product_id' => $product->id, 'name' => 'Router', 'file_path' => 'router.jpg']);
        $product->category->update(['name' => 'Routers']);
        $this->assertSame(7, ZivoWebhookEvent::where('type', 'product.updated')->count());
        $this->travel(5)->seconds();
        $size = Size::create(['product_id' => $product->id, 'name' => 'New']);
        $this->withToken($this->token)->getJson($this->url().'?updated_since=2026-09-28T10:00:05Z')
            ->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_category_cascade_emits_deletions(): void
    {
        config(['zivo.webhooks.enabled' => true]);
        $product = $this->product();
        $product->category->delete();
        $this->assertNull(Product::withTrashed()->find($product->id));
        $this->assertSame(1, ZivoWebhookEvent::where('type', 'product.deleted')->count());
    }

    public function test_signed_delivery_retries_identical_event_payload_after_backoff(): void
    {
        config(['zivo.webhooks.enabled' => true]);
        $this->product();
        Http::fake(['receiver.example/*' => Http::sequence()->push('failure', 503)->push('', 204)]);
        $this->artisan('zivo:webhooks-deliver')->assertFailed();
        $event = ZivoWebhookEvent::firstOrFail();
        $this->assertSame(1, $event->attempts);
        $this->assertNull($event->delivered_at);
        $this->artisan('zivo:webhooks-deliver')->assertSuccessful();
        Http::assertSentCount(1);
        $this->travel(61)->seconds();
        $this->artisan('zivo:webhooks-deliver')->assertSuccessful();
        Http::assertSentCount(2);
        $this->assertNotNull($event->fresh()->delivered_at);
        foreach (Http::recorded() as [$request, $response]) {
            $this->assertSame($event->payload, $request->body());
            $timestamp = $request->header('X-Zivo-Timestamp')[0];
            $this->assertSame('sha256='.hash_hmac('sha256', $timestamp.'.'.$event->payload, str_repeat('s', 64)),
                $request->header('X-Zivo-Signature')[0]);
            $this->assertSame($event->id, $request->header('X-Zivo-Event-Id')[0]);
        }
    }

    public function test_failed_delivery_exhaustion_and_manual_replay_keep_event_id(): void
    {
        config(['zivo.webhooks.enabled' => true, 'zivo.webhooks.max_attempts' => 2]);
        $this->product();
        Http::fake(['receiver.example/*' => Http::sequence()->push('', 500)->push('', 500)->push('', 200)]);
        $this->artisan('zivo:webhooks-deliver')->assertFailed();
        $this->travel(61)->seconds();
        $this->artisan('zivo:webhooks-deliver')->assertFailed();
        $event = ZivoWebhookEvent::firstOrFail();
        $this->assertNotNull($event->failed_at);
        $this->travel(3600)->seconds();
        $this->artisan('zivo:webhooks-deliver')->assertSuccessful();
        Http::assertSentCount(2);
        $this->artisan('zivo:webhooks-deliver', ['--retry-failed' => true])->assertSuccessful();
        $this->assertNotNull($event->fresh()->delivered_at);
        $this->assertSame(1, ZivoWebhookEvent::count());
    }

    public function test_disabled_or_insecure_webhooks_do_not_send(): void
    {
        Http::fake();
        $this->product();
        $this->assertSame(0, ZivoWebhookEvent::count());
        $this->artisan('zivo:webhooks-deliver')->assertSuccessful();
        config(['zivo.webhooks.enabled' => true, 'zivo.webhooks.url' => 'http://receiver.example/zivo']);
        $this->product();
        $this->artisan('zivo:webhooks-deliver')->assertFailed();
        $this->assertSame(0, ZivoWebhookEvent::first()->attempts);
        Http::assertNothingSent();
    }

    private function product(array $overrides = []): Product
    {
        $category = Category::firstOrCreate(['name' => 'Networking']);
        $product = (new Product)->forceFill(array_merge([
            'name' => 'Example Router', 'sku' => 'ROUTER-'.uniqid(), 'slug' => 'router-'.uniqid(),
            'description' => '<p>Example router</p><p>Eight ports</p>',
            'price' => 6600, 'has_price' => true, 'quantity' => 12, 'category_id' => $category->id,
            'is_active' => true, 'product_type' => 'product',
        ], $overrides));
        $product->save();

        return $product;
    }

    private function url(string $path = '/products'): string
    {
        return 'https://store.example/api/zivo/v1'.$path;
    }
}
