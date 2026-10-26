@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 64px;">
    <div class="bg-mesh"></div>

    <!-- Header -->
    <div class="page-hero">
        <h1 class="section-title fade-up-item">🛍️ Tous nos Services</h1>
        <p class="section-subtitle mb-md fade-up-item" style="animation-delay: 0.1s;">
            {{ $products->count() }} services disponibles
        </p>
        <div class="search-wrap fade-up-item" style="animation-delay: 0.2s;">
            <span class="search-ico">🔍</span>
            <form action="{{ route('products') }}" method="GET" style="width: 100%;">
                <input
                    type="search"
                    name="search"
                    class="search-input"
                    placeholder="Rechercher un service..."
                    value="{{ request('search') }}"
                    oninput="this.form.submit()"
                />
                @if(request('cat'))
                    <input type="hidden" name="cat" value="{{ request('cat') }}">
                @endif
            </form>
        </div>
    </div>

    <div class="container" style="padding-bottom: 80px;">
        <!-- Category pills -->
        <div class="mb-lg fade-in-scroll">
            <div class="cat-scroll">
                <a href="{{ route('products') }}" class="cat-chip {{ !request('cat') ? 'active' : '' }}">
                    ⭐ Tous
                </a>
                @foreach($categories as $c)
                    <a href="{{ route('products', ['cat' => $c->slug, 'search' => request('search')]) }}" 
                       class="cat-chip {{ request('cat') === $c->slug ? 'active' : '' }}">
                        {{ $c->name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($products->isEmpty())
            <div class="empty fade-in-scroll">
                <div class="empty-icon">🔍</div>
                <div class="empty-title">Aucun produit trouvé</div>
                <div class="empty-desc">Essayez une autre recherche ou catégorie</div>
            </div>
        @else
            <div class="products-grid">
                @foreach($products as $index => $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </div>
</main>

<style>
.fade-up-item { opacity: 0; transform: translateY(30px); animation: fadeUpAnim 0.6s ease-out forwards; }
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }
.fade-in-scroll { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
.fade-in-scroll.is-visible { opacity: 1; transform: translateY(0); }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-in-scroll').forEach(el => observer.observe(el));


    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const product = JSON.parse(e.currentTarget.getAttribute('data-product'));
            
            // Using global add to cart and upsell
            if (window.performGlobalAddToCart) {
                window.performGlobalAddToCart(product);
                
                // Simple visual feedback
                const origText = btn.innerHTML;
                btn.innerHTML = '✅ Ajouté';
                // Show global upsell immediately
                if (window.showGlobalUpsell) {
                    window.showGlobalUpsell(null, false);
                }

                setTimeout(() => {
                    btn.innerHTML = origText;
                }, 1500);
            }
        });
    });
});
</script>
@endpush
