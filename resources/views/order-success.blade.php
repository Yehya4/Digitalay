@extends('layouts.app')

@section('content')
<main style="min-height: 100vh; padding-top: 80px; padding-bottom: 80px; position: relative; overflow: hidden;">
    <div class="bg-mesh"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="success-card glass fade-up" style="max-width: 650px; margin: 0 auto; padding: 48px 32px; text-align: center; border-radius: 32px; box-shadow: var(--shadow);">
            
            <div class="success-icon" style="font-size: 64px; margin-bottom: 24px; animation: bounceIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);">✅</div>
            
            <h1 class="gradient-text" style="font-size: 32px; font-weight: 900; margin-bottom: 12px;">Merci pour votre confiance !</h1>
            <p style="color: var(--text-muted); font-size: 17px; margin-bottom: 32px;">
                Votre commande <span style="color: var(--primary); font-weight: 700;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span> a été enregistrée avec succès.
            </p>

            <div class="divider" style="height: 1px; background: var(--border); margin: 32px 0;"></div>

            @if($order->payment_method === 'bank_transfer')
                <div class="method-box" style="text-align: left;">
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                        🏦 Instructions de paiement
                    </h3>
                    
                    <div class="bank-details-premium" style="background: rgba(37, 99, 235, 0.04); border: 1px solid var(--border); border-radius: 20px; padding: 24px; margin-bottom: 24px;">
                        <p style="font-size: 14px; color: var(--text-2); margin-bottom: 16px;">Veuillez effectuer le virement de <strong style="color: var(--primary); font-size: 18px;">{{ number_format($order->total_amount, 0) }} MAD</strong> vers l'un des comptes suivants :</p>
                        
                        <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                            <div style="padding: 12px; border-left: 4px solid var(--primary); background: #fff; border-radius: 0 12px 12px 0;">
                                <div style="font-size: 12px; font-weight: 700; color: var(--text-muted);">CIH Bank</div>
                                <div style="font-family: monospace; font-size: 15px; font-weight: 700; margin: 4px 0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                    <span>230 780 9487104211023300 59</span>
                                    <button type="button" class="copy-btn" onclick="copyToClipboard('230 780 9487104211023300 59', this)" style="margin: 0; padding: 4px 8px; font-size: 11px;">
                                        <i class="far fa-copy"></i> Copier
                                    </button>
                                </div>
                                <div style="font-size: 13px; color: var(--text-2);">MOHAMMED AMINE ADI</div>
                            </div>
                            <div style="padding: 12px; border-left: 4px solid var(--accent-cyan); background: #fff; border-radius: 0 12px 12px 0;">
                                <div style="font-size: 12px; font-weight: 700; color: var(--text-muted);">Banque Populaire</div>
                                <div style="font-family: monospace; font-size: 15px; font-weight: 700; margin: 4px 0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                    <span>190 780 2111101886030004 95</span>
                                    <button type="button" class="copy-btn" onclick="copyToClipboard('190 780 2111101886030004 95', this)" style="margin: 0; padding: 4px 8px; font-size: 11px;">
                                        <i class="far fa-copy"></i> Copier
                                    </button>
                                </div>
                                <div style="font-size: 13px; color: var(--text-2);">ADI MOHAMMED AMINE</div>
                            </div>
                        </div>
                    </div>

                    @php
                        $itemsList = "";
                        foreach($order->items as $item) {
                            $itemsList .= "• " . ($item->product->name ?? 'Service') . " (" . $item->quantity . ")\n";
                        }
                        $waMsg = "Bonjour Digitalay 👋\n\nVoici le reçu pour ma commande *#".str_pad($order->id, 5, '0', STR_PAD_LEFT)."*\n\n📦 *Services :*\n" . $itemsList . "\n💰 *Total : ".number_format($order->total_amount, 0)." MAD*\n\nMerci d'activer mon service !";
                    @endphp

                    <a href="https://wa.me/212665654367?text={{ urlencode($waMsg) }}" target="_blank" class="btn btn-whatsapp btn-full btn-lg" style="box-shadow: 0 10px 20px rgba(37, 211, 102, 0.2);">
                        <i class="fab fa-whatsapp" style="font-size: 20px;"></i> Envoyer le reçu sur WhatsApp
                    </a>
                </div>
            @else
                <div class="method-box">
                    <div style="background: rgba(37, 211, 102, 0.05); border: 1px solid rgba(37, 211, 102, 0.2); border-radius: 24px; padding: 32px;">
                        <div style="font-size: 40px; margin-bottom: 16px;">👨‍💻</div>
                        <h3 style="font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 12px;">Validation en cours</h3>
                        <p style="color: var(--text-2); line-height: 1.6;">
                            Un agent de notre équipe vous contactera <strong>très rapidement</strong> sur WhatsApp pour finaliser votre commande et procéder à l'activation.
                        </p>
                    </div>
                </div>
            @endif

            <div style="margin-top: 40px;">
                <a href="{{ route('home') }}" class="btn btn-ghost">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</main>

<style>
@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); opacity: 1; }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); }
}

.fade-up {
    animation: fadeUp 0.6s ease-out forwards;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
