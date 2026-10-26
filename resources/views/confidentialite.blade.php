@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 80px; padding-bottom: 80px; position: relative;">
    <div class="bg-mesh"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="legal-card glass fade-up" style="max-width: 900px; margin: 0 auto; padding: 48px; border-radius: 24px; background: #111827; color: #fff; border: 1px solid rgba(255,255,255,0.1);">
            
            <h1 style="font-size: 32px; font-weight: 900; margin-bottom: 40px; text-align: center;" class="gradient-text">Politique de Confidentialité</h1>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">1. Collecte des données</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Nous collectons uniquement les informations nécessaires pour traiter vos commandes : nom, email et informations de contact WhatsApp. Ces données sont stockées localement dans votre navigateur pour faciliter vos futurs achats.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">2. Utilisation des données</h2>
                <ul style="color: rgba(255,255,255,0.7); line-height: 1.8; list-style: disc; padding-left: 20px;">
                    <li>Traiter et livrer vos commandes</li>
                    <li>Vous contacter concernant votre commande</li>
                    <li>Fournir un support client réactif</li>
                    <li>Améliorer nos services numériques</li>
                </ul>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">3. Protection des données (CNDP)</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6; margin-bottom: 12px;">Conformément à la loi n° 09-08 édictée par le Dahir n° 1-09-15 du 22 safar 1430 (18 février 2009), relative à la protection des personnes physiques à l'égard du traitement des données à caractère personnel, les informations recueillies sur le site Digitalay sont traitées de manière confidentielle.</p>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Le traitement de ces données a été notifié à la <strong>Commission Nationale de contrôle de la protection des Données à caractère Personnel (CNDP)</strong>. Digitalay s'engage à protéger l'intégrité et la confidentialité de vos données personnelles.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">4. Cookies et stockage local</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Nous utilisons le stockage local de votre navigateur (localStorage) pour sauvegarder vos informations de commande (nom et email) afin de faciliter vos achats futurs. Nous utilisons également des cookies pour analyser le trafic du site via Google Analytics.</p>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">5. Vos droits</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6; margin-bottom: 12px;">Vous avez le droit de :</p>
                <ul style="color: rgba(255,255,255,0.7); line-height: 1.8; list-style: disc; padding-left: 20px;">
                    <li>Accéder à vos données personnelles</li>
                    <li>Demander la correction de vos données</li>
                    <li>Demander la suppression de vos données</li>
                    <li>Vous opposer au traitement de vos données pour des motifs légitimes</li>
                </ul>
            </div>

            <div class="legal-section" style="margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">6. Services tiers</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Nous utilisons WhatsApp pour la communication et la livraison. WhatsApp a sa propre politique de confidentialité que nous vous encourageons à consulter.</p>
            </div>

            <div class="legal-section">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; color: var(--accent-cyan);">7. Contact</h2>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">Pour toute question concernant cette politique de confidentialité ou vos données personnelles, contactez-nous via WhatsApp au +212 665 654 367.</p>
            </div>

            <div style="margin-top: 48px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 13px; color: rgba(255,255,255,0.5); text-align: center;">
                Dernière mise à jour : 16 Mars 2026
            </div>
        </div>
    </div>
</main>
@endsection
