@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 64px;">
    <div class="bg-mesh"></div>
    <div class="page-hero" style="padding-bottom: 32px;">
        <h1 class="section-title">🛒 Mon Panier</h1>
        <p class="section-subtitle" id="cart-item-count">Chargement du panier...</p>
    </div>

    <!-- Empty State -->
    <div class="container" id="empty-cart-view" style="display: none; padding-bottom: 80px;">
        <div class="empty" style="padding-top: 80px;">
            <div class="empty-icon">🛒</div>
            <div class="empty-title">Votre panier est vide</div>
            <div class="empty-desc">Découvrez nos services premium et remplissez votre panier!</div>
            <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                Explorer les produits
            </a>
        </div>
    </div>

    <!-- Filled State -->
    <div class="container" id="filled-cart-view" style="display: none; padding-bottom: 80px;">
        <div class="checkout-layout">
            <!-- Items list -->
            <div>
                <div style="display: flex; flex-direction: column; gap: 12px;" id="cart-items-container">
                    <!-- Items rendered via JS -->
                </div>

                <button id="clear-cart-btn" class="btn btn-danger btn-sm mt-md">
                    🗑️ Vider le panier
                </button>
            </div>

            <!-- Summary -->
            <div class="summary-card">
                <div class="summary-title">Récapitulatif</div>
                <div id="summary-items-container">
                    <!-- Summary items rendered via JS -->
                </div>
                <div class="summary-total">
                    <span class="label">Total</span>
                    <span class="value" id="summary-total-price">0 MAD</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-primary btn-full btn-lg">
                    💳 Finaliser la commande
                </a>
                <a href="{{ route('products') }}" class="btn btn-ghost btn-full mt-sm">
                    ← Continuer mes achats
                </a>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const emptyView = document.getElementById('empty-cart-view');
    const filledView = document.getElementById('filled-cart-view');
    const itemsContainer = document.getElementById('cart-items-container');
    const summaryContainer = document.getElementById('summary-items-container');
    const itemCountText = document.getElementById('cart-item-count');
    const totalPriceText = document.getElementById('summary-total-price');
    const clearBtn = document.getElementById('clear-cart-btn');

    function renderCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (window.updateCartCount) window.updateCartCount();

        if (cart.length === 0) {
            emptyView.style.display = 'block';
            filledView.style.display = 'none';
            itemCountText.innerText = '0 article dans votre panier';
            return;
        }

        emptyView.style.display = 'none';
        filledView.style.display = 'block';
        
        const count = cart.length;
        itemCountText.innerText = `${count} article${count > 1 ? 's' : ''} dans votre panier`;

        itemsContainer.innerHTML = '';
        summaryContainer.innerHTML = '';
        let total = 0;

        cart.forEach((item, i) => {
            const itemTotal = parseFloat(item.price) * item.quantity;
            total += itemTotal;

            // Render Cart Item
            const div = document.createElement('div');
            div.className = 'cart-item fade-in';
            div.style.animationDelay = `${i * 0.05}s`;
            
            const thumb = item.image ? `<img src="${item.image}" alt="${item.name}" />` : `<span>📦</span>`;
            
            const durationText = item.duration ? `<div style="font-size: 11px; color: var(--accent-cyan); font-weight: 700;">⏱ ${item.duration}</div>` : '';
            
            div.innerHTML = `
                <div class="cart-thumb">
                    ${thumb}
                </div>
                <div class="cart-info">
                    <div class="cart-name">${item.name}</div>
                    ${durationText}
                    <div class="cart-price">
                        ${itemTotal.toFixed(0)} MAD
                        ${item.quantity > 1 ? `<span style="color: var(--text-muted); font-weight: 400;"> (${parseFloat(item.price).toFixed(0)} × ${item.quantity})</span>` : ''}
                    </div>
                </div>
                <div class="cart-controls">
                    <button class="cart-qty-btn" onclick="updateQty(${item.id}, '${item.duration || ''}', ${item.quantity - 1})">−</button>
                    <span class="cart-qty-num">${item.quantity}</span>
                    <button class="cart-qty-btn" onclick="updateQty(${item.id}, '${item.duration || ''}', ${item.quantity + 1})">+</button>
                    <button class="cart-del" onclick="removeItem(${item.id}, '${item.duration || ''}')" title="Supprimer">🗑️</button>
                </div>
            `;
            itemsContainer.appendChild(div);

            // Render Summary Item
            const sumDiv = document.createElement('div');
            sumDiv.className = 'summary-row';
            sumDiv.innerHTML = `
                <span class="label" style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    ${item.name} ×${item.quantity}
                </span>
                <span class="value">${itemTotal.toFixed(0)} MAD</span>
            `;
            summaryContainer.appendChild(sumDiv);
        });

        totalPriceText.innerText = `${total.toFixed(0)} MAD`;
    }

    window.updateQty = (id, duration, newQty) => {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (newQty < 1) return;
        
        let item = cart.find(x => x.id === id && (x.duration || '') === duration);
        if (item) {
            item.quantity = newQty;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    };

    window.removeItem = (id, duration) => {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(x => !(x.id === id && (x.duration || '') === duration));
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    };

    if(clearBtn) {
        clearBtn.addEventListener('click', () => {
            if(confirm('Êtes-vous sûr de vouloir vider votre panier ?')) {
                localStorage.setItem('cart', JSON.stringify([]));
                renderCart();
            }
        });
    }

    renderCart();
});
</script>
<style>
.fade-in { animation: fadeIn 0.3s ease-out forwards; opacity: 0; }
@keyframes fadeIn { from { opacity: 0; transform: translateX(-16px); } to { opacity: 1; transform: translateX(0); } }
</style>
@endpush
