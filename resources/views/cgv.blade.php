@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 80px; padding-bottom: 80px; position: relative;">
    <div class="bg-mesh"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="legal-card glass fade-up" style="max-width: 900px; margin: 0 auto; padding: 48px; border-radius: 24px; background: #111827; color: #fff; border: 1px solid rgba(255,255,255,0.1);">
            
            <h1 style="font-size: 32px; font-weight: 900; margin-bottom: 40px; text-align: center;" class="gradient-text">Conditions Générales de Vente (CGV)</h1>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">1. Acceptation des conditions</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">En utilisant les services de Digitalay Store, vous acceptez les présentes conditions d'utilisation. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser nos services.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">2. Produits et services</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Nous vendons des licences et abonnements numériques authentiques. Tous nos produits sont décrits avec précision sur notre site. Nous nous réservons le droit de modifier les prix et la disponibilité sans préavis.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">3. Commande et paiement</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Les paiements doivent être effectués avant l'activation de la licence. Nous acceptons plusieurs modes de paiement sécurisés (Virement bancaire, WhatsApp Pay).</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">4. Livraison</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">La livraison des licences est instantanée et s'effectue par WhatsApp ou Email. Les délais peuvent varier légèrement selon la disponibilité de notre équipe, mais sont généralement inférieurs à 15 minutes.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">5. Garantie et remboursement</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Nous garantissons l'activation de toutes nos licences. En cas de problème d'activation que nous ne pouvons pas résoudre, nous offrons un remboursement intégral dans les 7 jours suivant l'achat.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">6. Utilisation des licences</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Les licences doivent être utilisées conformément aux conditions du fournisseur d'origine. Toute utilisation abusive ou frauduleuse peut entraîner la révocation de la licence sans remboursement.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">7. Propriété intellectuelle</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Tous les contenus de ce site (textes, images, logos) sont protégés par le droit d'auteur et appartiennent à Digitalay Store ou à leurs propriétaires respectifs.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">8. Limitation de responsabilité</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Digitalay ne peut être tenu responsable des dommages indirects résultant de l'utilisation de nos produits. Notre responsabilité est limitée au montant payé pour le produit concerné.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">9. Modifications</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Nous nous réservons le droit de modifier ces conditions à tout moment. Les modifications entrent en vigueur dès leur publication sur le site.</p>
            </div>

            <div class="legal-section">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">10. Contact</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Pour toute question concernant ces conditions, contactez-nous via WhatsApp au +212 665 654 367.</p>
            </div>

            <div style="margin-top: 48px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 13px; color: rgba(255,255,255,0.5); text-align: center;">
                Dernière mise à jour : 16 Mars 2026
            </div>
        </div>
    </div>
</main>
@endsection
