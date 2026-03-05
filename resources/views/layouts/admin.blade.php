<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Pita Queen Hub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --admin-bg: #0f1117;
            --admin-sidebar: #161822;
            --admin-card: #1a1d2e;
            --admin-border: #2a2d3e;
            --admin-text: #e1e4ed;
            --admin-text-muted: #8b8fa3;
            --admin-primary: #6366f1;
            --admin-primary-hover: #818cf8;
            --admin-success: #22c55e;
            --admin-danger: #ef4444;
            --admin-warning: #f59e0b;
            --sidebar-width: 260px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text);
            margin: 0;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--admin-sidebar);
            border-right: 1px solid var(--admin-border);
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--admin-border);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--admin-text);
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--admin-primary), #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .sidebar-brand-text {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .sidebar-brand-sub {
            font-size: 0.7rem;
            color: var(--admin-text-muted);
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
            color: var(--admin-text-muted);
            margin-top: 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1.5rem;
            color: var(--admin-text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            color: var(--admin-text);
            background-color: rgba(99, 102, 241, 0.08);
        }

        .sidebar-link.active {
            color: var(--admin-primary);
            background-color: rgba(99, 102, 241, 0.1);
            border-left-color: var(--admin-primary);
        }

        .sidebar-link i {
            font-size: 1.15rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--admin-border);
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
            background: linear-gradient(135deg, var(--admin-primary), #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .sidebar-user-name {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .sidebar-user-role {
            font-size: 0.7rem;
            color: var(--admin-text-muted);
        }

        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .admin-topbar {
            background-color: var(--admin-sidebar);
            border-bottom: 1px solid var(--admin-border);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-title {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .admin-content {
            padding: 2rem;
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
            border-radius: 12px;
        }

        /* Table Styles */
        .admin-table {
            color: var(--admin-text);
            margin-bottom: 0;
        }

        .admin-table thead th {
            background-color: rgba(99, 102, 241, 0.08);
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
            background-color: rgba(99, 102, 241, 0.04);
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
            background: linear-gradient(135deg, var(--admin-primary), #8b5cf6);
            color: #fff;
            border: none;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-admin-primary:hover {
            background: linear-gradient(135deg, var(--admin-primary-hover), #a78bfa);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--admin-border);
            background: transparent;
            color: var(--admin-text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }

        .btn-action:hover {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--admin-text);
            border-color: var(--admin-primary);
        }

        .btn-action-danger:hover {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--admin-danger);
            border-color: var(--admin-danger);
        }

        /* Search Input */
        .admin-search {
            background-color: var(--admin-bg);
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
            border-radius: 8px;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            font-size: 0.85rem;
            width: 300px;
            transition: border-color 0.2s ease;
        }

        .admin-search:focus {
            outline: none;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            background-color: var(--admin-bg);
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
            border-radius: 12px;
            color: var(--admin-text);
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
            filter: invert(1) grayscale(100%) brightness(200%);
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
            background-color: var(--admin-bg);
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
            border-radius: 8px;
            padding: 0.6rem 0.85rem;
            font-size: 0.9rem;
        }

        .admin-form-control:focus {
            background-color: var(--admin-bg);
            border-color: var(--admin-primary);
            color: var(--admin-text);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .admin-form-control::placeholder {
            color: var(--admin-text-muted);
        }

        .admin-form-select {
            background-color: var(--admin-bg);
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
            border-radius: 8px;
            padding: 0.6rem 0.85rem;
            font-size: 0.9rem;
        }

        .admin-form-select:focus {
            background-color: var(--admin-bg);
            border-color: var(--admin-primary);
            color: var(--admin-text);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .admin-form-select option {
            background-color: var(--admin-card);
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
            background-color: rgba(99, 102, 241, 0.1);
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
            background-color: rgba(239, 68, 68, 0.12);
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
            background: rgba(15, 17, 23, 0.7);
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
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <div class="sidebar-brand-icon">👑</div>
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
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn-action ms-1" title="Logout">
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
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Site
                </a>
            </div>
        </div>

        <div class="admin-content">
            @yield('content')
        </div>
    </div>

    <!-- Toast Container -->
    <div class="admin-toast" id="toastContainer"></div>

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
            toast.style.cssText = `background: var(--admin-card); border: 1px solid ${colors[type]}33; color: var(--admin-text); border-radius: 10px; animation: slideInRight 0.3s ease;`;
            toast.innerHTML = `<i class="bi ${icons[type]}" style="color: ${colors[type]}; font-size: 1.1rem;"></i><span style="font-size: 0.9rem;">${message}</span>`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // CSRF setup for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    </script>

    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>

    @stack('scripts')
</body>
</html>
