# Orbitlink / Zivo API v1

The store-side integration is implemented. It reads catalogue products and public business policies only. It does not create orders, take payments, expose customer records or authenticate a customer account.

## URLs

This workstation's tested HTTPS base URL is:

```text
https://localhost/orbitlinksolutions/api/zivo/v1
```

| Purpose | Method and path |
| --- | --- |
| Product search | `GET /products?search=router&page=1&per_page=20` |
| Product detail | `GET /products/{id}` |
| Incremental synchronisation | `GET /products?updated_since=2026-09-28T10%3A00%3A00Z` |
| Business policies | `GET /store/policies` |

`localhost` is accessible on the store workstation; Zivo's hosted connector needs a deployed, publicly reachable HTTPS store URL. On a deployment at the root of a domain, the base is `https://YOUR_STORE_DOMAIN/api/zivo/v1`. This change has not been deployed to the public store.

Set `ZIVO_PUBLIC_URL` to the store's canonical HTTPS URL, including any installation subdirectory, to produce accurate product, image and pagination links. The API rejects insecure requests. `ZIVO_ALLOW_LOCAL_HTTP=true` is available only in the `local` or `testing` application environment. Production requires HTTPS even if that flag is set. When TLS terminates at a proxy, configure Laravel's trusted proxies for that deployment.

## Authentication and keys

Every request requires:

```http
Authorization: Bearer <API_KEY>
Accept: application/json
```

Keys contain 256 random bits; only SHA-256 hashes are stored in `zivo_api_keys`. A key belongs to the configured `ZIVO_STORE_ID` and cannot authenticate a user or grant access to other API routes. Keep the store ID stable and use different keys for different installations. This is a single-store application, not a multi-tenant API.

Provision a key on the target server:

```sh
php artisan zivo:key-create "Zivo connector" --days=30
```

The command displays the key once and its numeric ID. Supported expiry is 1–365 days. Share the secret through a password manager or another agreed secure channel. Never put it in a URL, source control, a public directory, a ticket or application logs.

Revoke immediately:

```sh
php artisan zivo:key-revoke KEY_ID
```

For rotation, issue a new key, update Zivo, verify requests, then revoke the previous key. A seven-day local test key was created during implementation; its secret is stored outside the repository and web root at `C:\Users\Administrator\.orbitlink\zivo-local-test-key.txt`. It is restricted to the local Windows account and SYSTEM. Provision a separate credential after deploying to production.

## Requests and response shapes

Examples use a `ZIVO_API_KEY` variable populated from secure storage; its value is not included here.

```sh
curl --get 'https://YOUR_STORE_DOMAIN/api/zivo/v1/products' \
  --header "Authorization: Bearer $ZIVO_API_KEY" \
  --header 'Accept: application/json' \
  --data-urlencode 'search=router' \
  --data-urlencode 'page=1' \
  --data-urlencode 'per_page=20'

curl 'https://YOUR_STORE_DOMAIN/api/zivo/v1/products/123' \
  --header "Authorization: Bearer $ZIVO_API_KEY"

curl --get 'https://YOUR_STORE_DOMAIN/api/zivo/v1/products' \
  --header "Authorization: Bearer $ZIVO_API_KEY" \
  --data-urlencode 'updated_since=2026-09-28T10:00:00Z'

curl 'https://YOUR_STORE_DOMAIN/api/zivo/v1/store/policies' \
  --header "Authorization: Bearer $ZIVO_API_KEY"
```

Product detail response (illustrative data):

```json
{
  "data": {
    "id": "123",
    "sku": "ROUTER-001",
    "name": "Example Router",
    "description": "Product description",
    "category": "Networking",
    "price": "6600.00",
    "currency": "KES",
    "tax_included": null,
    "availability": "in_stock",
    "stock_quantity": 12,
    "product_url": "https://YOUR_STORE_DOMAIN/product/example-router",
    "image_url": "https://YOUR_STORE_DOMAIN/images?path=products%2Fexample-router.jpg",
    "specifications": {"Ports": "8"},
    "variants": [
      {
        "id": "7",
        "sku": null,
        "options": {"size": "8 ports"},
        "price": null,
        "availability": null
      }
    ],
    "is_active": true,
    "updated_at": "2026-09-28T10:00:00Z",
    "deleted_at": null
  }
}
```

- IDs and prices are strings. Prices use two decimal places and public catalogue pricing; installer discounts are excluded. A hidden price (`has_price=false`) returns `null`. A known zero remains `"0.00"`.
- `description` is plain text. Specifications come from the store's structured additional information. An empty specifications object is `{}`; no variants is `[]`.
- `stock_quantity` uses `quantity`, matching the storefront's inventory helper; the separate legacy `stock` column is not substituted for an unknown quantity.
- Availability uses explicit `stock_status` when recognised, otherwise known quantity: zero is `out_of_stock`, 1–3 is `low_stock`, and larger values are `in_stock`. Explicit `preorder` and `available_on_request` are also supported. Unknown quantity/status returns `null`.
- `tax_included` stays `null` until an approved value is configured using `ZIVO_TAX_INCLUDED=true` or `false`.
- Existing size records have their own IDs and option names but no independent SKU, price or availability source. Those variant fields return `null`; the parent values are not invented as variant values. Populating independent variant values requires extending the catalogue's variant data model.
- Missing product images return `null`; category pictures or placeholders are not represented as product images.
- `is_active=false` or non-null `deleted_at` means the product must not be offered to customers. Lists and detail responses include inactive records and soft-deleted tombstones so a connector can remove stale entries.
- Only `product_type=product` is exported; custom design records are excluded.

List envelope (the `data` array contains the product objects described above):

```json
{
  "data": [],
  "meta": {
    "store_id": "orbitlinksolutions",
    "page": 1,
    "per_page": 20,
    "total": 0,
    "last_page": 1,
    "sync_until": "2026-09-28T10:00:00Z"
  },
  "links": {"next": null}
}
```

`search` searches name, SKU, description, brand and model; it accepts at most 200 characters. `%` and `_` are literal search characters. `page` starts at 1 (maximum 1,000,000), `per_page` defaults to 20 (maximum 100). Invalid parameters return 422 with an `errors` object. Unknown product IDs return 404. Non-read methods return 405. Errors always use JSON and do not include debug traces.

### Reliable synchronisation

1. Perform an initial unfiltered product scan. Save the first response's `meta.sync_until`.
2. Follow each `links.next` URL exactly until it is `null`. Continuation URLs carry `after_id`, `max_id` and `updated_until`, retaining the scan's upper timestamp and ID boundary. They use ascending IDs rather than shifting page offsets. Counts are informative and can change during concurrent edits; they are not a completion signal.
3. Only after every page succeeds, persist that scan's `sync_until` as the next `updated_since`.
4. Poll with `updated_since`, upsert by product ID and apply inactive/deletion flags. Timestamp comparisons are inclusive at second precision, so duplicate boundary rows are expected. Use ISO-8601 with `Z` or an explicit offset; URL-encode `+` offsets. `updated_until` is optional and must be at least `updated_since`.
5. On webhooks, fetch the latest detail instead of assuming notification delivery order reflects update order. A 404 means remove that ID. Soft deletions return inactive tombstones instead.
6. Periodically perform a full reconciliation. Hard deletions and records changed to a non-catalogue type are announced by webhook but cannot remain in the normal product list. Do not remove local entries until a full scan completes successfully; recheck missing IDs before removal during concurrent changes.

Related size, image, category and specification edits update product timestamps. The scan is not a database snapshot; items edited beyond its upper boundary are caught by the next incremental scan.

## Store policies

```json
{
  "data": {
    "delivery_areas": ["Kenya"],
    "delivery_pricing_rules": [
      {
        "service": "delivery",
        "amount": null,
        "currency": "KES",
        "requires_quotation": true,
        "description": "Contact support for a delivery quotation for your destination and items."
      }
    ],
    "payment_methods": null,
    "warranty": null,
    "returns_policy": null,
    "business_hours": null,
    "timezone": "Africa/Nairobi",
    "store_id": "orbitlinksolutions",
    "support_contacts": {
      "phone": null,
      "whatsapp": null,
      "email": null,
      "address": null
    }
  }
}
```

Contacts are populated from the existing public contact options. The example uses nulls for illustration. Edit `config/zivo-policies.php` with approved payment methods, warranty/returns terms and opening hours. Unknown fields deliberately remain `null`; the AI must not interpret them as free delivery, no warranty, no returns, or 24-hour service. Keep charges needing a quotation explicitly flagged. Rebuild configuration cache after changing policies.

## Rate limits

Default: 60 requests per minute shared by all Zivo keys for this store, configured with `ZIVO_RATE_LIMIT`. The application's existing API limit of 60/minute per IP also applies. Responses expose `X-RateLimit-Limit` and `X-RateLimit-Remaining`; a 429 response supplies `Retry-After`. Back off accordingly. Responses use `Cache-Control: private, no-store`.

## Webhooks

Outbound delivery is disabled by default. Zivo's connector and webhook receiver must still be built. The Connected Apps URL field alone does not perform synchronisation. The following signature protocol is implemented on the store side and must be agreed with Zivo before enabling delivery; no receiving URL has been assumed.

Configure the target deployment:

```dotenv
ZIVO_STORE_ID=orbitlinksolutions
ZIVO_PUBLIC_URL=https://YOUR_STORE_DOMAIN
ZIVO_WEBHOOKS_ENABLED=true
ZIVO_WEBHOOK_URL=https://ZIVO_RECEIVER_HOST/EXACT_RECEIVER_PATH
ZIVO_WEBHOOK_SECRET=<shared-random-secret-of-at-least-32-characters>
```

Secrets must be provisioned securely at both ends. Run:

```sh
php artisan config:cache
php artisan zivo:webhooks-deliver
```

Laravel's scheduler invokes delivery every minute. On a production server, run `php artisan schedule:run` every minute through cron or the platform scheduler. For a local foreground worker use `php artisan schedule:work`. A normal queue worker is not required: deliveries use the durable `zivo_webhook_events` outbox, including when `QUEUE_CONNECTION=sync`.

Events are recorded for `product.created`, `product.updated`, `product.deleted` and `inventory.updated`. An inventory edit emits both product and inventory notifications. Each event has a distinct UUID; attempts to deliver the same event preserve that UUID and the exact body bytes.

```json
{
  "event_id": "57f70eca-a124-4e37-86c2-f32fa6c3d203",
  "store_id": "orbitlinksolutions",
  "type": "inventory.updated",
  "product_id": "123",
  "timestamp": "2026-09-28T10:00:00Z"
}
```

Request headers:

```http
Content-Type: application/json
X-Zivo-Event-Id: 57f70eca-a124-4e37-86c2-f32fa6c3d203
X-Zivo-Timestamp: <Unix timestamp in seconds for this attempt>
X-Zivo-Signature: sha256=<lowercase hexadecimal HMAC>
```

Compute the HMAC-SHA256 over the ASCII timestamp header, a literal period, then the **exact raw HTTP request body**, using the shared secret:

```php
$expected = 'sha256=' . hash_hmac('sha256', $timestamp . '.' . $rawBody, $sharedSecret);
$valid = hash_equals($expected, $signatureHeader);
```

Zivo should validate a timestamp tolerance such as five minutes with synchronised clocks, verify the signature before parsing/trusting the event, check the expected store ID, and deduplicate authenticated event IDs. Do not re-encode JSON before verification. The event's body timestamp is its creation time; the header timestamp changes on retries. Return a 2xx response after accepting a valid event durably, including an already accepted duplicate.

All non-2xx results, connection errors and timeouts retry. Redirects are not followed. Delivery uses HTTPS with normal certificate verification, a 5-second connection timeout and a 15-second overall timeout. There are at most eight attempts, with delays of 60, 300, 900, 3,600, 10,800, 21,600 and 43,200 seconds. Scheduler frequency can increase these delays. A worker crash releases its lease after two minutes, allowing at-least-once redelivery.

Exhausted events remain in the outbox with `failed_at`, `attempts` and a sanitised `last_error`. Inspect the outbox and scheduler failures operationally. After fixing a receiver issue, replay exhausted events with the same event IDs:

```sh
php artisan zivo:webhooks-deliver --retry-failed --limit=100
```

With webhooks enabled, model save/delete operations and outbox writes share a transaction. Related catalogue model edits and category deletion cascades are covered. Bulk SQL updates/deletes, imports that bypass Eloquent events, `saveQuietly`, and external database writers bypass this tracking: import through model save/delete operations inside a database transaction, or explicitly record corresponding outbox events and update product timestamps. Events are not retained for changes made while `ZIVO_WEBHOOKS_ENABLED=false`; run an initial/full sync when enabling it.

## Deployment and validation

Apply the new migration on the target database:

```sh
php artisan migrate --path=database/migrations/2026_09_28_000001_create_zivo_integration_tables.php --force
```

The integration uses existing product, size, media and options tables. The local migration was applied without running unrelated pending migrations. Deploy the changed PHP files, set the canonical URL and verified policy values, issue a production key, and configure the scheduler/receiver when Zivo is ready. Do not copy the local HTTP exception or local test key into production.

Validation commands:

```sh
php artisan test --filter=ZivoIntegrationTest
php artisan test
```

The integration tests use isolated in-memory SQLite and fake outbound HTTP; they never send to a real webhook receiver. Local HTTPS smoke checks also verified authenticated search, detail, incremental synchronisation and policy responses against the existing MySQL catalogue.
