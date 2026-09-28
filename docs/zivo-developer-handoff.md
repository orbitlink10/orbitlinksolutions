# Build a store integration API for Zivo WhatsApp AI

Status: original proposed contract, retained for reference. The store-side API is now implemented; see [implementation and API documentation](zivo-api.md). Zivo's matching connector and receiver remain a separate dependency.

We need Zivo to retrieve accurate product information before answering customers. Please implement the following in the Orbitlink Solutions store.

## 1. Secure API access

- HTTPS base URL, such as `https://yourstore.com/api/zivo/v1`.
- Authentication using `Authorization: Bearer <API_KEY>`.
- A dedicated, revocable, read-only key restricted to our store.

## 2. Product endpoints

- `GET /products?search=router&page=1&per_page=20`
- `GET /products/{id}`
- `GET /products?updated_since=<ISO-8601 timestamp>` for synchronisation.

Each product must return:

```json
{
  "id": "123",
  "sku": "ROUTER-001",
  "name": "Example Router",
  "description": "Product description",
  "category": "Networking",
  "price": "6600.00",
  "currency": "KES",
  "tax_included": true,
  "availability": "in_stock",
  "stock_quantity": 12,
  "product_url": "https://yourstore.com/products/example-router",
  "image_url": "https://yourstore.com/images/example-router.jpg",
  "specifications": {},
  "variants": [],
  "is_active": true,
  "updated_at": "2026-09-28T10:00:00Z"
}
```

Values and URLs above are illustrative, not verified store data. Variants must include their own ID, SKU, options, price and availability. Return unknown values as `null`, not zero. Include pagination details in list responses.

## 3. Business information

Implement `GET /store/policies` returning delivery areas, delivery pricing rules, payment methods, warranty, returns policy, business hours and support contacts. Clearly identify charges that require a quotation.

## 4. Update webhooks

Send Zivo notifications for:

- `product.created`
- `product.updated`
- `product.deleted`
- `inventory.updated`

Include a unique event ID, store ID, product ID and timestamp. Sign each request using HMAC-SHA256 with a shared secret. Retry failed deliveries with backoff; Zivo will ignore duplicate event IDs.

## 5. Deliverables

Provide API documentation or an OpenAPI file, sample requests/responses, a test credential, rate limits, and instructions for configuring the webhook destination. Share credentials securely.

**Scope:** Product and policy reading only. Order creation, payments and customer records are excluded from this first integration.

## Zivo dependency

This is the proposed contract. The Zivo team still needs to implement the matching connector and webhook receiver, then provide the exact receiving URL and signature format. The existing Connected Apps URL field alone does not perform product synchronisation.

Before enabling webhook deliveries, both teams must agree on the header names, exact bytes to sign, timestamp/replay checks and secret provisioning. No receiving URL or final signature format is supplied by this brief.

## Notes for the Orbitlink developer

These notes are based on the current repository and identify mapping decisions for implementation:

- The project uses Laravel 10 and registers API routes in `routes/api.php` under `/api`. The requested Zivo routes are not currently defined there.
- `app/Models/Product.php` already exposes product identity, prices, stock fields, category, sizes and media relationships. Use an explicit response schema to keep internal fields out of this API.
- The storefront stock helper in `app/helpers/helper.php` uses `stock_status`, then `quantity`. There is also a separate `stock` database column; confirm the inventory source before mapping `stock_quantity`. A missing quantity must stay `null`.
- `has_price` controls whether the storefront displays a price. Products requiring a quotation should not expose a misleading zero price. Confirm tax treatment before populating `tax_included`.
- `app/Models/Size.php` and the sizes migration currently store a variant's product ID and name, but no separate SKU, price or inventory. Add a reliable source for those values or return `null` for unknown fields; do not fabricate them from the parent product.
- Structured additional information is stored through `product_additional_information()` in `app/helpers/helper.php`. Review it as a source for `specifications`.
- The public product route is named `product_details` and uses `/product/{slug}`. Generate canonical links from that route instead of copying the example URL above.
- Public support contact options include `contact_phone`, `whatsapp_phone`, `contact_email` and `address`. Delivery charges, payment methods, warranty terms, returns and business hours need verified policy content; the homepage's marketing text is not a complete policy source.
- Product records use soft deletes. Specify how synchronisation handles deleted and inactive products, timestamp boundaries and pagination during concurrent updates so Zivo can remove stale catalogue entries.
- Changes to sizes, images, categories and specifications can affect a product response without a direct product edit. Include these paths in change tracking, and document how bulk imports and inventory updates generate notifications.

## Suggested acceptance checks

- Missing, invalid and revoked keys are rejected; the Zivo key cannot read another store or access customer/order data.
- Search, detail lookup, pagination and timestamp validation behave as documented; unknown values remain `null`.
- Product responses match public catalogue pricing and inventory, and variant fields do not invent unavailable data.
- Policy responses distinguish known prices, unknown values and charges requiring a quotation.
- Each required event is delivered after the corresponding change is committed, with a stable event ID across retries.
- A receiver verifies signatures against the exact request body; failed deliveries retry with backoff and remain inspectable after retries are exhausted.
- Test credentials and webhook secrets are delivered through an agreed secure channel, outside source control and this document.
