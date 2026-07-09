/* Gamun theme UI overrides: modern, clean, consistent */
:root {
  --brand: #0d6efd;
  --brand-600: #0b5ed7;
  --text: #212529;
  --muted: #6c757d;
  --border: rgba(0,0,0,.08);
  --bg-soft: #f8f9fa;
  --radius: 12px;
  --shadow-sm: 0 6px 18px rgba(0,0,0,.06);
}

html { scroll-behavior: smooth; }
body { color: var(--text); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

/* Headings */
h1,h2,h3,h4,h5 { color: var(--text); letter-spacing: .2px; }
.text-brand { color: var(--brand) !important; }

/* Buttons */
.btn { border-radius: calc(var(--radius) - 6px); }
.btn-primary { background: var(--brand); border-color: var(--brand); }
.btn-primary:hover { background: var(--brand-600); border-color: var(--brand-600); }

/* Forms */
.form-control, .form-select { border-radius: calc(var(--radius) - 6px); border-color: var(--border); }
.form-control:focus, .form-select:focus { border-color: var(--brand); box-shadow: 0 0 0 .2rem rgba(13,110,253,.15); }
.form-label { font-weight: 600; color: var(--text); }

/* Cards & containers */
.card, .product-cart-wrap { border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-sm); }
.product-cart-wrap { transition: transform .2s ease, box-shadow .2s ease; overflow: hidden; background: #fff; }
.product-cart-wrap:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(0,0,0,.08); }
.product-cart-wrap .product-img { border-bottom: 1px solid var(--border); overflow: hidden; }
.product-cart-wrap .product-img img { border-top-left-radius: var(--radius); border-top-right-radius: var(--radius); }
.product-content-wrap { padding: .75rem .9rem 1rem; }
.product-content-wrap h2 { font-size: 0.98rem; line-height: 1.25rem; margin: .35rem 0 .25rem; }
.product-content-wrap .product-category a { color: var(--muted); font-size: .82rem; }
.product-price span { color: var(--brand); font-weight: 700; }

/* Product image sizing */
.uniform-height .product-img img,
.product-cart-wrap .product-img img.default-img,
.product-cart-wrap .product-img img.hover-img { height: 220px; width: 100%; object-fit: cover; }
@media (max-width: 576px) {
  .uniform-height .product-img img,
  .product-cart-wrap .product-img img.default-img,
  .product-cart-wrap .product-img img.hover-img { height: 180px; }
}

/* Sections */
.section-padding { padding-top: 48px; padding-bottom: 48px; }
@media (max-width: 576px) { .section-padding { padding-top: 32px; padding-bottom: 32px; } }

/* Hero slider image treatment */
.single-slider-img img { width: 100%; height: clamp(280px, 52vh, 540px); object-fit: cover; border-radius: var(--radius); }
.hero-slider-content-2 h1,.hero-slider-content-2 h2 { text-shadow: 0 2px 10px rgba(0,0,0,.2); }

/* Navigation tweaks */
.main-menu nav ul li a { position: relative; }
.main-menu nav ul li a:hover, .main-menu nav ul li a.active { color: var(--brand); }
.main-menu nav ul li a.active::after { content: ""; position: absolute; left: 0; right: 0; bottom: -6px; height: 2px; background: var(--brand); border-radius: 2px; }

/* Category scroller (from homepage) */
.cat-card { border-radius: var(--radius); overflow: hidden; }
.cat-thumb img { display: block; }
.cat-overlay span { font-size: .92rem; }

/* Media gallery */
.media-card { border-radius: var(--radius); box-shadow: var(--shadow-sm); }
.media-card img { border-radius: var(--radius); }

/* Breadcrumbs */
.breadcrumb a { color: var(--muted); }
.breadcrumb a:hover { color: var(--brand); }

/* Footer */
footer.main { background: #fff; border-top: 1px solid var(--border); }

/* Topbar */
.welding-topbar { background: linear-gradient(90deg, #0b5ed7, #0a58ca); }
.welding-topbar .btn { border-radius: 20px; }
