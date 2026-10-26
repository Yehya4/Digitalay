<nav class="navbar">
    <div class="navbar-inner">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="navbar-logo" style="text-decoration: none;">
            <span style="font-size: 28px; font-weight: 900; background: linear-gradient(135deg, #1a3a8f, #2563eb); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -1px; font-family: Inter, system-ui, sans-serif;">
                digitalay
            </span>
        </a>

        <!-- Desktop links -->
        <div class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">🏠 Accueil</a>
            <a href="{{ route('products') }}" class="{{ request()->routeIs('products*') ? 'active' : '' }}">🛍️ Boutique</a>
            <a href="{{ route('blog') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">📝 Blog</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">✉️ Contact</a>
        </div>

        <div class="navbar-right">
            <a href="{{ route('cart') }}" class="cart-btn">
                🛒 <span class="d-none-mobile">Panier</span>
                <span class="cart-badge" id="nav-cart-badge" style="display: none;">0</span>
            </a>
            <button class="hamburger" id="hamburger-btn" aria-label="Ouvrir menu">
                ☰
            </button>
        </div>
    </div>
</nav>

<!-- Mobile drawer -->
<div class="mobile-nav" id="mobile-nav">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">🏠 Accueil</a>
    <a href="{{ route('products') }}" class="{{ request()->routeIs('products*') ? 'active' : '' }}">🛍️ Boutique</a>
    <a href="{{ route('blog') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">📝 Blog</a>
    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">✉️ Contact</a>
    <div class="mobile-nav-divider"></div>
    <a href="{{ route('cart') }}" style="background: rgba(30,58,138,0.1); border-color: rgba(30,58,138,0.2);">
        🛒 Mon Panier <span id="mobile-cart-count"></span>
    </a>
    <a href="https://wa.me/212665654367?text=Bonjour Digitalay!" target="_blank" rel="noreferrer" style="background: rgba(37,211,102,0.1); border-color: rgba(37,211,102,0.2); color: #25D366;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
            Commander WhatsApp
        </div>
    </a>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.updateCartCount = function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            const dBadge = document.getElementById('nav-cart-badge');
            const mBadge = document.getElementById('mobile-cart-count');
            
            if(dBadge) {
                dBadge.innerText = count;
                dBadge.style.display = count > 0 ? 'inline-block' : 'none';
            }
            if(mBadge) {
                mBadge.innerText = count > 0 ? `(${count})` : '';
            }
        };
        window.updateCartCount();

        const btn = document.getElementById('hamburger-btn');
        const nav = document.getElementById('mobile-nav');

        btn.addEventListener('click', () => {
            nav.classList.toggle('open');
            btn.innerHTML = nav.classList.contains('open') ? '✕' : '☰';
        });

        const links = nav.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('open');
                btn.innerHTML = '☰';
            });
        });
    });
</script>
@endpush
