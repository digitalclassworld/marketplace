<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Digital Class - India\'s Leading Educational Marketplace & Coaching Directory')</title>
    <meta name="description" content="@yield('meta_description', 'Digital Class is India\'s premier educational marketplace. Explore 11,000+ verified coaching institutes, enroll in certified online courses, hire freelance experts, and access premium study materials.')">
    <meta name="keywords" content="@yield('meta_keywords', 'online courses India, coaching institutes directory, computer classes, spoken english institute, freelance services, educational products, learn online, digital class marketplace')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:site_name" content="Digital Class">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', View::yieldContent('title', 'Digital Class - Educational Marketplace & Coaching Directory'))">
    <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', 'Explore 11,000+ verified coaching institutes, online courses, and freelance services on Digital Class.'))">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/digital-class-banner.jpg'))">
    <meta property="og:locale" content="en_IN">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@DigitalClassWorld">
    <meta name="twitter:title" content="@yield('og_title', View::yieldContent('title', 'Digital Class - Educational Marketplace'))">
    <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', 'Explore verified coaching institutes, courses, and services on Digital Class.'))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/digital-class-banner.jpg'))">

    <!-- Geo Metadata for India -->
    <meta name="geo.region" content="IN-GJ">
    <meta name="geo.placename" content="Ahmedabad">
    <meta name="geo.position" content="23.0225;72.5714">
    <meta name="ICBM" content="23.0225, 72.5714">

    <!-- Global Organization & WebSite JSON-LD Schema -->
    <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@graph' => [
        [
          '@type' => 'Organization',
          '@id' => url('/') . '/#organization',
          'name' => 'Digital Class',
          'url' => url('/'),
          'telephone' => '+919173860404',
          'email' => 'support@digitalclassworldin.com',
          'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('images/logo.png'),
            'caption' => 'Digital Class Logo'
          ],
          'sameAs' => [
            'https://www.facebook.com/digitalclassworld',
            'https://www.instagram.com/digitalclassworld',
            'https://www.linkedin.com/company/digitalclassworld',
            'https://twitter.com/digitalclassw'
          ]
        ],
        [
          '@type' => 'WebSite',
          '@id' => url('/') . '/#website',
          'url' => url('/'),
          'name' => 'Digital Class',
          'publisher' => [
            '@id' => url('/') . '/#organization'
          ],
          'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => url('/search') . '?q={search_term_string}',
            'query-input' => 'required name=search_term_string'
          ]
        ]
      ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @stack('schema')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans, Outfit & JetBrains Mono (Super Premium Typography) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6.5.1 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --dc-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --dc-font-heading: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            --dc-font-mono: 'JetBrains Mono', monospace;
            --dc-primary: #0066ff;
            --dc-primary-hover: #0052cc;
            --dc-primary-soft: #eff6ff;
            --dc-navy: #0b1424;
            --dc-dark: #0f172a;
            --dc-gray-bg: #f8fafc;
            --dc-border: #e2e8f0;
            --dc-text-muted: #64748b;
            --dc-success: #10b981;
            --dc-warning: #f59e0b;
            --dc-card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --dc-card-hover-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.12);
        }

        ::selection {
            background: #dbeafe;
            color: #1d4ed8;
        }

        body {
            font-family: var(--dc-font-sans);
            background-color: var(--dc-gray-bg);
            color: var(--dc-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            letter-spacing: -0.01em;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand, .dc-brand {
            font-family: var(--dc-font-heading);
            letter-spacing: -0.025em;
        }

        .font-monospace, code {
            font-family: var(--dc-font-mono) !important;
            letter-spacing: 0.02em;
        }

        /* Top Notification Bar */
        .dc-top-alert {
            background: linear-gradient(90deg, #070c18 0%, #0f1a30 100%);
            color: #94a3b8;
            font-size: 0.8125rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .dc-top-alert a {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.15s ease;
        }
        .dc-top-alert a:hover {
            color: #7dd3fc;
            text-decoration: underline;
        }
        .dc-top-alert a.text-light:hover {
            color: #38bdf8 !important;
            text-decoration: none;
        }

        .dc-live-dot {
            width: 7px;
            height: 7px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            animation: dcPulse 2s infinite;
        }
        @keyframes dcPulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
            70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Navigation */
        .dc-navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease;
        }

        .dc-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            transition: transform 0.2s ease;
        }
        .dc-brand:hover {
            transform: scale(1.02);
        }

        .dc-brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0066ff 0%, #00d2ff 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.15rem;
            box-shadow: 0 4px 10px rgba(0, 102, 255, 0.25);
        }

        .dc-brand span.dc-highlight {
            color: var(--dc-primary);
        }

        .dc-brand-subtitle {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--dc-text-muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: block;
            margin-top: -2px;
        }

        .nav-link.dc-nav-link {
            font-weight: 600;
            font-size: 0.875rem;
            color: #475569;
            padding: 0.45rem 0.9rem !important;
            border-radius: 999px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .nav-link.dc-nav-link:hover {
            color: var(--dc-primary);
            background-color: var(--dc-primary-soft);
        }

        .nav-link.dc-nav-link.active-marketplace-tab {
            color: #0066ff !important;
            background-color: #eff6ff;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 102, 255, 0.1);
        }

        .nav-link.dc-nav-link.active-marketplace-tab::after {
            display: none;
        }

        /* Navbar Search Box */
        .dc-nav-search-wrap {
            position: relative;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            transition: all 0.2s ease;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 2px 3px 2px 14px;
        }
        .dc-nav-search-wrap:focus-within {
            background: #ffffff;
            border-color: #0066ff;
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.12);
        }
        .dc-nav-search-input {
            border: none;
            background: transparent;
            font-size: 0.85rem;
            color: #1e293b;
            outline: none;
            width: 100%;
        }
        .dc-nav-search-input::placeholder {
            color: #94a3b8;
        }
        .dc-nav-search-btn {
            border: none;
            background: #0066ff;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }
        .dc-nav-search-btn:hover {
            background: #0052cc;
            transform: scale(1.05);
        }

        .dc-badge-soon {
            font-size: 0.65rem;
            font-weight: 600;
            background: #f1f5f9;
            color: #64748b;
            padding: 0.15rem 0.45rem;
            border-radius: 999px;
            margin-left: 0.25rem;
            vertical-align: middle;
        }

        .btn-dc-primary {
            background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
        }

        .btn-dc-primary:hover {
            background: linear-gradient(135deg, #0052cc 0%, #004099 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 102, 255, 0.35);
        }

        .btn-dc-outline {
            background-color: #ffffff;
            border: 1px solid var(--dc-border);
            color: var(--dc-dark);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1.15rem;
            border-radius: 999px;
            transition: all 0.2s ease;
        }

        .btn-dc-outline:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            color: var(--dc-primary);
        }

        /* Footer */
        .dc-footer {
            background: linear-gradient(180deg, #0b1424 0%, #060b14 100%);
            color: #94a3b8;
            padding: 4.5rem 0 2rem;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
        }

        .dc-footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .dc-footer a:hover {
            color: #38bdf8;
            padding-left: 2px;
        }

        .dc-footer-title {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.06em;
            color: #93c5fd;
        }

        .dc-footer-social-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .dc-footer-social-btn:hover {
            background: #0066ff;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.35);
        }

        /* Flash Message Alert */
        .alert-floating {
            position: fixed;
            top: 85px;
            right: 20px;
            z-index: 1090;
            min-width: 320px;
            max-width: 450px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
            border-radius: 12px;
            border: none;
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* ========================================================================
           MODERN UI DESIGN TOKENS & RESPONSIVE POLISH
           ======================================================================== */
        :root {
            --dc-surface-card: #ffffff;
            --dc-surface-subtle: #f8fafc;
            --dc-radius-sm: 8px;
            --dc-radius-md: 14px;
            --dc-radius-lg: 20px;
            --dc-radius-pill: 9999px;
            --dc-shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
            --dc-shadow-sm: 0 4px 12px -2px rgba(15, 23, 42, 0.06);
            --dc-shadow-md: 0 12px 28px -4px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.03);
            --dc-shadow-lg: 0 20px 40px -6px rgba(15, 23, 42, 0.12), 0 8px 16px -4px rgba(15, 23, 42, 0.04);
            --dc-shadow-glow: 0 8px 24px -2px rgba(0, 102, 255, 0.28);
        }

        /* Enhanced Card Polish with subtle border gradient & smooth transition */
        .card, .dc-card-modern {
            border-radius: var(--dc-radius-md);
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: var(--dc-shadow-sm);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
        }
        .card:hover, .dc-card-modern:hover {
            border-color: #cbd5e1;
        }

        /* Modern Pill Navigation & Interactive Badges */
        .badge-modern-verified {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.7rem;
            padding: 0.25rem 0.65rem;
            border-radius: var(--dc-radius-pill);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        }

        /* Mobile Bottom Navigation Dock */
        .dc-mobile-bottom-dock {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(226, 232, 240, 0.9);
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 6px 8px;
            z-index: 1040;
            box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.08);
        }
        .dc-mob-dock-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #64748b;
            text-decoration: none;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 6px;
            border-radius: 12px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            gap: 3px;
            flex: 1;
            max-width: 72px;
        }
        .dc-mob-dock-item i {
            font-size: 1.15rem;
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .dc-mob-dock-item:hover, .dc-mob-dock-item:active {
            color: var(--dc-primary);
        }
        .dc-mob-dock-item.active {
            color: var(--dc-primary);
            font-weight: 700;
        }
        .dc-mob-dock-item.active i {
            transform: translateY(-2px);
        }

        /* Hide scrollbars for slick horizontal swipe bars on mobile */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Smooth Tap Target Sizing & Responsive Rules */
        @media (max-width: 768px) {
            body {
                padding-bottom: 74px !important; /* Prevent bottom nav from covering page content */
            }
            .container, .container-fluid {
                padding-left: 14px;
                padding-right: 14px;
            }
            .dc-top-alert {
                font-size: 0.72rem;
                padding: 0.4rem 0;
            }
            .dc-navbar {
                padding: 0.5rem 0;
            }
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                border-radius: 16px;
                padding: 1rem;
                margin-top: 0.5rem;
                box-shadow: 0 12px 30px rgba(0,0,0,0.08);
                border: 1px solid #e2e8f0;
            }
            .navbar-nav .nav-link {
                padding: 0.65rem 1rem !important;
                margin-bottom: 2px;
            }
            .dc-footer {
                padding: 3rem 0 1.5rem;
                margin-bottom: 0;
            }
        }

        /* ==========================================================================
           UNIVERSAL LUXURY CARDS SYSTEM (FOR ALL CURRENT & FUTURE CARDS)
           ========================================================================== */
        .luxury-card,
        .business-grid-card,
        .trending-course-card,
        .course-card-unified,
        .service-card,
        .service-card-unified,
        .product-card,
        .product-card-unified,
        .business-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 18px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease;
            will-change: transform, box-shadow;
        }

        .luxury-card:hover,
        .business-grid-card:hover,
        .trending-course-card:hover,
        .course-card-unified:hover,
        .service-card:hover,
        .service-card-unified:hover,
        .product-card:hover,
        .product-card-unified:hover,
        .business-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 38px -10px rgba(15, 23, 42, 0.12), 0 8px 16px -4px rgba(15, 23, 42, 0.05);
            border-color: rgba(0, 102, 255, 0.35);
        }

        .luxury-card-thumb,
        .trending-course-thumb-box,
        .card-thumb-wrapper,
        .service-thumb,
        .product-thumb,
        .business-thumb,
        .course-thumb-box {
            position: relative;
            width: 100%;
            overflow: hidden;
            background: #f8fafc;
        }

        .luxury-card-thumb img,
        .trending-course-thumb-box img,
        .card-thumb-wrapper img,
        .service-thumb img,
        .product-thumb img,
        .business-thumb img,
        .course-thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .luxury-card:hover .luxury-card-thumb img,
        .trending-course-card:hover .trending-course-thumb-box img,
        .business-grid-card:hover .card-thumb-wrapper img,
        .service-card:hover .service-thumb img,
        .product-card:hover .product-thumb img,
        .business-card:hover .business-thumb img,
        .course-card-unified:hover .course-thumb-box img {
            transform: scale(1.08);
        }

        /* Luxury Glass Badge */
        .luxury-glass-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 3;
            background: rgba(15, 23, 42, 0.72);
            backdrop-filter: blur(10px);
            color: #ffffff;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.28rem 0.65rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            letter-spacing: 0.02em;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .luxury-glass-badge.gold {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.95) 0%, rgba(217, 119, 6, 0.98) 100%);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
        }

        .luxury-glass-badge.blue {
            background: linear-gradient(135deg, rgba(0, 102, 255, 0.95) 0%, rgba(30, 64, 175, 0.98) 100%);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 4px 14px rgba(0, 102, 255, 0.35);
        }

        .luxury-glass-badge.emerald {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.95) 0%, rgba(5, 150, 105, 0.98) 100%);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }

        /* Luxury Rating Pill */
        .luxury-rating-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 999px;
            padding: 0.15rem 0.55rem;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .luxury-rating-pill .fa-star {
            color: #f59e0b;
        }

        /* Luxury Price Typography */
        .luxury-price-current {
            font-size: 1.18rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .luxury-discount-pill {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-size: 0.68rem;
            font-weight: 800;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            letter-spacing: 0.02em;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        /* Cart Button Brand Style (Replacing legacy green with Royal Blue) */
        .btn-add-to-cart-green,
        .btn-add-to-cart {
            background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 14px rgba(0, 102, 255, 0.35) !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .btn-add-to-cart-green:hover,
        .btn-add-to-cart:hover {
            background: linear-gradient(135deg, #0052cc 0%, #003d99 100%) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(0, 102, 255, 0.45) !important;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="dc-top-alert">
        <div class="container-fluid px-lg-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="dc-live-dot me-2"></span>
                <a href="{{ route('home') }}" class="fw-semibold text-light text-decoration-none d-inline-flex align-items-center" title="Digital Class Marketplace Homepage">
                    <span>Digital Class Marketplace:</span>
                </a>
                <span class="ms-1 text-secondary d-none d-lg-inline">Discover courses, hire experts, shop products & explore local businesses.</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-1 text-light text-decoration-none fw-semibold" title="Go to Marketplace Homepage">
                    <i class="fa-solid fa-shop text-info" style="font-size: 0.75rem;"></i>
                    <span>Go to Marketplace</span>
                </a>
                <span class="text-secondary opacity-50 d-none d-md-inline">•</span>
                <div class="d-none d-md-flex align-items-center gap-3">
                    <span class="text-secondary">Are you an educator, agency, or institute?</span>
                    <a href="{{ route('seller.register') }}" class="d-inline-flex align-items-center gap-1 text-decoration-none">
                        <span>Join as a Seller</span>
                        <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
                    </a>
                    <span class="text-secondary opacity-50">•</span>
                    <a href="{{ route('seller.login') }}" class="d-inline-flex align-items-center gap-1 text-light text-decoration-none fw-semibold">
                        <i class="fa-solid fa-store text-warning" style="font-size: 0.75rem;"></i>
                        <span>Seller Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar (Matching UI/UX Design) -->
    <nav class="navbar navbar-expand-xl dc-navbar bg-white border-bottom sticky-top py-2">
        <div class="container-fluid px-lg-4">
            <!-- Brand Logo -->
            <a class="dc-brand me-3 d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Digital Class Educational World" class="dc-navbar-logo" style="height: 42px; width: auto; max-height: 44px; object-fit: contain;">
                <span class="visually-hidden">Digital Class</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMarketplace" aria-controls="navbarMarketplace" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars text-dark fs-4"></i>
            </button>

            <!-- Navigation Links & Search -->
            <div class="collapse navbar-collapse" id="navbarMarketplace">
                <ul class="navbar-nav me-3 mb-2 mb-xl-0 align-items-xl-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dc-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Explore
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                            <li><a class="dropdown-item small py-2" href="{{ route('home') }}"><i class="fa-solid fa-table-cells me-2 text-primary"></i> All Categories</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('courses') }}"><i class="fa-solid fa-graduation-cap me-2 text-info"></i> Online Courses</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('seller.register') }}"><i class="fa-solid fa-store me-2 text-success"></i> Become a Seller</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link {{ request()->routeIs('courses') ? 'active-marketplace-tab' : '' }}" href="{{ route('courses') }}" title="Online Courses">Courses<span class="visually-hidden"> Online Courses</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link {{ request()->routeIs('services') ? 'active-marketplace-tab' : '' }}" href="{{ route('services') }}" title="Professional Services" data-module="Professional Services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link {{ request()->routeIs('products') ? 'active-marketplace-tab' : '' }}" href="{{ route('products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link {{ request()->routeIs('businesses') || request()->routeIs('business.*') ? 'active-marketplace-tab' : '' }}" href="{{ route('businesses') }}">Businesses</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dc-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            For Institutions
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                            <li><a class="dropdown-item small py-2" href="{{ route('seller.register') }}"><i class="fa-solid fa-school me-2 text-primary"></i> Institute Onboarding</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('seller.register') }}"><i class="fa-solid fa-building me-2 text-secondary"></i> Agency Partnership</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Center Search Input with Modern Pill -->
                <form action="{{ request()->routeIs('businesses') ? route('businesses') : (request()->routeIs('courses*') ? route('courses') : (request()->routeIs('services*') ? route('services') : (request()->routeIs('products*') ? route('products') : route('home')))) }}" method="GET" class="flex-grow-1 mx-xl-3 my-2 my-xl-0" style="max-width: 460px;">
                    <div class="dc-nav-search-wrap">
                        <i class="fa-solid fa-magnifying-glass text-muted me-2" style="font-size: 0.85rem;"></i>
                        <input type="text" name="search" value="{{ request('search') }}" class="dc-nav-search-input" placeholder="Search courses, businesses, products, services...">
                        <button class="dc-nav-search-btn" type="submit" title="Search">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- Right Side Elements -->
                <div class="d-flex align-items-center gap-2 gap-xl-2.5 ms-xl-auto mt-2 mt-xl-0 flex-wrap flex-xl-nowrap">
                    <!-- Location Selector (Hidden on Home Page) -->
                    @if(!request()->routeIs('home'))
                    <div class="dropdown d-none d-md-block" id="navLocationDropdown">
                        <button class="btn btn-sm btn-light border-0 dropdown-toggle small text-muted d-flex align-items-center gap-1.5" type="button" data-bs-toggle="dropdown" id="navLocationBtn">
                            <i class="fa-solid fa-location-dot text-primary"></i>
                            <span class="text-dark fw-semibold" id="navSelectedCityText">{{ request('city', 'Ahmedabad') }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" style="min-width: 230px;">
                            <li>
                                <button type="button" class="dropdown-item small text-primary fw-bold py-2 rounded-2 d-flex align-items-center gap-2" onclick="detectGlobalNavLocation()">
                                    <i class="fa-solid fa-location-crosshairs text-primary"></i>
                                    <span>Detect My Location (Near Me)</span>
                                </button>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li class="dropdown-header small text-muted fw-bold py-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">POPULAR CITIES</li>
                            @php
                                $navCityTarget = request()->routeIs('businesses') ? 'businesses' : 'home';
                            @endphp
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'All Locations' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'All Locations']) }}"><i class="fa-solid fa-globe me-1.5 text-secondary"></i> All India</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ (!request('city') || request('city') === 'Ahmedabad') ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Ahmedabad']) }}">Ahmedabad</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Surat' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Surat']) }}">Surat</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Vadodara' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Vadodara']) }}">Vadodara</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Rajkot' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Rajkot']) }}">Rajkot</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Gandhinagar' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Gandhinagar']) }}">Gandhinagar</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Mumbai' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Mumbai']) }}">Mumbai</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Delhi NCR' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Delhi NCR']) }}">Delhi NCR</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Bengaluru' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Bengaluru']) }}">Bengaluru</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Pune' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Pune']) }}">Pune</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Jaipur' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Jaipur']) }}">Jaipur</a></li>
                            <li><a class="dropdown-item small py-1.5 rounded-2 {{ request('city') === 'Indore' ? 'active' : '' }}" href="{{ route($navCityTarget, ['city' => 'Indore']) }}">Indore</a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li class="dropdown-header small text-muted fw-bold py-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">STATES &amp; REGIONS</li>
                            <div style="max-height: 200px; overflow-y: auto;">
                                @php
                                    $topNavStates = [
                                        'Maharashtra', 'Karnataka', 'Delhi', 'Gujarat', 'Uttar Pradesh', 'Rajasthan',
                                        'Punjab', 'Tamil Nadu', 'Madhya Pradesh', 'Bihar', 'West Bengal', 'Haryana',
                                        'Kerala', 'Andhra Pradesh', 'Telangana', 'Jharkhand', 'Chhattisgarh',
                                        'Uttarakhand', 'Odisha', 'Assam', 'Jammu & Kashmir', 'Himachal Pradesh',
                                        'Goa', 'Puducherry', 'Tripura', 'Sikkim', 'Manipur', 'Arunachal Pradesh'
                                    ];
                                @endphp
                                @foreach($topNavStates as $stName)
                                    <li><a class="dropdown-item small py-1 rounded-2 {{ (request('city') === $stName || request('state') === $stName) ? 'active' : '' }}" href="{{ route('businesses', ['city' => $stName]) }}">{{ $stName }}</a></li>
                                @endforeach
                            </div>
                        </ul>
                    </div>
                    @endif

                    <!-- Cart Icon with Live Dynamic Badge -->
                    <button type="button" class="btn btn-light rounded-circle position-relative p-2 border-0 shadow-sm dc-cart-nav-btn" onclick="openCartDrawer()" title="View Shopping Cart" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; background: #f8fafc; transition: all 0.2s;">
                        <i class="fa-solid fa-cart-shopping text-secondary fs-6"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartNavBadge" style="font-size: 0.65rem; display: none;">
                            0
                        </span>
                    </button>

                    <!-- Auth Buttons (Customer vs Seller Awareness) -->
                    @auth
                        @if(Auth::user()->isCustomer())
                            <!-- Customer Account Menu -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-2.5 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: #ffffff; border-color: #cbd5e1;">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.78rem;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="text-start d-flex flex-column justify-content-center pe-1" style="line-height: 1.15;">
                                        <span class="fw-bold text-dark small text-truncate" style="max-width: 120px;">{{ Auth::user()->name }}</span>
                                        <span class="text-muted text-truncate" style="font-size: 0.68rem; font-weight: 600; max-width: 120px;" title="{{ Auth::user()->profession ?? 'Customer' }}">
                                            {{ Auth::user()->profession_label ?? (Auth::user()->profession ?? 'Customer') }}
                                        </span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-1 py-1" style="min-width: 220px;">
                                    <li class="px-3 py-2 border-bottom">
                                        <div class="fw-bold text-dark small">{{ Auth::user()->name }}</div>
                                        <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ Auth::user()->email }}</div>
                                        <div class="d-flex align-items-center gap-1.5 mt-1.5 flex-wrap">
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle d-inline-flex align-items-center gap-1" style="font-size: 0.68rem; font-weight: 600;">
                                                <i class="fa-solid fa-user-tag" style="font-size: 0.65rem;"></i>
                                                {{ Auth::user()->profession ?? 'Customer Account' }}
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small py-2" href="{{ route('customer.profile') }}">
                                            <i class="fa-regular fa-user me-2 text-primary"></i> My Account
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small py-2" href="{{ route('customer.orders') }}">
                                            <i class="fa-solid fa-bag-shopping me-2 text-primary"></i> My Orders & Purchases
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form method="POST" action="{{ route('customer.logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item small py-2 text-danger">
                                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @elseif(Auth::user()->isSeller())
                            <!-- Logged in as Seller -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle d-flex align-items-center gap-1.5 rounded-pill px-3 py-1.5 fw-semibold" style="background-color: #0066ff;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-store"></i>
                                    <span class="small">Seller: {{ \Illuminate\Support\Str::limit(Auth::user()->name, 12) }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-1 py-1" style="min-width: 220px;">
                                    <li class="px-3 py-2 border-bottom">
                                        <div class="fw-bold text-dark small">{{ Auth::user()->name }}</div>
                                        <span class="badge bg-warning-subtle text-warning-emphasis" style="font-size: 0.65rem;">Seller Mode</span>
                                        <div class="text-muted mt-1" style="font-size: 0.7rem; line-height: 1.3;">To make purchases, customer authentication is required.</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small py-2" href="{{ route('seller.dashboard') }}">
                                            <i class="fa-solid fa-gauge-high me-2 text-primary"></i> Seller Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small py-2" style="color: #6d28d9;" href="{{ route('customer.login') }}">
                                            <i class="fa-solid fa-user-plus me-2"></i> Login as Customer
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form method="POST" action="{{ route('seller.logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item small py-2 text-danger">
                                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout Seller
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @elseif(Auth::user()->isSuperAdmin())
                            <!-- Logged in as Admin -->
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm px-3 fw-bold" style="background-color: #0f172a;">
                                    <i class="fa-solid fa-shield-halved text-warning me-1"></i> Admin Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger p-1.5 rounded-circle" title="Logout">
                                        <i class="fa-solid fa-power-off" style="font-size: 0.75rem;"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <!-- Guest Navigation: User Login & User Sign Up -->
                        <div class="d-flex align-items-center gap-2 flex-wrap flex-xl-nowrap">
                            <!-- User Login (Dedicated Customer Portal) -->
                            <a href="{{ route('customer.login') }}" class="btn btn-sm rounded-pill px-3 fw-semibold text-nowrap d-inline-flex align-items-center gap-1.5 shadow-xs" style="height: 36px; font-size: 0.8125rem; color: #6d28d9; border: 1px solid #ddd6fe; background-color: #faf5ff;">
                                <i class="fa-regular fa-user"></i>
                                <span>User Login</span>
                            </a>

                            <!-- User Sign Up (Dedicated Customer Registration) -->
                            <a href="{{ route('customer.register') }}" class="btn btn-sm rounded-pill px-3.5 fw-bold text-nowrap shadow-sm d-inline-flex align-items-center text-white" style="height: 36px; font-size: 0.8125rem; background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);">
                                <span>User Sign Up</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Global Toast / Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-floating" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Success</h6>
                    <small>{{ session('success') }}</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-floating" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Notice</h6>
                    <small>{{ session('error') }}</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show alert-floating" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-info fs-4 me-3 text-info"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Information</h6>
                    <small>{{ session('info') }}</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Coming Soon Modal for Unbuilt Customer Marketplace Modules -->
    <div class="modal fade" id="comingSoonModal" tabindex="-1" aria-labelledby="comingSoonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 50%; background-color: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-rocket fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="modalModuleName">Coming Soon</h5>
                    <p class="text-muted small mb-4">
                        This customer marketplace feature is scheduled for our upcoming release phase. We are currently onboarding verified educators, service providers, and businesses.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('seller.register') }}" class="btn btn-dc-primary px-4">
                            Register as a Seller
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="dc-footer">
        <div class="container-fluid px-lg-5">
            <!-- Trust Metric Highlights Strip -->
            <div class="row g-3 pb-4 mb-4 border-bottom" style="border-color: rgba(255,255,255,0.08) !important;">
                <div class="col-md-3 col-6 d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(0, 102, 255, 0.15); color: #38bdf8; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold small">100% Verified</div>
                        <div class="text-secondary small" style="font-size: 0.72rem;">Authentic Sellers & Institutes</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); color: #34d399; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold small">Direct Contact</div>
                        <div class="text-secondary small" style="font-size: 0.72rem;">Call or WhatsApp Sellers Instantly</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); color: #fbbf24; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold small">Genuine Ratings</div>
                        <div class="text-secondary small" style="font-size: 0.72rem;">Real Community Feedback</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(168, 85, 247, 0.15); color: #c084fc; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold small">Zero Commission</div>
                        <div class="text-secondary small" style="font-size: 0.72rem;">Grow Your Business Without Hidden Fees</div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Digital Class" style="height: 42px; width: auto; background: white; padding: 6px 12px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                        <h4 class="visually-hidden">Digital Class</h4>
                    </div>
                    <p class="small text-secondary mb-3" style="line-height: 1.6;">
                        Digital Class Marketplace &mdash; <strong>Learn. Hire. Buy. Discover.</strong> India's leading multi-vendor educational and local business ecosystem connecting students, clients, shoppers, and verified businesses in one trusted platform.
                    </p>
                    
                    <!-- Social Media Links -->
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>

                    <div class="d-flex gap-2">
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Digital Class Official</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Secure Cloud Platform</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="dc-footer-title">Marketplace</div>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                        <li><a href="{{ route('businesses') }}">Local Businesses</a></li>
                        <li><a href="{{ route('courses') }}">Online Courses</a></li>
                        <li><a href="{{ route('products') }}">Shop Products</a></li>
                        <li><a href="{{ route('services') }}">Hire Services</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog & Guides</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="dc-footer-title">Seller Portal</div>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                        <li><a href="{{ route('seller.register') }}" class="text-info fw-semibold"><i class="fa-solid fa-arrow-right me-1 small"></i> Become a Seller</a></li>
                        <li><a href="{{ route('seller.login') }}">Seller Login</a></li>
                        <li>
                            <a href="{{ route('admin.login') }}" target="_blank" rel="noopener noreferrer" class="text-warning-emphasis">
                                <i class="fa-solid fa-shield-halved me-1 text-warning"></i> Super Admin Login <i class="fa-solid fa-arrow-up-right-from-square ms-1 small" style="font-size: 0.68rem;"></i>
                            </a>
                        </li>
                        @auth
                            @if(Auth::user()->isSeller())
                                <li><a href="{{ route('seller.dashboard') }}">Seller Dashboard</a></li>
                                <li><a href="{{ route('seller.profile') }}">Store Settings</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="dc-footer-title">Get in Touch</div>
                    <p class="small text-secondary mb-3">
                        Have questions about listing your institute, coaching academy, services, or products? Our vendor onboarding advisors are ready to assist.
                    </p>
                    <div class="d-flex align-items-center gap-2 text-secondary small mb-2">
                        <i class="fa-solid fa-envelope text-primary"></i>
                        <a href="mailto:support@digitalclassworldin.com" class="text-secondary text-decoration-none">support@digitalclassworldin.com</a>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-secondary small">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <a href="tel:+919173860404" class="text-secondary text-decoration-none">+91 91738 60404</a>
                        <span>&bull; Mon - Sat, 9am - 7pm IST</span>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.08);">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-secondary pt-2 pb-3">
                <div>
                    &copy; {{ date('Y') }} Digital Class Marketplace &bull; All Rights Reserved.
                </div>
                <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
                    <a href="{{ $superAdminUrl ?? (config('app.super_admin_url') ?: url('/super/admin/login')) }}" target="_blank" rel="noopener noreferrer" class="text-secondary text-decoration-none hover-white small">
                        <i class="fa-solid fa-lock me-1"></i> Admin Portal
                    </a>
                    <span>&bull;</span>
                    <span>100% Genuine & Verified Marketplace</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ============================================================================
         SHOPPING CART OFFCANVAS DRAWER (100% Workable)
         ============================================================================ -->
    <div class="offcanvas offcanvas-end border-0 shadow-lg" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel" style="width: 420px; max-width: 100vw; z-index: 1060;">
        <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-cart-shopping fs-6"></i>
                </div>
                <div>
                    <h5 class="offcanvas-title fw-bold text-dark mb-0 fs-6" id="cartOffcanvasLabel">My Shopping Cart</h5>
                    <small class="text-muted" id="cartDrawerCountText" style="font-size: 0.725rem;">0 items in cart</small>
                </div>
            </div>
            <button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0 d-flex flex-column" style="background-color: #f8fafc;">
            <!-- Cart Items Container -->
            <div id="cartItemsList" class="flex-grow-1 p-3 overflow-y-auto" style="max-height: calc(100vh - 220px);">
                <!-- Dynamic Items will be rendered here -->
            </div>

            <!-- Empty Cart State -->
            <div id="cartEmptyState" class="text-center py-5 px-4 my-auto" style="display: none;">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm p-4 mb-3 border">
                    <i class="fa-solid fa-basket-shopping fs-1 text-primary opacity-50"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Your cart is empty</h5>
                <p class="text-muted small mb-4" style="max-width: 260px; margin: 0 auto; font-size: 0.8rem;">
                    Looks like you haven't added any courses, services, or products to your cart yet.
                </p>
                <div class="d-flex flex-column gap-2" style="max-width: 240px; margin: 0 auto;">
                    <a href="{{ route('courses') }}" class="btn btn-primary btn-sm fw-semibold py-2 rounded-3" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-graduation-cap me-1.5"></i> Browse Courses
                    </a>
                    <a href="{{ route('services') }}" class="btn btn-outline-secondary btn-sm fw-semibold py-2 rounded-3 bg-white" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-briefcase me-1.5"></i> Browse Services
                    </a>
                    <a href="{{ route('products') }}" class="btn btn-outline-secondary btn-sm fw-semibold py-2 rounded-3 bg-white" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-box-open me-1.5"></i> Browse Products
                    </a>
                </div>
            </div>

            <!-- Cart Footer with Totals and Checkout Button -->
            <div id="cartFooterSection" class="p-3 bg-white border-top shadow-sm mt-auto" style="display: none;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Subtotal</span>
                    <strong class="text-dark" id="cartSubtotalAmount">₹0.00</strong>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3 pt-2 border-top">
                    <div>
                        <strong class="text-dark d-block">Total Amount</strong>
                        <small class="text-success" style="font-size: 0.7rem;"><i class="fa-solid fa-shield-halved me-1"></i> 100% Secure Checkout</small>
                    </div>
                    <h4 class="fw-bold text-primary mb-0" id="cartTotalAmount">₹0.00</h4>
                </div>
                <button type="button" class="btn btn-primary w-100 fw-bold py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" onclick="openCheckoutModal()">
                    <span>Proceed to Checkout</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
                <div class="text-center mt-2">
                    <button type="button" class="btn btn-link text-muted p-0 text-decoration-none" style="font-size: 0.725rem;" onclick="clearCart()">
                        <i class="fa-regular fa-trash-can me-1"></i> Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================================
         CHECKOUT MODAL (Complete Order Flow)
         ============================================================================ -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true" style="z-index: 1070;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <div class="modal-header py-3 px-4 bg-primary text-white border-0">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-shield-check fs-5"></i>
                        <h5 class="modal-title fw-bold mb-0 fs-6" id="checkoutModalLabel">Instant Marketplace Checkout</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Checkout Form Screen -->
                <div id="checkoutFormScreen" class="modal-body p-4">
                    <form id="marketplaceCheckoutForm" onsubmit="handleCheckoutSubmit(event)">
                        <div class="row g-3">
                            <!-- Left: Customer Details -->
                            <div class="col-lg-7 border-end-lg pe-lg-4">
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">
                                    <i class="fa-solid fa-user-circle text-primary me-1.5"></i> Customer Information
                                </h6>

                                <div class="mb-2.5">
                                    <label class="form-label small fw-semibold text-muted mb-1">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm rounded-3 py-2" id="checkoutName" required placeholder="e.g. Rahul Sharma" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                </div>

                                <div class="row g-2 mb-2.5">
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-sm rounded-3 py-2" id="checkoutEmail" required placeholder="name@example.com" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control form-control-sm rounded-3 py-2" id="checkoutPhone" required placeholder="9876543210" value="{{ Auth::check() && Auth::user()->phone ? Auth::user()->phone : '' }}">
                                    </div>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">City</label>
                                        <input type="text" class="form-control form-control-sm rounded-3 py-2" id="checkoutCity" placeholder="Ahmedabad" value="Ahmedabad">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">Address / Landmark</label>
                                        <input type="text" class="form-control form-control-sm rounded-3 py-2" id="checkoutAddress" placeholder="Street / Area">
                                    </div>
                                </div>

                                <h6 class="fw-bold text-dark mb-2.5" style="font-size: 0.9rem;">
                                    <i class="fa-solid fa-credit-card text-success me-1.5"></i> Payment Method
                                </h6>
                                <div class="d-flex flex-column gap-2 mb-2">
                                    <label class="form-check border rounded-3 p-2.5 d-flex align-items-center gap-2.5 cursor-pointer bg-light">
                                        <input class="form-check-input mt-0" type="radio" name="paymentMethod" value="Online UPI / Cards" checked>
                                        <div>
                                            <div class="fw-bold text-dark small">UPI / QR Code / Net Banking</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">Instant online confirmation & receipt</small>
                                        </div>
                                        <span class="badge bg-success-subtle text-success ms-auto fw-bold" style="font-size: 0.65rem;">Recommended</span>
                                    </label>
                                    <label class="form-check border rounded-3 p-2.5 d-flex align-items-center gap-2.5 cursor-pointer">
                                        <input class="form-check-input mt-0" type="radio" name="paymentMethod" value="Cash / Pay on Delivery">
                                        <div>
                                            <div class="fw-bold text-dark small">Cash / Pay on Delivery</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">Pay directly upon confirmation</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Right: Order Summary Preview -->
                            <div class="col-lg-5 ps-lg-3">
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">
                                    <i class="fa-solid fa-receipt text-warning me-1.5"></i> Order Review
                                </h6>

                                <div class="bg-light rounded-3 p-3 border mb-3">
                                    <div id="checkoutItemsPreview" class="d-flex flex-column gap-2 mb-3 overflow-y-auto" style="max-height: 180px;">
                                        <!-- Rendered dynamically -->
                                    </div>
                                    <div class="border-top pt-2">
                                        <div class="d-flex justify-content-between text-muted small mb-1">
                                            <span>Subtotal</span>
                                            <span id="checkoutSubtotal">₹0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-success small mb-1 d-none" id="checkoutDiscountRow">
                                            <span><i class="fa-solid fa-tag me-1"></i> Coupon Discount (<span id="checkoutDiscountCode"></span>)</span>
                                            <span id="checkoutDiscountAmount" class="fw-bold">-₹0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-muted small mb-2">
                                            <span>Platform Handling</span>
                                            <span class="text-success fw-bold">FREE</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-dark fw-bold border-top pt-2" style="font-size: 1.05rem;">
                                            <span>Total Due</span>
                                            <span class="text-primary" id="checkoutTotal">₹0.00</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" id="btnPlaceOrder" class="btn btn-primary w-100 fw-bold py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Confirm & Place Order</span>
                                </button>
                                <div class="text-center mt-2">
                                    <small class="text-muted" style="font-size: 0.68rem;">By ordering you agree to Digital Class Terms of Service.</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Checkout Success Screen -->
                <div id="checkoutSuccessScreen" class="modal-body p-5 text-center" style="display: none;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white shadow p-3 mb-3" style="width: 68px; height: 68px;">
                        <i class="fa-solid fa-check fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Order Placed Successfully!</h4>
                    <p class="text-muted small mb-3">Your order has been confirmed and registered with the seller.</p>

                    <div class="bg-light border rounded-3 p-3 mb-4 mx-auto text-start" style="max-width: 380px;">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Order Reference:</span>
                            <strong class="text-primary" id="successOrderRef">#DC-00000</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Amount Paid:</span>
                            <strong class="text-dark" id="successAmount">₹0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Customer:</span>
                            <span class="text-dark" id="successCustomer"></span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Status:</span>
                            <span class="badge bg-success-subtle text-success fw-bold">Confirmed & Active</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-primary px-4 fw-semibold rounded-pill" data-bs-dismiss="modal" onclick="window.location.reload()">
                            Continue Browsing
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================================================
         CUSTOMER AUTHENTICATION MODAL (Enhanced, Bigger & Premium Styling)
         ============================================================================ -->
    <style>
        #customerAuthModal .modal-dialog {
            max-width: 540px;
        }
        #customerAuthModal .modal-content {
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.35);
        }
        #customerAuthModal .auth-modal-header {
            background: linear-gradient(135deg, #090e17 0%, #0f1c3f 50%, #0052cc 100%) !important;
            padding: 2rem 2.25rem 1.75rem;
            position: relative;
        }
        #customerAuthModal .auth-nav-pill-box {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 4px;
        }
        #customerAuthModal .auth-nav-pill-box .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.55rem 0.75rem;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #customerAuthModal .auth-nav-pill-box .nav-link.active {
            background: #ffffff !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25) !important;
        }
        #customerAuthModal .auth-nav-pill-box .nav-link:hover:not(.active) {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }
        #customerAuthModal .auth-input-group {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: #f8fafc;
            transition: all 0.2s ease;
        }
        #customerAuthModal .auth-input-group:focus-within {
            border-color: #0066ff;
            background: #ffffff;
            box-shadow: 0 0 0 3.5px rgba(0, 102, 255, 0.15);
        }
        #customerAuthModal .auth-input-group .form-control {
            border: none;
            background: transparent;
            height: 48px;
            font-size: 0.95rem;
            color: #0f172a;
            box-shadow: none !important;
        }
        #customerAuthModal .auth-input-group .input-group-text {
            border: none;
            background: transparent;
            color: #64748b;
            font-size: 1rem;
            padding: 0 1rem;
        }
        #customerAuthModal .btn-auth-submit {
            background: linear-gradient(135deg, #0066ff 0%, #004ee6 100%);
            border: none;
            height: 50px;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 12px;
            color: #ffffff;
            box-shadow: 0 8px 24px -4px rgba(0, 102, 255, 0.45);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        #customerAuthModal .btn-auth-submit:hover {
            background: linear-gradient(135deg, #0052cc 0%, #003db3 100%);
            transform: translateY(-1.5px);
            box-shadow: 0 12px 28px -4px rgba(0, 102, 255, 0.55);
            color: #ffffff;
        }
        #customerAuthModal .trust-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.72rem;
            color: #475569;
            background: #f1f5f9;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            font-weight: 500;
        }
    </style>

    <div class="modal fade" id="customerAuthModal" tabindex="-1" aria-labelledby="customerAuthModalLabel" aria-hidden="true" style="z-index: 1070;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <!-- Premium Header -->
                <div class="auth-modal-header text-white">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow-none opacity-75 hover-opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    <div class="d-flex align-items-center gap-2.5 mb-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; background: rgba(255, 255, 255, 0.15); border: 1.5px solid rgba(255, 255, 255, 0.3); backdrop-filter: blur(8px);">
                            <i class="fa-solid fa-graduation-cap text-warning fs-5"></i>
                        </div>
                        <div>
                            <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-2.5 py-0.5 text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">Customer Portal</span>
                            <h4 class="fw-bold mb-0 text-white fs-5 mt-0.5" id="customerAuthModalLabel">Sign In to Your Account</h4>
                        </div>
                    </div>
                    
                    <p class="text-white-50 small mb-3" style="font-size: 0.82rem; line-height: 1.4;">
                        Access online courses, book expert services, track orders & download learning resources.
                    </p>

                    <!-- Segmented Tab Navigation -->
                    <ul class="nav nav-pills nav-fill auth-nav-pill-box" id="customerAuthTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-cust-login-btn" data-bs-toggle="pill" data-bs-target="#tabCustLogin" type="button" role="tab">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1.5"></i> Customer Login
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('customer.register') }}" class="nav-link text-white text-opacity-75" style="border-radius: 10px;" title="Go to Customer Registration Page">
                                <i class="fa-solid fa-user-plus me-1.5"></i> Create Account
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('seller.login') }}" class="nav-link text-white text-opacity-75" style="border-radius: 10px;" title="Go to Instructor & Institute Portal">
                                <i class="fa-solid fa-store me-1.5 text-warning"></i> Seller Login
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4 p-md-5 bg-white">
                    
                    <!-- Seller Mode Notice -->
                    @if(Auth::check() && Auth::user()->isSeller())
                        <div class="alert alert-warning border-0 rounded-3 mb-4 p-3" style="background-color: #fffbeb; border: 1px solid #fde68a !important;">
                            <div class="d-flex align-items-start gap-2.5">
                                <i class="fa-solid fa-triangle-exclamation text-warning fs-5 mt-0.5 flex-shrink-0"></i>
                                <div>
                                    <strong class="d-block text-dark small fw-bold">Currently in Seller Mode</strong>
                                    <span style="font-size: 0.775rem; line-height: 1.4;" class="text-muted d-block mb-2">
                                        You are signed in as <strong>{{ Auth::user()->name }}</strong> (Seller). To add courses or products to your cart and make purchases, please log in with your Customer account.
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        <form method="POST" action="{{ route('seller.logout') }}" class="d-inline m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm py-1 px-2.5 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                                <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Logout Seller
                                            </button>
                                        </form>
                                        <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-dark btn-sm py-1 px-2.5 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                            Go to Dashboard
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="tab-content">
                        <!-- TAB 1: LOGIN -->
                        <div class="tab-pane fade show active" id="tabCustLogin" role="tabpanel">
                            <div id="customerLoginAlert" class="alert alert-danger border-0 small rounded-3 mb-3 p-2.5 text-center" style="display: none; font-size: 0.8rem;"></div>

                            <form id="customerModalLoginForm" onsubmit="handleCustomerLoginSubmit(event)">
                                <!-- Email or Phone -->
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark mb-1.5">Email Address or Phone Number</label>
                                    <div class="input-group auth-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="text" id="custModalLoginEmail" class="form-control" placeholder="name@example.com or 10-digit mobile" required autofocus>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1.5">
                                        <label class="form-label small fw-bold text-dark mb-0">Password</label>
                                        <a href="{{ route('customer.login') }}" class="small text-primary text-decoration-none fw-semibold" style="font-size: 0.75rem;">Forgot password?</a>
                                    </div>
                                    <div class="input-group auth-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" id="custModalLoginPassword" class="form-control" placeholder="Enter your password" required>
                                        <button class="btn btn-link text-muted px-3 text-decoration-none" type="button" onclick="toggleModalPass('custModalLoginPassword', this)" title="Show/Hide Password">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Remember & Helper -->
                                <div class="d-flex align-items-center justify-content-between mb-3.5">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="modalRememberCust" checked>
                                        <label class="form-check-label small text-muted" for="modalRememberCust" style="font-size: 0.8rem;">
                                            Keep me logged in
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" id="btnCustModalLogin" class="btn btn-auth-submit w-100 mb-3">
                                    <span>Sign In as Customer</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </form>

                            <div class="text-center small text-muted mb-3">
                                Don't have a customer account yet? 
                                <a href="{{ route('customer.register') }}" class="text-primary fw-bold text-decoration-none">Create free account &rarr;</a>
                            </div>

                            <!-- Trust Chips -->
                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap pt-2 border-top">
                                <span class="trust-chip"><i class="fa-solid fa-shield-halved text-success"></i> 100% Secure Checkout</span>
                                <span class="trust-chip"><i class="fa-solid fa-bolt text-warning"></i> Instant Access</span>
                                <span class="trust-chip"><i class="fa-solid fa-box text-primary"></i> Live Order Tracking</span>
                            </div>
                        </div>

                        <!-- TAB 2: REGISTER -->
                        <div class="tab-pane fade" id="tabCustReg" role="tabpanel">
                            <div id="customerRegisterAlert" class="alert alert-danger border-0 small rounded-3 mb-3 p-2.5 text-center" style="display: none; font-size: 0.8rem;"></div>

                            <form id="customerModalRegisterForm" onsubmit="handleCustomerRegisterSubmit(event)">
                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark mb-1.5">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group auth-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                        <input type="text" id="custModalRegName" class="form-control" placeholder="e.g. Priya Patel" required>
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark mb-1.5">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group auth-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="email" id="custModalRegEmail" class="form-control" placeholder="name@example.com" required>
                                    </div>
                                </div>

                                <!-- Mobile Phone -->
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark mb-1.5">Mobile Phone (Optional)</label>
                                    <div class="input-group auth-input-group">
                                        <span class="input-group-text fw-semibold small">+91</span>
                                        <input type="tel" id="custModalRegPhone" class="form-control" placeholder="9876543210">
                                    </div>
                                </div>

                                <!-- Profession / Profile Type -->
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark mb-1.5">Profession / Profile Type <span class="text-danger">*</span></label>
                                    <div class="input-group auth-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                                        <select id="custModalRegProfession" class="form-select form-select-sm" required>
                                            <option value="Student / Learner" selected>Student / Learner (College / School)</option>
                                            <option value="Parent / Guardian">Parent / Guardian (For my children)</option>
                                            <option value="Teacher / Educator">Teacher / Educator / Private Tutor</option>
                                            <option value="Business Owner">Business Owner / Founder / MSME</option>
                                            <option value="Working Professional / Employee">Working Professional / Employee</option>
                                            <option value="Job Seeker / Fresher">Job Seeker / Fresher</option>
                                            <option value="Freelancer / Agency">Freelancer / Agency</option>
                                            <option value="Retailer / Merchant">Retailer / Store Owner</option>
                                            <option value="Institute Representative">Institute Representative</option>
                                            <option value="Other Professional">Other Professional Profile</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Password & Confirm -->
                                <div class="row g-2 mb-3.5">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1.5">Password <span class="text-danger">*</span></label>
                                        <div class="input-group auth-input-group">
                                            <input type="password" id="custModalRegPass" class="form-control" placeholder="Min. 6 chars" required minlength="6">
                                            <button class="btn btn-link text-muted px-2 text-decoration-none" type="button" onclick="toggleModalPass('custModalRegPass', this)">
                                                <i class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1.5">Confirm <span class="text-danger">*</span></label>
                                        <div class="input-group auth-input-group">
                                            <input type="password" id="custModalRegPassConf" class="form-control" placeholder="Repeat pass" required minlength="6">
                                            <button class="btn btn-link text-muted px-2 text-decoration-none" type="button" onclick="toggleModalPass('custModalRegPassConf', this)">
                                                <i class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" id="btnCustModalReg" class="btn btn-auth-submit w-100 mb-3">
                                    <span>Create Free Customer Account</span>
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>

                            <div class="text-center small text-muted mb-3">
                                Already registered? 
                                <a href="javascript:void(0)" onclick="switchCustomerAuthTab('login')" class="text-primary fw-bold text-decoration-none">Login here &rarr;</a>
                            </div>

                            <!-- Trust Chips -->
                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap pt-2 border-top">
                                <span class="trust-chip"><i class="fa-solid fa-lock text-success"></i> Free Registration</span>
                                <span class="trust-chip"><i class="fa-solid fa-certificate text-primary"></i> Verified Certificates</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Switcher to Seller Login -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-success text-white shadow-xs" style="width: 36px; height: 36px; flex-shrink: 0;">
                                    <i class="fa-solid fa-store" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">Are you a Seller or Instructor?</div>
                                    <small class="text-muted" style="font-size: 0.725rem;">Manage courses, services, and institute dashboard</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('seller.login') }}" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-xs text-nowrap" style="font-size: 0.775rem;">
                                    Seller Login &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Live Toast Alert -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
        <div id="cartLiveToast" class="toast align-items-center text-white bg-dark border-0 shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2 py-2 px-3 small">
                    <i class="fa-solid fa-circle-check text-success fs-6"></i>
                    <span id="cartToastMsg">Item added to cart!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ============================================================================
         CART, CHECKOUT & CUSTOMER AUTH ENGINE
         ============================================================================ -->
    <script>
        const CART_STORAGE_KEY = 'dc_marketplace_cart_items';

        // Global Customer Auth State
        window.DC_AUTH = {
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            isCustomer: {{ (Auth::check() && Auth::user()->isCustomer()) ? 'true' : 'false' }},
            isSeller: {{ (Auth::check() && Auth::user()->isSeller()) ? 'true' : 'false' }},
            role: '{{ Auth::check() ? Auth::user()->role : 'guest' }}',
            userName: '{{ Auth::check() ? addslashes(Auth::user()->name) : '' }}',
            userEmail: '{{ Auth::check() ? addslashes(Auth::user()->email) : '' }}',
            userPhone: '{{ Auth::check() ? addslashes(Auth::user()->phone ?? '') : '' }}'
        };

        window.pendingCartItem = null;

        // Open Customer Auth Page (Navigates directly to dedicated login/register page)
        function openCustomerAuthModal(tab) {
            if (tab === 'register') {
                window.location.href = "{{ route('customer.register') }}";
                return;
            }
            window.location.href = "{{ route('customer.login') }}";
        }

        // Switch Tabs in Customer Modal
        function switchCustomerAuthTab(tab) {
            if (tab === 'register') {
                const btn = document.getElementById('tab-cust-reg-btn');
                if (btn) {
                    const trigger = new bootstrap.Tab(btn);
                    trigger.show();
                }
            } else {
                const btn = document.getElementById('tab-cust-login-btn');
                if (btn) {
                    const trigger = new bootstrap.Tab(btn);
                    trigger.show();
                }
            }
        }

        // Toggle Password Show/Hide in Modal
        function toggleModalPass(id, btn) {
            const el = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (!el || !icon) return;
            if (el.type === 'password') {
                el.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                el.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Handle Customer AJAX Login
        async function handleCustomerLoginSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('btnCustModalLogin');
            const alertBox = document.getElementById('customerLoginAlert');
            alertBox.style.display = 'none';

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Verifying...';

            const payload = {
                email: document.getElementById('custModalLoginEmail').value,
                password: document.getElementById('custModalLoginPassword').value,
                remember: true
            };

            try {
                const res = await fetch('{{ route("customer.login.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (data.success) {
                    if (data.csrf_token) {
                        document.querySelectorAll('meta[name="csrf-token"]').forEach(m => m.setAttribute('content', data.csrf_token));
                        document.querySelectorAll('input[name="_token"]').forEach(i => i.value = data.csrf_token);
                    }
                    window.DC_AUTH = {
                        isLoggedIn: true,
                        isCustomer: true,
                        isSeller: false,
                        role: 'customer',
                        userName: data.user.name,
                        userEmail: data.user.email,
                        userPhone: data.user.phone || ''
                    };

                    const modalEl = document.getElementById('customerAuthModal');
                    if (modalEl) {
                        const bsModal = bootstrap.Modal.getInstance(modalEl);
                        if (bsModal) bsModal.hide();
                    }

                    showCartToast('Logged in as ' + data.user.name + '!');

                    if (window.pendingCartItem) {
                        const pending = window.pendingCartItem;
                        window.pendingCartItem = null;
                        setTimeout(() => {
                            addToCart(pending);
                        }, 300);
                    } else {
                        setTimeout(() => {
                            window.location.reload();
                        }, 600);
                    }
                } else {
                    alertBox.textContent = data.message || 'Invalid credentials.';
                    alertBox.style.display = 'block';
                    btn.disabled = false;
                    btn.innerHTML = '<span>Login as Customer</span>';
                }
            } catch (err) {
                alertBox.textContent = 'Server error during login. Please try again.';
                alertBox.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<span>Login as Customer</span>';
            }
        }

        // Handle Customer AJAX Registration
        async function handleCustomerRegisterSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('btnCustModalReg');
            const alertBox = document.getElementById('customerRegisterAlert');
            alertBox.style.display = 'none';

            const pass = document.getElementById('custModalRegPass').value;
            const passConf = document.getElementById('custModalRegPassConf').value;
            if (pass !== passConf) {
                alertBox.textContent = 'Passwords do not match.';
                alertBox.style.display = 'block';
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Creating Account...';

            const payload = {
                name: document.getElementById('custModalRegName').value,
                email: document.getElementById('custModalRegEmail').value,
                phone: document.getElementById('custModalRegPhone').value,
                profession: document.getElementById('custModalRegProfession')?.value || 'Student / Learner',
                password: pass,
                password_confirmation: passConf
            };

            try {
                const res = await fetch('{{ route("customer.register.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (data.success) {
                    if (data.csrf_token) {
                        document.querySelectorAll('meta[name="csrf-token"]').forEach(m => m.setAttribute('content', data.csrf_token));
                        document.querySelectorAll('input[name="_token"]').forEach(i => i.value = data.csrf_token);
                    }
                    window.DC_AUTH = {
                        isLoggedIn: true,
                        isCustomer: true,
                        isSeller: false,
                        role: 'customer',
                        userName: data.user.name,
                        userEmail: data.user.email,
                        userPhone: data.user.phone || ''
                    };

                    const modalEl = document.getElementById('customerAuthModal');
                    if (modalEl) {
                        const bsModal = bootstrap.Modal.getInstance(modalEl);
                        if (bsModal) bsModal.hide();
                    }

                    showCartToast('Account created! Welcome, ' + data.user.name);

                    if (window.pendingCartItem) {
                        const pending = window.pendingCartItem;
                        window.pendingCartItem = null;
                        setTimeout(() => {
                            addToCart(pending);
                        }, 300);
                    } else {
                        setTimeout(() => {
                            window.location.reload();
                        }, 600);
                    }
                } else {
                    alertBox.textContent = data.message || 'Unable to create account.';
                    alertBox.style.display = 'block';
                    btn.disabled = false;
                    btn.innerHTML = '<span>Create Customer Account</span>';
                }
            } catch (err) {
                alertBox.textContent = 'Server error during registration. Please try again.';
                alertBox.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<span>Create Customer Account</span>';
            }
        }

        // Load cart items from localStorage
        function getCartItems() {
            try {
                const stored = localStorage.getItem(CART_STORAGE_KEY);
                return stored ? JSON.parse(stored) : [];
            } catch (e) {
                return [];
            }
        }

        // Save cart items to localStorage & update UI
        function saveCartItems(items) {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(items));
            renderCartUI();
        }

        // Add item to cart (Customer Login REQUIRED)
        function addToCart(item) {
            if (!item || !item.id) return;

            // Check Customer Authentication Requirement
            if (!window.DC_AUTH || !window.DC_AUTH.isCustomer) {
                window.pendingCartItem = item;
                openCustomerAuthModal(window.DC_AUTH && window.DC_AUTH.isLoggedIn ? 'switch' : 'login');
                return;
            }

            let items = getCartItems();
            const key = (item.type || 'item').toLowerCase() + '_' + item.id;
            const existingIdx = items.findIndex(i => i.key === key);

            if (existingIdx > -1) {
                items[existingIdx].quantity = (items[existingIdx].quantity || 1) + (item.quantity || 1);
                if (item.coupon_code) {
                    items[existingIdx].coupon_code = item.coupon_code;
                    items[existingIdx].price = parseFloat(item.price) || 0;
                    items[existingIdx].discount_amount = parseFloat(item.discount_amount) || 0;
                }
            } else {
                items.push({
                    key: key,
                    id: item.id,
                    type: item.type || 'Course',
                    title: item.title || 'Marketplace Item',
                    price: parseFloat(item.price) || 0,
                    original_price: parseFloat(item.original_price || item.price) || 0,
                    coupon_code: item.coupon_code || null,
                    discount_amount: parseFloat(item.discount_amount) || 0,
                    thumbnail: item.thumbnail || 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                    seller_id: item.seller_id || 1,
                    quantity: item.quantity || 1
                });
            }

            saveCartItems(items);
            showCartToast('Added to Cart: ' + item.title);
            openCartDrawer();

            // Sync with backend session asynchronously
            try {
                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(item)
                }).then(r => r.json()).then(data => {
                    if (data && data.auth_required) {
                        openCustomerAuthModal('login');
                    }
                }).catch(() => {});
            } catch (err) {}
        }

        // Update item quantity in cart
        function updateCartQty(key, delta) {
            let items = getCartItems();
            const idx = items.findIndex(i => i.key === key);
            if (idx > -1) {
                const newQty = (items[idx].quantity || 1) + delta;
                if (newQty <= 0) {
                    items.splice(idx, 1);
                } else {
                    items[idx].quantity = newQty;
                }
                saveCartItems(items);
            }
        }

        // Remove item from cart
        function removeFromCart(key) {
            let items = getCartItems();
            items = items.filter(i => i.key !== key);
            saveCartItems(items);
            showCartToast('Item removed from cart');
        }

        // Clear all items in cart
        function clearCart() {
            saveCartItems([]);
            showCartToast('Cart cleared');
            try {
                fetch('{{ route("cart.clear") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                }).catch(() => {});
            } catch (e) {}
        }

        // Open offcanvas drawer
        function openCartDrawer() {
            renderCartUI();
            const el = document.getElementById('cartOffcanvas');
            if (el) {
                const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(el);
                bsOffcanvas.show();
            }
        }

        // Open Checkout Modal (Customer Login REQUIRED)
        function openCheckoutModal() {
            if (!window.DC_AUTH || !window.DC_AUTH.isCustomer) {
                openCustomerAuthModal('login');
                return;
            }

            const items = getCartItems();
            if (!items.length) {
                alert('Your cart is empty! Please add items before checking out.');
                return;
            }

            // Close offcanvas if open
            const offcanvasEl = document.getElementById('cartOffcanvas');
            if (offcanvasEl) {
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (bsOffcanvas) bsOffcanvas.hide();
            }

            // Pre-fill fields from DC_AUTH
            if (window.DC_AUTH) {
                const nameInput = document.getElementById('checkoutName');
                const emailInput = document.getElementById('checkoutEmail');
                const phoneInput = document.getElementById('checkoutPhone');
                if (nameInput && !nameInput.value && window.DC_AUTH.userName) nameInput.value = window.DC_AUTH.userName;
                if (emailInput && !emailInput.value && window.DC_AUTH.userEmail) emailInput.value = window.DC_AUTH.userEmail;
                if (phoneInput && !phoneInput.value && window.DC_AUTH.userPhone) phoneInput.value = window.DC_AUTH.userPhone;
            }

            // Render items preview in checkout modal
            const previewContainer = document.getElementById('checkoutItemsPreview');
            let subtotal = 0;
            let totalDiscount = 0;
            let appliedCoupon = null;
            let previewHtml = '';

            items.forEach(item => {
                const itemTotal = (item.price || 0) * (item.quantity || 1);
                const originalTotal = (item.original_price || item.price || 0) * (item.quantity || 1);
                subtotal += (item.original_price ? originalTotal : itemTotal);
                if (item.discount_amount) {
                    totalDiscount += (parseFloat(item.discount_amount) * (item.quantity || 1));
                } else if (item.original_price && item.original_price > item.price) {
                    totalDiscount += (originalTotal - itemTotal);
                }
                if (item.coupon_code) {
                    appliedCoupon = item.coupon_code;
                }

                previewHtml += `
                    <div class="d-flex align-items-center gap-2 bg-white p-2 rounded-2 border">
                        <img src="${item.thumbnail}" alt="${item.title}" style="width: 36px; height: 36px; object-fit: cover; border-radius: 6px;">
                        <div class="flex-grow-1" style="min-width: 0;">
                            <div class="text-dark small fw-bold text-truncate">${item.title}</div>
                            <small class="text-muted" style="font-size: 0.7rem;">
                                ${item.type} &bull; Qty: ${item.quantity}
                                ${item.coupon_code ? '<span class="badge bg-purple-subtle text-primary ms-1" style="font-size:0.62rem; background:#f3e8ff; color:#7c3aed;"><i class="fa-solid fa-tag me-0.5"></i>' + item.coupon_code + '</span>' : ''}
                            </small>
                        </div>
                        <div class="text-end">
                            <strong class="text-dark small d-block">₹${itemTotal.toLocaleString('en-IN')}</strong>
                            ${item.original_price && item.original_price > item.price ? '<small class="text-muted text-decoration-line-through" style="font-size:0.65rem;">₹' + originalTotal.toLocaleString('en-IN') + '</small>' : ''}
                        </div>
                    </div>
                `;
            });

            if (previewContainer) previewContainer.innerHTML = previewHtml;
            const subtotalEl = document.getElementById('checkoutSubtotal');
            const totalEl = document.getElementById('checkoutTotal');
            const discountRow = document.getElementById('checkoutDiscountRow');
            const discountCodeEl = document.getElementById('checkoutDiscountCode');
            const discountAmountEl = document.getElementById('checkoutDiscountAmount');

            const finalDue = Math.max(0, subtotal - totalDiscount);

            if (subtotalEl) subtotalEl.textContent = '₹' + subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 });
            if (discountRow) {
                if (totalDiscount > 0) {
                    discountRow.classList.remove('d-none');
                    if (discountCodeEl) discountCodeEl.textContent = appliedCoupon || 'COUPON';
                    if (discountAmountEl) discountAmountEl.textContent = '-₹' + totalDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2 });
                } else {
                    discountRow.classList.add('d-none');
                }
            }
            if (totalEl) totalEl.textContent = '₹' + finalDue.toLocaleString('en-IN', { minimumFractionDigits: 2 });

            // Store current checkout coupon info on window for submit
            window.activeCheckoutCoupon = appliedCoupon;
            window.activeCheckoutDiscount = totalDiscount;

            // Reset screens
            document.getElementById('checkoutFormScreen').style.display = 'block';
            document.getElementById('checkoutSuccessScreen').style.display = 'none';

            // Show checkout modal
            const modalEl = document.getElementById('checkoutModal');
            if (modalEl) {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
                bsModal.show();
            }
        }

        // Handle Checkout Form Submission (Customer Login REQUIRED)
        async function handleCheckoutSubmit(e) {
            e.preventDefault();

            if (!window.DC_AUTH || !window.DC_AUTH.isCustomer) {
                openCustomerAuthModal('login');
                return;
            }

            const btn = document.getElementById('btnPlaceOrder');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing Order...';
            }

            const items = getCartItems();
            let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const payload = {
                _token: csrfToken,
                name: document.getElementById('checkoutName').value,
                email: document.getElementById('checkoutEmail').value,
                phone: document.getElementById('checkoutPhone').value,
                city: document.getElementById('checkoutCity').value,
                address: document.getElementById('checkoutAddress').value,
                payment_method: document.querySelector('input[name="paymentMethod"]:checked')?.value || 'Online UPI',
                coupon_code: window.activeCheckoutCoupon || null,
                discount: window.activeCheckoutDiscount || 0,
                items: items
            };

            try {
                let res = await fetch('{{ route("cart.checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                });

                // Auto-refresh token and seamlessly retry if 419 session expired occurs
                if (res.status === 419) {
                    try {
                        const refreshRes = await fetch('{{ route("refresh-csrf") }}');
                        const refreshData = await refreshRes.json();
                        if (refreshData && refreshData.token) {
                            csrfToken = refreshData.token;
                            payload._token = csrfToken;
                            document.querySelectorAll('meta[name="csrf-token"]').forEach(m => m.setAttribute('content', csrfToken));
                            document.querySelectorAll('input[name="_token"]').forEach(i => i.value = csrfToken);

                            res = await fetch('{{ route("cart.checkout") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify(payload)
                            });
                        }
                    } catch (retryErr) {
                        console.error('CSRF auto-recovery failed:', retryErr);
                    }
                }

                let data = {};
                try {
                    data = await res.json();
                } catch (e) {
                    data = { success: false, message: 'Server returned an invalid response. Please try again.' };
                }

                if (data.success) {
                    // Clear cart
                    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify([]));
                    renderCartUI();

                    // Show success screen
                    document.getElementById('checkoutFormScreen').style.display = 'none';
                    document.getElementById('checkoutSuccessScreen').style.display = 'block';
                    document.getElementById('successOrderRef').textContent = data.order_id || '#DC-10928';
                    document.getElementById('successAmount').textContent = '₹' + (data.total_amount || '0.00');
                    document.getElementById('successCustomer').textContent = data.customer_name || payload.name;
                } else if (data.auth_required) {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Confirm & Place Order</span>';
                    }
                    openCustomerAuthModal('login');
                } else {
                    alert(data.message || 'Error processing order. Please try again.');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Confirm & Place Order</span>';
                    }
                }
            } catch (err) {
                alert('Connection error during checkout. Please try again.');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Confirm & Place Order</span>';
                }
            }
        }

        // Render Cart UI inside offcanvas & navbar badge
        function renderCartUI() {
            const items = getCartItems();
            const badge = document.getElementById('cartNavBadge');
            const drawerCount = document.getElementById('cartDrawerCountText');
            const listContainer = document.getElementById('cartItemsList');
            const emptyState = document.getElementById('cartEmptyState');
            const footer = document.getElementById('cartFooterSection');

            // 1. Badge count
            const totalQty = items.reduce((sum, i) => sum + (i.quantity || 1), 0);
            if (badge) {
                if (totalQty > 0) {
                    badge.textContent = totalQty;
                    badge.style.display = 'inline-block';
                } else {
                    badge.textContent = '0';
                    badge.style.display = 'none';
                }
            }
            const mobBadge = document.getElementById('mobileCartNavBadge');
            if (mobBadge) {
                if (totalQty > 0) {
                    mobBadge.textContent = totalQty;
                    mobBadge.style.display = 'inline-block';
                } else {
                    mobBadge.textContent = '0';
                    mobBadge.style.display = 'none';
                }
            }

            if (drawerCount) {
                drawerCount.textContent = totalQty + (totalQty === 1 ? ' item in cart' : ' items in cart');
            }

            // 2. Empty vs Filled state
            if (!items.length) {
                if (listContainer) listContainer.style.display = 'none';
                if (emptyState) emptyState.style.display = 'block';
                if (footer) footer.style.display = 'none';
                return;
            }

            if (listContainer) listContainer.style.display = 'block';
            if (emptyState) emptyState.style.display = 'none';
            if (footer) footer.style.display = 'block';

            // 3. Render items
            let total = 0;
            let html = '';

            items.forEach(item => {
                const itemTotal = (item.price || 0) * (item.quantity || 1);
                total += itemTotal;
                const typeClass = item.type === 'Service' ? 'bg-success-subtle text-success' : (item.type === 'Product' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary');

                html += `
                    <div class="card border border-slate-200 rounded-3 p-2.5 mb-2.5 bg-white shadow-xs">
                        <div class="d-flex align-items-center gap-2.5">
                            <img src="${item.thumbnail}" alt="${item.title}" style="width: 58px; height: 58px; object-fit: cover; border-radius: 8px; flex-shrink: 0;" class="border">
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="badge ${typeClass} fw-bold" style="font-size: 0.6rem; padding: 0.15rem 0.45rem;">${item.type}</span>
                                    <button type="button" class="btn btn-sm text-danger p-0 border-0" onclick="removeFromCart('${item.key}')" title="Remove">
                                        <i class="fa-solid fa-trash-can" style="font-size: 0.8rem;"></i>
                                    </button>
                                </div>
                                <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.825rem;" title="${item.title}">${item.title}</h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <strong class="text-primary" style="font-size: 0.88rem;">₹${itemTotal.toLocaleString('en-IN')}</strong>
                                    
                                    <!-- Qty Selector -->
                                    <div class="d-flex align-items-center border rounded-2 bg-light px-1">
                                        <button type="button" class="btn btn-sm btn-link text-dark p-0 px-1 text-decoration-none" style="font-size: 0.75rem;" onclick="updateCartQty('${item.key}', -1)">&minus;</button>
                                        <span class="px-1.5 fw-bold" style="font-size: 0.75rem;">${item.quantity || 1}</span>
                                        <button type="button" class="btn btn-sm btn-link text-dark p-0 px-1 text-decoration-none" style="font-size: 0.75rem;" onclick="updateCartQty('${item.key}', 1)">&plus;</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            if (listContainer) listContainer.innerHTML = html;
            const subtotalEl = document.getElementById('cartSubtotalAmount');
            const totalEl = document.getElementById('cartTotalAmount');
            if (subtotalEl) subtotalEl.textContent = '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 2 });
            if (totalEl) totalEl.textContent = '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 2 });
        }

        // Show live toast message
        function showCartToast(msg) {
            const toastEl = document.getElementById('cartLiveToast');
            const toastMsg = document.getElementById('cartToastMsg');
            if (toastEl && toastMsg) {
                toastMsg.textContent = msg;
                const bsToast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3000 });
                bsToast.show();
            }
        }

        // Initialize Cart UI on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function () {
            renderCartUI();
        });
    </script>
    <script>
        // Modal module dynamic title
        const comingSoonModal = document.getElementById('comingSoonModal');
        if (comingSoonModal) {
            comingSoonModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const moduleName = button.getAttribute('data-module') || 'Marketplace Feature';
                const modalTitle = comingSoonModal.querySelector('#modalModuleName');
                modalTitle.textContent = moduleName + ' (Coming Soon)';
            });
        }

        // Auto-dismiss floating alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-floating');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Global Geolocation Detector (Navbar & Filter)
        function detectGlobalNavLocation() {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }
            const btn = document.getElementById('navLocationBtn');
            const origHtml = btn ? btn.innerHTML : '';
            if (btn) btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Locating...';

            navigator.geolocation.getCurrentPosition(function(pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const targetBase = window.location.pathname.startsWith('/businesses') ? "{{ route('businesses') }}" : "{{ route('home') }}";
                const url = new URL(targetBase, window.location.origin);
                url.searchParams.set('lat', lat);
                url.searchParams.set('lng', lng);
                url.searchParams.set('city', 'Near Me');
                url.searchParams.set('sort', 'nearest');
                window.location.href = url.toString();
            }, function(err) {
                alert('Unable to retrieve your location: ' + err.message + '. Please ensure location permissions are granted in your browser.');
                if (btn) btn.innerHTML = origHtml;
            }, { timeout: 10000, enableHighAccuracy: true });
        }
    </script>
    <!-- ========================================================================
         MOBILE BOTTOM FLOATING DOCK / NAVIGATION BAR (App-like UX on Phone)
         ======================================================================== -->
    <nav class="dc-mobile-bottom-dock d-md-none" aria-label="Mobile Navigation">
        <a href="{{ route('home') }}" class="dc-mob-dock-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('courses') }}" class="dc-mob-dock-item {{ request()->routeIs('courses*') || request()->routeIs('course.*') || request()->routeIs('elearn.*') ? 'active' : '' }}">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Courses</span>
        </a>
        <a href="{{ route('businesses') }}" class="dc-mob-dock-item {{ request()->routeIs('businesses') || request()->routeIs('business.*') ? 'active' : '' }}">
            <i class="fa-solid fa-building-columns"></i>
            <span>Institutes</span>
        </a>
        <a href="{{ route('services') }}" class="dc-mob-dock-item {{ request()->routeIs('services*') || request()->routeIs('service.*') ? 'active' : '' }}">
            <i class="fa-solid fa-briefcase"></i>
            <span>Services</span>
        </a>
        <button type="button" class="dc-mob-dock-item position-relative border-0 bg-transparent p-0" onclick="openCartDrawer()" title="View Cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="position-absolute top-0 start-50 translate-middle-x badge rounded-pill bg-danger" id="mobileCartNavBadge" style="display: none; font-size: 0.6rem; transform: translate(8px, -4px) !important;">
                0
            </span>
            <span>Cart</span>
        </button>
    </nav>

    @yield('scripts')
</body>
</html>

