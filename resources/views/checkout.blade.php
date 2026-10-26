@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 64px;">
    <div class="bg-mesh"></div>
    <div class="page-hero" style="padding-bottom: 32px;">
        <h1 class="section-title">💳 Finaliser la commande</h1>
    </div>

    <!-- Empty State -->
    <div class="container" id="empty-checkout-view" style="display: none; padding-bottom: 80px;">
        <div class="empty" style="padding-top: 80px;">
            <div class="empty-icon">🛒</div>
            <div class="empty-title">Panier vide</div>
            <a href="{{ route('products') }}" class="btn btn-primary">Voir les produits</a>
        </div>
    </div>

    <!-- Checkout Form -->
    <div class="container" id="filled-checkout-view" style="display: none; padding-bottom: 80px;">
        <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <!-- Need to inject cart data inside form for backend processing -->
            <input type="hidden" name="items" id="cart_items_input" value="">
            <input type="hidden" name="total_amount" id="cart_total_amount_input" value="">
            
            <div class="checkout-layout">

                <!-- === LEFT === -->
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    <!-- Customer info -->
                    <div class="glass-card">
                        <div style="font-weight: 800; font-size: 17px; margin-bottom: 18px;">👤 Vos informations</div>
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Nom complet <span>*</span></label>
                                <input type="text" name="customer_name" id="customer_name" class="input" placeholder="Votre nom" required />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Téléphone <span>*</span></label>
                                <input type="text" name="customer_phone" id="customer_phone" class="input" placeholder="06XXXXXXXX" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email (optionnel)</label>
                            <input type="email" name="customer_email" class="input" placeholder="votre@email.com" />
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Note (optionnel)</label>
                            <textarea name="note" id="note" class="input" placeholder="Instructions particulières..."></textarea>
                        </div>
                    </div>

                    <!-- Payment method -->
                    <div class="glass-card">
                        <div style="font-weight: 800; font-size: 17px; margin-bottom: 16px;">💰 Mode de paiement</div>
                        <div class="pay-toggle">
                            <input type="hidden" name="payment_method" id="payment_method_input" value="bank_transfer">
                            <button type="button" class="pay-option bank active" id="btn-pay-bank" onclick="setPayMethod('bank_transfer')">
                                <div class="pay-option-icon">🏦</div>
                                <div class="pay-option-name">Virement Bancaire</div>
                                <div class="pay-option-sub">RIB fourni ci-dessous</div>
                            </button>
                            <button type="button" class="pay-option wa" id="btn-pay-wa" onclick="setPayMethod('whatsapp')">
                                <div class="pay-option-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
                                </div>
                                <div class="pay-option-name">WhatsApp</div>
                                <div class="pay-option-sub">Discutez directement</div>
                            </button>
                        </div>

                        <!-- Bank Transfer RIB Cards -->
                        <div id="bank-info-card" class="bank-card fade-in">
                            <!-- Bank Tabs -->
                            <div class="bank-tabs">
                                <button type="button" class="bank-tab active" id="tab-cih" onclick="selectBank('cih')">🏦 <span class="hide-mobile">Virement </span>CIH</button>
                                <button type="button" class="bank-tab" id="tab-bp" onclick="selectBank('bp')">🏛️ <span class="hide-mobile">Virement </span>Banque Populaire</button>
                            </div>

                            <!-- CIH Bank Info -->
                            <div id="bank-cih" class="bank-tab-content">
                                <div class="bank-header">
                                    <div class="bank-ico">🏦</div>
                                    <div>
                                        <div class="bank-n">Virement bancaire</div>
                                        <div class="bank-t">Compte professionnel (CIH)</div>
                                    </div>
                                </div>
                                <div class="rib-label">RIB — Relevé d'Identité Bancaire</div>
                                <div class="rib-value" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                                    <span>230 780 9487104211023300 59</span>
                                    <button type="button" class="copy-btn" onclick="copyToClipboard('230 780 9487104211023300 59', this)">
                                        <i class="far fa-copy"></i> Copier
                                    </button>
                                </div>
                                <div class="bank-row">
                                    <span class="bank-row-label">Bénéficiaire</span>
                                    <span class="bank-row-value">MOHAMMED AMINE ADI</span>
                                </div>
                            </div>

                            <!-- Banque Populaire Info -->
                            <div id="bank-bp" class="bank-tab-content" style="display:none;">
                                <div class="bank-header">
                                    <div class="bank-ico">🏛️</div>
                                    <div>
                                        <div class="bank-n">Virement bancaire</div>
                                        <div class="bank-t">Compte professionnel (BP)</div>
                                    </div>
                                </div>
                                <div class="rib-label">RIB — Relevé d'Identité Bancaire</div>
                                <div class="rib-value" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                                    <span>190 780 2111101886030004 95</span>
                                    <button type="button" class="copy-btn" onclick="copyToClipboard('190 780 2111101886030004 95', this)">
                                        <i class="far fa-copy"></i> Copier
                                    </button>
                                </div>
                                <div class="bank-row">
                                    <span class="bank-row-label">Bénéficiaire</span>
                                    <span class="bank-row-value">ADI MOHAMMED AMINE</span>
                                </div>
                            </div>

                            <!-- Montant commun -->
                            <div class="bank-row" style="margin-top: 12px;">
                                <span class="bank-row-label">Montant à virer</span>
                                <span class="bank-row-value" style="color: var(--accent-cyan); font-size: 17px;" id="bank-total-amount">
                                    0 MAD
                                </span>
                            </div>
                            <div class="alert alert-warn mt-md">
                                <span>⚠️</span>
                                <span>
                                    Après le virement, envoyez le reçu sur WhatsApp au 
                                    <a href="https://wa.me/212665654367" target="_blank" rel="noreferrer" style="color: #25D366; font-weight: 700;">
                                        +212665654367
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- === RIGHT — SUMMARY === -->
                <div class="summary-card">
                    <div class="summary-title">📋 Récapitulatif</div>
                    <div id="summary-items-container">
                        <!-- Summary rendered via JS -->
                    </div>
                    <div class="summary-total">
                        <span class="label">Total</span>
                        <span class="value" id="summary-total-price">0 MAD</span>
                    </div>

                    <div id="btn-submit-bank">
                        <button type="submit" class="btn btn-primary btn-full btn-lg" id="submit-real-btn">
                            ✅ Confirmer la commande
                        </button>
                    </div>
                    
                    <div id="btn-submit-wa" style="display: none;">
                        <button type="button" class="btn btn-whatsapp btn-full btn-lg" onclick="handleWaCheckout()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
                            Envoyer sur WhatsApp
                        </button>
                    </div>

                    <a href="{{ route('cart') }}" class="btn btn-ghost btn-full mt-sm">
                        ← Modifier le panier
                    </a>
                </div>

            </div>
        </form>
    </div>
</main>
@endsection

@push('scripts')
<script>
let globalCart = [];
let globalTotal = 0;

window.selectBank = function(bank) {
    const cih = document.getElementById('bank-cih');
    const bp  = document.getElementById('bank-bp');
    const tabCih = document.getElementById('tab-cih');
    const tabBp  = document.getElementById('tab-bp');
    if (bank === 'cih') {
        cih.style.display = 'block';
        bp.style.display  = 'none';
        tabCih.classList.add('active');
        tabBp.classList.remove('active');
    } else {
        cih.style.display = 'none';
        bp.style.display  = 'block';
        tabBp.classList.add('active');
        tabCih.classList.remove('active');
    }
};

window.setPayMethod = function(method) {
    document.getElementById('payment_method_input').value = method;
    if (method === 'bank_transfer') {
        document.getElementById('btn-pay-bank').classList.add('active');
        document.getElementById('btn-pay-wa').classList.remove('active');
        document.getElementById('bank-info-card').style.display = 'block';
        document.getElementById('btn-submit-bank').style.display = 'block';
        document.getElementById('btn-submit-wa').style.display = 'none';
        setTimeout(() => document.getElementById('bank-info-card').classList.add('fade-in'), 10);
    } else {
        document.getElementById('btn-pay-wa').classList.add('active');
        document.getElementById('btn-pay-bank').classList.remove('active');
        document.getElementById('bank-info-card').style.display = 'none';
        document.getElementById('btn-submit-bank').style.display = 'none';
        document.getElementById('btn-submit-wa').style.display = 'block';
    }
};

window.handleWaCheckout = function() {
    const name = document.getElementById('customer_name').value;
    const phone = document.getElementById('customer_phone').value;

    if (!name || !phone) {
        alert('Veuillez remplir le nom et le téléphone.');
        return;
    }

    // Set payment method to whatsapp just in case
    setPayMethod('whatsapp');
    
    // Submit the form to record order in DB
    const form = document.getElementById('checkout-form');
    if (typeof form.requestSubmit === 'function') {
        form.requestSubmit();
    } else {
        form.submit();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    globalCart = cart;
    const emptyView = document.getElementById('empty-checkout-view');
    const filledView = document.getElementById('filled-checkout-view');

    // Update navbar badge
    let dBadge = document.getElementById('nav-cart-badge');
    let mBadge = document.getElementById('mobile-cart-count');
    let navCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    if(navCount > 0) {
        if(dBadge) { dBadge.style.display = 'inline-block'; dBadge.innerText = navCount; }
        if(mBadge) mBadge.innerText = `(${navCount})`;
    } else {
        if(dBadge) dBadge.style.display = 'none';
        if(mBadge) mBadge.innerText = '';
    }

    if (cart.length === 0) {
        emptyView.style.display = 'block';
        filledView.style.display = 'none';
        return;
    }

    emptyView.style.display = 'none';
    filledView.style.display = 'block';

    const sumContainer = document.getElementById('summary-items-container');
    const inputCart = document.getElementById('cart_items_input');
    const inputTotal = document.getElementById('cart_total_amount_input');
    
    // Fill hidden input for backend tracking
    inputCart.value = JSON.stringify(cart);

    let total = 0;
    cart.forEach(item => {
        const itemTotal = parseFloat(item.price) * item.quantity;
        total += itemTotal;

        const div = document.createElement('div');
        div.className = 'summary-row';
        div.innerHTML = `
            <span class="label" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 170px;">
                ${item.name} ×${item.quantity}
            </span>
            <span class="value">${itemTotal.toFixed(0)} MAD</span>
        `;
        sumContainer.appendChild(div);
    });

    globalTotal = total;
    inputTotal.value = total;
    document.getElementById('summary-total-price').innerText = `${total.toFixed(0)} MAD`;
    document.getElementById('bank-total-amount').innerText = `${total.toFixed(0)} MAD`;

    // Intercept form submit to clear cart and show loading
    document.getElementById('checkout-form').addEventListener('submit', (e) => {
        const btn = document.getElementById('submit-real-btn');
        btn.innerHTML = '⏳ En cours...';
        btn.disabled = true;
        // On succcess, the backend redirects. And we need to clear localstorage.
        // Easiest is to clear it now right before the submit continues
        localStorage.setItem('cart', JSON.stringify([])); 
    });
});
</script>
<style>
.fade-in { animation: fadeIn 0.3s ease-out forwards; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

/* Bank Tabs Layout Improvement */
.bank-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 18px;
}

/* Vertical stacking for better mobile accessibility */
@media (max-width: 640px) {
    .bank-tabs {
        flex-direction: column;
        gap: 10px;
    }
}

.bank-tab {
    flex: 1;
    padding: 14px 16px; /* Slightly more padding for better touch targets */
    border: 1px solid var(--border);
    border-radius: 12px;
    background: #fff;
    color: var(--text-muted);
    font-size: 14px; /* Increased font size for readability */
    font-weight: 600;
    cursor: pointer;
    transition: var(--t);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 52px; /* Ensure a minimum height for touch devices */
}
.bank-tab:hover {
    border-color: var(--primary-light);
    color: var(--primary);
    background: var(--bg-card-2);
}
.bank-tab.active {
    border-color: var(--primary);
    background: rgba(37, 99, 235, 0.08);
    color: var(--primary);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
}
</style>
@endpush
