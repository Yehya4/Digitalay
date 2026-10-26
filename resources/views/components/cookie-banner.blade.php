<div id="cookie-banner" class="glass" style="display: none; position: fixed; bottom: 24px; left: 24px; right: 24px; max-width: 500px; z-index: 9999; padding: 24px; border-radius: 20px; box-shadow: var(--shadow); border: 1px solid var(--border); background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px);">
    <div style="display: flex; gap: 16px; align-items: flex-start;">
        <div style="font-size: 24px;">🍪</div>
        <div style="flex: 1;">
            <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 8px; color: var(--text);">Nous respectons votre vie privée</h4>
            <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 16px;">
                Digitalay utilise des cookies pour améliorer votre expérience d'achat et analyser notre trafic. En continuant, vous acceptez notre <a href="{{ route('privacy') }}" style="color: var(--primary); font-weight: 700; text-decoration: underline;">politique de confidentialité</a>.
            </p>
            <div style="display: flex; gap: 10px;">
                <button onclick="acceptCookies()" class="btn btn-primary btn-sm" style="flex: 1;">Accepter</button>
                <button onclick="closeCookieBanner()" class="btn btn-ghost btn-sm">Refuser</button>
            </div>
        </div>
    </div>
</div>

<script>
function acceptCookies() {
    localStorage.setItem('cookiesAccepted', 'true');
    closeCookieBanner();
}

function closeCookieBanner() {
    const banner = document.getElementById('cookie-banner');
    banner.style.opacity = '0';
    banner.style.transform = 'translateY(20px)';
    setTimeout(() => { banner.style.display = 'none'; }, 300);
}

document.addEventListener('DOMContentLoaded', () => {
    if (!localStorage.getItem('cookiesAccepted')) {
        const banner = document.getElementById('cookie-banner');
        banner.style.display = 'block';
        banner.style.opacity = '0';
        banner.style.transform = 'translateY(20px)';
        banner.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
        
        setTimeout(() => {
            banner.style.opacity = '1';
            banner.style.transform = 'translateY(0)';
        }, 1000);
    }
});
</script>
