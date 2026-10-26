@extends('layouts.admin')

@section('title', isset($product) ? 'Modifier Produit' : 'Nouveau Produit')

@section('content')
<div class="fade-up-item">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">{{ isset($product) ? '✏️ Modifier Produit' : '+ Nouveau Produit' }}</h1>
            <p class="admin-sub">{{ isset($product) ? 'Mise à jour des informations de ' . $product->name : 'Ajouter un nouveau service au catalogue' }}</p>
        </div>
        <a href="{{ route('admin.products') }}" class="btn btn-outline">← Retour</a>
    </div>

    <div class="glass-card" style="padding: 32px;">
        <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="admin-product-form-grid">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <!-- LEFT COLUMN -->
            <div class="admin-form-col">
                <div>
                    <label class="admin-label">Nom du produit *</label>
                    <input type="text" name="name" class="input" required value="{{ old('name', isset($product) ? $product->name : '') }}" placeholder="ex: Netflix Premium 4K" />
                </div>

                <div>
                    <label class="admin-label">Catégorie *</label>
                    <select name="category_id" class="input" required>
                        <option value="">Sélectionner...</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ (old('category_id', isset($product) ? $product->category_id : '') == $c->id) ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-row">
                    <div>
                        <label class="admin-label">Prix (MAD) *</label>
                        <input type="number" step="0.01" min="0" name="price" class="input" required value="{{ old('price', isset($product) ? $product->price : '') }}" placeholder="99.00" />
                    </div>
                    <div>
                        <label class="admin-label">Prix barré (MAD)</label>
                        <input type="number" step="0.01" min="0" name="original_price" class="input" value="{{ old('original_price', isset($product) ? $product->original_price : '') }}" placeholder="199.00" />
                    </div>
                </div>

                <div class="admin-form-row">
                    <div>
                        <label class="admin-label">Badge</label>
                        <input type="text" name="badge" id="badge-input" class="input" value="{{ old('badge', isset($product) ? $product->badge : '') }}" placeholder="ex: Populaire" oninput="updateBadgePreview()" />
                    </div>
                    <div>
                        <label class="admin-label">Couleur badge</label>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="color" name="badge_color" id="badge-color-input" value="{{ old('badge_color', isset($product) ? $product->badge_color : '#7C3AED') }}" 
                                style="width: 44px; height: 44px; padding: 0; border: none; border-radius: 8px; cursor: pointer; background: transparent;" 
                                oninput="updateBadgePreview()" />
                            <span id="badge-color-text" style="font-family: monospace; font-size: 13px; color: var(--text-muted);">
                                {{ old('badge_color', isset($product) ? $product->badge_color : '#7C3AED') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="admin-label">Stock</label>
                    <input type="number" min="0" name="stock" class="input" value="{{ old('stock', isset($product) ? $product->stock : 100) }}" />
                </div>

                <div>
                    <label class="admin-label">⏱ Durée par défaut ou unique (en mois)</label>
                    <input
                        type="number"
                        name="duration_months"
                        class="input"
                        min="1"
                        max="360"
                        value="{{ old('duration_months', isset($product) ? $product->duration_months : '') }}"
                        placeholder="ex: 1, 3, 6, 12, 24..."
                    />
                    <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Entrez la durée en mois. Laissez vide si vous utilisez le tableau de multi-durées ci-dessous.</p>
                </div>

                <!-- MULTI-DURATION SECTION -->
                <div class="glass-card" style="padding: 24px; border: 1px dashed var(--primary-light); background: rgba(124, 58, 237, 0.02); margin-top: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div>
                            <h4 style="font-size: 15px; font-weight: 800; color: var(--primary); margin-bottom: 4px;">💎 Gestion des Tarifs Multi-durées</h4>
                            <p style="font-size: 12px; color: var(--text-muted);">Ajoutez les différentes options de durée (ex: 1 Mois, 12 Mois) et leurs prix respectifs.</p>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addDurationRow()" style="padding: 8px 16px; font-size: 13px;">+ Ajouter une durée</button>
                    </div>
                    
                    <div id="durations-container">
                        @php
                            $durations = old('durations', isset($product) ? $product->durations->toArray() : []);
                        @endphp
                        @foreach($durations as $index => $d)
                            <div class="duration-row-premium fade-up-item" style="margin-bottom: 12px;">
                                <div class="duration-row-grid">
                                    <div class="duration-input-group">
                                        <span class="duration-input-icon">⏱️</span>
                                        <input type="text" name="durations[{{ $index }}][duration_name]" class="input" value="{{ $d['duration_name'] }}" required placeholder="ex: 1 Mois" />
                                    </div>
                                    <div class="duration-input-group">
                                        <span class="duration-input-icon">💰</span>
                                        <input type="number" step="0.01" name="durations[{{ $index }}][price]" class="input" value="{{ $d['price'] }}" required placeholder="Prix" />
                                    </div>
                                    <div class="duration-input-group">
                                        <span class="duration-input-icon" style="color: #ef4444;">🏷️</span>
                                        <input type="number" step="0.01" name="durations[{{ $index }}][original_price]" class="input" value="{{ $d['original_price'] }}" placeholder="Prix barré" />
                                    </div>
                                    <button type="button" class="duration-remove-btn" onclick="this.closest('.duration-row-premium').remove()">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if(count($durations) === 0)
                        <div id="no-durations-hint" style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 13px; border: 1px dashed var(--border); border-radius: 12px;">
                            Aucune durée spécifique ajoutée. Le produit utilisera le prix unique par défaut.
                        </div>
                    @endif
                </div>

                <div>
                    <label class="admin-label">Description *</label>
                    <textarea name="description" class="input" rows="3" required placeholder="Description du service...">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                </div>

                <div>
                    <label class="admin-label">Fonctionnalités (une par ligne)</label>
                    <textarea name="features" class="input" rows="3" placeholder="Ultra HD 4K&#10;4 écrans simultanés&#10;30 jours d'accès">{{ old('features', isset($product) ? $product->features : '') }}</textarea>
                </div>

                <div>
                    <label class="admin-label">Message WhatsApp (optionnel)</label>
                    <textarea name="whatsapp_message" class="input" rows="2" placeholder="Message personnalisé pour la commande WhatsApp...">{{ old('whatsapp_message', isset($product) ? $product->whatsapp_message : '') }}</textarea>
                </div>

                <div class="admin-form-toggles">
                    <label class="admin-toggle-label" style="cursor: pointer;">
                        <input type="checkbox" name="is_active" id="is_active" value="1" style="display: none;" {{ old('is_active', isset($product) ? $product->is_active : true) ? 'checked' : '' }} onchange="toggleSwitch('switch-active', this.checked)">
                        <div class="admin-switch {{ old('is_active', isset($product) ? $product->is_active : true) ? 'on' : '' }}" id="switch-active">
                            <div class="admin-switch-knob"></div>
                        </div>
                        <span>Produit publié (visible)</span>
                    </label>

                    <label class="admin-toggle-label" style="cursor: pointer;">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" style="display: none;" {{ old('is_featured', isset($product) ? $product->is_featured : false) ? 'checked' : '' }} onchange="toggleSwitch('switch-featured', this.checked, '#F59E0B')">
                        <div class="admin-switch {{ old('is_featured', isset($product) ? $product->is_featured : false) ? 'on' : '' }}" id="switch-featured" style="{{ old('is_featured', isset($product) ? $product->is_featured : false) ? 'background: #F59E0B;' : '' }}">
                            <div class="admin-switch-knob"></div>
                        </div>
                        <span>Mis en vedette (tendance)</span>
                    </label>
                </div>
            </div>

            <!-- RIGHT COLUMN – IMAGE -->
            <div class="admin-form-col">
                <label class="admin-label">Image du produit</label>

                <!-- DROP ZONE -->
                <div class="admin-dropzone" onclick="document.getElementById('image-upload').click()">
                    @php $imgUrl = old('image_url', isset($product) ? ($product->image_url ?: '') : ''); @endphp
                    <div id="image-preview-container" style="{{ $imgUrl ? 'position: relative;' : 'display: none;' }}">
                        <img src="{{ $imgUrl }}" id="image-preview" alt="preview" class="admin-img-preview" />
                        <button type="button" class="admin-img-remove" onclick="removeImage(event)">×</button>
                    </div>

                    <div id="image-placeholder" style="{{ $imgUrl ? 'display: none;' : 'text-align: center; color: var(--text-muted);' }}">
                        <div style="font-size: 40px; margin-bottom: 8px;">🖼️</div>
                        <div style="font-weight: 600; margin-bottom: 4px;">Cliquez pour choisir une image</div>
                        <div style="font-size: 11px; margin-top: 8px; color: var(--text-muted);">JPG, PNG, WebP – max 5 Mo</div>
                    </div>
                </div>

                <!-- IMAGE GUIDELINES -->
                <div class="glass-card" style="margin-top: 16px; padding: 16px; border-color: rgba(37, 99, 235, 0.2); background: rgba(37, 99, 235, 0.05);">
                    <h4 style="font-size: 13px; font-weight: 800; color: var(--primary); margin-bottom: 8px;">💡 Conseil pour un design premium :</h4>
                    <ul style="font-size: 12px; color: var(--text-2); list-style: disc; padding-left: 18px; line-height: 1.6;">
                        <li>Utilisez des images <strong>carrées (1:1)</strong>, ex: 800x800 px.</li>
                        <li>Privilégiez le format <strong>PNG avec fond transparent</strong>.</li>
                        <li>Cadrez le logo ou l'objet bien au centre.</li>
                        <li>Cela garantit que tous les produits auront la même taille sur le site.</li>
                    </ul>
                </div>

                <input type="file" name="image" id="image-upload" accept="image/*" style="display: none;" onchange="previewImage(event)" />
                <!-- Hidden input to maintain existing image URL if not uploading a new one -->
                <input type="hidden" name="image_url" id="image-url-input" value="{{ $imgUrl }}" />

                <div style="margin-top: 16px;">
                    <label class="admin-label">— ou — Saisir l'URL de l'image (désactive l'envoi de fichier)</label>
                    <input type="text" id="manual-url" class="input" placeholder="https://..." value="{{ $imgUrl }}" oninput="updateUrlPreview(event)" />
                </div>

                <!-- BADGE PREVIEW -->
                <div id="badge-preview-container" style="{{ old('badge', isset($product) ? $product->badge : '') ? '' : 'display: none;' }} margin-top: 24px;">
                    <label class="admin-label">Aperçu du badge</label>
                    <span id="badge-preview" style="display: inline-block; padding: 4px 14px; border-radius: 14px; font-size: 13px; font-weight: 700;">
                        {{ old('badge', isset($product) ? $product->badge : '') }}
                    </span>
                </div>
            </div>

            <!-- SUBMIT FULL WIDTH -->
            <div class="admin-form-submit">
                <a href="{{ route('admin.products') }}" class="btn btn-outline" style="flex: 1; text-align: center;">Annuler</a>
                <button type="submit" class="btn btn-primary" style="flex: 2;">
                    {{ isset($product) ? '💾 Enregistrer les modifications' : '✅ Créer le produit' }}
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

/* PREMIUM DURATION ROWS */
.duration-row-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 44px;
    gap: 12px;
    align-items: center;
}
.duration-input-group {
    position: relative;
    display: flex;
    align-items: center;
}
.duration-input-icon {
    position: absolute;
    left: 14px;
    font-size: 16px;
    pointer-events: none;
    z-index: 1;
}
.duration-input-group .input {
    padding-left: 40px;
    margin-bottom: 0 !important;
}
.duration-remove-btn {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(239, 68, 68, 0.05);
    border: 1px solid rgba(239, 68, 68, 0.1);
    color: #ef4444;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}
.duration-remove-btn:hover {
    background: #ef4444;
    color: #fff;
    transform: scale(1.05);
}
.duration-remove-btn svg { width: 18px; height: 18px; }

@media (max-width: 600px) {
    .duration-row-grid {
        grid-template-columns: 1fr 1fr;
    }
    .duration-input-group:first-child { grid-column: span 2; }
    .duration-remove-btn { grid-column: span 2; width: 100%; }
}
</style>

@push('scripts')
<script>
    function toggleSwitch(id, isChecked, activeColor = null) {
        const sw = document.getElementById(id);
        if (isChecked) {
            sw.classList.add('on');
            if(activeColor) sw.style.background = activeColor;
        } else {
            sw.classList.remove('on');
            sw.style.background = 'var(--bg-main)';
        }
    }

    function updateBadgePreview() {
        const text = document.getElementById('badge-input').value;
        const color = document.getElementById('badge-color-input').value;
        const container = document.getElementById('badge-preview-container');
        const preview = document.getElementById('badge-preview');
        const colorText = document.getElementById('badge-color-text');

        colorText.innerText = color;

        if (text.trim() === '') {
            container.style.display = 'none';
        } else {
            container.style.display = 'block';
            preview.innerText = text;
            preview.style.backgroundColor = `${color}22`;
            preview.style.color = color;
            preview.style.border = `1px solid ${color}44`;
        }
    }

    // Call once on load to set proper styling
    document.addEventListener('DOMContentLoaded', () => {
        updateBadgePreview();
    });

    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').style.display = 'block';
                document.getElementById('image-placeholder').style.display = 'none';
                
                // Clear manual URL since we're using a file
                document.getElementById('manual-url').value = '';
                document.getElementById('image-url-input').value = '';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage(event) {
        event.stopPropagation();
        document.getElementById('image-upload').value = '';
        document.getElementById('manual-url').value = '';
        document.getElementById('image-url-input').value = '';
        document.getElementById('image-preview').src = '';
        document.getElementById('image-preview-container').style.display = 'none';
        document.getElementById('image-placeholder').style.display = 'block';
    }

    function updateUrlPreview(event) {
        const url = event.target.value;
        
        // Clear file input
        document.getElementById('image-upload').value = '';
        // Set hidden input value
        document.getElementById('image-url-input').value = url;
        
        if (url.trim() !== '') {
            document.getElementById('image-preview').src = url;
            document.getElementById('image-preview-container').style.display = 'block';
            document.getElementById('image-placeholder').style.display = 'none';
        } else {
            removeImage(event);
        }
    }

    let durationIndex = {{ isset($durations) ? count($durations) : 0 }};
    function addDurationRow() {
        const hint = document.getElementById('no-durations-hint');
        if(hint) hint.remove();

        const container = document.getElementById('durations-container');
        const div = document.createElement('div');
        div.className = 'duration-row-premium fade-up-item';
        div.style.marginBottom = '12px';
        div.innerHTML = `
            <div class="duration-row-grid">
                <div class="duration-input-group">
                    <span class="duration-input-icon">⏱️</span>
                    <input type="text" name="durations[${durationIndex}][duration_name]" class="input" required placeholder="ex: 1 Mois" />
                </div>
                <div class="duration-input-group">
                    <span class="duration-input-icon">💰</span>
                    <input type="number" step="0.01" name="durations[${durationIndex}][price]" class="input" required placeholder="Prix" />
                </div>
                <div class="duration-input-group">
                    <span class="duration-input-icon" style="color: #ef4444;">🏷️</span>
                    <input type="number" step="0.01" name="durations[${durationIndex}][original_price]" class="input" placeholder="Prix barré" />
                </div>
                <button type="button" class="duration-remove-btn" onclick="this.closest('.duration-row-premium').remove()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
        `;
        container.appendChild(div);
        durationIndex++;
    }
</script>
@endpush
@endsection
