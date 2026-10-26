@extends('layouts.admin')

@section('title', 'Produits')

@section('content')
<div class="fade-up-item">
    <!-- HEADER -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">Produits</h1>
            <p class="admin-sub">{{ count($products) }} produit(s) dans le catalogue</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Nouveau Produit</a>
    </div>

    @php
        $filterCat = request('category', 'all');
        $search = request('search', '');
    @endphp

    <!-- SEARCH & FILTER -->
    <div class="admin-search-bar">
        <span class="admin-search-icon">🔍</span>
        <form action="{{ route('admin.products') }}" method="GET" style="flex: 1; display: flex;">
            <input type="hidden" name="category" value="{{ $filterCat }}">
            <input
                type="text"
                name="search"
                class="admin-search-input"
                placeholder="Rechercher un produit..."
                value="{{ $search }}"
                onchange="this.form.submit()"
            />
        </form>
        @if($search)
            <a href="{{ route('admin.products', ['category' => $filterCat]) }}" class="admin-search-clear" style="text-decoration:none; color:inherit;">×</a>
        @endif
    </div>

    <div class="admin-filter-tabs">
        <a href="{{ route('admin.products', ['search' => $search]) }}" class="admin-filter-tab {{ $filterCat === 'all' ? 'active' : '' }}">
            Tous <span class="admin-count-pill">{{ count($products) }}</span>
        </a>
        @foreach($categories as $c)
            @php $countCat = $products->where('category_id', $c->id)->count(); @endphp
            <a href="{{ route('admin.products', ['category' => $c->id, 'search' => $search]) }}" class="admin-filter-tab {{ $filterCat == $c->id ? 'active' : '' }}">
                {{ $c->name }} <span class="admin-count-pill">{{ $countCat }}</span>
            </a>
        @endforeach
    </div>

    @php
        // Basic filtering for view if not handled by backend entirely
        $filtered = $products;
        if($filterCat !== 'all') {
            $filtered = $filtered->where('category_id', $filterCat);
        }
        if($search) {
            $filtered = $filtered->filter(function($item) use ($search) {
                return stripos($item->name, $search) !== false;
            });
        }
    @endphp

    <!-- TABLE – DESKTOP -->
    <div class="glass-card" style="overflow: hidden; padding: 0;">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th><th>Produit</th><th>Prix</th><th>Stock</th>
                        <th>Visible</th><th>Vedette</th><th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filtered as $p)
                        <tr>
                            <td>
                                <div class="admin-product-thumb">
                                    @if($p->image_url)
                                        <img src="{{ $p->image_url }}" alt="{{ $p->name }}" />
                                    @else
                                        <span>🛍️</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 800;">{{ $p->name }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ $p->category->name ?? 'Sans Catégorie' }}</div>
                                @if($p->badge)
                                    <span style="display: inline-block; margin-top: 4px; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; background: {{ $p->badge_color }}22; color: {{ $p->badge_color }};">
                                        {{ $p->badge }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--primary-light);">{{ $p->price }} MAD</div>
                                @if($p->original_price)
                                    <div style="font-size: 11px; text-decoration: line-through; color: var(--text-muted);">{{ $p->original_price }} MAD</div>
                                @endif
                            </td>
                            <td>
                                <span style="font-size: 13px; font-weight: 600; color: {{ $p->stock < 10 ? 'var(--accent-red)' : 'var(--text-2)' }};">
                                    {{ $p->stock }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.products.toggle', $p->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="field" value="is_active">
                                    <button
                                        type="submit"
                                        class="admin-toggle-btn"
                                        style="background: {{ $p->is_active ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.1)' }}; color: {{ $p->is_active ? '#10B981' : '#EF4444' }}; border-color: {{ $p->is_active ? '#10B98144' : '#EF444444' }};"
                                    >
                                        {{ $p->is_active ? '✅ Publié' : '❌ Masqué' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.products.toggle', $p->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="field" value="is_featured">
                                    <button
                                        type="submit"
                                        class="admin-toggle-btn"
                                        style="background: {{ $p->is_featured ? 'rgba(245,158,11,0.15)' : 'transparent' }}; color: {{ $p->is_featured ? '#F59E0B' : 'var(--text-muted)' }}; border-color: {{ $p->is_featured ? '#F59E0B55' : 'var(--border)' }};"
                                    >
                                        {{ $p->is_featured ? '⭐ Vedette' : 'Standard' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: flex-end; flex-wrap: wrap;">
                                    <button class="btn btn-outline" style="padding: 5px 10px; font-size: 12px;" onclick="viewProduct({{ $p->toJson() }})">👁</button>
                                    <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-outline" style="padding: 5px 10px; font-size: 12px;">✏️</a>
                                    <button
                                        class="btn btn-outline"
                                        style="padding: 5px 10px; font-size: 12px; border-color: var(--accent-red); color: var(--accent-red);"
                                        onclick="confirmDelete({{ $p->id }}, '{{ addslashes($p->name) }}')"
                                    >🗑️</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="padding: 40px; text-align: center; color: var(--text-muted);">
                            {{ $search ? "Aucun résultat pour \"$search\"" : "Aucun produit trouvé." }}
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="admin-mobile-cards">
            @forelse($filtered as $p)
                <div class="glass-card admin-product-card-mobile" style="padding: 16px; margin-bottom: 12px;">
                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <div class="admin-product-thumb" style="width: 60px; height: 60px; flex-shrink: 0;">
                            @if($p->image_url)
                                <img src="{{ $p->image_url }}" alt="{{ $p->name }}" />
                            @else
                                <span>🛍️</span>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 800; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p->name }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">{{ $p->category->name ?? '' }}</div>
                            <div style="font-weight: 700; color: var(--primary-light); margin-top: 4px;">
                                {{ $p->price }} MAD
                                @if($p->original_price)
                                    <span style="font-size: 11px; text-decoration: line-through; color: var(--text-muted); margin-left: 6px;">{{ $p->original_price }} MAD</span>
                                @endif
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <form action="{{ route('admin.products.toggle', $p->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="field" value="is_active">
                                <button type="submit" class="admin-toggle-btn" style="font-size: 11px; padding: 4px 8px; background: {{ $p->is_active ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.1)' }}; color: {{ $p->is_active ? '#10B981' : '#EF4444' }}; border-color: {{ $p->is_active ? '#10B98144' : '#EF444444' }};">
                                    {{ $p->is_active ? '✅' : '❌' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.products.toggle', $p->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="field" value="is_featured">
                                <button type="submit" class="admin-toggle-btn" style="font-size: 11px; padding: 4px 8px; background: {{ $p->is_featured ? 'rgba(245,158,11,0.15)' : 'transparent' }}; color: {{ $p->is_featured ? '#F59E0B' : 'var(--text-muted)' }}; border-color: {{ $p->is_featured ? '#F59E0B55' : 'var(--border)' }};">
                                    {{ $p->is_featured ? '⭐' : '—' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <div style="display: flex; gap: 6px; margin-top: 12px; flex-wrap: wrap;">
                        <button class="btn btn-outline" style="padding: 5px 10px; font-size: 12px; flex: 1;" onclick="viewProduct({{ $p->toJson() }})">👁 Voir</button>
                        <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-outline" style="padding: 5px 10px; font-size: 12px; flex: 1; text-align: center;">✏️ Éditer</a>
                        <button class="btn btn-outline" style="padding: 5px 10px; font-size: 12px; border-color: var(--accent-red); color: var(--accent-red); flex: 1;" onclick="confirmDelete({{ $p->id }}, '{{ addslashes($p->name) }}')">🗑️</button>
                    </div>
                </div>
            @empty
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">
                    {{ $search ? "Aucun résultat pour \"$search\"" : "Aucun produit trouvé." }}
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- DELETE CONFIRM MODAL -->
<div class="admin-modal-backdrop" id="delete-modal" style="display: none;" onclick="closeModal('delete-modal')">
    <div class="glass-card fade-up-item" style="max-width: 400px; width: 90%; padding: 32px; text-align: center; margin: auto; margin-top: 15vh;" onclick="event.stopPropagation()">
        <div style="font-size: 48px; margin-bottom: 16px;">🗑️</div>
        <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">Supprimer « <span id="del-pname"></span> » ?</h3>
        <p style="color: var(--text-muted); margin-bottom: 24px; font-size: 13px;">Cette action est irréversible.</p>
        
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

<!-- VIEW PRODUCT MODAL -->
<div class="admin-modal-backdrop" id="view-modal" style="display: none;" onclick="closeModal('view-modal')">
    <div class="glass-card admin-modal-card fade-up-item" style="max-width: 560px; margin: auto; margin-top: 10vh;" onclick="event.stopPropagation()">
        <div class="admin-modal-header">
            <h2 class="admin-modal-title">Détail Produit</h2>
            <button class="admin-modal-close" onclick="closeModal('view-modal')">×</button>
        </div>
        <div id="view-product-content" style="padding: 0 24px;">
            <!-- Rendered by JS -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function confirmDelete(id, name) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/produits/${id}`;
        document.getElementById('del-pname').innerText = name;
        document.getElementById('delete-modal').style.display = 'block';
    }

    function viewProduct(p) {
        const content = document.getElementById('view-product-content');
        let html = '';
        
        if(p.image_url) {
            html += `<img src="${p.image_url}" alt="${p.name}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 16px;">`;
        }
        
        let badgeHtml = '';
        if(p.badge) {
            badgeHtml = `<span style="padding: 4px 12px; border-radius: 14px; font-size: 12px; font-weight: 700; background: ${p.badge_color}22; color: ${p.badge_color}; flex-shrink: 0;">${p.badge}</span>`;
        }

        let origPrice = '';
        let discount = '';
        if(p.original_price && p.original_price > p.price) {
            origPrice = `<span style="text-decoration: line-through; color: var(--text-muted);">${p.original_price} MAD</span>`;
            const pct = Math.round((1 - (p.price / p.original_price)) * 100);
            discount = `<span style="background: rgba(239,68,68,0.1); color: #EF4444; padding: 2px 8px; border-radius: 10px; font-size: 12px; font-weight: 700;">-${pct}%</span>`;
        }

        let featsHtml = '';
        if(p.features) {
            const lines = p.features.split('\n').filter(l => l.trim().length > 0);
            if(lines.length > 0) {
                let tags = lines.map(f => `<span style="background: var(--bg-main); padding: 4px 12px; border-radius: 20px; font-size: 12px; border: 1px solid var(--border);">${f}</span>`).join('');
                featsHtml = `
                    <div style="margin-top: 16px;">
                        <div style="font-weight: 700; margin-bottom: 8px;">✅ Fonctionnalités</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 6px;">${tags}</div>
                    </div>
                `;
            }
        }

        const catName = p.category ? p.category.name : 'Sans catégorie';

        html += `
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 900; margin-bottom: 6px;">${p.name}</h3>
                    <div style="font-size: 13px; color: var(--text-muted);">${catName}</div>
                </div>
                ${badgeHtml}
            </div>
            <div style="margin: 12px 0; display: flex; gap: 12px; align-items: center;">
                <span style="font-size: 22px; font-weight: 900; color: var(--primary);">${p.price} MAD</span>
                ${origPrice}
                ${discount}
            </div>
            <p style="color: var(--text-2); line-height: 1.6; margin-bottom: 12px; white-space: pre-wrap;">${p.description}</p>
            ${featsHtml}
            <div style="margin-top: 16px; font-size: 13px; color: var(--text-muted); display: flex; gap: 16px;">
                <span>Stock : <strong style="color: var(--text);">${p.stock}</strong></span>
                <span>Actif : <strong style="color: ${p.is_active ? '#10B981' : '#EF4444'}">${p.is_active ? 'Oui' : 'Non'}</strong></span>
                <span>Vedette : <strong style="color: ${p.is_featured ? '#F59E0B' : 'var(--text)'}">${p.is_featured ? 'Oui' : 'Non'}</strong></span>
            </div>
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <a href="/admin/produits/${p.id}/edit" class="btn btn-primary" style="flex: 1; text-align: center;">✏️ Modifier</a>
                <button class="btn btn-outline" style="flex: 1;" onclick="closeModal('view-modal')">Fermer</button>
            </div>
        `;

        content.innerHTML = html;
        document.getElementById('view-modal').style.display = 'block';
    }
</script>
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

@media (max-width: 767px) {
    .admin-table-wrap { display: none; }
    .admin-mobile-cards { display: block; }
}
@media (min-width: 768px) {
    .admin-table-wrap { display: block; }
    .admin-mobile-cards { display: none; }
}
</style>
@endpush
