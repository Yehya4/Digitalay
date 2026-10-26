@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 80px; padding-bottom: 80px; position: relative;">
    <div class="bg-mesh"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="legal-card glass fade-up" style="max-width: 900px; margin: 0 auto; padding: 48px; border-radius: 24px; background: #111827; color: #fff; border: 1px solid rgba(255,255,255,0.1);">
            
            <h1 style="font-size: 32px; font-weight: 900; margin-bottom: 40px; text-align: center;" class="gradient-text">Mentions Légales</h1>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">1. Éditeur du site</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6; margin-bottom: 8px;"><strong>Digitalay Store</strong></p>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Dirigeant : Mohammed Amine Adi</p>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Siège Social : Casablanca, Maroc</p>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Email : contact@digitalay.shop</p>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Téléphone : +212 665 654 367</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">2. Hébergement</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Ce site est hébergé par :</p>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;"><strong>Hostinger International Ltd.</strong></p>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">61 Lordou Vironos Street, 6023 Larnaca, Chypre</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">3. Collecte de données</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Digitalay s'engage à ce que la collecte et le traitement de vos données soient conformes à la loi n° 09-08 relative à la protection des personnes physiques à l'égard du traitement des données à caractère personnel (CNDP).</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">4. Propriété intellectuelle</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">L'ensemble de ce site relève de la législation internationale sur le droit d'auteur et la propriété intellectuelle. Tous les droits de reproduction sont réservés, y compris pour les documents téléchargeables et les représentations iconographiques et photographiques.</p>
            </div>

            <div class="legal-section">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">5. Contact</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Pour toute question ou information, vous pouvez nous contacter via WhatsApp ou par le formulaire de contact disponible sur le site.</p>
            </div>

            <div style="margin-top: 48px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 13px; color: rgba(255,255,255,0.5); text-align: center;">
                Digitalay Store © 2026. Tous droits réservés.
            </div>
        </div>
    </div>
</main>
@endsection
