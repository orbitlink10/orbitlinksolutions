<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\FootballCouponEntitlement;
use App\Models\FootballMatch;
use App\Models\FootballPrediction;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CouponService;
use App\Services\FootballPromotionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CouponFootballFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_login_and_cannot_view_another_customers_order(): void
    {
        $this->post('/register', [
            'name' => 'Buyer One',
            'email' => 'buyer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'buyer@example.com',
            'user_type' => 'buyer',
        ]);

        auth()->logout();

        $this->post('/login', [
            'email' => 'buyer@example.com',
            'password' => 'password',
        ])->assertRedirect('/account/dashboard');

        $owner = User::factory()->create(['user_type' => 'buyer']);
        $otherCustomer = User::factory()->create(['user_type' => 'buyer']);
        $order = $this->orderFor($owner);

        $this->actingAs($otherCustomer)
            ->get(route('account.orders.show', $order))
            ->assertForbidden();
    }

    public function test_admin_can_create_coupon_and_coupon_rules_are_enforced(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.coupons.store'), [
                'code' => ' save1000 ',
                'description' => 'Save KES 1,000',
                'discount_type' => Coupon::TYPE_FIXED,
                'discount_value' => 1000,
                'usage_limit' => 1,
                'is_active' => 1,
            ])
            ->assertRedirect();

        $coupon = Coupon::firstOrFail();
        $this->assertSame('SAVE1000', $coupon->code);

        $service = app(CouponService::class);
        $customer = User::factory()->create(['user_type' => 'buyer']);
        $order = $this->orderFor($customer, 500);

        $redemption = $service->redeemForOrder('save1000', $customer, $order, 500);

        $this->assertSame(500.0, $redemption['discount_amount']);
        $this->assertSame(0.0, (float) $order->fresh()->total_amount);

        $this->expectException(ValidationException::class);
        $service->quote('SAVE1000', User::factory()->create(['user_type' => 'buyer']), 1000);
    }

    public function test_checkout_recalculates_coupon_totals_server_side(): void
    {
        $customer = User::factory()->create(['user_type' => 'buyer']);
        $product = $this->product(25000);

        Coupon::create([
            'code' => 'MANU10',
            'description' => '10% discount promotion',
            'discount_type' => Coupon::TYPE_PERCENTAGE,
            'discount_value' => 10,
            'is_active' => true,
            'usage_limit' => 1,
            'source' => Coupon::SOURCE_MANUAL,
            'created_by' => $customer->id,
        ]);

        $this->actingAs($customer)
            ->withSession([
                'coupon_code' => 'MANU10',
                'cart' => [
                    $product->id => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'quantity' => 1,
                        'price' => 1,
                        'size_id' => null,
                        'photo' => null,
                    ],
                ],
            ])
            ->post(route('store_order'), [
                'address' => 'Nairobi CBD',
                'subtotal' => 1,
                'total' => 1,
            ])
            ->assertRedirect();

        $order = Order::firstOrFail();

        $this->assertSame(25000.0, (float) $order->subtotal_before_discount);
        $this->assertSame(2500.0, (float) $order->discount_amount);
        $this->assertSame(22500.0, (float) $order->total_amount);
    }

    public function test_admin_can_create_match_publish_result_and_generate_winner_entitlements(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.football-matches.store'), [
                'home_team' => 'Manchester United',
                'away_team' => 'Arsenal',
                'home_abbreviation' => 'MA',
                'away_abbreviation' => 'AR',
                'competition' => 'Premier League',
                'match_date' => now()->addDay()->toDateString(),
                'kickoff_time' => '18:30',
                'prediction_closes_at' => now()->addHours(12)->format('Y-m-d\TH:i'),
                'status' => FootballMatch::STATUS_UPCOMING,
                'is_published' => 1,
                'coupon_discount_type' => Coupon::TYPE_PERCENTAGE,
                'coupon_discount_value' => 10,
                'coupon_description' => 'Correct Score Weekend Promotion',
            ])
            ->assertRedirect();

        $match = FootballMatch::firstOrFail();
        $winner = User::factory()->create(['user_type' => 'buyer']);
        $loser = User::factory()->create(['user_type' => 'buyer']);

        FootballPrediction::create([
            'football_match_id' => $match->id,
            'user_id' => $winner->id,
            'home_score' => 2,
            'away_score' => 0,
        ]);
        FootballPrediction::create([
            'football_match_id' => $match->id,
            'user_id' => $loser->id,
            'home_score' => 2,
            'away_score' => 1,
        ]);

        $result = app(FootballPromotionService::class)->publishResult($match, 2, 0, $admin);

        $this->assertSame('MA2AR0', $result['code']);
        $this->assertSame(1, $result['winners_count']);
        $this->assertDatabaseHas('football_predictions', [
            'user_id' => $winner->id,
            'status' => FootballPrediction::STATUS_CORRECT,
        ]);
        $this->assertDatabaseHas('football_predictions', [
            'user_id' => $loser->id,
            'status' => FootballPrediction::STATUS_INCORRECT,
        ]);
        $this->assertDatabaseHas('football_coupon_entitlements', [
            'user_id' => $winner->id,
            'coupon_id' => $result['coupon']->id,
        ]);
        $this->assertDatabaseMissing('football_coupon_entitlements', [
            'user_id' => $loser->id,
            'coupon_id' => $result['coupon']->id,
        ]);
    }

    public function test_football_coupon_requires_winning_entitlement_and_can_only_be_redeemed_once(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        $winner = User::factory()->create(['user_type' => 'buyer']);
        $loser = User::factory()->create(['user_type' => 'buyer']);
        $match = FootballMatch::create([
            'home_team' => 'Manchester United',
            'away_team' => 'Arsenal',
            'home_abbreviation' => 'MA',
            'away_abbreviation' => 'AR',
            'competition' => 'Premier League',
            'match_date' => now()->addDay()->toDateString(),
            'kickoff_time' => '18:30',
            'prediction_closes_at' => now()->addHours(12),
            'status' => FootballMatch::STATUS_UPCOMING,
            'is_published' => true,
            'coupon_discount_type' => Coupon::TYPE_PERCENTAGE,
            'coupon_discount_value' => 10,
            'created_by' => $admin->id,
        ]);

        $coupon = Coupon::create([
            'code' => 'MA2AR0',
            'description' => 'Correct Score Weekend Promotion',
            'discount_type' => Coupon::TYPE_PERCENTAGE,
            'discount_value' => 10,
            'is_active' => true,
            'usage_limit' => null,
            'source' => Coupon::SOURCE_FOOTBALL,
            'football_match_id' => $match->id,
            'created_by' => $admin->id,
        ]);

        FootballCouponEntitlement::create([
            'football_match_id' => $match->id,
            'coupon_id' => $coupon->id,
            'user_id' => $winner->id,
        ]);

        $service = app(CouponService::class);

        $this->expectException(ValidationException::class);
        $service->quote('MA2AR0', $loser, 1000);
    }

    public function test_winning_customer_cannot_redeem_football_coupon_twice(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        $winner = User::factory()->create(['user_type' => 'buyer']);
        $match = FootballMatch::create([
            'home_team' => 'Chelsea',
            'away_team' => 'Liverpool',
            'home_abbreviation' => 'CH',
            'away_abbreviation' => 'LI',
            'competition' => 'Premier League',
            'match_date' => now()->addDay()->toDateString(),
            'kickoff_time' => '18:30',
            'prediction_closes_at' => now()->addHours(12),
            'status' => FootballMatch::STATUS_UPCOMING,
            'is_published' => true,
            'coupon_discount_type' => Coupon::TYPE_FIXED,
            'coupon_discount_value' => 1000,
            'created_by' => $admin->id,
        ]);
        $coupon = Coupon::create([
            'code' => 'CH1LI3',
            'description' => 'Correct Score Reward',
            'discount_type' => Coupon::TYPE_FIXED,
            'discount_value' => 1000,
            'is_active' => true,
            'usage_limit' => null,
            'source' => Coupon::SOURCE_FOOTBALL,
            'football_match_id' => $match->id,
            'created_by' => $admin->id,
        ]);
        FootballCouponEntitlement::create([
            'football_match_id' => $match->id,
            'coupon_id' => $coupon->id,
            'user_id' => $winner->id,
        ]);

        $service = app(CouponService::class);
        $service->redeemForOrder('ch1li3', $winner, $this->orderFor($winner, 5000), 5000);

        $this->assertDatabaseHas('football_coupon_entitlements', [
            'user_id' => $winner->id,
            'coupon_id' => $coupon->id,
            'order_id' => Order::latest('id')->first()->id,
        ]);

        $this->expectException(ValidationException::class);
        $service->redeemForOrder('CH1LI3', $winner, $this->orderFor($winner, 5000), 5000);
    }

    private function orderFor(User $user, float $amount = 1000): Order
    {
        $product = $this->product($amount);

        return Order::create([
            'order_reference' => 'ORD-' . uniqid(),
            'customer_first_name' => 'Test',
            'customer_last_name' => 'Customer',
            'customer_email' => $user->email,
            'customer_phone' => $user->phone ?: '',
            'user_id' => $user->id,
            'shipping_address' => 'Nairobi',
            'subtotal' => $amount,
            'shipping_cost' => 0,
            'total_amount' => $amount,
            'product_id' => $product->id,
            'status' => 'pending',
        ]);
    }

    private function product(float $price = 1000): Product
    {
        $category = Category::create(['name' => 'Networking']);

        return Product::create([
            'name' => 'Router ' . uniqid(),
            'sku' => 'SKU-' . uniqid(),
            'price' => $price,
            'discount' => 0,
            'quantity' => 10,
            'photo' => null,
            'slug' => 'router-' . uniqid(),
            'description' => 'Networking equipment',
            'category_id' => $category->id,
            'sub_category_id' => null,
            'stock' => 10,
            'is_active' => true,
            'product_type' => 'product',
        ]);
    }
}
