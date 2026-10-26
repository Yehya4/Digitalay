<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/logo192.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Digitalay | Le futur de vos Abonnements Premium</title>
    <meta name="description" content="Débloquez tout le potentiel de l'IA et du streaming. ChatGPT, Netflix, Midjourney et 15+ services avec activation instantanée au Maroc par virement bancaire." />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <meta name="theme-color" content="#1F3C88" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .copy-btn {
            background: rgba(37, 99, 235, 0.08);
            border: 1px solid var(--border);
            color: var(--primary);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-left: 10px;
            transition: var(--t);
            cursor: pointer;
        }
        .copy-btn:hover {
            background: var(--primary);
            color: #fff;
            transform: scale(1.05);
        }
        .copy-btn.copied {
            background: var(--whatsapp, #25D366);
            border-color: #25D366;
            color: #fff;
        }
    </style>

    <script>
        window.copyToClipboard = function(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Copié !';
                btn.classList.add('copied');
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.classList.remove('copied');
                }, 2000);
            }).catch(err => {
                console.error('Erreur lors de la copie : ', err);
            });
        };
    </script>
</head>
<body>
    <div id="app">
        @include('layouts.navbar')

        <main style="overflow-x: hidden;">
            @yield('content')
        </main>

        @include('layouts.footer')
        @include('layouts.whatsapp-float')
        <x-upsell-modal />
        <x-cookie-banner />
    </div>

    @stack('scripts')
</body>
</html>
