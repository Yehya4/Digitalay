@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')
<div class="fade-up-item">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">Paramètres</h1>
            <p class="admin-sub">Configuration de l'espace administration.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr; gap: 20px; max-width: 620px;">

        <!-- INFO CARD -->
        <div class="glass-card fade-up-item" style="padding: 18px 22px; display: flex; align-items: center; gap: 14px; animation-delay: 0.1s;">
            <div style="font-size: 28px; flex-shrink: 0;">🗄️</div>
            <div>
                <div style="font-weight: 800; font-size: 14px; margin-bottom: 2px;">Mot de passe stocké en base de données</div>
                <div style="font-size: 12px; color: var(--text-muted);">Le mot de passe est haché (Bcrypt via Laravel) et conservé dans la base de données <strong>MySQL</strong>.</div>
            </div>
            <span style="margin-left: auto; flex-shrink: 0; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; background: rgba(16,185,129,0.12); color: #10B981;">
                ✅ Sécurisé
            </span>
        </div>

        <!-- CHANGE PASSWORD FORM -->
        <div class="glass-card fade-up-item" style="padding: 28px 24px; animation-delay: 0.2s;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(37,99,235,0.1); display: flex; align-items: center; justify-content: center; font-size: 18px;">🔒</div>
                <div>
                    <div style="font-weight: 800; font-size: 16px;">Changer le mot de passe admin</div>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">La modification est enregistrée immédiatement en base de données.</div>
                </div>
            </div>

            @if(session('password_changed'))
                <div style="background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.2); border-radius: 8px; padding: 10px 14px; margin-bottom: 20px; font-size: 13px; color: #10B981; font-weight: 600;">
                    ✅ Mot de passe modifié le {{ now()->format('d/m/Y à H:i') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.password') }}" method="POST" style="display: flex; flex-direction: column; gap: 18px;" onsubmit="return validatePasswordForm()">
                @csrf
                
                <!-- CURRENT -->
                <div>
                    <label class="admin-label">Mot de passe actuel *</label>
                    <div style="position: relative;">
                        <input
                            required
                            name="current_password"
                            type="password"
                            id="current-pass"
                            class="input @error('current_password') error @enderror"
                            placeholder="Entrez votre mot de passe actuel"
                            style="padding-right: 44px;"
                        />
                        <button type="button" class="eye-btn" onclick="togglePassword('current-pass', this)">👁️</button>
                    </div>
                    @error('current_password')
                        <div style="color: var(--accent-red); font-size: 12px; margin-top: 4px; font-weight: 600;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NEW -->
                <div>
                    <label class="admin-label">Nouveau mot de passe *</label>
                    <div style="position: relative;">
                        <input
                            required
                            name="new_password"
                            type="password"
                            id="new-pass"
                            class="input @error('new_password') error @enderror"
                            placeholder="Minimum 6 caractères"
                            style="padding-right: 44px;"
                            oninput="checkStrength(); checkMatch()"
                        />
                        <button type="button" class="eye-btn" onclick="togglePassword('new-pass', this)">👁️</button>
                    </div>
                    @error('new_password')
                        <div style="color: var(--accent-red); font-size: 12px; margin-top: 4px; font-weight: 600;">{{ $message }}</div>
                    @enderror

                    <!-- STRENGTH BAR -->
                    <div id="strength-container" style="margin-top: 8px; display: none;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span style="font-size: 11px; color: var(--text-muted);">Force</span>
                            <span id="strength-label" style="font-size: 11px; font-weight: 700;"></span>
                        </div>
                        <div style="height: 4px; background: var(--border); border-radius: 4px; overflow: hidden;">
                            <div id="strength-bar" style="height: 100%; transition: all 0.3s; border-radius: 4px;"></div>
                        </div>
                    </div>
                </div>

                <!-- CONFIRM -->
                <div>
                    <label class="admin-label">Confirmer le nouveau mot de passe *</label>
                    <div style="position: relative;">
                        <input
                            required
                            name="new_password_confirmation"
                            type="password"
                            id="confirm-pass"
                            class="input"
                            placeholder="Retapez le nouveau mot de passe"
                            style="padding-right: 44px;"
                            oninput="checkMatch()"
                        />
                        <button type="button" class="eye-btn" onclick="togglePassword('confirm-pass', this)">👁️</button>
                    </div>
                    <div id="match-status" style="margin-top: 4px; font-size: 12px; font-weight: 600; display: none;"></div>
                </div>

                <button
                    type="submit"
                    id="submit-btn"
                    class="btn btn-primary btn-full"
                    style="margin-top: 8px;"
                >
                    💾 Enregistrer le nouveau mot de passe
                </button>
            </form>
        </div>

        <!-- INFO NOTE -->
        <div class="fade-up-item" style="background: rgba(37,99,235,0.04); border: 1px solid rgba(37,99,235,0.15); border-radius: 10px; padding: 14px 16px; font-size: 13px; color: var(--text-2); line-height: 1.6; animation-delay: 0.3s;">
            ℹ️ <strong>Sécurité :</strong> Le mot de passe est haché avec <strong>Bcrypt</strong> avant d'être stocké. Le mot de passe en clair n'est jamais sauvegardé. En cas d'oubli, vous pouvez le réinitialiser via Tinker :<br />
            <code style="display: block; background: var(--bg); padding: 8px 12px; border-radius: 6px; margin-top: 8px; font-size: 12px; font-family: monospace; white-space: pre-wrap;">php artisan tinker
> App\Models\AdminConfig::updateOrCreate(['key' => 'admin_password'], ['value' => Hash::make('nouveau_mdp')])</code>
        </div>
    </div>
</div>

<style>
.fade-up-item { opacity: 0; transform: translateY(20px); animation: fadeUpAnim 0.4s ease-out forwards; }
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

.eye-btn {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: transparent; border: none; cursor: pointer; font-size: 16px;
    color: var(--text-muted); padding: 4px;
}
</style>

@push('scripts')
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerText = '🙈';
        } else {
            input.type = 'password';
            btn.innerText = '👁️';
        }
    }

    function checkStrength() {
        const pass = document.getElementById('new-pass').value;
        const container = document.getElementById('strength-container');
        const label = document.getElementById('strength-label');
        const bar = document.getElementById('strength-bar');

        if (!pass) {
            container.style.display = 'none';
            return;
        }
        
        container.style.display = 'block';

        let strLabel = '';
        let strColor = '';
        let strWidth = '';

        if (pass.length < 6) {
            strLabel = 'Trop court'; strColor = '#EF4444'; strWidth = '20%';
        } else if (pass.length < 8) {
            strLabel = 'Faible'; strColor = '#F59E0B'; strWidth = '40%';
        } else if (/[A-Z]/.test(pass) && /[0-9]/.test(pass)) {
            strLabel = 'Fort'; strColor = '#10B981'; strWidth = '100%';
        } else {
            strLabel = 'Moyen'; strColor = '#3B82F6'; strWidth = '70%';
        }

        label.innerText = strLabel;
        label.style.color = strColor;
        bar.style.width = strWidth;
        bar.style.backgroundColor = strColor;
    }

    function checkMatch() {
        const newPass = document.getElementById('new-pass').value;
        const confirmPass = document.getElementById('confirm-pass').value;
        const status = document.getElementById('match-status');
        const confirmInput = document.getElementById('confirm-pass');
        const submitBtn = document.getElementById('submit-btn');

        if (!confirmPass) {
            status.style.display = 'none';
            confirmInput.style.borderColor = 'var(--border)';
            submitBtn.disabled = false;
            return;
        }

        status.style.display = 'block';
        if (newPass === confirmPass) {
            status.innerText = '✓ Les mots de passe correspondent';
            status.style.color = '#10B981';
            confirmInput.style.borderColor = '#10B981';
            submitBtn.disabled = false;
        } else {
            status.innerText = '✗ Les mots de passe ne correspondent pas';
            status.style.color = '#EF4444';
            confirmInput.style.borderColor = '#EF4444';
            submitBtn.disabled = true;
        }
    }

    function validatePasswordForm() {
        const newPass = document.getElementById('new-pass').value;
        const confirmPass = document.getElementById('confirm-pass').value;

        if (newPass.length < 6) {
            showToast('danger', 'Le nouveau mot de passe doit comporter au moins 6 caractères');
            return false;
        }
        if (newPass !== confirmPass) {
            showToast('danger', 'Les mots de passe ne correspondent pas');
            return false;
        }
        
        const btn = document.getElementById('submit-btn');
        btn.innerHTML = '⏳ Enregistrement en base...';
        btn.style.opacity = '0.7';
        btn.disabled = true;
        
        return true;
    }
</script>
@endpush
@endsection
