@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 64px;">
    <div class="bg-mesh"></div>

    <div class="page-hero" style="padding-bottom: 32px;">
        <h1 class="section-title fade-up-item">🤝 Contactez-nous</h1>
        <p class="section-subtitle fade-up-item" style="animation-delay: 0.1s;">
            Notre équipe réactive est là pour répondre à toutes vos questions.
        </p>
    </div>

    <div class="container" style="padding-bottom: 80px; max-width: 1000px;">
        <div class="contact-grid">

            <!-- LEFT: Info & Alternate contacts -->
            <div class="fade-up-item" style="display: flex; flex-direction: column; gap: 20px; animation-delay: 0.2s;">
                <!-- Live Support -->
                <div class="glass-card" style="padding: 30px; text-align: center; border-top: 4px solid #25D366;">
                    <div style="margin-bottom: 16px; display: flex; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="#25D366" style="filter: drop-shadow(0 10px 15px rgba(37,211,102,0.3));">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
                        </svg>
                    </div>
                    <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">Support WhatsApp Rapide</h2>
                    <p style="color: var(--text-2); font-size: 15px; margin-bottom: 24px; line-height: 1.6;">
                        Pour une réponse en moins de 5 minutes, privilégiez toujours notre canal WhatsApp officiel.
                    </p>
                    <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                        <a href="https://wa.me/212665654367?text={{ urlencode('Bonjour Digitalay 👋, j\'ai une question.') }}" target="_blank" class="btn btn-whatsapp btn-full btn-lg" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fab fa-whatsapp"></i> Ouvrir WhatsApp
                        </a>
                        <a href="https://www.facebook.com/share/1GWqAaef2x/" target="_blank" rel="noreferrer" class="btn btn-outline btn-full btn-lg" style="border-color: #1877F2; color: #1877F2; background: rgba(24,119,242,0.05); display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fab fa-facebook-f"></i> Rejoindre notre page Facebook
                        </a>
                        <a href="https://www.instagram.com/digitalay.store?igsh=MWIwMzV1NHk4bXdjaQ==" target="_blank" rel="noreferrer" class="btn btn-outline btn-full btn-lg" style="border-color: #E1306C; color: #E1306C; background: rgba(225,48,108,0.05); display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fab fa-instagram"></i> Rejoindre notre page Instagram
                        </a>
                    </div>
                </div>

                <!-- General Info -->
                <div class="glass-card" style="padding: 30px;">
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 20px;">Informations utiles</h3>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="display: flex; gap: 12px;">
                            <div style="font-size: 20px;">📧</div>
                            <div>
                                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Email</div>
                                <div style="font-size: 15px; font-weight: 700; color: var(--text);">Digitalayco@gmail.com</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 12px;">
                            <div style="font-size: 20px;">⏰</div>
                            <div>
                                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Horaires du support</div>
                                <div style="font-size: 15px; font-weight: 700; color: var(--text);">Lundi - Dimanche<br />09:00 - 00:00 (Minuit)</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 12px;">
                            <div style="font-size: 20px;">🏦</div>
                            <div>
                                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Service Technique</div>
                                <div style="font-size: 15px; font-weight: 700; color: var(--text);">Activations immédiates après validation du virement.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Form -->
            <div class="glass-card fade-up-item" style="padding: 32px; animation-delay: 0.3s;">
                <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 8px;">Envoyez-nous un message</h2>
                <p style="color: var(--text-2); font-size: 14px; margin-bottom: 24px;">
                    Remplissez le formulaire ci-dessous et nous vous répondrons par email.
                </p>

                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 20px;">
                        ✅ {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error" style="margin-bottom: 20px;">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
                    @csrf
                    <div class="form-row form-row-2">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Nom complet <span>*</span></label>
                            <input name="name" class="input" placeholder="Votre nom" required />
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Email <span>*</span></label>
                            <input name="email" type="email" class="input" placeholder="votre@email.com" required />
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Sujet <span>*</span></label>
                        <select name="subject" class="input" required>
                            <option value="" disabled selected>Sélectionnez un sujet...</option>
                            <option value="Problème avec un compte/abonnement">Problème avec un compte/abonnement</option>
                            <option value="Question sur le paiement (Virement)">Question sur le paiement (Virement)</option>
                            <option value="Demande de partenariat">Demande de partenariat</option>
                            <option value="Autre demande">Autre demande</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Message <span>*</span></label>
                        <textarea
                            name="message"
                            class="input"
                            placeholder="Détaillez votre demande ici..."
                            required
                            style="min-height: 140px; resize: vertical;"
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="margin-top: 8px;">
                        📤 Envoyer le message
                    </button>
                </form>
            </div>

        </div>
    </div>
</main>

<style>
.fade-up-item { opacity: 0; transform: translateY(30px); animation: fadeUpAnim 0.6s ease-out forwards; }
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

.contact-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 40px; align-items: start; }
@media (min-width: 768px) {
    .contact-grid {
        grid-template-columns: 350px 1fr !important;
    }
}
</style>
@endsection
