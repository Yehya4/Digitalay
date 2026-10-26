@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 80px; padding-bottom: 80px; position: relative;">
    <div class="bg-mesh"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="section-header fade-up">
            <h1 class="section-title">Foire Aux Questions (FAQ)</h1>
            <p class="section-subtitle">Trouvez rapidement des réponses à vos questions. Si vous ne trouvez pas ce que vous cherchez, contactez-nous sur WhatsApp.</p>
        </div>

        <div class="faq-container" style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 40px;">
            
            <!-- Category: Commandes -->
            <div class="faq-category fade-up" style="animation-delay: 0.1s;">
                <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; color: var(--primary); display: flex; align-items: center; gap: 10px;">
                    🛒 Commandes & Paiement
                </h2>
                <div class="accordion">
                    <div class="accordion-item glass">
                        <button class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Comment passer une commande ?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Choisissez votre service premium, cliquez sur "Ajouter au panier" ou "Commander", remplissez vos informations et choisissez votre mode de paiement. Une fois la commande confirmée, suivez les instructions affichées à l'écran.</p>
                        </div>
                    </div>
                    <div class="accordion-item glass">
                        <button class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Quels sont les modes de paiement acceptés ?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Nous acceptons les virements bancaires (CIH Bank, Banque Populaire) ainsi que les paiements directs via WhatsApp pour plus de proximité.</p>
                        </div>
                    </div>
                    <div class="accordion-item glass">
                        <button class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Puis-je annuler ma commande ?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Vous pouvez annuler votre commande tant que le service n'a pas encore été activé. Une fois l'activation effectuée, l'annulation n'est plus possible.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Livraison -->
            <div class="faq-category fade-up" style="animation-delay: 0.2s;">
                <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; color: var(--primary); display: flex; align-items: center; gap: 10px;">
                    🚀 Livraison & Activation
                </h2>
                <div class="accordion">
                    <div class="accordion-item glass">
                        <button class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Combien de temps prend la livraison ?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content">
                            <p>La livraison est généralement instantanée après réception du paiement. Dans certains cas, cela peut prendre entre 5 à 15 minutes selon la charge de notre équipe.</p>
                        </div>
                    </div>
                    <div class="accordion-item glass">
                        <button class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Comment activer ma licence ?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Vous recevrez les instructions d'activation détaillées directement sur WhatsApp ou par Email. Il s'agit généralement d'un code ou d'une invitation à rejoindre un plan famille/premium.</p>
                        </div>
                    </div>
                    <div class="accordion-item glass">
                        <button class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Que faire si l'activation échoue ?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Pas d'inquiétude ! Contactez immédiatement notre support sur WhatsApp avec votre numéro de commande, et un agent vous assistera en quelques minutes.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Garanties -->
            <div class="faq-category fade-up" style="animation-delay: 0.3s;">
                <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; color: var(--primary); display: flex; align-items: center; gap: 10px;">
                    🛡️ Garanties & Sécurité
                </h2>
                <div class="accordion">
                    <div class="accordion-item glass">
                        <button class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Les licences sont-elles authentiques ?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Oui, 100% de nos abonnements sont officiels et proviennent directement des fournisseurs de services originaux. Nous garantissons la durée totale de votre abonnement.</p>
                        </div>
                    </div>
                    <div class="accordion-item glass">
                        <button class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Quelle est votre politique de remboursement ?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Si nous ne parvenons pas à activer votre service dans les 24h, vous êtes intégralement remboursé.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="faq-cta glass fade-up" style="padding: 40px; text-align: center; border-radius: 24px; background: var(--grad-primary); color: #fff; border: none;">
                <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 12px;">Vous avez d'autres questions ?</h3>
                <p style="opacity: 0.9; margin-bottom: 24px;">Notre équipe est disponible 24/7 pour répondre à toutes vos interrogations.</p>
                <a href="https://wa.me/212665654367" target="_blank" class="btn btn-whatsapp" style="background: #fff; color: #25D366; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                    <i class="fab fa-whatsapp"></i> Contactez-nous sur WhatsApp
                </a>
            </div>

        </div>
    </div>
</main>

<style>
.accordion-item {
    margin-bottom: 12px;
    border-radius: 16px;
    overflow: hidden;
    transition: var(--t);
    border: 1px solid var(--border);
}

.accordion-item:hover {
    border-color: var(--primary-light);
}

.accordion-header {
    width: 100%;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: transparent;
    border: none;
    color: var(--text);
    font-size: 16px;
    font-weight: 700;
    text-align: left;
    cursor: pointer;
    font-family: var(--font);
}

.accordion-header i {
    transition: transform 0.3s ease;
    color: var(--primary);
}

.accordion-item.active .accordion-header i {
    transform: rotate(180deg);
}

.accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out, padding 0.3s ease;
    padding: 0 24px;
    background: rgba(37, 99, 235, 0.02);
}

.accordion-item.active .accordion-content {
    max-height: 200px;
    padding: 0 24px 20px 24px;
}

.accordion-content p {
    color: var(--text-2);
    line-height: 1.6;
    font-size: 15px;
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

<script>
function toggleAccordion(btn) {
    const item = btn.parentElement;
    const isActive = item.classList.contains('active');
    
    // Close all other items
    document.querySelectorAll('.accordion-item').forEach(el => el.classList.remove('active'));
    
    // Toggle current
    if (!isActive) {
        item.classList.add('active');
    }
}
</script>
@endsection
