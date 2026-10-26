<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administration | Digitalay</title>
    <link rel="icon" type="image/svg+xml" href="/logo192.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/app.css'])
    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .toast {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-left: 4px solid var(--primary);
            box-shadow: var(--shadow-xl);
            padding: 12px 16px;
            border-radius: var(--r);
            color: var(--text);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease forwards;
            min-width: 250px;
        }
        .toast.success { border-left-color: var(--accent-emerald); }
        .toast.error { border-left-color: var(--accent-rose); }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(100%); }
        }
    </style>
</head>
<body style="background: var(--bg);">

    <!-- Toast Container -->
    <div id="toast-container" class="toast-container"></div>

    <div class="admin-root">
        <!-- Sidebar overlay for mobile -->
        <div class="admin-overlay" id="admin-overlay" style="display: none;"></div>

        <!-- SIDEBAR -->
        <aside class="admin-sidebar" id="admin-sidebar">
            <div class="admin-sidebar-header">
                <div class="admin-logo">
                    <span class="admin-logo-text">digitalay</span>
                    <span class="admin-logo-badge">ADMIN</span>
                </div>
            </div>

            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'admin-nav-item-active' : '' }}">
                    <span class="admin-nav-icon">📊</span>
                    <span>Tableau de bord</span>
                    @if(request()->routeIs('admin.dashboard')) <span class="admin-nav-dot"></span> @endif
                </a>
                <a href="{{ route('admin.orders') }}" class="admin-nav-item {{ request()->routeIs('admin.orders*') ? 'admin-nav-item-active' : '' }}">
                    <span class="admin-nav-icon">🛒</span>
                    <span>Commandes</span>
                    @if(request()->routeIs('admin.orders*')) <span class="admin-nav-dot"></span> @endif
                </a>
                <a href="{{ route('admin.products') }}" class="admin-nav-item {{ request()->routeIs('admin.products*') ? 'admin-nav-item-active' : '' }}">
                    <span class="admin-nav-icon">🛍️</span>
                    <span>Produits</span>
                    @if(request()->routeIs('admin.products*')) <span class="admin-nav-dot"></span> @endif
                </a>
                <a href="{{ route('admin.categories') }}" class="admin-nav-item {{ request()->routeIs('admin.categories*') ? 'admin-nav-item-active' : '' }}">
                    <span class="admin-nav-icon">🏷️</span>
                    <span>Catégories</span>
                    @if(request()->routeIs('admin.categories*')) <span class="admin-nav-dot"></span> @endif
                </a>
                <a href="{{ route('admin.blog') }}" class="admin-nav-item {{ request()->routeIs('admin.blog*') ? 'admin-nav-item-active' : '' }}">
                    <span class="admin-nav-icon">📝</span>
                    <span>Blog</span>
                    @if(request()->routeIs('admin.blog*')) <span class="admin-nav-dot"></span> @endif
                </a>
                <a href="{{ route('admin.messages') }}" class="admin-nav-item {{ request()->routeIs('admin.messages*') ? 'admin-nav-item-active' : '' }}">
                    <span class="admin-nav-icon">✉️</span>
                    <span>Messages</span>
                    @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                        <span class="admin-badge-count" style="margin-left: auto; height: 22px; width: 22px; padding: 0; display: flex; align-items: center; justify-content: center;">{{ $unreadMessagesCount }}</span>
                    @elseif(request()->routeIs('admin.messages*'))
                        <span class="admin-nav-dot"></span>
                    @endif
                </a>
                <a href="{{ route('admin.settings') }}" class="admin-nav-item {{ request()->routeIs('admin.settings') ? 'admin-nav-item-active' : '' }}">
                    <span class="admin-nav-icon">⚙️</span>
                    <span>Paramètres</span>
                    @if(request()->routeIs('admin.settings')) <span class="admin-nav-dot"></span> @endif
                </a>
            </nav>

            <div class="admin-sidebar-footer">
                <a href="{{ route('admin.logout') }}" class="btn btn-outline btn-full" style="font-size: 13px; padding: 10px; display: block; text-align: center;">
                    🚪 Déconnexion
                </a>
                <a href="{{ route('home') }}" style="display: block; text-align: center; margin-top: 10px; font-size: 12px; color: var(--text-muted);">
                    ← Voir la boutique
                </a>
            </div>
        </aside>

        <!-- MAIN -->
        <div class="admin-main">
            <header class="admin-header">
                <div class="admin-header-left">
                    <button class="admin-hamburger" id="admin-hamburger" aria-label="Menu">
                        <span></span><span></span><span></span>
                    </button>
                    <div>
                        <div class="admin-page-title">@yield('title', 'Administration')</div>
                        <div class="admin-breadcrumb">Digitalay › @yield('title', 'Administration')</div>
                    </div>
                </div>
                <div class="admin-header-right">
                    <a href="{{ route('home') }}" class="admin-store-link">🏪 Boutique</a>
                    <div class="admin-avatar">
                        <div class="admin-avatar-circle">A</div>
                        <span class="admin-avatar-label">Admin</span>
                    </div>
                </div>
            </header>

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('success') }}", 'success');
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('error') }}", 'error');
            });
        </script>
    @endif

    <!-- Inline JS for Admin Layout -->
    <script>
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('admin-overlay');
        const hamburger = document.getElementById('admin-hamburger');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('admin-sidebar-open');
            overlay.style.display = sidebar.classList.contains('admin-sidebar-open') ? 'block' : 'none';
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('admin-sidebar-open');
            overlay.style.display = 'none';
        });

        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            const icon = type === 'success' ? '✅' : (type === 'error' ? '❌' : 'ℹ️');
            toast.innerHTML = `<span>${icon}</span> <span>${message}</span>`;
            
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'fadeOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
        
        // Make it globally available
        window.toast = {
            success: (msg) => showToast(msg, 'success'),
            error: (msg) => showToast(msg, 'error'),
            info: (msg) => showToast(msg, 'info')
        };
    </script>
    @stack('scripts')
</body>
</html>
