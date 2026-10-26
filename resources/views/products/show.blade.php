@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 64px;">
    <div class="bg-mesh"></div>

    <!-- ═══ TOP BAR ═══ -->
    <div class="detail-top-bar">
        <div class="container" style="display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
            <a href="javascript:history.back()" class="btn btn-ghost btn-sm" style="display: flex; align-items: center; gap: 6px;">
                ← Retour
            </a>

            <div class="breadcrumb" style="flex: 1; display: flex; justify-content: center;">
                <a href="{{ route('home') }}" style="color: var(--text-muted)">Accueil</a>
                <span class="breadcrumb-sep">›</span>
                <a href="{{ route('products') }}" style="color: var(--text-muted)">Produits</a>
                <span class="breadcrumb-sep">›</span>
                <span style="color: var(--primary-light); max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $product->name }}
                </span>
            </div>

            <button class="btn btn-primary btn-sm add-multi-cart" data-product="{{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'image' => $product->image_url]) }}">
                🛒 Ajouter au panier
            </button>
        </div>
    </div>

    <!-- ═══ MAIN CONTENT ═══ -->
    <div class="container" style="padding: 24px 16px 80px;">
        <div class="detail-grid">

            <!-- ═══ LEFT: PRODUCT VISUALS ═══ -->
            <div class="fade-up-item">
                <div class="detail-img-container">
                    <div class="detail-img-wrap">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="main-product-image" />
                        @else
                            <div class="placeholder-img">
                                <span style="font-size: 80px;">📦</span>
                            </div>
                        @endif
                        
                        @if($product->badge)
                            <div class="hero-badge" style="background: {{ $product->badge_color ?? 'var(--grad-primary)' }};">
                                {{ $product->badge }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="detail-trust-grid">
                    <div class="trust-card">
                        <div class="trust-icon">⚡</div>
                        <div class="trust-content">
                            <span class="trust-title">Livraison Rapide</span>
                            <span class="trust-sub">Activation en < 30min</span>
                        </div>
                    </div>
                    <div class="trust-card">
                        <div class="trust-icon">🔒</div>
                        <div class="trust-content">
                            <span class="trust-title">100% Sécurisé</span>
                            <span class="trust-sub">SSL & HTTPS Garanti</span>
                        </div>
                    </div>
                    <div class="trust-card">
                        <div class="trust-icon">✅</div>
                        <div class="trust-content">
                            <span class="trust-title">Qualité Premium</span>
                            <span class="trust-sub">Service Authentique</span>
                        </div>
                    </div>
                    <div class="trust-card highlight">
                        <div class="trust-icon"><i class="fab fa-whatsapp"></i></div>
                        <div class="trust-content">
                            <span class="trust-title">Support 24/7</span>
                            <span class="trust-sub">Assistance Directe</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ═══ RIGHT: PRODUCT INFO & ACTIONS ═══ -->
            <div class="fade-up-item" style="animation-delay: 0.15s;">
                <div class="info-header">
                    <div class="info-meta">
                        <a href="{{ route('products', ['cat' => $product->category->slug ?? '']) }}" class="category-tag">
                            {{ $product->category->name ?? 'Général' }}
                        </a>
                        @if($product->original_price && $product->original_price > $product->price)
                            <span class="discount-pill">
                                -{{ $product->discount_percent }}% OFF
                            </span>
                        @endif
                    </div>

                    <h1 class="detail-title-premium">{{ $product->name }}</h1>
                    <div class="rating-summary">
                        <div class="stars">⭐⭐⭐⭐⭐</div>
                        <span class="review-count">(4.9/5 • 120+ avis)</span>
                    </div>
                </div>

                <!-- SELECT DURATION -->
                <div class="premium-selection-box fade-up-item" style="animation-delay: 0.2s;">
                    <div class="selection-header">
                        <h3 class="selection-title">Choisir votre forfait</h3>
                        @if($product->original_price && $product->original_price > $product->price)
                            <div id="savings-badge" class="selection-savings">
                                Économisez <span id="savings-percent-top">{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}</span>%
                            </div>
                        @endif
                    </div>

                    @if($product->durations->count() > 0)
                        <div class="duration-grid">
                            @foreach($product->durations as $index => $dur)
                                <div class="duration-card {{ $index === 0 ? 'active' : '' }}" 
                                     data-price="{{ $dur->price }}" 
                                     data-original="{{ $dur->original_price }}" 
                                     data-name="{{ $dur->duration_name }}"
                                     onclick="selectPlanCard(this)">
                                    <div class="duration-card-inner">
                                        <div class="duration-name">{{ $dur->duration_name }}</div>
                                        <div class="duration-pricing">
                                            <div class="curr-price">{{ number_format($dur->price, 0) }} MAD</div>
                                            @if($dur->original_price && $dur->original_price > $dur->price)
                                                <div class="old-price">{{ number_format($dur->original_price, 0) }} MAD</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($dur->original_price && $dur->original_price > $dur->price)
                                        <div class="duration-badge">-{{ round((($dur->original_price - $dur->price) / $dur->original_price) * 100) }}%</div>
                                    @endif
                                    <div class="check-mark">✓</div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="premium-price-box">
                        <div class="price-header">
                            <span class="price-label">PRIX TOTAL</span>
                            <div id="savings-box" class="price-savings" style="{{ ($product->original_price && $product->original_price > $product->price) ? '' : 'display: none;' }}">
                                Économie: <span id="savings-amount">{{ number_format($product->original_price - $product->price, 0) }}</span> MAD
                            </div>
                        </div>
                        <div class="price-display">
                            <span class="price-symbol">MAD</span>
                            <span class="price-value" id="main-price">{{ number_format($product->price, 0) }}</span>
                            <span class="price-suffix">/ forfait</span>
                        </div>
                    </div>
                </div>

                <!-- TABS -->
                <div class="premium-tabs-wrap">
                    <div class="premium-tabs">
                        <button class="tab-btn-premium active" data-target="tab-details">📋 Description</button>
                        <button class="tab-btn-premium" data-target="tab-features">✨ Inclus</button>
                    </div>

                    <div id="tab-details" class="tab-content-premium active fade-in">
                        <p class="description-text">{{ $product->description }}</p>
                        <div class="meta-grid">
                            <div class="meta-item">
                                <span class="meta-label">Catégorie</span>
                                <span class="meta-value">{{ $product->category->name ?? 'Général' }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Disponibilité</span>
                                <span class="meta-value status-active">En stock ✅</span>
                            </div>
                        </div>
                    </div>

                    <div id="tab-features" class="tab-content-premium fade-in" style="display: none;">
                        @if(count($product->features_list) > 0)
                            <ul class="premium-list">
                                @foreach($product->features_list as $f)
                                    <li><span class="check-icon">✦</span> {{ $f }}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="empty-state">Aucun détail supplémentaire.</div>
                        @endif
                    </div>
                </div>

                <!-- ACTIONS -->
                @php
                    $waMsg = $product->whatsapp_message ?: "Bonjour Digitalay 👋\n\nJe voudrais commander :\n📦 *{$product->name}*\n💰 Prix : {$product->price} MAD\n\nMerci !";
                @endphp
                <div class="action-footer">
                    <div class="qty-control">
                        <span class="qty-label">Quantité</span>
                        <div class="qty-stepper">
                            <button class="qty-btn" id="qty-minus">−</button>
                            <span class="qty-num" id="qty-val">1</span>
                            <button class="qty-btn" id="qty-plus">+</button>
                        </div>
                    </div>

                    <div class="button-stack">
                        <div class="main-buttons">
                            <button class="btn btn-primary btn-lg btn-glow add-multi-cart" style="flex: 1.5;" data-product="{{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'image' => $product->image_url]) }}">
                                🛒 Ajouter au panier
                            </button>
                            <a href="{{ route('cart') }}" class="btn btn-dark btn-lg buy-now-btn" style="flex: 1;" data-product="{{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'image' => $product->image_url]) }}">
                                Commander
                            </a>
                        </div>
                        <a href="https://wa.me/212665654367?text={{ urlencode($waMsg) }}" target="_blank" class="btn btn-whatsapp-premium btn-lg btn-full" id="wa-link">
                            <i class="fab fa-whatsapp"></i> Commander via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ RELATED CTA ═══ -->
        <div class="premium-cta fade-in-scroll">
            <div class="cta-glass">
                <div class="cta-icon">🎁</div>
                <h2 class="cta-title">Explorez plus de services premium</h2>
                <p class="cta-desc">Rejoignez 5000+ clients satisfaits au Maroc.</p>
                <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Parcourir la boutique</a>
            </div>
        </div>
    </div>

</main>

<style>
/* ═══ PREMIUM DESIGN SYSTEM — COMPONENT LEVEL ═══ */
:root {
    --p-bg: #ffffff;
    --p-card: #f8fbff;
    --p-border: rgba(37, 99, 235, 0.08);
    --p-accent: #2563eb;
    --p-text-main: #0f172a;
    --p-text-sub: #64748b;
    --r-premium: 24px;
    --shadow-premium: 0 20px 50px rgba(15, 23, 42, 0.06);
}

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: start;
}

@media (max-width: 1024px) {
    .detail-grid { grid-template-columns: 1fr; gap: 32px; }
}

/* IMAGE SECTION */
.detail-img-container {
    background: #fff;
    border-radius: var(--r-premium);
    padding: 12px;
    border: 1px solid var(--p-border);
    box-shadow: var(--shadow-premium);
    position: relative;
    overflow: hidden;
}

.detail-img-wrap {
    background: #f1f5f9;
    border-radius: calc(var(--r-premium) - 8px);
    aspect-ratio: 16/11;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.main-product-image {
    width: 85%;
    height: 85%;
    object-fit: contain;
    filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));
    transition: transform 0.5s ease;
}

.detail-img-container:hover .main-product-image {
    transform: scale(1.05);
}

.hero-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    padding: 6px 16px;
    border-radius: 100px;
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.placeholder-img { font-size: 80px; display: flex; align-items: center; justify-content: center; }

/* TRUST GRID */
.detail-trust-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-top: 24px;
}

.trust-card {
    background: #fff;
    border: 1px solid var(--p-border);
    border-radius: 16px;
    padding: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
}

.trust-card:hover { border-color: var(--p-accent); transform: translateY(-2px); }
.trust-card.highlight { background: rgba(37, 211, 102, 0.03); border-color: rgba(37, 211, 102, 0.2); }

.trust-icon {
    width: 36px;
    height: 36px;
    background: var(--p-card);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--p-accent);
}

.trust-content { display: flex; flex-direction: column; }
.trust-title { font-size: 13px; font-weight: 800; color: var(--p-text-main); }
.trust-sub { font-size: 11px; color: var(--p-text-sub); }

/* INFO SECTION */
.info-header { margin-bottom: 24px; }
.info-meta { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
.category-tag { background: rgba(37, 99, 235, 0.05); color: var(--p-accent); padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700; }
.discount-pill { background: #ef4444; color: #fff; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 800; }

.detail-title-premium {
    font-size: clamp(28px, 4vw, 42px);
    font-weight: 900;
    color: var(--p-text-main);
    line-height: 1.1;
    letter-spacing: -1px;
    margin-bottom: 8px;
}

.rating-summary { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--p-text-sub); }

/* SELECTION BOX */
.premium-selection-box {
    background: #fff;
    border: 1px solid var(--p-border);
    border-radius: var(--r-premium);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
}

.selection-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.selection-title { font-size: 16px; font-weight: 800; color: var(--p-text-main); }
.selection-savings { background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 800; }

.duration-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; margin-bottom: 24px; }

.duration-card {
    background: #f8fafc;
    border: 2px solid transparent;
    border-radius: 18px;
    padding: 16px;
    cursor: pointer;
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.duration-card:hover { background: #f1f5f9; transform: translateY(-2px); }
.duration-card.active {
    background: #fff;
    border-color: var(--p-accent);
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.1);
}

.duration-name { font-size: 12px; font-weight: 800; color: var(--p-text-sub); text-transform: uppercase; margin-bottom: 8px; }
.duration-pricing { display: flex; flex-direction: column; }
.curr-price { font-size: 18px; font-weight: 900; color: var(--p-text-main); }
.old-price { font-size: 11px; text-decoration: line-through; color: var(--p-text-sub); }

.duration-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ef4444;
    color: #fff;
    font-size: 9px;
    font-weight: 900;
    padding: 2px 6px;
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.2);
}

.check-mark {
    position: absolute;
    bottom: 12px;
    right: 12px;
    width: 20px;
    height: 20px;
    background: var(--p-accent);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.3s ease;
}

.duration-card.active .check-mark { opacity: 1; transform: scale(1); }

/* PRICE BOX */
.premium-price-box {
    background: var(--p-card);
    border-radius: 20px;
    padding: 20px;
    border: 1px solid var(--p-border);
}

.price-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
.price-label { font-size: 11px; font-weight: 800; color: var(--p-text-sub); letter-spacing: 1px; }
.price-savings { color: #10b981; font-size: 13px; font-weight: 800; }

.price-display { display: flex; align-items: baseline; gap: 6px; }
.price-symbol { font-size: 20px; font-weight: 800; color: var(--p-accent); opacity: 0.8; }
.price-value { font-size: 48px; font-weight: 900; color: var(--p-accent); letter-spacing: -2px; line-height: 1; }
.price-suffix { font-size: 14px; font-weight: 700; color: var(--p-text-sub); }

/* TABS SECTION */
.premium-tabs-wrap { margin-bottom: 32px; }
.premium-tabs {
    display: flex;
    gap: 8px;
    background: #f1f5f9;
    padding: 4px;
    border-radius: 14px;
    margin-bottom: 20px;
}

.tab-btn-premium {
    flex: 1;
    padding: 10px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 800;
    color: var(--p-text-sub);
    transition: all 0.2s;
}

.tab-btn-premium.active { background: #fff; color: var(--p-accent); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

.description-text { font-size: 14px; line-height: 1.7; color: var(--p-text-sub); margin-bottom: 20px; }

.meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.meta-item { background: #f8fafc; padding: 12px; border-radius: 12px; border: 1px solid var(--p-border); }
.meta-label { display: block; font-size: 10px; font-weight: 800; color: var(--p-text-sub); text-transform: uppercase; margin-bottom: 4px; }
.meta-value { font-size: 13px; font-weight: 700; color: var(--p-text-main); }
.status-active { color: #10b981; }

.premium-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.premium-list li { display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--p-text-sub); font-weight: 600; }
.check-icon { color: var(--p-accent); font-weight: 900; }

/* ACTION FOOTER */
.action-footer { display: flex; flex-direction: column; gap: 24px; padding-top: 24px; border-top: 1px solid var(--p-border); }
.qty-control { display: flex; align-items: center; justify-content: space-between; }
.qty-label { font-size: 14px; font-weight: 800; color: var(--p-text-main); }
.qty-stepper {
    display: flex;
    align-items: center;
    background: #f1f5f9;
    border-radius: 12px;
    padding: 4px;
}

.qty-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 8px;
    font-weight: 900;
    color: var(--p-accent);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.qty-num { width: 40px; text-align: center; font-weight: 900; color: var(--p-text-main); }

.button-stack { display: flex; flex-direction: column; gap: 12px; }
.main-buttons { display: flex; gap: 12px; }

.btn-dark { background: #0f172a; color: #fff; }
.btn-dark:hover { background: #1e293b; transform: translateY(-2px); }

.btn-whatsapp-premium {
    background: #25d366;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 800;
}

.btn-whatsapp-premium:hover { background: #22c35e; transform: scale(1.02); box-shadow: 0 10px 20px rgba(37, 211, 102, 0.2); }

/* CTA BANNER */
.premium-cta { margin-top: 80px; text-align: center; }
.cta-glass {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(37, 99, 235, 0.02));
    padding: 60px 40px;
    border-radius: var(--r-premium);
    border: 1px solid rgba(37, 99, 235, 0.1);
}

.cta-icon { font-size: 40px; margin-bottom: 20px; }
.cta-title { font-size: 32px; font-weight: 900; color: var(--p-text-main); margin-bottom: 12px; }
.cta-desc { font-size: 16px; color: var(--p-text-sub); margin-bottom: 30px; }

/* MODAL UPSELL */
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
    color: var(--p-text-sub);
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    z-index: 10;
}

.modal-close:hover {
    background: #e2e8f0;
    color: var(--p-text-main);
    transform: rotate(90deg);
}

.modal-badge-premium { 
    background: var(--p-accent); 
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
    color: var(--p-text-main);
    margin-bottom: 12px;
    line-height: 1.2;
}

.upsell-item-box {
    background: #f8fafc;
    border: 1px solid var(--p-border);
    border-radius: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    text-align: left;
    margin: 24px 0;
}

.upsell-item-box img { width: 60px; height: 60px; border-radius: 12px; object-fit: cover; }
.upsell-item-info h4 { font-size: 16px; font-weight: 800; margin-bottom: 4px; }
.upsell-price { color: var(--p-accent); font-weight: 900; font-size: 18px; }

.modal-actions { display: flex; flex-direction: column; gap: 10px; }

/* RESPONSIVE TRICKS */
@media (max-width: 480px) {
    .main-buttons { flex-direction: column; }
    .price-value { font-size: 40px; }
    .cta-glass { padding: 40px 20px; }
    .detail-trust-grid { grid-template-columns: 1fr; }
}

/* Animations */
.fade-up-item { opacity: 0; transform: translateY(20px); animation: fadeUp 0.6s ease forwards; }
@keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }

.fade-in { animation: fadeIn 0.4s ease forwards; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.fade-in-scroll { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
.fade-in-scroll.is-visible { opacity: 1; transform: translateY(0); }

</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Premium Tabs Logic
    const tabBtns = document.querySelectorAll('.tab-btn-premium');
    const tabContents = document.querySelectorAll('.tab-content-premium');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => {
                c.style.display = 'none';
                c.classList.remove('active');
            });
            
            btn.classList.add('active');
            const target = document.getElementById(btn.getAttribute('data-target'));
            target.style.display = 'block';
            setTimeout(() => target.classList.add('active'), 10);
        });
    });

    // Animation Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    
    document.querySelectorAll('.fade-in-scroll').forEach(el => observer.observe(el));

    // Pricing & State Management
    let qty = 1;
    let currentPrice = {{ $product->price }};
    let currentOriginalPrice = {{ $product->original_price ?: 0 }};
    let currentDuration = "{{ $product->durations->first()->duration_name ?? '' }}";
    
    const productName = "{{ $product->name }}";
    const waLink = document.getElementById('wa-link');
    const originalWaMsg = "Bonjour Digitalay 👋\n\nJe voudrais commander :\n📦 *{name}* ({duration})\n💰 Prix : {price} MAD\n📦 Quantité : {qty}\n\nMerci !";

    window.selectPlanCard = function(card) {
        document.querySelectorAll('.duration-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        
        currentPrice = parseFloat(card.dataset.price);
        currentOriginalPrice = parseFloat(card.dataset.original) || 0;
        currentDuration = card.dataset.name;
        
        updateTotalDisplay();
    };

    function updateTotalDisplay() {
        const mainPriceEl = document.getElementById('main-price');
        const savingsBox = document.getElementById('savings-box');
        const savingsBadge = document.getElementById('savings-badge');
        
        mainPriceEl.innerText = currentPrice.toLocaleString();
        
        if (currentOriginalPrice > currentPrice) {
            if(savingsBox) {
                savingsBox.style.display = 'inline-block';
                document.getElementById('savings-amount').innerText = (currentOriginalPrice - currentPrice).toLocaleString();
            }
            if(savingsBadge) {
                savingsBadge.style.display = 'inline-block';
                const percent = Math.round(((currentOriginalPrice - currentPrice) / currentOriginalPrice) * 100);
                document.getElementById('savings-percent-top').innerText = percent;
            }
        } else {
            if(savingsBox) savingsBox.style.display = 'none';
            if(savingsBadge) savingsBadge.style.display = 'none';
        }
        
        // DATA UPDATE FOR CART
        const updatedProductData = {
            id: {{ $product->id }},
            name: productName + (currentDuration ? " (" + currentDuration + ")" : ""),
            price: currentPrice,
            image: "{{ $product->image_url }}",
            duration: currentDuration
        };
        
        document.querySelectorAll('.add-multi-cart, .buy-now-btn').forEach(btn => {
            btn.setAttribute('data-product', JSON.stringify(updatedProductData));
        });

        // WHATSAPP UPDATE
        let msg = originalWaMsg.replace('{name}', productName)
                               .replace('{duration}', currentDuration)
                               .replace('{price}', (currentPrice * qty))
                               .replace('{qty}', qty);
        waLink.href = `https://wa.me/212665654367?text=${encodeURIComponent(msg)}`;
    }

    // Qty Controls
    document.getElementById('qty-plus').addEventListener('click', () => updateQty(qty + 1));
    document.getElementById('qty-minus').addEventListener('click', () => updateQty(Math.max(1, qty - 1)));

    function updateQty(newQty) {
        qty = newQty;
        const qtyVal = document.getElementById('qty-val');
        if(qtyVal) qtyVal.innerText = qty;
        updateTotalDisplay();
    }

    // Cart Logic Integration
    const handleAdd = (e, redirect = false) => {
        if (e) e.preventDefault();
        const productDataStr = e.currentTarget.getAttribute('data-product');
        if (!productDataStr) return;
        
        const product = JSON.parse(productDataStr);
        product.quantity = qty; // Use the current quantity from the stepper
        
        if (redirect) {
            window.showGlobalUpsell(product, true);
            return;
        }

        if (window.performGlobalAddToCart) {
            window.performGlobalAddToCart(product);
        }
        
        const btn = e.currentTarget;
        const origHTML = btn.innerHTML;
        btn.innerHTML = '✅ Ajouté';
        btn.style.background = '#10b981';

        // Show global upsell immediately for feedback, reset button after delay
        if (window.showGlobalUpsell) {
            window.showGlobalUpsell(null, false);
        }

        setTimeout(() => {
            btn.innerHTML = origHTML;
            btn.style.background = '';
        }, 1500);
    };

    // Global logic handles the rest. Removed local performAddToCart and Modal helpers.

    document.querySelectorAll('.add-multi-cart').forEach(btn => btn.addEventListener('click', (e) => handleAdd(e, false)));
    document.querySelectorAll('.buy-now-btn').forEach(btn => btn.addEventListener('click', (e) => handleAdd(e, true)));

    // Init
    updateTotalDisplay();
});
</script>
@endpush
