<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Pita Queen</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --admin-bg: #eef3ff;
            --admin-sidebar: #1a47c7;
            --admin-card: #ffffff;
            --admin-border: #dfe7f5;
            --admin-text: #1f2c51;
            --admin-text-muted: #6276a7;
            --admin-primary: #1f57ff;
            --admin-primary-hover: #1a43cd;
            --admin-success: #15b78c;
            --admin-danger: #f4526f;
            --admin-warning: #f09a2a;
            --admin-shadow-soft: 0 10px 28px rgba(33, 61, 126, 0.08);
            --admin-shadow-strong: 0 24px 44px rgba(22, 44, 96, 0.12);
            --sidebar-width: 260px;
        }

        * { box-sizing: border-box; }

        *::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        *::-webkit-scrollbar-track {
            background: #eaf0fb;
        }

        *::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #90a8df, #5d7fd1);
            border-radius: 999px;
            border: 2px solid #eaf0fb;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(circle at 8% -14%, rgba(31, 87, 255, 0.2), transparent 38%),
                radial-gradient(circle at 95% -10%, rgba(70, 198, 255, 0.18), transparent 34%),
                var(--admin-bg);
            color: var(--admin-text);
            margin: 0;
            min-height: 100vh;
        }

        .admin-ambient {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .admin-ambient::before,
        .admin-ambient::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            filter: blur(2px);
        }

        .admin-ambient::before {
            width: 340px;
            height: 340px;
            left: -120px;
            top: 180px;
            background: radial-gradient(circle, rgba(31, 87, 255, 0.12) 0%, rgba(31, 87, 255, 0) 70%);
        }

        .admin-ambient::after {
            width: 290px;
            height: 290px;
            right: -100px;
            bottom: 60px;
            background: radial-gradient(circle, rgba(21, 183, 140, 0.12) 0%, rgba(21, 183, 140, 0) 70%);
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(165deg, #1a47c7 0%, #2157df 52%, #1f66f2 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 14px 0 34px rgba(21, 63, 176, 0.38);
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
            background: linear-gradient(180deg, rgba(140, 203, 255, 0.24), rgba(60, 126, 255, 0));
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #fff;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            overflow: hidden;
            box-shadow: 0 0 0 2px rgba(31, 87, 255, 0.14), 0 8px 18px rgba(31, 87, 255, 0.18);
        }

        .sidebar-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-brand-text {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .sidebar-brand-sub {
            font-size: 0.7rem;
            color: rgba(212, 224, 255, 0.76);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .nav-section-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(219, 233, 255, 0.72);
            margin-top: 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1.5rem;
            color: rgba(233, 242, 255, 0.94);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            border-left: 3px solid transparent;
            border-radius: 0 12px 12px 0;
            margin: 0.12rem 0.8rem 0.12rem 0;
        }

        .sidebar-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.18);
            transform: translateX(2px);
        }

        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(155, 214, 255, 0.32), rgba(255, 255, 255, 0.12));
            border-left-color: #d8f0ff;
            font-weight: 600;
            box-shadow: inset 0 0 0 1px rgba(216, 240, 255, 0.38);
        }

        .sidebar-link i {
            font-size: 1.15rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.16);
            background-color: rgba(10, 28, 86, 0.24);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--admin-primary), #2dc1ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            color: #fff;
            box-shadow: 0 8px 20px rgba(31, 87, 255, 0.32);
        }

        .sidebar-user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
        }

        .sidebar-user-role {
            font-size: 0.7rem;
            color: rgba(205, 222, 255, 0.72);
        }

        .sidebar-footer .btn-action {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.18);
            color: rgba(233, 242, 255, 0.92);
        }

        .sidebar-footer .btn-action:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.34);
        }

        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .admin-topbar {
            background: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid rgba(223, 231, 245, 0.9);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 24px rgba(31, 60, 126, 0.08);
        }

        .topbar-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.18rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .admin-content {
            padding: 2rem 2.2rem;
            animation: contentLift 0.35s ease;
        }

        .topbar-action-btn {
            border-radius: 999px;
            border-color: rgba(31, 87, 255, 0.28);
            color: var(--admin-primary);
            font-weight: 700;
            padding-inline: 0.95rem;
            background: rgba(31, 87, 255, 0.03);
        }

        .topbar-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.34rem 0.72rem;
            border-radius: 999px;
            border: 1px solid rgba(31, 87, 255, 0.22);
            background: rgba(31, 87, 255, 0.05);
            color: var(--admin-primary);
            font-size: 0.76rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .topbar-action-btn:hover {
            background: rgba(31, 87, 255, 0.1);
            border-color: var(--admin-primary);
            color: var(--admin-primary);
        }

        /* Sidebar Toggle (mobile) */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--admin-text);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .admin-main {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: inline-block;
            }
        }

        /* Cards */
        .admin-card {
            background-color: var(--admin-card);
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            box-shadow: var(--admin-shadow-soft);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .admin-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 34px rgba(33, 61, 126, 0.12);
        }

        /* Table Styles */
        .admin-table {
            color: var(--admin-text);
            margin-bottom: 0;
        }

        .admin-table thead th {
            background: linear-gradient(180deg, rgba(31, 87, 255, 0.08), rgba(31, 87, 255, 0.02));
            color: var(--admin-text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            border-bottom: 1px solid var(--admin-border);
            padding: 0.85rem 1rem;
            white-space: nowrap;
        }

        .sortable-header {
            cursor: pointer;
            user-select: none;
            transition: color 0.2s ease;
        }

        .sortable-header:hover {
            color: var(--admin-text) !important;
        }

        .sort-icon {
            font-size: 0.65rem;
            margin-left: 0.25rem;
            opacity: 0.5;
        }

        .sortable-header:hover .sort-icon {
            opacity: 1;
        }

        .admin-table tbody td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--admin-border);
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .admin-table tbody tr:hover {
            background-color: rgba(31, 87, 255, 0.035);
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Product Thumbnail */
        .product-thumb {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--admin-border);
        }

        .product-thumb-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            background-color: var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--admin-text-muted);
            font-size: 1.25rem;
        }

        /* Status Badge */
        .badge-status {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active {
            background-color: rgba(34, 197, 94, 0.15);
            color: var(--admin-success);
        }

        .badge-inactive {
            background-color: rgba(239, 68, 68, 0.15);
            color: var(--admin-danger);
        }

        /* Buttons */
        .btn-admin-primary {
            background: linear-gradient(135deg, var(--admin-primary), #2cb8ff);
            color: #fff;
            border: none;
            padding: 0.6rem 1.25rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            transition: all 0.2s ease;
            box-shadow: 0 10px 24px rgba(31, 87, 255, 0.28);
        }

        .btn-admin-primary:hover {
            background: linear-gradient(135deg, var(--admin-primary-hover), #1b8fd7);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(31, 87, 255, 0.34);
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid var(--admin-border);
            background: #fff;
            color: var(--admin-text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }

        .btn-action:hover {
            background-color: rgba(31, 87, 255, 0.08);
            color: var(--admin-primary);
            border-color: var(--admin-primary);
            transform: translateY(-1px);
        }

        .btn-action-danger:hover {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--admin-danger);
            border-color: var(--admin-danger);
        }

        /* Search Input */
        .admin-search {
            background-color: #fff;
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
            border-radius: 10px;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            font-size: 0.85rem;
            width: 300px;
            transition: border-color 0.2s ease;
            box-shadow: 0 4px 12px rgba(33, 61, 126, 0.05);
        }

        .admin-search:focus {
            outline: none;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(57, 106, 255, 0.12);
            background-color: #fff;
            color: var(--admin-text);
        }

        .admin-search::placeholder {
            color: var(--admin-text-muted);
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--admin-text-muted);
            font-size: 0.9rem;
        }

        /* Modal Overrides */
        .modal-content {
            background-color: var(--admin-card);
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            color: var(--admin-text);
            box-shadow: var(--admin-shadow-strong);
        }

        .modal-header {
            border-bottom: 1px solid var(--admin-border);
            padding: 1.25rem 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--admin-border);
            padding: 1rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .btn-close {
            filter: none;
        }

        .admin-form-label {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--admin-text-muted);
            margin-bottom: 0.4rem;
        }

        .admin-form-control {
            background-color: #fff;
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
            border-radius: 10px;
            padding: 0.6rem 0.85rem;
            font-size: 0.9rem;
        }

        .admin-form-control:focus {
            background-color: #fff;
            border-color: var(--admin-primary);
            color: var(--admin-text);
            box-shadow: 0 0 0 3px rgba(57, 106, 255, 0.12);
        }

        .admin-form-control::placeholder {
            color: var(--admin-text-muted);
        }

        .admin-form-select {
            background-color: #fff;
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
            border-radius: 10px;
            padding: 0.6rem 0.85rem;
            font-size: 0.9rem;
        }

        .admin-form-select:focus {
            background-color: #fff;
            border-color: var(--admin-primary);
            color: var(--admin-text);
            box-shadow: 0 0 0 3px rgba(57, 106, 255, 0.12);
        }

        .admin-form-select option {
            background-color: #fff;
            color: var(--admin-text);
        }

        /* Image Preview */
        .image-preview-wrapper {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            border: 2px dashed var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .image-preview-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-wrapper .placeholder-icon {
            color: var(--admin-text-muted);
            font-size: 2rem;
        }

        /* Pagination */
        .admin-pagination .page-link {
            background-color: var(--admin-card);
            border-color: var(--admin-border);
            color: var(--admin-text-muted);
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
        }

        .admin-pagination .page-link:hover {
            background-color: rgba(57, 106, 255, 0.08);
            border-color: var(--admin-primary);
            color: var(--admin-text);
        }

        .admin-pagination .page-item.active .page-link {
            background-color: var(--admin-primary);
            border-color: var(--admin-primary);
            color: #fff;
        }

        .admin-pagination .page-item.disabled .page-link {
            background-color: var(--admin-card);
            border-color: var(--admin-border);
            color: var(--admin-text-muted);
            opacity: 0.5;
        }

        /* Toast / Alert */
        .admin-toast {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            min-width: 300px;
        }

        /* Confirm Modal */
        .confirm-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: rgba(254, 92, 115, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--admin-danger);
            font-size: 1.75rem;
        }

        .text-description-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Loading overlay */
        .loading-overlay {
            position: absolute;
            inset: 0;
            background: rgba(245, 247, 250, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 12px;
        }

        .invalid-feedback {
            font-size: 0.8rem;
        }

        @media (max-width: 767.98px) {
            .admin-content { padding: 1rem; }
            .admin-search { width: 100%; }
            .text-description-preview { max-width: 120px; }
            .admin-topbar { padding: 0.85rem 1rem; }
            .topbar-status-pill { display: none; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="admin-ambient" aria-hidden="true"></div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <img src="/images/logo.png" alt="Pita Queen">
                </div>
                <div>
                    <div class="sidebar-brand-text">Pita Queen</div>
                    <div class="sidebar-brand-sub">Admin Panel</div>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <div class="nav-section-title">Management</div>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Products</span>
            </a>
            <a href="{{ route('admin.locations.index') }}" class="sidebar-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Manage Locations</span>
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="sidebar-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="bi bi-chat-left-quote-fill"></i>
                <span>Testimonials</span>
            </a>
            <a href="{{ route('admin.contacts.edit') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="bi bi-telephone-fill"></i>
                <span>Manage Contacts</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-grow-1">
                    <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" id="logoutForm">
                    @csrf
                    <button
                        type="button"
                        class="btn-action ms-1"
                        title="Logout"
                        data-bs-toggle="modal"
                        data-bs-target="#logoutConfirmModal"
                    >
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="topbar-status-pill">
                    <i class="bi bi-clock-history"></i>
                    <span id="adminLiveDateTime">--</span>
                </span>
                <a href="{{ route('home') }}" class="btn btn-sm topbar-action-btn" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Site
                </a>
            </div>
        </div>

        <div class="admin-content">
            @yield('content')
        </div>
    </div>

    <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <div class="confirm-icon">
                        <i class="bi bi-box-arrow-right"></i>
                    </div>
                    <h5 class="mb-2" id="logoutConfirmModalLabel">Sign out now?</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Your current admin session will be closed.</p>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="admin-toast" id="toastContainer" role="status" aria-live="polite" aria-atomic="true"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        });
        document.getElementById('sidebarOverlay')?.addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.remove('show');
            this.classList.remove('show');
        });

        // Toast Helper
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const icons = { success: 'bi-check-circle-fill', danger: 'bi-exclamation-triangle-fill', warning: 'bi-exclamation-circle-fill' };
            const colors = { success: '#22c55e', danger: '#ef4444', warning: '#f59e0b' };

            const toast = document.createElement('div');
            toast.className = 'alert d-flex align-items-center gap-2 shadow-lg mb-2';
            toast.style.cssText = `background: #fff; border: 1px solid ${colors[type]}33; color: var(--admin-text); border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); animation: slideInRight 0.3s ease;`;
            toast.innerHTML = `<i class="bi ${icons[type]}" style="color: ${colors[type]}; font-size: 1.1rem;"></i><span style="font-size: 0.9rem;">${message}</span>`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        @if(session('status'))
            showToast(@json(session('status')), 'success');
        @endif

        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @endif

        @if(session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif

        @if(session('error'))
            showToast(@json(session('error')), 'danger');
        @endif

        // CSRF setup for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        document.getElementById('confirmLogoutBtn')?.addEventListener('click', function () {
            document.getElementById('logoutForm')?.submit();
        });

        const liveDateTime = document.getElementById('adminLiveDateTime');
        if (liveDateTime) {
            const formatter = new Intl.DateTimeFormat(undefined, {
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
            });

            const updateLiveDateTime = () => {
                liveDateTime.textContent = formatter.format(new Date());
            };

            updateLiveDateTime();
            setInterval(updateLiveDateTime, 30000);
        }
    </script>

    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes contentLift {
            from { transform: translateY(8px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>

    @stack('scripts')
</body>
</html>
