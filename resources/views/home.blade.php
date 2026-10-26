@extends('layouts.app')

@section('content')
<div class="bg-mesh">
    <div class="bg-grid"></div>
</div>

<!-- ═══ HERO 3D ═══ -->
<section class="hero" id="hero-section">
    <div class="hero-blob hero-blob-1" style="background: var(--primary);"></div>
    <div class="hero-blob hero-blob-2" style="background: var(--accent-cyan);"></div>
    <div class="hero-blob hero-blob-3" style="background: var(--accent-amber);"></div>

    <div class="container hero-content">
        <div class="hero-inner">
            <div class="fade-up-group">
                <div class="hero-eyebrow fade-up-item">✨ La référence numérique au Maroc</div>
                <h1 class="hero-title fade-up-item">
                    Le futur de vos <br />
                    <span class="gradient-text">Abonnements</span> <br />
                    Premium.
                </h1>
                <p class="hero-desc fade-up-item">
                    Débloquez tout le potentiel de l'IA et du streaming. ChatGPT, Netflix, Midjourney et 15+ services avec activation instantanée par virement bancaire.
                </p>
                <div class="hero-ctas fade-up-item">
                    <a href="{{ route('products') }}" class="btn btn-primary btn-xl">🚀 Explorer le catalogue</a>
                    <a href="https://wa.me/212665654367" target="_blank" rel="noreferrer" class="btn btn-whatsapp btn-xl" style="display: inline-flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
                        Acheter via WhatsApp
                    </a>
                </div>
                <!-- STATS COUNTER -->
                <div class="hero-stats fade-up-item">
                    <div style="text-align: center;">
                        <div class="hero-stat-val"><span class="counter" data-target="16">0</span>+</div>
                        <div class="hero-stat-lbl">Services Pro</div>
                    </div>
                    <div style="text-align: center;">
                        <div class="hero-stat-val"><span class="counter" data-target="100">0</span>%</div>
                        <div class="hero-stat-lbl">Sécurisé</div>
                    </div>
                    <div style="text-align: center;">
                        <div class="hero-stat-val">< <span class="counter" data-target="30">0</span>m</div>
                        <div class="hero-stat-lbl">Livraison</div>
                    </div>
                </div>
            </div>

            <div class="floating-scene">
                <!-- Javascript will render the floating cards here based on data-cards -->
            </div>
        </div>
    </div>
</section>

<!-- ═══ PROMO FLASH CARD — Premium ═══ -->
<section class="promo-flash-section fade-in-scroll" style="padding-top: 0;">
    <div class="container">
        <div class="promo-flash-card">
            <!-- Glow blobs -->
            <div class="promo-blob promo-blob-1"></div>
            <div class="promo-blob promo-blob-2"></div>

            <!-- Left: Badge + Text -->
            <div class="promo-flash-left">
                <div class="promo-flash-badge">
                    <span class="promo-flash-dot"></span>
                    🔥 Offre Limitée
                </div>
                <h2 class="promo-flash-title">🌟 Pack Google One Complet</h2>
                <p class="promo-flash-sub">
                    Cloud <strong>2 To</strong> + Gemini Advanced AI + Workspace Premium
                </p>
                <div class="promo-flash-price-row">
                    <span class="promo-flash-old">350 MAD</span>
                    <span class="promo-flash-price">189 MAD</span>
                    <span class="promo-flash-tag">-46%</span>
                </div>
            </div>

            <!-- Right: CTA -->
            <div class="promo-flash-right">
                <a href="{{ route('products') }}" class="promo-flash-btn">
                    <span class="promo-btn-icon">🚀</span>
                    <span class="promo-btn-text">Profiter de l'offre</span>
                    <span class="promo-btn-arrow">→</span>
                </a>
                <p class="promo-flash-note">⚡ Activation sous 30 min · Virement bancaire</p>
            </div>
        </div>
    </div>
</section>

<style>
.promo-flash-section { padding: 0 0 24px; }

.promo-flash-card {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 24px;
    padding: 36px 40px;
    border-radius: 24px;
    background: linear-gradient(135deg, #1a3a8f 0%, #1e56c0 50%, #2563EB 100%);
    border: 1px solid rgba(255,255,255,0.15);
    box-shadow: 0 20px 60px rgba(37,99,235,0.35), inset 0 1px 0 rgba(255,255,255,0.15);
}

.promo-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    pointer-events: none;
}
.promo-blob-1 {
    width: 300px; height: 300px;
    background: rgba(96,165,250,0.3);
    top: -100px; left: -80px;
}
.promo-blob-2 {
    width: 250px; height: 250px;
    background: rgba(255,216,77,0.15);
    bottom: -80px; right: -60px;
}

.promo-flash-left { position: relative; z-index: 1; flex: 1; min-width: 260px; }
.promo-flash-right { position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; gap: 10px; }

.promo-flash-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    backdrop-filter: blur(8px);
    border-radius: 999px;
    padding: 5px 14px;
    font-size: 12px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 12px;
    letter-spacing: 0.3px;
}

.promo-flash-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #FFD84D;
    box-shadow: 0 0 8px #FFD84D;
    animation: pulseDot 1.5s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes pulseDot {
    0%,100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.6; }
}

.promo-flash-title {
    font-size: clamp(20px, 3vw, 28px);
    font-weight: 900;
    color: #fff;
    margin: 0 0 6px;
    line-height: 1.2;
}

.promo-flash-sub {
    font-size: 14px;
    color: rgba(255,255,255,0.75);
    margin: 0 0 14px;
    line-height: 1.5;
}

.promo-flash-price-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.promo-flash-old {
    font-size: 16px;
    color: rgba(255,255,255,0.4);
    text-decoration: line-through;
    font-weight: 600;
}

.promo-flash-price {
    font-size: 32px;
    font-weight: 900;
    color: #FFD84D;
    text-shadow: 0 0 20px rgba(255,216,77,0.5);
    line-height: 1;
}

.promo-flash-tag {
    background: rgba(255,216,77,0.2);
    border: 1px solid rgba(255,216,77,0.4);
    color: #FFD84D;
    font-size: 13px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 999px;
}

.promo-flash-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 32px;
    background: #fff;
    color: #1a3a8f;
    border-radius: 999px;
    font-size: 15px;
    font-weight: 900;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 8px 30px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.8);
    white-space: nowrap;
    letter-spacing: 0.2px;
}

.promo-flash-btn:hover {
    transform: translateY(-4px) scale(1.04);
    box-shadow: 0 20px 50px rgba(0,0,0,0.25), 0 0 0 4px rgba(255,255,255,0.3);
    color: #1a3a8f;
}

.promo-btn-icon { font-size: 18px; transition: transform 0.3s ease; }
.promo-flash-btn:hover .promo-btn-icon { transform: rotate(-10deg) scale(1.2); }

.promo-btn-arrow {
    font-size: 18px;
    font-weight: 900;
    transition: transform 0.3s ease;
}
.promo-flash-btn:hover .promo-btn-arrow { transform: translateX(4px); }

.promo-flash-note {
    font-size: 11px;
    color: rgba(255,255,255,0.55);
    margin: 0;
    text-align: center;
    font-weight: 500;
}

@media (max-width: 640px) {
    .promo-flash-card { padding: 28px 22px; flex-direction: column; align-items: flex-start; }
    .promo-flash-right { width: 100%; align-items: flex-start; }
    .promo-flash-btn { width: 100%; justify-content: center; }
}
</style>

<!-- ═══ CATEGORIES ═══ -->
<section class="section" style="padding-top: 0; padding-bottom: 30px; position: relative; z-index: 2;">
    <div class="container">
        <div class="cat-scroll-wrap">
            <div class="cat-scroll-content">
                @for ($i = 0; $i < 3; $i++)
                    @foreach($categories as $c)
                        <a href="{{ route('products', ['cat' => $c->slug]) }}" class="cat-chip">
                            {{ $c->name }}
                        </a>
                    @endforeach
                @endfor
            </div>
        </div>
    </div>
</section>

<!-- ═══ BRAND SCROLL ═══ -->
@php
$brandMarquee = [
    ['name' => 'ChatGPT', 'img' => '/brands/chatgpt.png'],
    ['name' => 'Claude', 'img' => '/brands/claude.png'],
    ['name' => 'Perplexity', 'img' => '/brands/perplexity.png'],
    ['name' => 'Gemini', 'img' => '/brands/gemini.png'],
    ['name' => 'Antigravity', 'img' => '/brands/antigravity.png'],
    ['name' => 'Netflix', 'img' => '/brands/netflix.png'],
    ['name' => 'Spotify', 'img' => '/brands/spotify.png'],
    ['name' => 'Canva', 'img' => '/brands/canva.png'],
];
@endphp
<section style="position: relative; z-index: 2; margin-bottom: 40px; margin-top: -15px;">
    <div class="container">
        <div class="brand-scroll-wrap">
            <div class="brand-scroll-content">
                @for ($i = 0; $i < 3; $i++)
                    @foreach($brandMarquee as $b)
                        <div class="brand-logo-chip" title="{{ $b['name'] }}">
                            <img src="{{ asset($b['img']) }}" alt="{{ $b['name'] }}" />
                        </div>
                    @endforeach
                @endfor
            </div>
        </div>
    </div>
</section>

<!-- ═══ FEATURED ═══ -->
<section class="section" style="position: relative; z-index: 2;">
    <div class="container">
        <div class="section-header fade-in-scroll">
            <h2 class="section-title">🌟 Services Tendances</h2>
            <p class="section-subtitle">Les outils les plus demandés actuellement au Maroc</p>
        </div>

        <div class="products-grid products-grid--home">
            @foreach($featured as $index => $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="text-center mt-lg fade-in-scroll">
            <a href="{{ route('products') }}" class="btn btn-outline btn-lg" style="border-radius: var(--r-full);">
                Découvrir tout le catalogue →
            </a>
        </div>
    </div>
</section>

<!-- ═══ SOCIAL PROOF (MARQUEE) ═══ -->
<section class="section" style="background: rgba(37, 99, 235, 0.02); overflow: hidden;">
    <div class="container text-center">
        <div class="section-header">
            <div class="hero-eyebrow fade-up-item" style="display: inline-flex; align-items: center; justify-content: center; background: rgba(37,99,235,0.08); border: 1px solid rgba(37,99,235,0.2); border-radius: 999px; padding: 6px 20px; color: var(--primary); font-weight: 800; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(37,99,235,0.1);">
                PREUVE SOCIALE
            </div>
            <h2 class="section-title">Ce que disent nos clients</h2>
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 10px;">
                <div style="display: flex; color: #FFB800;">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span style="font-weight: 700; font-size: 15px;">4.9/5 sur plus de 5000 commandes</span>
            </div>
        </div>
    </div>

    <div class="marquee-wrapper">
        <div class="marquee-content">
            @php
                $reviews = [
                    ['n' => 'Amine K.', 'i' => 'A', 'g' => 'var(--grad-primary)', 't' => 'Très satisfait du service. J\'ai pris un abonnement ChatGPT Plus, activation en moins de 10 minutes. Le support sur WhatsApp est hyper réactif.'],
                    ['n' => 'Sara M.', 'i' => 'S', 'g' => 'var(--grad-hot)', 't' => 'Je recommande Digitalay pour Netflix et Spotify. C\'est beaucoup moins cher et l\'équipe est très professionnelle. Activation sans souci !'],
                    ['n' => 'Youssef B.', 'i' => 'Y', 'g' => 'var(--grad-teal)', 't' => 'J\'utilise Canva Pro pour mon travail depuis 6 mois avec eux, aucun problème. Renouvellement facile via WhatsApp. Le top au Maroc.'],
                    ['n' => 'Mounir Z.', 'i' => 'M', 'g' => '#8b5cf6', 't' => 'Activation rapide pour IPTV et Disney+. Franchement, rien à dire sur le service. Prix imbattable.'],
                    ['n' => 'Hind L.', 'i' => 'H', 'g' => '#f472b6', 't' => 'J\'ai pris Office 365, tout fonctionne parfaitement. Merci pour le sérieux et la rapidité.'],
                    ['n' => 'Omar R.', 'i' => 'O', 'g' => '#fbbf24', 't' => 'Service client au top. Ils m\'ont aidé à configurer mon compte Netflix en quelques minutes. Très pro.'],
                ];
            @endphp

            @foreach(array_merge($reviews, $reviews) as $r)
            <div class="review-card glass">
                <div class="review-header">
                    <div class="avatar" style="background: {{ $r['g'] }};">{{ $r['i'] }}</div>
                    <div>
                        <div class="name">{{ $r['n'] }}</div>
                        <div class="status">Client vérifié ✅</div>
                    </div>
                </div>
                <p class="text">"{{ $r['t'] }}"</p>
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.marquee-wrapper {
    margin-top: 40px;
    position: relative;
    width: 100%;
    overflow: hidden;
    padding: 20px 0;
    mask-image: linear-gradient(to right, transparent, #000 10%, #000 90%, transparent);
    -webkit-mask-image: linear-gradient(to right, transparent, #000 10%, #000 90%, transparent);
}
.marquee-content {
    display: flex;
    gap: 24px;
    width: max-content;
    animation: scroll-marquee 40s linear infinite;
}
.marquee-content:hover {
    animation-play-state: paused;
}
@keyframes scroll-marquee {
    from { transform: translateX(0); }
    to { transform: translateX(calc(-50% - 12px)); }
}
.review-card {
    width: 320px;
    padding: 24px;
    border-radius: 24px;
    flex-shrink: 0;
    transition: var(--t);
    border: 1px solid var(--border);
}
.review-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary-light);
    box-shadow: var(--glow-sm);
}
.review-header {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}
.avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 800;
    font-size: 16px;
}
.name {
    font-weight: 800;
    font-size: 15px;
    color: var(--text);
}
.status {
    font-size: 11px;
    color: var(--text-muted);
}
.review-card .text {
    font-size: 13px;
    color: var(--text-2);
    line-height: 1.6;
    font-style: italic;
}
.stars {
    margin-top: 16px;
    color: #FFB800;
    font-size: 11px;
}
</style>

<!-- ═══ HOW IT WORKS ═══ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Comment ça marche ?</h2>
            <p class="section-subtitle">Votre compte activé en un temps record</p>
        </div>
        <div class="steps-grid">
            <div class="step-card fade-in-scroll">
                <div class="step-num">Étape 01</div>
                <div class="step-icon" style="filter: drop-shadow(0 10px 15px rgba(31,60,136,0.2));">🛍️</div>
                <div class="step-title">Sélectionnez</div>
                <div class="step-desc">Choisissez l'abonnement qui correspond à vos besoins parmi notre sélection.</div>
            </div>
            <div class="step-card fade-in-scroll" style="animation-delay: 0.15s">
                <div class="step-num">Étape 02</div>
                <div class="step-icon" style="filter: drop-shadow(0 10px 15px rgba(31,60,136,0.2));">📝</div>
                <div class="step-title">Commandez</div>
                <div class="step-desc">Remplissez vos coordonnées rapidement, sans inscription nécessaire.</div>
            </div>
            <div class="step-card fade-in-scroll" style="animation-delay: 0.3s">
                <div class="step-num">Étape 03</div>
                <div class="step-icon" style="filter: drop-shadow(0 10px 15px rgba(31,60,136,0.2));">🏦</div>
                <div class="step-title">Virement</div>
                <div class="step-desc">Payez par virement bancaire et transférez le reçu.</div>
            </div>
            <div class="step-card fade-in-scroll" style="animation-delay: 0.45s">
                <div class="step-num">Étape 04</div>
                <div class="step-icon" style="filter: drop-shadow(0 10px 15px rgba(31,60,136,0.2));">🚀</div>
                <div class="step-title">Profitez</div>
                <div class="step-desc">Recevez vos accès premium directement sur WhatsApp.</div>
            </div>
        </div>
    </div>
</section>


<!-- ═══ MAIN CTA ═══ -->
<section class="section">
    <div class="container">
        <div class="cta-banner fade-in-scroll" style="background: linear-gradient(135deg, rgba(31,60,136,0.1) 0%, rgba(130,200,229,0.1) 100%); border: 1px solid rgba(31,60,136,0.1);">
            <div class="spin-anim" style="font-size: 48px; margin-bottom: 20px; display: inline-block;">💎</div>
            <h2 class="cta-title gradient-text">Passez au niveau supérieur</h2>
            <p class="cta-sub" style="font-size: 16px; max-width: 500px; margin: 0 auto 30px;">
                Rejoignez des milliers de professionnels marocains qui utilisent Digitalay pour leurs outils digitaux.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('products') }}" class="btn btn-primary btn-xl" style="box-shadow: var(--glow);">
                    🚀 Voir le catalogue
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Utilities for replacing framer-motion */
.fade-up-item { opacity: 0; transform: translateY(30px); animation: fadeUpAnim 0.6s ease-out forwards; }
.fade-up-item:nth-child(1) { animation-delay: 0.1s; }
.fade-up-item:nth-child(2) { animation-delay: 0.2s; }
.fade-up-item:nth-child(3) { animation-delay: 0.3s; }
.fade-up-item:nth-child(4) { animation-delay: 0.4s; }

@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

.fade-in-scroll { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
.fade-in-scroll.is-visible { opacity: 1; transform: translateY(0); }

@keyframes spinInfinite { 100% { transform: rotate(360deg); } }
.spin-anim { animation: spinInfinite 20s linear infinite; }

/* 3D Floating Cards styles */
.floating-card {
    position: absolute;
    background: var(--bg-card);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-card);
    padding: 20px;
    border-radius: var(--r-lg);
    text-align: center;
    backdrop-filter: blur(10px);
    cursor: pointer;
    width: 160px;
    opacity: 0;
    transform: scale(0);
    transition: transform 0.2s ease;
    animation: floatIn 1.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}
.floating-card:hover {
    transform: scale(1.1) !important;
    z-index: 10;
}
@keyframes floatIn {
    to { opacity: 1; transform: scale(1); }
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Counter Animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        const updateCount = () => {
            const count = +counter.innerText;
            const inc = target / 100; // Speed factor
            if(count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

    // 2. Scroll Animations (Intersection Observer)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-in-scroll').forEach(el => observer.observe(el));

    // 3. Hero Parallax
    const heroSection = document.getElementById('hero-section');
    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if(y < 500) {
            heroSection.style.transform = `translateY(${y * 0.3}px)`;
            heroSection.style.opacity = 1 - (y / 400);
        }
    });

    // 4. Floating 3D Cards logic (Hero)
    const floatingCards = [
        { icon: '🧠', name: 'ChatGPT Plus', price: '149 MAD', delay: 0, x: -60, y: -40, rotate: -5 },
        { icon: '🎬', name: 'Netflix 4K', price: '99 MAD', delay: 200, x: 50, y: -80, rotate: 6 },
        { icon: '🎵', name: 'Spotify', price: '59 MAD', delay: 400, x: 80, y: 20, rotate: -3 },
        { icon: '🎨', name: 'Midjourney', price: '159 MAD', delay: 600, x: -40, y: 60, rotate: 4 },
        { icon: '🔍', name: 'Perplexity', price: '129 MAD', delay: 800, x: 0, y: 0, rotate: 0 },
    ];

    const scene = document.querySelector('.floating-scene');
    if(scene){
        floatingCards.forEach((c, i) => {
            const card = document.createElement('div');
            card.className = 'floating-card';
            card.style.animationDelay = `${c.delay}ms`;
            
            card.innerHTML = `
                <div style="font-size: 48px; margin-bottom: 10px; filter: drop-shadow(0 10px 20px rgba(31,60,136,0.2));">${c.icon}</div>
                <div style="font-size: 13px; font-weight: 800; color: var(--text);">${c.name}</div>
                <div style="font-size: 12px; font-weight: 900; color: var(--accent-cyan);">${c.price}</div>
            `;
            
            const wrapper = document.createElement('div');
            wrapper.style.position = 'absolute';
            wrapper.style.left = `calc(50% + ${c.x}px)`;
            wrapper.style.top = `calc(50% + ${c.y}px)`;
            
            wrapper.appendChild(card);
            scene.appendChild(wrapper);

            setTimeout(() => {
                card.animate([
                    { transform: `translateY(0px) rotate(${c.rotate}deg)` },
                    { transform: `translateY(-15px) rotate(${c.rotate + 3}deg)` },
                    { transform: `translateY(0px) rotate(${c.rotate}deg)` }
                ], {
                    duration: (4 + i) * 1000,
                    iterations: Infinity,
                    easing: 'ease-in-out'
                });
            }, 1000 + c.delay);
        });
    }


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
