@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
    <!-- HEADER -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">Catégories</h1>
            <p class="admin-sub">Gérez les catégories de votre catalogue.</p>
        </div>
        <button class="btn btn-primary" onclick="openModal()">+ Nouvelle Catégorie</button>
    </div>

<div class="fade-up-item">
    <!-- CARDS GRID -->
    <div class="admin-cat-grid">
        @forelse($categories as $c)
            <div class="glass-card admin-cat-card fade-up-item" style="animation-delay: {{ $loop->index * 0.05 }}s;">
                <div class="admin-cat-card-header">
                    <div class="admin-cat-icon" style="background: {{ $c->color }}22; color: {{ $c->color }};">
                        <i class="{{ $c->icon ?: 'fas fa-tag' }}"></i>
                    </div>
                    <div style="display: flex; gap: 6px; margin-left: auto;">
                        <button class="btn btn-outline" style="padding: 5px 10px; font-size: 12px;" onclick="openModal({{ $c->toJson() }})">✏️</button>
                        <button
                            class="btn btn-outline"
                            style="padding: 5px 10px; font-size: 12px; border-color: var(--accent-red); color: var(--accent-red);"
                            onclick="confirmDelete('{{ $c->id }}', '{{ addslashes($c->name) }}')"
                        >🗑️</button>
                    </div>
                </div>
                <div class="admin-cat-name">{{ $c->name }}</div>
                <div class="admin-cat-slug">{{ $c->slug }}</div>
                @if($c->description)
                    <div class="admin-cat-desc">{{ $c->description }}</div>
                @endif
                <div class="admin-cat-footer">
                    <span class="admin-cat-count" style="background: {{ $c->color }}22; color: {{ $c->color }};">
                        {{ $c->products_count ?? 0 }} produit{{ ($c->products_count ?? 0) !== 1 ? 's' : '' }}
                    </span>
                    <span style="font-size: 13px; font-family: monospace; color: var(--text-muted); margin-left: auto;">{{ $c->color }}</span>
                </div>
            </div>
        @empty
            <div class="empty" style="grid-column: 1 / -1;"><div class="empty-icon">🏷️</div><div class="empty-title">Aucune catégorie</div></div>
        @endforelse
    </div>
</div>

@php
    $iconPresets = [
        'fas fa-crown', 'fas fa-star', 'fas fa-bolt', 'fas fa-brain',
        'fas fa-music', 'fas fa-tv', 'fas fa-film', 'fas fa-robot',
        'fas fa-shield-alt', 'fas fa-lock', 'fas fa-globe', 'fas fa-cloud',
        'fas fa-mobile-alt', 'fas fa-gamepad', 'fas fa-headphones', 'fas fa-gem',
    ];
@endphp

<!-- CATEGORY MODAL -->
<div class="admin-modal-backdrop" id="cat-modal" style="display: none;" onclick="closeModal('cat-modal')">
    <div class="glass-card admin-modal-card fade-up-item" style="max-width: 540px; margin: auto; margin-top: 5vh;" onclick="event.stopPropagation()">
        <div class="admin-modal-header">
            <h2 class="admin-modal-title" id="cat-modal-title">Nouvelle Catégorie</h2>
            <button class="admin-modal-close" onclick="closeModal('cat-modal')">×</button>
        </div>

        <div style="padding: 0 24px;">
            <!-- LIVE PREVIEW -->
            <div class="admin-cat-preview">
                <div class="admin-cat-icon" id="preview-icon-wrapper" style="background: #7C3AED22; color: #7C3AED; width: 50px; height: 50px; font-size: 22px;">
                    <i id="preview-icon" class="fas fa-star"></i>
                </div>
                <div>
                    <div style="font-weight: 800;" id="preview-name">Nom de la catégorie</div>
                    <div style="font-size: 12px; color: var(--text-muted);" id="preview-slug">slug</div>
                </div>
            </div>

            <form id="cat-form" method="POST" action="{{ route('admin.categories.store') }}" style="display: flex; flex-direction: column; gap: 16px;">
                @csrf
                <input type="hidden" name="_method" id="cat-method" value="POST">

                <div>
                    <label class="admin-label">Nom *</label>
                    <input type="text" name="name" id="cat-name" required class="input" oninput="updateCatForm()" placeholder="ex: Streaming" />
                </div>

                <div>
                    <label class="admin-label">Slug * (Généré automatiquement si vide)</label>
                    <input type="text" name="slug" id="cat-slug" class="input" oninput="updateCatForm()" placeholder="ex: streaming" />
                    <p id="slug-warning" style="display: none; font-size: 11px; color: var(--text-muted); margin-top: 4px;">Le slug ne peut pas être modifié lors de l'édition.</p>
                </div>

                <div>
                    <label class="admin-label">Couleur</label>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="color" name="color" id="cat-color" value="#7C3AED" oninput="updateCatForm()" style="width: 44px; height: 44px; padding: 0; border: none; border-radius: 8px; cursor: pointer; background: transparent;" />
                        <span id="cat-color-text" style="font-family: monospace; color: var(--text-muted);">#7C3AED</span>
                    </div>
                </div>

                <div>
                    <label class="admin-label">Icône FontAwesome</label>
                    <input type="text" name="icon" id="cat-icon" class="input" placeholder="fas fa-star" value="fas fa-star" oninput="updateCatForm()" style="margin-bottom: 10px;" />
                    <div class="admin-icon-presets">
                        @foreach($iconPresets as $ic)
                            <button type="button" class="admin-icon-btn" onclick="setIcon('{{ $ic }}')" title="{{ $ic }}" data-icon="{{ $ic }}">
                                <i class="{{ $ic }}"></i>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="admin-label">Description (optionnel)</label>
                    <textarea name="description" id="cat-desc" class="input" rows="2" placeholder="Description courte..."></textarea>
                </div>

                <div style="margin-top: 8px; display: flex; gap: 12px;">
                    <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeModal('cat-modal')">Annuler</button>
                    <button type="submit" id="cat-submit-btn" class="btn btn-primary" style="flex: 2;">✅ Créer la catégorie</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE CONFIRM -->
<div class="admin-modal-backdrop" id="delete-modal" style="display: none;" onclick="closeModal('delete-modal')">
    <div class="glass-card fade-up-item" style="max-width: 400px; width: 90%; padding: 32px; text-align: center; margin: auto; margin-top: 15vh;" onclick="event.stopPropagation()">
        <div style="font-size: 48px; margin-bottom: 16px;">⚠️</div>
        <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 12px;">Supprimer « <span id="del-catname"></span> » ?</h3>
        <p style="color: var(--text-muted); margin-bottom: 24px;">Les produits associés n'auront plus de catégorie.</p>
        
        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closeModal('delete-modal')" class="btn btn-outline" style="flex: 1;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="flex: 1; background: var(--accent-red); border: none;">Supprimer</button>
            </div>
        </form>
    </div>
</div>

<style>
.fade-up-item { opacity: 0; transform: translateY(20px); animation: fadeUpAnim 0.3s ease-out forwards; }
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

.admin-modal-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000;
    backdrop-filter: blur(4px); display: flex; align-items: flex-start; justify-content: center; overflow-y: auto; padding: 20px; box-sizing: border-box;
}
.admin-modal-card {
    width: 100%; background: var(--bg-card); border-radius: var(--r-lg); border: 1px solid var(--border);
    padding-bottom: 24px; box-sizing: border-box;
}
.admin-modal-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 20px 24px; border-bottom: 1px solid var(--border); margin-bottom: 20px;
}
.admin-modal-title { font-size: 20px; font-weight: 800; }
.admin-modal-close { background: transparent; border: none; font-size: 24px; cursor: pointer; color: var(--text-muted); }
</style>

@endsection

@push('scripts')
<script>
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function confirmDelete(id, name) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/categories/${id}`;
        document.getElementById('del-catname').innerText = name;
        document.getElementById('delete-modal').style.display = 'block';
    }

    function openModal(cat = null) {
        const form = document.getElementById('cat-form');
        const title = document.getElementById('cat-modal-title');
        const submitBtn = document.getElementById('cat-submit-btn');
        const method = document.getElementById('cat-method');
        const slugInput = document.getElementById('cat-slug');
        const slugWarning = document.getElementById('slug-warning');

        if(cat) {
            form.action = `/admin/categories/${cat.id}`;
            method.value = 'PUT';
            title.innerText = '✏️ Modifier la Catégorie';
            submitBtn.innerText = '💾 Mettre à jour';
            
            document.getElementById('cat-name').value = cat.name;
            slugInput.value = cat.slug;
            slugInput.readOnly = true;
            slugInput.style.opacity = '0.5';
            slugWarning.style.display = 'block';
            
            document.getElementById('cat-color').value = cat.color;
            document.getElementById('cat-icon').value = cat.icon || 'fas fa-star';
            document.getElementById('cat-desc').value = cat.description || '';
        } else {
            form.action = `{{ route('admin.categories.store') }}`;
            method.value = 'POST';
            title.innerText = 'Nouvelle Catégorie';
            submitBtn.innerText = '✅ Créer la catégorie';
            
            form.reset();
            document.getElementById('cat-color').value = '#7C3AED';
            document.getElementById('cat-icon').value = 'fas fa-star';
            
            slugInput.readOnly = false;
            slugInput.style.opacity = '1';
            slugWarning.style.display = 'none';
        }
        
        updateCatForm();
        document.getElementById('cat-modal').style.display = 'block';
    }

    function setIcon(ic) {
        document.getElementById('cat-icon').value = ic;
        updateCatForm();
    }

    function updateCatForm() {
        const name = document.getElementById('cat-name').value;
        const slugInput = document.getElementById('cat-slug');
        const color = document.getElementById('cat-color').value;
        const icon = document.getElementById('cat-icon').value;
        
        // Auto-generate slug if it's a new category and user hasn't typed anything in slug manually, 
        // OR simply rely on server side. For preview, we'll just format it.
        let slug = slugInput.value;
        if(!slugInput.readOnly && name && (!slug || slug.trim() === '')) {
            slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            // slugInput.value = slug; // Don't auto-fill input to not override user typing, but show in preview
        }

        // Update preview
        document.getElementById('preview-name').innerText = name || 'Nom de la catégorie';
        document.getElementById('preview-slug').innerText = slug || slugInput.value || 'slug';
        
        const previewIconWrapper = document.getElementById('preview-icon-wrapper');
        previewIconWrapper.style.backgroundColor = `${color}22`;
        previewIconWrapper.style.color = color;
        
        document.getElementById('cat-color-text').innerText = color;
        document.getElementById('preview-icon').className = icon || 'fas fa-star';

        // Update active state of preset buttons
        document.querySelectorAll('.admin-icon-btn').forEach(btn => {
            if(btn.dataset.icon === icon) {
                btn.style.backgroundColor = `${color}33`;
                btn.style.borderColor = color;
                btn.style.color = color;
                btn.classList.add('active');
            } else {
                btn.style.backgroundColor = '';
                btn.style.borderColor = '';
                btn.style.color = '';
                btn.classList.remove('active');
            }
        });
    }
</script>
@endpush
