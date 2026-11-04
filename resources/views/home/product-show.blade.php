@extends('layouts.app')

@section('title', ($product->title ?? 'HP 15s Laptop') . ' - Digital Class')

@section('styles')
<!-- SEO Meta Tags -->
<meta name="description" content="{{ Str::limit(strip_tags($product->description ?? 'HP 15s Laptop with Intel Core i5 13th Gen, 16GB RAM, 512GB SSD for students and professionals.'), 160) }}">
<meta name="keywords" content="{{ $product->category ?? 'Laptops' }}, {{ $product->title }}, online shopping, digital class, laptop for students, best price">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph SEO -->
<meta property="og:title" content="{{ $product->title }} - Digital Class">
<meta property="og:description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
<meta property="og:image" content="{{ $product->display_thumbnail }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="product">

<!-- Twitter Card SEO -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $product->title }} - Digital Class">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
<meta name="twitter:image" content="{{ $product->display_thumbnail }}">

<!-- Google Schema.org Product Structured Data -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org/',
    '@type' => 'Product',
    'name' => $product->title,
    'image' => [$product->display_thumbnail],
    'description' => strip_tags($product->description),
    'sku' => 'HP15S-i5-512-SL',
    'brand' => [
        '@type' => 'Brand',
        'name' => 'HP',
    ],
    'offers' => [
        '@type' => 'Offer',
        'url' => url()->current(),
        'priceCurrency' => 'INR',
        'price' => (string)(float)$product->price,
        'priceValidUntil' => '2027-12-31',
        'itemCondition' => 'https://schema.org/NewCondition',
        'availability' => 'https://schema.org/InStock',
        'seller' => [
            '@type' => 'Organization',
            'name' => $product->seller_name,
        ],
    ],
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.6',
        'reviewCount' => '1240',
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<style>
    :root {
        --dc-blue: #0066cc;
        --dc-blue-hover: #0052a3;
        --dc-text-dark: #0f172a;
        --dc-text-muted: #64748b;
        --dc-border: #e2e8f0;
        --dc-green: #16a34a;
        --dc-bg-light: #f8fafc;
    }

    body {
        background-color: #ffffff;
        color: var(--dc-text-dark);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    /* Breadcrumbs */
    .product-breadcrumbs {
        padding: 0.75rem 0;
        font-size: 0.82rem;
        color: #64748b;
    }
    .product-breadcrumbs a {
        color: #475569;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .product-breadcrumbs a:hover {
        color: var(--dc-blue);
    }
    .product-breadcrumbs span.separator {
        margin: 0 0.4rem;
        color: #94a3b8;
    }
    .product-breadcrumbs span.current {
        color: #0f172a;
        font-weight: 500;
    }

    /* Product Gallery */
    .gallery-container {
        display: flex;
        gap: 0.75rem;
    }
    .gallery-thumbs-col {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        width: 68px;
        flex-shrink: 0;
    }
    .thumb-item {
        width: 68px;
        height: 68px;
        border-radius: 8px;
        border: 1.5px solid var(--dc-border);
        overflow: hidden;
        cursor: pointer;
        padding: 4px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .thumb-item.active, .thumb-item:hover {
        border-color: var(--dc-blue);
        box-shadow: 0 0 0 2px rgba(0, 102, 204, 0.15);
    }
    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .thumb-3d-btn {
        width: 68px;
        height: 52px;
        border-radius: 8px;
        border: 1.5px dashed #cbd5e1;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.65rem;
        font-weight: 600;
        color: #475569;
        transition: all 0.2s ease;
    }
    .thumb-3d-btn:hover {
        background: #eff6ff;
        border-color: var(--dc-blue);
        color: var(--dc-blue);
    }

    .gallery-main-display {
        flex: 1;
        position: relative;
        border: 1px solid var(--dc-border);
        border-radius: 12px;
        background: #ffffff;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        overflow: hidden;
    }
    .gallery-main-img {
        max-width: 100%;
        max-height: 380px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .gallery-main-img:hover {
        transform: scale(1.03);
    }

    /* Badges & Buttons over main image */
    .badge-bestseller {
        position: absolute;
        top: 14px;
        left: 14px;
        background: #f59e0b;
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
    }
    .badge-discount-float {
        position: absolute;
        top: 44px;
        left: 14px;
        background: #10b981;
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 4px;
        z-index: 2;
    }
    .btn-wishlist-float {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid var(--dc-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        transition: all 0.2s ease;
        z-index: 2;
    }
    .btn-wishlist-float:hover {
        background: #fef2f2;
        transform: scale(1.08);
    }
    .gallery-arrow-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
        z-index: 2;
    }
    .gallery-arrow-btn:hover {
        background: #ffffff;
        color: var(--dc-blue);
    }
    .gallery-arrow-prev { left: 12px; }
    .gallery-arrow-next { right: 12px; }

    /* Product Details Info (Center Column) */
    .brand-logo-badge {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #0070ba;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.15rem;
        font-style: italic;
        margin-right: 12px;
        flex-shrink: 0;
        box-shadow: 0 2px 5px rgba(0, 112, 186, 0.25);
    }
    .product-headline {
        font-size: 1.35rem;
        font-weight: 700;
        line-height: 1.35;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }
    .rating-sold-bar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        margin-bottom: 0.85rem;
    }
    .rating-stars {
        color: #f59e0b;
        font-weight: 700;
    }
    .sold-count-badge {
        color: #475569;
        font-weight: 500;
    }

    /* Trust Highlights Row */
    .trust-highlights-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .trust-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
    }

    .product-summary-p {
        font-size: 0.88rem;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 1.25rem;
    }

    /* 6 Key Spec Cards */
    .spec-grid-6 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.65rem;
        margin-bottom: 1.25rem;
    }
    .spec-box-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.65rem 0.75rem;
        background: #f8fafc;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .spec-box-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #e0f2fe;
        color: #0284c7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .spec-box-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .spec-box-sub {
        font-size: 0.7rem;
        color: #64748b;
    }

    /* Color Selection */
    .color-selection-wrap {
        margin-bottom: 1rem;
    }
    .color-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.35rem;
    }
    .color-swatch-list {
        display: flex;
        gap: 0.5rem;
    }
    .color-swatch {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #cbd5e1;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .color-swatch.active {
        box-shadow: 0 0 0 2px var(--dc-blue);
    }

    /* Meta bar */
    .meta-details-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
        font-size: 0.78rem;
        color: #64748b;
        padding-top: 0.75rem;
        border-top: 1px solid #f1f5f9;
    }
    .meta-details-bar strong {
        color: #1e293b;
    }

    /* Sticky Buy Box (Right Column) */
    .purchase-card-box {
        border: 1px solid var(--dc-border);
        border-radius: 12px;
        background: #ffffff;
        padding: 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .price-discount-badge {
        background: #dcfce7;
        color: #15803d;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        display: inline-block;
    }
    .tax-inclusive-label {
        font-size: 0.72rem;
        color: #94a3b8;
    }
    .huge-price-text {
        font-size: 2.1rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .mrp-strike-text {
        font-size: 1rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 0.4rem;
    }
    .savings-text {
        font-size: 0.8rem;
        font-weight: 600;
        color: #16a34a;
        margin-top: 0.2rem;
        margin-bottom: 1rem;
    }

    /* Stepper & Stock */
    .stepper-stock-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .stepper-control {
        display: inline-flex;
        align-items: center;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        overflow: hidden;
    }
    .stepper-btn {
        background: #f8fafc;
        border: none;
        width: 32px;
        height: 32px;
        font-size: 1rem;
        color: #334155;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .stepper-btn:hover {
        background: #e2e8f0;
    }
    .stepper-input {
        width: 40px;
        height: 32px;
        border: none;
        text-align: center;
        font-weight: 700;
        font-size: 0.85rem;
        background: #fff;
    }
    .stock-indicator-pill {
        font-size: 0.8rem;
        font-weight: 700;
        color: #16a34a;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    /* Action Buttons */
    .btn-buy-primary {
        background: var(--dc-blue);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: none;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        margin-bottom: 0.5rem;
        cursor: pointer;
    }
    .btn-buy-primary:hover {
        background: var(--dc-blue-hover);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.25);
    }
    .btn-cart-outline {
        background: #ffffff;
        color: var(--dc-blue);
        border: 1.5px solid var(--dc-blue);
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        margin-bottom: 1.25rem;
        cursor: pointer;
    }
    .btn-cart-outline:hover {
        background: #eff6ff;
        color: var(--dc-blue);
    }

    /* 4 Guarantees grid */
    .guarantee-grid-4 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        padding-top: 1rem;
        border-top: 1px solid #f1f5f9;
        margin-bottom: 1.25rem;
    }
    .guarantee-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .guarantee-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
    }
    .guarantee-item:nth-child(2) .guarantee-icon { color: #10b981; background: #ecfdf5; }
    .guarantee-item:nth-child(3) .guarantee-icon { color: #8b5cf6; background: #f5f3ff; }
    .guarantee-item:nth-child(4) .guarantee-icon { color: #f59e0b; background: #fffbeb; }
    .guarantee-text {
        font-size: 0.72rem;
        color: #334155;
        line-height: 1.2;
    }
    .guarantee-text strong {
        display: block;
        color: #0f172a;
    }

    /* Institutional Bulk Card */
    .bulk-quote-card {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-radius: 10px;
        padding: 0.9rem;
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }
    .bulk-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #fde68a;
        color: #b45309;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .bulk-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 0.2rem;
    }
    .bulk-desc {
        font-size: 0.72rem;
        color: #b45309;
        line-height: 1.3;
        margin-bottom: 0.4rem;
    }
    .bulk-link {
        font-size: 0.75rem;
        font-weight: 700;
        color: #b45309;
        text-decoration: none;
    }
    .bulk-link:hover {
        text-decoration: underline;
    }

    /* Sticky Product Navigation Tabs */
    .product-nav-tabs-bar {
        border-bottom: 2px solid #e2e8f0;
        margin-top: 2rem;
        margin-bottom: 1.75rem;
        display: flex;
        gap: 2rem;
        overflow-x: auto;
    }
    .p-nav-tab {
        padding: 0.75rem 0.25rem;
        font-size: 0.92rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        position: relative;
        white-space: nowrap;
        cursor: pointer;
    }
    .p-nav-tab.active {
        color: var(--dc-blue);
    }
    .p-nav-tab.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--dc-blue);
        border-radius: 3px 3px 0 0;
    }

    /* Middle 4-Column Layout */
    .detail-columns-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    .col-card-box {
        border: 1px solid var(--dc-border);
        border-radius: 12px;
        background: #ffffff;
        padding: 1.25rem;
    }
    .col-header-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Key Features Column */
    .key-feature-item {
        display: flex;
        gap: 0.65rem;
        margin-bottom: 0.85rem;
        align-items: flex-start;
    }
    .kf-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #eff6ff;
        color: var(--dc-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .kf-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.25;
    }
    .kf-sub {
        font-size: 0.72rem;
        color: #64748b;
    }

    /* Product Highlights 2x3 Grid */
    .highlights-2x3-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.65rem;
    }
    .highlight-tile {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        height: 105px;
    }
    .highlight-tile img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .highlight-tile:hover img {
        transform: scale(1.05);
    }
    .highlight-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 60%, transparent 100%);
        padding: 0.4rem;
        color: #ffffff;
    }
    .highlight-title {
        font-size: 0.72rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .highlight-battery-badge {
        position: absolute;
        top: 6px;
        right: 6px;
        background: #10b981;
        color: #ffffff;
        font-size: 0.62rem;
        font-weight: 700;
        padding: 0.15rem 0.4rem;
        border-radius: 12px;
    }

    /* Offers & Discounts Column */
    .offer-item-row {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 0.85rem;
        align-items: flex-start;
        padding-bottom: 0.85rem;
        border-bottom: 1px dashed #e2e8f0;
    }
    .offer-item-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .offer-icon-box {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .offer-heading {
        font-size: 0.8rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.15rem;
    }
    .offer-detail-text {
        font-size: 0.73rem;
        color: #64748b;
        line-height: 1.3;
    }

    /* Sold by Seller Card */
    .seller-header-flex {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .seller-dc-badge {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #0f172a;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -1px;
    }
    .seller-store-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .seller-verified-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #0284c7;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 12px;
        margin-top: 0.2rem;
    }
    .seller-rating-score {
        font-size: 0.78rem;
        color: #475569;
        margin-bottom: 0.85rem;
    }
    .seller-checklist-ul {
        list-style: none;
        padding: 0;
        margin: 0 0 1.25rem 0;
    }
    .seller-checklist-ul li {
        font-size: 0.75rem;
        color: #334155;
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }
    .seller-checklist-ul li i {
        color: #16a34a;
        font-size: 0.75rem;
    }
    .seller-actions-row {
        display: flex;
        gap: 0.5rem;
    }
    .btn-seller-store {
        flex: 1;
        background: #eff6ff;
        color: var(--dc-blue);
        border: 1px solid #bfdbfe;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.45rem;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-seller-store:hover {
        background: var(--dc-blue);
        color: #ffffff;
    }
    .btn-seller-contact {
        flex: 1;
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.45rem;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-seller-contact:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Frequently Bought Together Box */
    .frequently-bought-card {
        border: 1px solid var(--dc-border);
        border-radius: 12px;
        background: #ffffff;
        padding: 1.25rem;
        margin-bottom: 2.5rem;
    }
    .bundle-items-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .bundle-item-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.65rem 0.85rem;
        background: #f8fafc;
        max-width: 250px;
        flex: 1;
        min-width: 190px;
    }
    .bundle-item-thumb {
        width: 50px;
        height: 50px;
        object-fit: contain;
        background: #ffffff;
        border-radius: 6px;
        padding: 2px;
    }
    .bundle-item-info {
        font-size: 0.78rem;
    }
    .bundle-item-title {
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 130px;
    }
    .bundle-item-price {
        color: var(--dc-blue);
        font-weight: 700;
    }
    .bundle-plus-sign {
        font-size: 1.25rem;
        font-weight: 800;
        color: #94a3b8;
    }
    .bundle-summary-col {
        margin-left: auto;
        min-width: 200px;
        text-align: right;
    }
    .bundle-total-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
    }
    .bundle-total-mrp {
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 0.35rem;
    }
    .bundle-save-pill {
        font-size: 0.75rem;
        font-weight: 700;
        color: #16a34a;
        margin-bottom: 0.5rem;
    }
    .btn-add-bundle {
        background: var(--dc-blue);
        color: #ffffff;
        border: none;
        padding: 0.6rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-add-bundle:hover {
        background: var(--dc-blue-hover);
    }

    /* Similar Products Carousel/Grid */
    .similar-products-section {
        margin-bottom: 3rem;
    }
    .similar-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }
    .similar-card {
        border: 1px solid var(--dc-border);
        border-radius: 12px;
        padding: 1rem;
        background: #ffffff;
        position: relative;
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .similar-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        color: inherit;
    }
    .similar-thumb-wrap {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
    }
    .similar-thumb-wrap img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }
    .similar-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.3rem;
    }
    .similar-rating {
        font-size: 0.75rem;
        color: #f59e0b;
        font-weight: 600;
        margin-bottom: 0.4rem;
    }
    .similar-price {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* Responsive */
    @media (max-width: 1199px) {
        .detail-columns-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .similar-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 768px) {
        .gallery-container {
            flex-direction: column-reverse;
        }
        .gallery-thumbs-col {
            flex-direction: row;
            width: 100%;
            overflow-x: auto;
        }
        .spec-grid-6 {
            grid-template-columns: repeat(2, 1fr);
        }
        .detail-columns-grid {
            grid-template-columns: 1fr;
        }
        .similar-grid {
            grid-template-columns: 1fr;
        }
        .bundle-items-row {
            flex-direction: column;
            align-items: stretch;
        }
        .bundle-summary-col {
            text-align: left;
            margin-left: 0;
            margin-top: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-3">
    <!-- Breadcrumb Navigation -->
    <div class="product-breadcrumbs">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
        <span class="separator">&gt;</span>
        <a href="{{ route('products') }}">Products</a>
        <span class="separator">&gt;</span>
        <a href="{{ route('products', ['category' => 'Laptops & Computers']) }}">{{ $product->category ?? 'Laptops & Computers' }}</a>
        <span class="separator">&gt;</span>
        <a href="{{ route('products', ['brand' => 'HP']) }}">HP</a>
        <span class="separator">&gt;</span>
        <span class="current">{{ Str::limit($product->title, 48) }}</span>
    </div>

    <!-- MAIN PRODUCT SHOWCASE (3 COLUMNS) -->
    <div class="row g-4 mt-1">
        <!-- 1. LEFT GALLERY SHOWCASE -->
        <div class="col-lg-5 col-md-12">
            <div class="gallery-container">
                <!-- Vertical Thumbs -->
                <div class="gallery-thumbs-col">
                    @foreach($galleryImages as $index => $img)
                        <div class="thumb-item {{ $index === 0 ? 'active' : '' }}" onclick="switchMainImage('{{ $img }}', this)" title="View angle {{ $index + 1 }}">
                            <img src="{{ $img }}" alt="{{ $product->title }} thumb {{ $index + 1 }}">
                        </div>
                    @endforeach
                    <!-- 3D View Button -->
                    <div class="thumb-3d-btn" onclick="open3DModal()" title="Explore 3D Interactive Model">
                        <i class="fa-solid fa-cube fa-lg mb-1 text-primary"></i>
                        <span>3D View</span>
                    </div>
                </div>

                <!-- Main Display Area -->
                <div class="gallery-main-display">
                    <!-- Badges -->
                    <span class="badge-bestseller"><i class="fa-solid fa-fire me-1"></i> Best Seller</span>
                    <span class="badge-discount-float">33% OFF</span>

                    <!-- Wishlist -->
                    <button type="button" class="btn-wishlist-float" onclick="toggleProductWishlist(this)" title="Add to Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>

                    <!-- Navigation arrows -->
                    <button type="button" class="gallery-arrow-btn gallery-arrow-prev" onclick="prevGalleryImage()" title="Previous Image">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="gallery-arrow-btn gallery-arrow-next" onclick="nextGalleryImage()" title="Next Image">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <!-- Main Image -->
                    <img id="mainProductImage" src="{{ $galleryImages[0] ?? $product->display_thumbnail }}" alt="{{ $product->title }}" class="gallery-main-img">
                </div>
            </div>
        </div>

        <!-- 2. CENTER PRODUCT DETAILS & SPECS -->
        <div class="col-lg-4 col-md-7">
            <!-- Brand & Title -->
            <div class="d-flex align-items-center mb-2">
                <div class="brand-logo-badge" title="Official HP Product">hp</div>
                <h1 class="product-headline m-0">{{ $product->title }}</h1>
            </div>

            <!-- Rating & Sold Count -->
            <div class="rating-sold-bar">
                <div class="rating-stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <span class="ms-1 text-dark">4.6</span>
                </div>
                <span class="text-muted">(1,240 reviews)</span>
                <span class="text-muted">|</span>
                <span class="sold-count-badge"><i class="fa-solid fa-bag-shopping text-primary me-1"></i> 2,500+ sold</span>
            </div>

            <!-- Trust Highlights (4 Pills) -->
            <div class="trust-highlights-row">
                <span class="trust-pill"><i class="fa-solid fa-circle-check"></i> Original Product</span>
                <span class="trust-pill"><i class="fa-solid fa-shield-halved"></i> 1 Year Warranty</span>
                <span class="trust-pill"><i class="fa-solid fa-truck-fast"></i> Free Shipping</span>
                <span class="trust-pill"><i class="fa-solid fa-file-invoice"></i> GST Invoice</span>
            </div>

            <!-- Description Summary -->
            <p class="product-summary-p">
                {{ $product->description ?: 'Powerful and stylish laptop for students, professionals and business users. Perfect for online classes, office work, content creation and everyday use.' }}
            </p>

            <!-- 6 Key Spec Cards -->
            <div class="spec-grid-6">
                @foreach($specHighlights as $spec)
                    <div class="spec-box-card">
                        <div class="spec-box-icon">
                            <i class="{{ $spec['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="spec-box-title">{{ $spec['label'] }}</div>
                            <div class="spec-box-sub">{{ $spec['sub'] ?? 'Specification' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Color Selector -->
            <div class="color-selection-wrap">
                <div class="color-label">Color: <span id="selectedColorName" class="fw-bold text-dark">Silver</span></div>
                <div class="color-swatch-list">
                    <div class="color-swatch active" style="background: #e2e8f0;" onclick="selectProductColor('Silver', this)" title="Silver"></div>
                    <div class="color-swatch" style="background: #1e3a8a;" onclick="selectProductColor('Navy Blue', this)" title="Navy Blue"></div>
                    <div class="color-swatch" style="background: #fef08a;" onclick="selectProductColor('Warm Gold', this)" title="Warm Gold"></div>
                </div>
            </div>

            <!-- Meta details bar -->
            <div class="meta-details-bar">
                <div>Brand: <strong>HP</strong></div>
                <div>Series: <strong>15s</strong></div>
                <div>Product Code: <strong>HP15S-i5-512-SL</strong></div>
                <div>Availability: <strong class="text-success"><i class="fa-solid fa-circle-check"></i> In Stock</strong></div>
            </div>
        </div>

        <!-- 3. RIGHT STICKY PURCHASE CARD -->
        <div class="col-lg-3 col-md-5">
            <div class="purchase-card-box sticky-top" style="top: 20px;">
                <!-- Discount & Tax Label -->
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="price-discount-badge">{{ $product->discount_percentage ?? 33 }}% OFF</span>
                    <span class="tax-inclusive-label">Inclusive of all taxes</span>
                </div>

                <!-- Price Numbers -->
                <div class="d-flex align-items-baseline mb-1">
                    <span class="huge-price-text">₹{{ number_format((float)$product->price) }}</span>
                    @if($product->mrp > $product->price)
                        <span class="mrp-strike-text">₹{{ number_format((float)$product->mrp) }}</span>
                    @else
                        <span class="mrp-strike-text">₹63,999</span>
                    @endif
                </div>

                <!-- Savings -->
                <div class="savings-text">
                    You save ₹{{ number_format((float)(($product->mrp ?: 63999) - $product->price)) }} ({{ $product->discount_percentage ?? 33 }}%)
                </div>

                <!-- Quantity Stepper & Stock -->
                <div class="stepper-stock-row">
                    <div class="stepper-control">
                        <button type="button" class="stepper-btn" onclick="decreaseQty()">-</button>
                        <input type="text" id="productQty" value="1" readonly class="stepper-input">
                        <button type="button" class="stepper-btn" onclick="increaseQty()">+</button>
                    </div>
                    <div class="stock-indicator-pill">
                        <i class="fa-solid fa-circle fa-2xs"></i> In Stock
                    </div>
                </div>

                <!-- Buy Buttons -->
                <button type="button" class="btn-buy-primary" onclick="proceedToBuy()">
                    <i class="fa-solid fa-bolt"></i> Buy Now
                </button>
                <button type="button" class="btn-cart-outline" onclick="addToCartLive()">
                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                </button>

                <!-- 4 Guarantees -->
                <div class="guarantee-grid-4">
                    <div class="guarantee-item">
                        <div class="guarantee-icon"><i class="fa-solid fa-truck"></i></div>
                        <div class="guarantee-text">
                            <strong>Free Delivery</strong>
                            2-4 Days
                        </div>
                    </div>
                    <div class="guarantee-item">
                        <div class="guarantee-icon"><i class="fa-solid fa-rotate-left"></i></div>
                        <div class="guarantee-text">
                            <strong>Easy Returns</strong>
                            7 Days
                        </div>
                    </div>
                    <div class="guarantee-item">
                        <div class="guarantee-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="guarantee-text">
                            <strong>1 Year</strong>
                            Warranty
                        </div>
                    </div>
                    <div class="guarantee-item">
                        <div class="guarantee-icon"><i class="fa-solid fa-lock"></i></div>
                        <div class="guarantee-text">
                            <strong>Secure</strong>
                            Payments
                        </div>
                    </div>
                </div>

                <!-- Bulk Purchase Institutional Card -->
                <div class="bulk-quote-card">
                    <div class="bulk-icon-wrap">
                        <i class="fa-solid fa-school"></i>
                    </div>
                    <div>
                        <div class="bulk-title">Bulk Purchase for Institutes?</div>
                        <div class="bulk-desc">Special pricing for schools, colleges and training centers.</div>
                        <a href="javascript:void(0)" onclick="openInstitutionalQuoteModal()" class="bulk-link">
                            Request Quote &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STICKY HORIZONTAL PRODUCT NAVIGATION TABS -->
    <div class="product-nav-tabs-bar">
        <a href="#overview" class="p-nav-tab active">Overview</a>
        <a href="#specifications" class="p-nav-tab">Specifications</a>
        <a href="#reviews" class="p-nav-tab">Reviews (1,240)</a>
        <a href="#questions" class="p-nav-tab">Questions</a>
        <a href="#seller-info" class="p-nav-tab">Seller Info</a>
        <a href="#warranty" class="p-nav-tab">Warranty & Support</a>
    </div>

    <!-- MIDDLE 4-COLUMN CONTENT SECTION -->
    <div class="detail-columns-grid">
        <!-- COLUMN 1: Key Features -->
        <div class="col-card-box">
            <h3 class="col-header-title">Key Features</h3>
            @foreach($keyFeatures as $kf)
                <div class="key-feature-item">
                    <div class="kf-icon">
                        <i class="{{ $kf['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="kf-title">{{ $kf['title'] }}</div>
                        <div class="kf-sub">{{ $kf['sub'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- COLUMN 2: Product Highlights (2x3 Image Grid) -->
        <div class="col-card-box">
            <h3 class="col-header-title">Product Highlights</h3>
            <div class="highlights-2x3-grid">
                @foreach($highlights as $hIdx => $hl)
                    <div class="highlight-tile">
                        <img src="{{ $hl['img'] }}" alt="{{ $hl['title'] }}">
                        @if($hIdx === 5)
                            <span class="highlight-battery-badge">Up to 7.5 Hours</span>
                        @endif
                        <div class="highlight-overlay">
                            <div class="highlight-title">{{ $hl['title'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- COLUMN 3: Offers & Discounts -->
        <div class="col-card-box">
            <h3 class="col-header-title">Offers & Discounts</h3>
            @foreach($offers as $offer)
                <div class="offer-item-row">
                    <div class="offer-icon-box" style="color: {{ $offer['color'] }};">
                        <i class="{{ $offer['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="offer-heading">{{ $offer['type'] }}</div>
                        <div class="offer-detail-text">{{ $offer['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- COLUMN 4: Sold by Seller Card -->
        <div class="col-card-box">
            <h3 class="col-header-title">Sold by</h3>
            <div class="seller-header-flex">
                <div class="seller-dc-badge">dc</div>
                <div>
                    <div class="seller-store-name">{{ $product->seller_name ?? 'Digital Class Store' }}</div>
                    <span class="seller-verified-pill"><i class="fa-solid fa-circle-check"></i> Verified Seller</span>
                </div>
            </div>
            <div class="seller-rating-score">
                <i class="fa-solid fa-star text-warning"></i> <strong>4.7</strong> (12,580+ ratings)
            </div>

            <ul class="seller-checklist-ul">
                <li><i class="fa-solid fa-circle-check"></i> 100% Original Products</li>
                <li><i class="fa-solid fa-circle-check"></i> GST Billing Available</li>
                <li><i class="fa-solid fa-circle-check"></i> 7 Days Easy Returns</li>
                <li><i class="fa-solid fa-circle-check"></i> Secure Packaging</li>
                <li><i class="fa-solid fa-circle-check"></i> Dedicated Customer Support</li>
            </ul>

            <div class="seller-actions-row">
                <a href="{{ route('products', ['seller' => $product->seller_id ?? 1]) }}" class="btn-seller-store">View Store &rarr;</a>
                <a href="javascript:void(0)" onclick="openContactSellerModal()" class="btn-seller-contact">Contact Seller</a>
            </div>
        </div>
    </div>

    <!-- FREQUENTLY BOUGHT TOGETHER SECTION -->
    <div class="frequently-bought-card">
        <h4 class="fw-bold mb-3" style="font-size: 1.05rem;">Frequently Bought Together</h4>
        <div class="bundle-items-row">
            @foreach($bundleItems as $idx => $bItem)
                <div class="bundle-item-card">
                    <input type="checkbox" class="form-check-input bundle-checkbox me-2" id="bundleCheck{{ $bItem['id'] }}" data-price="{{ $bItem['price'] }}" {{ $bItem['checked'] ? 'checked' : '' }} onchange="calculateBundleTotal()">
                    <img src="{{ $bItem['thumb'] }}" alt="{{ $bItem['title'] }}" class="bundle-item-thumb">
                    <div class="bundle-item-info">
                        <div class="bundle-item-title" title="{{ $bItem['title'] }}">{{ $bItem['title'] }}</div>
                        <div class="bundle-item-price">₹{{ number_format((float)$bItem['price']) }}</div>
                    </div>
                </div>
                @if(!$loop->last)
                    <span class="bundle-plus-sign">+</span>
                @endif
            @endforeach

            <!-- Total and action -->
            <div class="bundle-summary-col">
                <div>
                    <span class="text-muted small">Total Price:</span>
                    <span id="bundleTotalPrice" class="bundle-total-price">₹45,696</span>
                    <span class="bundle-total-mrp">₹48,596</span>
                </div>
                <div class="bundle-save-pill">You save ₹2,900 (6%)</div>
                <button type="button" class="btn-add-bundle" onclick="addBundleToCart()">
                    <i class="fa-solid fa-cart-plus me-1"></i> Add All to Cart
                </button>
            </div>
        </div>
    </div>

    <!-- SIMILAR PRODUCTS CAROUSEL -->
    <div class="similar-products-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold m-0" style="font-size: 1.15rem;">Similar Products</h4>
            <a href="{{ route('products', ['category' => 'Laptops & Computers']) }}" class="text-primary text-decoration-none fw-semibold small">
                View All &rarr;
            </a>
        </div>

        <div class="similar-grid">
            @foreach($similarProducts as $sp)
                @php
                    $spTitle = is_array($sp) ? $sp['title'] : $sp->title;
                    $spPrice = is_array($sp) ? $sp['price'] : $sp->price;
                    $spRating = is_array($sp) ? $sp['rating'] : 4.5;
                    $spReviews = is_array($sp) ? $sp['reviews'] : '980';
                    $spThumb = is_array($sp) ? $sp['thumb'] : $sp->display_thumbnail;
                    $spSlug = is_array($sp) ? Str::slug($sp['title']) : ($sp->slug ?: Str::slug($sp->title));
                @endphp
                <a href="{{ route('product.show', $spSlug) }}" class="similar-card">
                    <button type="button" class="btn-wishlist-float" style="top: 8px; right: 8px; width: 30px; height: 30px;" onclick="event.preventDefault(); toggleProductWishlist(this);">
                        <i class="fa-regular fa-heart fa-sm"></i>
                    </button>
                    <div class="similar-thumb-wrap">
                        <img src="{{ $spThumb }}" alt="{{ $spTitle }}">
                    </div>
                    <div class="similar-title">{{ $spTitle }}</div>
                    <div class="similar-rating">
                        <i class="fa-solid fa-star"></i> {{ $spRating }} <span class="text-muted fw-normal">({{ $spReviews }})</span>
                    </div>
                    <div class="similar-price">₹{{ number_format((float)$spPrice) }}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- 3D INTERACTIVE VIEW MODAL -->
<div class="modal fade" id="modal3DViewer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-cube text-primary me-2"></i> 3D Product Interactive View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div id="threeDStage" style="width: 100%; height: 360px; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle, #f8fafc 0%, #e2e8f0 100%); border-radius: 12px; cursor: grab; user-select: none;">
                    <img id="threeDImage" src="{{ $galleryImages[0] ?? $product->display_thumbnail }}" style="max-height: 280px; object-fit: contain; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.15)); transition: transform 0.1s ease-out;">
                </div>
                <div class="mt-3 text-muted small">
                    <i class="fa-solid fa-hand-pointer text-primary me-1"></i> Drag horizontally to rotate 360° &bull; Scroll to zoom in/out
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BULK INSTITUTIONAL QUOTE MODAL -->
<div class="modal fade" id="quoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fa-solid fa-school text-warning me-2"></i> Request Institute Bulk Quote
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">
                    Get special tiered pricing and GST invoice quotations for <strong>{{ $product->title }}</strong>.
                </p>
                <form id="instituteQuoteForm" onsubmit="submitQuoteRequest(event)">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Institute / Organization Name</label>
                        <input type="text" class="form-control" required placeholder="e.g. Modern Public School">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Contact Person</label>
                            <input type="text" class="form-control" required placeholder="Full Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Phone Number</label>
                            <input type="tel" class="form-control" required placeholder="+91 98765 43210">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Required Quantity</label>
                        <input type="number" class="form-control" min="5" value="10" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background: var(--dc-blue); border: none;">
                        Submit Quotation Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT INTERACTIONS -->
<script>
    const galleryList = @json($galleryImages);
    let currentImageIndex = 0;

    function switchMainImage(src, element) {
        document.getElementById('mainProductImage').src = src;
        document.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
        if (element) {
            element.classList.add('active');
            const items = Array.from(document.querySelectorAll('.thumb-item'));
            currentImageIndex = items.indexOf(element);
        }
    }

    function nextGalleryImage() {
        currentImageIndex = (currentImageIndex + 1) % galleryList.length;
        const targetSrc = galleryList[currentImageIndex];
        document.getElementById('mainProductImage').src = targetSrc;
        const thumbs = document.querySelectorAll('.thumb-item');
        thumbs.forEach(t => t.classList.remove('active'));
        if (thumbs[currentImageIndex]) thumbs[currentImageIndex].classList.add('active');
    }

    function prevGalleryImage() {
        currentImageIndex = (currentImageIndex - 1 + galleryList.length) % galleryList.length;
        const targetSrc = galleryList[currentImageIndex];
        document.getElementById('mainProductImage').src = targetSrc;
        const thumbs = document.querySelectorAll('.thumb-item');
        thumbs.forEach(t => t.classList.remove('active'));
        if (thumbs[currentImageIndex]) thumbs[currentImageIndex].classList.add('active');
    }

    function selectProductColor(colorName, el) {
        document.getElementById('selectedColorName').innerText = colorName;
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
        el.classList.add('active');
    }

    function increaseQty() {
        const input = document.getElementById('productQty');
        let val = parseInt(input.value) || 1;
        input.value = val + 1;
    }

    function decreaseQty() {
        const input = document.getElementById('productQty');
        let val = parseInt(input.value) || 1;
        if (val > 1) input.value = val - 1;
    }

    function toggleProductWishlist(btn) {
        const icon = btn.querySelector('i');
        if (icon.classList.contains('fa-regular')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            icon.style.color = '#ef4444';
            showLiveNotification('Saved to Wishlist', 'This product has been saved to your wishlist.');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
            icon.style.color = '';
            showLiveNotification('Removed from Wishlist', 'Product removed from wishlist.');
        }
    }

    function addToCartLive() {
        const qty = document.getElementById('productQty').value;
        showLiveNotification('Added to Cart', `${qty} item(s) of {{ addslashes($product->title) }} added to your cart.`);
    }

    function proceedToBuy() {
        showLiveNotification('Order Processing', 'Proceeding to secure checkout...');
        setTimeout(() => {
            window.location.href = "{{ url('/checkout') }}";
        }, 800);
    }

    function calculateBundleTotal() {
        let total = 0;
        const checkboxes = document.querySelectorAll('.bundle-checkbox');
        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseFloat(cb.dataset.price || 0);
            }
        });
        document.getElementById('bundleTotalPrice').innerText = '₹' + total.toLocaleString('en-IN');
    }

    function addBundleToCart() {
        let count = 0;
        document.querySelectorAll('.bundle-checkbox').forEach(cb => {
            if (cb.checked) count++;
        });
        showLiveNotification('Bundle Added', `${count} items added to your cart with bundle discount!`);
    }

    function open3DModal() {
        const modal = new bootstrap.Modal(document.getElementById('modal3DViewer'));
        modal.show();
    }

    function openInstitutionalQuoteModal() {
        const modal = new bootstrap.Modal(document.getElementById('quoteModal'));
        modal.show();
    }

    function openContactSellerModal() {
        showLiveNotification('Seller Contact', 'Direct messaging with {{ addslashes($product->seller_name) }} initialized.');
    }

    function submitQuoteRequest(e) {
        e.preventDefault();
        const modal = bootstrap.Modal.getInstance(document.getElementById('quoteModal'));
        if (modal) modal.hide();
        showLiveNotification('Request Received', 'Your bulk quotation request has been submitted to the seller team.');
    }

    function showLiveNotification(title, message) {
        let toastEl = document.getElementById('dcProductToast');
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.id = 'dcProductToast';
            toastEl.style.position = 'fixed';
            toastEl.style.bottom = '24px';
            toastEl.style.right = '24px';
            toastEl.style.zIndex = '9999';
            toastEl.style.background = '#0f172a';
            toastEl.style.color = '#ffffff';
            toastEl.style.padding = '0.75rem 1.25rem';
            toastEl.style.borderRadius = '10px';
            toastEl.style.boxShadow = '0 10px 25px rgba(0,0,0,0.2)';
            toastEl.style.fontSize = '0.85rem';
            toastEl.style.transition = 'all 0.3s ease';
            document.body.appendChild(toastEl);
        }
        toastEl.innerHTML = `<strong>${title}</strong>: ${message}`;
        toastEl.style.opacity = '1';
        toastEl.style.transform = 'translateY(0)';
        setTimeout(() => {
            toastEl.style.opacity = '0';
            toastEl.style.transform = 'translateY(10px)';
        }, 2800);
    }

    // 3D Rotator Simulation
    (function init3DStage() {
        const stage = document.getElementById('threeDStage');
        const img = document.getElementById('threeDImage');
        if (!stage || !img) return;

        let isDown = false;
        let startX = 0;
        let currentRotation = 0;

        stage.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX;
            stage.style.cursor = 'grabbing';
        });

        window.addEventListener('mouseup', () => {
            isDown = false;
            if (stage) stage.style.cursor = 'grab';
        });

        window.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            const walk = (e.pageX - startX) * 0.75;
            currentRotation += walk;
            startX = e.pageX;
            img.style.transform = `rotateY(${currentRotation}deg)`;
        });
    })();
</script>
@endsection
