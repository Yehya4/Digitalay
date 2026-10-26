<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion Administration | Digitalay</title>
    @vite(['resources/css/app.css'])
</head>
<body style="background: var(--bg); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px;">

    <div class="glass-card" style="padding: 44px 36px; width: 100%; max-width: 400px; text-align: center;">
        <div style="font-size: 52px; margin-bottom: 10px;">🔐</div>
        <h2 style="font-weight: 900; font-size: 22px; margin-bottom: 6px;">Administration</h2>
        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 28px;">
            Digitalay Admin Panel
        </p>

        @if(session('error'))
            <div class="alert alert-error" style="margin-bottom: 20px;">
                ❌ {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div style="position: relative; margin-bottom: 14px;">
                <input
                    type="password"
                    name="password"
                    id="password-input"
                    class="input"
                    placeholder="Mot de passe"
                    required
                    style="padding-right: 44px; text-align: center; letter-spacing: 2px;"
                    autofocus
                />
                <button
                    type="button"
                    onclick="togglePass()"
                    style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; font-size: 16px; color: var(--text-muted);"
                    id="toggle-btn"
                >👁️</button>
            </div>

            <button type="submit" class="btn btn-primary btn-full" style="font-size: 15px; padding: 12px;">
                🚀 Se connecter
            </button>
        </form>

        <a href="{{ route('home') }}" style="display: block; margin-top: 20px; color: var(--text-muted); font-size: 13px;">
            ← Retour à la boutique
        </a>
    </div>

    <script>
        function togglePass() {
            const input = document.getElementById('password-input');
            const btn = document.getElementById('toggle-btn');
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerText = '🙈';
            } else {
                input.type = 'password';
                btn.innerText = '👁️';
            }
        }
    </script>
</body>
</html>
