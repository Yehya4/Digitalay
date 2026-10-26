@if(isset($globalUpsellProduct))
<div id="global-upsell-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content-premium fade-up">
        <button class="modal-close" onclick="closeGlobalUpsell()">×</button>
        <span class="modal-badge-premium">🔥 OFFRE SPÉCIALE</span>
        <h2 class="modal-title">Boostez votre abonnement</h2>
        <div class="upsell-item-box">
            @if($globalUpsellProduct->image_url)
                <img src="{{ $globalUpsellProduct->image_url }}" alt="{{ $globalUpsellProduct->name }}">
            @else
                <div style="width: 60px; height: 60px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px;">📦</div>
            @endif
            <div class="upsell-item-info">
                <h4>{{ $globalUpsellProduct->name }}</h4>
                <span class="upsell-price">{{ number_format($globalUpsellProduct->price, 0) }} MAD</span>
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn btn-primary btn-full" onclick="addGlobalUpsellAndContinue()">Ajouter l'offre +</button>
            <button class="btn btn-ghost btn-full" onclick="closeGlobalUpsell()">Non merci</button>
        </div>
    </div>
</div>
@endif

@php
    $upsellData = isset($globalUpsellProduct) ? [
        'id' => $globalUpsellProduct->id,
        'name' => $globalUpsellProduct->name,
        'price' => $globalUpsellProduct->price,
        'image' => $globalUpsellProduct->image_url,
        'quantity' => 1
    ] : null;
@endphp

<script>
window.globalUpsellData = @json($upsellData);

function showGlobalUpsell(pendingProduct, redirect = false) {
    window.pendingCartProduct = pendingProduct;
    window.upsellRedirect = redirect;
    
    const modal = document.getElementById('global-upsell-modal');
    // ONLY show modal if it exists (i.e., if upsell product is set)
    if(modal) {
        modal.style.display = 'flex';
    } else {
        // Fallback: just complete the action if no modal
        closeGlobalUpsell();
    }
}

function closeGlobalUpsell() {
    const modal = document.getElementById('global-upsell-modal');
    if(modal) modal.style.display = 'none';
    
    if (window.pendingCartProduct) {
        performGlobalAddToCart(window.pendingCartProduct);
        if (window.upsellRedirect) {
            window.location.href = "{{ route('cart') }}";
        }
    }
}

function addGlobalUpsellAndContinue() {
    if (window.globalUpsellData) {
        performGlobalAddToCart(window.globalUpsellData);
    }
    closeGlobalUpsell();
}

function performGlobalAddToCart(product) {
    if (!product) return;
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let existing = cart.find(x => x.id === product.id && (x.duration || '') === (product.duration || ''));
    
    const qtyToAdd = parseInt(product.quantity) || 1;

    if(existing) {
        existing.quantity += qtyToAdd;
    } else {
        cart.push({
            ...product,
            quantity: qtyToAdd
        });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    if(window.updateCartCount) window.updateCartCount();
}
</script>

<style>
/* Modal Styles (extracted from show.blade.php and generalized) */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(8px);
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-content-premium {
    max-width: 440px;
    width: 100%;
    background: #fff;
    padding: 48px 32px 40px;
    border-radius: 32px;
    position: relative;
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    z-index: 10001;
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 32px;
    height: 32px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    z-index: 10;
}

.modal-close:hover {
    background: #e2e8f0;
    color: #0f172a;
    transform: rotate(90deg);
}

.modal-badge-premium { 
    background: #2563eb; 
    color: #fff; 
    padding: 6px 16px; 
    border-radius: 100px; 
    font-size: 11px; 
    font-weight: 900; 
    margin-bottom: 20px; 
    display: inline-block; 
    letter-spacing: 0.5px;
}

.modal-title {
    font-size: 24px;
    font-weight: 900;
    color: #0f172a;
    margin-bottom: 12px;
    line-height: 1.2;
}

.upsell-item-box {
    background: #f8fafc;
    border: 1px solid rgba(37, 99, 235, 0.08);
    border-radius: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    text-align: left;
    margin: 24px 0;
}

.upsell-item-box img { width: 60px; height: 60px; border-radius: 12px; object-fit: cover; }
.upsell-item-info h4 { font-size: 16px; font-weight: 800; margin-bottom: 4px; color: #0f172a; }
.upsell-price { color: #2563eb; font-weight: 900; font-size: 18px; }

.modal-actions { display: flex; flex-direction: column; gap: 10px; }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-up {
    animation: fadeUp 0.5s ease forwards;
}
</style>
