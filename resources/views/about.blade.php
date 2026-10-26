@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 80px; padding-bottom: 80px; position: relative;">
    <div class="bg-mesh"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="section-header fade-up">
            <h1 class="section-title">Qui Sommes-Nous ?</h1>
            <p class="section-subtitle">Découvrez l'histoire de Digitalay et notre engagement à démocratiser le premium au Maroc.</p>
        </div>

        <div class="about-grid" style="display: grid; grid-template-columns: 1fr; gap: 40px; align-items: center; max-width: 1000px; margin: 0 auto;">
            
            <div class="about-text glass fade-up" style="padding: 40px; border-radius: 24px;">
                <h2 style="font-size: 24px; font-weight: 900; margin-bottom: 20px;" class="gradient-text">Notre Mission</h2>
                <p style="color: var(--text-2); line-height: 1.7; margin-bottom: 20px;">
                    Fondée avec la volonté de rendre les meilleurs outils numériques accessibles à tous, <strong>Digitalay</strong> est devenue en peu de temps une référence au Maroc pour l'acquisition d'abonnements premium.
                </p>
                <p style="color: var(--text-2); line-height: 1.7; margin-bottom: 20px;">
                    Que ce soit pour le divertissement (Netflix, Spotify), la productivité (ChatGPT Plus, Office 365) ou l'éducation (Coursera, LinkedIn Learning), nous simplifions le processus d'achat et d'activation pour nos clients.
                </p>
                
                <div class="about-stats" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 32px;">
                    <div class="stat-item">
                        <div style="font-size: 28px; font-weight: 900; color: var(--primary);">5000+</div>
                        <div style="font-size: 14px; color: var(--text-muted);">Clients Satisfaits</div>
                    </div>
                    <div class="stat-item">
                        <div style="font-size: 28px; font-weight: 900; color: var(--primary);">15+</div>
                        <div style="font-size: 14px; color: var(--text-muted);">Services Premium</div>
                    </div>
                </div>
            </div>

            <div class="about-values" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
                <div class="value-card glass fade-up" style="padding: 32px; border-radius: 20px; text-align: center; transition: var(--t);">
                    <div style="font-size: 40px; margin-bottom: 16px;">⚡</div>
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 12px;">Rapidité</h3>
                    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6;">Activation en un temps record après votre commande.</p>
                </div>
                <div class="value-card glass fade-up" style="padding: 32px; border-radius: 20px; text-align: center; transition: var(--t);">
                    <div style="font-size: 40px; margin-bottom: 16px;">🛡️</div>
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 12px;">Sécurité</h3>
                    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6;">Paiements sécurisés et licences 100% officielles.</p>
                </div>
                <div class="value-card glass fade-up" style="padding: 32px; border-radius: 20px; text-align: center; transition: var(--t);">
                    <div style="font-size: 40px; margin-bottom: 16px;">💎</div>
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 12px;">Qualité</h3>
                    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6;">Le meilleur service client disponible 24h/24 et 7j/7.</p>
                </div>
            </div>

            <div class="cta-banner glass fade-up" style="padding: 60px 40px; text-align: center; border-radius: 32px; background: var(--grad-primary); border: none; color: #fff;">
                <h2 style="font-size: 30px; font-weight: 900; margin-bottom: 16px;">Prêt à passer au Premium ?</h2>
                <p style="opacity: 0.9; margin-bottom: 32px; max-width: 600px; margin-left: auto; margin-right: auto;">Rejoignez la communauté Digitalay dès aujourd'hui et profitez de vos services préférés sans limites.</p>
                <a href="{{ route('products') }}" class="btn btn-primary btn-xl" style="background: #fff; color: var(--primary);">
                    🚀 Explorer la Boutique
                </a>
            </div>

        </div>
    </div>
</main>

<style>
.value-card:hover {
    transform: translateY(-10px);
    border-color: var(--primary-light);
    box-shadow: var(--glow-sm);
}

.fade-up {
    animation: fadeUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

@keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
