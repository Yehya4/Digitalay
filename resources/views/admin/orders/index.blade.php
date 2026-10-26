@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
@php
    $statusOptions = [
        ['value' => 'pending', 'label' => 'En attente', 'color' => '#F59E0B', 'bg' => 'rgba(245,158,11,0.12)'],
        ['value' => 'processing', 'label' => 'En traitement', 'color' => '#38BDF8', 'bg' => 'rgba(56,189,248,0.12)'],
        ['value' => 'confirmed', 'label' => 'Confirmée', 'color' => '#818CF8', 'bg' => 'rgba(99,102,241,0.12)'],
        ['value' => 'delivered', 'label' => 'Livrée', 'color' => '#10B981', 'bg' => 'rgba(16,185,129,0.12)'],
        ['value' => 'cancelled', 'label' => 'Annulée', 'color' => '#EF4444', 'bg' => 'rgba(239,68,68,0.12)'],
    ];

    $filterStatus = request('status', 'all');
    $search = request('search', '');
@endphp

<div class="fade-up-item">
    <!-- HEADER -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">Commandes</h1>
            <p class="admin-sub">Gérez et traitez les commandes clients.</p>
        </div>
        <div class="admin-badge-count">{{ count($orders) }} commandes</div>
    </div>

    <!-- SEARCH -->
    <div class="admin-search-bar">
        <span class="admin-search-icon">🔍</span>
        <form action="{{ route('admin.orders') }}" method="GET" style="flex: 1; display: flex;">
            <input type="hidden" name="status" value="{{ $filterStatus }}">
            <input
                type="text"
                name="search"
                class="admin-search-input"
                placeholder="Rechercher par nom, email, téléphone, N°..."
                value="{{ $search }}"
                onchange="this.form.submit()"
            />
        </form>
        @if($search)
            <a href="{{ route('admin.orders', ['status' => $filterStatus]) }}" class="admin-search-clear" style="text-decoration:none; color:inherit;">×</a>
        @endif
    </div>

    <!-- FILTER TABS -->
    <div class="admin-filter-tabs">
        <a href="{{ route('admin.orders', ['search' => $search]) }}" class="admin-filter-tab {{ $filterStatus === 'all' ? 'active' : '' }}">
            Toutes <span class="admin-count-pill">{{ count($orders) }}</span> <!-- Simplification: using global count here, proper implementation needs aggregated count query -->
        </a>
        @foreach($statusOptions as $st)
            <a href="{{ route('admin.orders', ['status' => $st['value'], 'search' => $search]) }}" 
               class="admin-filter-tab {{ $filterStatus === $st['value'] ? 'active' : '' }}"
               style="{{ $filterStatus === $st['value'] ? 'color: '.$st['color'].'; border-color: '.$st['color'].';' : '' }}">
                {{ $st['label'] }}
            </a>
        @endforeach
    </div>

    <!-- TABLE – DESKTOP -->
    <div class="glass-card" style="padding: 0; overflow: hidden;">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>N°</th><th>Client</th><th>Date</th><th>Total</th><th>Paiement</th><th>Statut</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                        @php
                            $st = collect($statusOptions)->firstWhere('value', $o->status) ?? $statusOptions[0];
                        @endphp
                        <tr>
                            <td><strong>#{{ $o->id }}</strong></td>
                            <td>
                                <div style="font-weight: 600;">{{ $o->customer_name }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ $o->customer_email ?: $o->customer_phone }}</div>
                            </td>
                            <td style="font-size: 13px; color: var(--text-2);">
                                {{ $o->created_at->format('d/m/Y') }}
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $o->created_at->format('H:i') }}</div>
                            </td>
                            <td><strong style="color: var(--primary-light);">{{ $o->total_amount }} MAD</strong></td>
                            <td style="font-size: 13px;">{{ $o->payment_method === 'bank_transfer' ? '🏦 Virement' : '💬 WhatsApp' }}</td>
                            <td>
                                <form action="{{ route('admin.orders.status', $o->id) }}" method="POST" class="status-form">
                                    @csrf
                                    @method('PATCH')
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="admin-status-select"
                                        style="color: {{ $st['color'] }}; border-color: {{ $st['color'] }}66; background: {{ $st['bg'] }};"
                                    >
                                        @foreach($statusOptions as $s)
                                            <option value="{{ $s['value'] }}" {{ $o->status === $s['value'] ? 'selected' : '' }}>{{ $s['label'] }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: flex-end; flex-wrap: wrap;">
                                    <button class="btn btn-outline" style="font-size: 12px; padding: 5px 12px;" onclick="openDetailModal({{ $o->toJson() }})">
                                        👁 Détails
                                    </button>
                                    <button
                                        class="btn btn-outline"
                                        style="font-size: 12px; padding: 5px 10px; border-color: var(--accent-red); color: var(--accent-red);"
                                        onclick="confirmDelete({{ $o->id }})"
                                    >🗑</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="padding: 40px; text-align: center; color: var(--text-muted);">
                            {{ $search ? 'Aucun résultat pour "'.$search.'"' : 'Aucune commande.' }}
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="admin-mobile-cards">
            @foreach($orders as $o)
                @php $st = collect($statusOptions)->firstWhere('value', $o->status) ?? $statusOptions[0]; @endphp
                <div class="glass-card admin-order-card-mobile" style="padding: 16px; margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <div style="font-weight: 800; font-size: 15px;">#{{ $o->id }} – {{ $o->customer_name }}</div>
                            <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">{{ $o->customer_phone }}</div>
                        </div>
                        <span class="admin-status-badge" style="background: {{ $st['bg'] }}; color: {{ $st['color'] }}; padding: 4px 8px; border-radius: 20px; font-weight: 700; font-size: 11px;">
                            {{ $st['label'] }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <div>
                            <div style="font-weight: 700; color: var(--primary-light); font-size: 16px;">{{ $o->total_amount }} MAD</div>
                            <div style="font-size: 12px; color: var(--text-muted);">{{ $o->created_at->format('d/m/Y') }} • {{ $o->payment_method === 'bank_transfer' ? '🏦 Virement' : '💬 WhatsApp' }}</div>
                        </div>
                        <div style="display: flex; gap: 6px;">
                            <button class="btn btn-outline" style="font-size: 12px; padding: 5px 12px;" onclick="openDetailModal({{ $o->toJson() }})">Détails</button>
                            <button class="btn btn-outline" style="font-size: 12px; padding: 5px 10px; border-color: var(--accent-red); color: var(--accent-red);" onclick="confirmDelete({{ $o->id }})">🗑</button>
                        </div>
                    </div>
                    <form action="{{ route('admin.orders.status', $o->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="admin-status-select"
                            style="width: 100%; color: {{ $st['color'] }}; border-color: {{ $st['color'] }}66; background: {{ $st['bg'] }};"
                        >
                            @foreach($statusOptions as $s)
                                <option value="{{ $s['value'] }}" {{ $o->status === $s['value'] ? 'selected' : '' }}>{{ $s['label'] }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ORDER DETAIL MODAL -->
<div class="admin-modal-backdrop" id="detail-modal" style="display: none;" onclick="closeModal('detail-modal')">
    <div class="glass-card admin-modal-card fade-up-item" onclick="event.stopPropagation()">
        <div class="admin-modal-header">
            <h2 class="admin-modal-title" id="modal-order-title">Commande</h2>
            <button class="admin-modal-close" onclick="closeModal('detail-modal')">×</button>
        </div>
        <div id="modal-content">
            <!-- Populated via JS -->
        </div>
    </div>
</div>

<!-- DELETE CONFIRM MODAL -->
<div class="admin-modal-backdrop" id="delete-modal" style="display: none;" onclick="closeModal('delete-modal')">
    <div class="glass-card fade-up-item" style="max-width: 400px; width: 90%; padding: 32px; text-align: center; margin: auto; margin-top: 15vh;" onclick="event.stopPropagation()">
        <div style="font-size: 48px; margin-bottom: 16px;">⚠️</div>
        <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 12px;">Supprimer la commande ?</h3>
        <p style="color: var(--text-muted); margin-bottom: 24px;">Cette action est irréversible.</p>
        
        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closeModal('delete-modal')" class="btn btn-outline" style="flex: 1;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="flex: 1; background: var(--accent-red); border: none;">
                    Supprimer
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const statusColorMap = {
        pending: '#F59E0B',
        processing: '#38BDF8',
        confirmed: '#818CF8',
        delivered: '#10B981',
        cancelled: '#EF4444'
    };
    
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function confirmDelete(id) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/commandes/${id}`;
        document.getElementById('delete-modal').style.display = 'block';
    }

    function openDetailModal(order) {
        document.getElementById('modal-order-title').innerText = `Commande #${order.id}`;
        
        // Use proper date formatting
        const date = new Date(order.created_at).toLocaleString('fr-FR');
        const payment = order.payment_method === 'bank_transfer' ? '🏦 Virement' : '💬 WhatsApp';
        
        let itemsHtml = '';
        if(order.items && order.items.length > 0) {
            order.items.forEach(item => {
                const prodName = item.product ? item.product.name : 'Produit inconnu';
                itemsHtml += `
                    <div class="admin-order-item" style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                        <div>
                            <span style="font-weight: 700; color: var(--primary-light);">${item.quantity}×</span>&nbsp;
                            <span style="font-weight: 600;">${prodName}</span>
                        </div>
                        <div style="font-weight: 700;">${item.unit_price * item.quantity} MAD</div>
                    </div>
                `;
            });
        }

        const phoneBtn = order.customer_phone ? 
            `<a href="https://wa.me/${order.customer_phone.replace(/[^0-9]/g, '')}?text=Bonjour ${order.customer_name}, concernant votre commande #${order.id}..." 
                target="_blank" rel="noreferrer" class="btn btn-outline" 
                style="margin-top: 10px; font-size: 12px; padding: 6px 12px; display: inline-flex; align-items: center; gap: 6px; border-color: #25D366; color: #25D366;">
                💬 Contacter via WhatsApp
            </a>` : '';

        // Note formatting
        const noteHtml = order.note 
            ? `<div style="color: var(--text); line-height: 1.6;">${order.note}</div>` 
            : `<div style="color: var(--text-muted); font-style: italic; line-height: 1.6;">Aucune note.</div>`;

        // Render content
        document.getElementById('modal-content').innerHTML = `
            <!-- CLIENT INFO -->
            <div class="admin-detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; padding: 20px; background: var(--bg-card); border-radius: var(--r);">
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">👤 Client</div>
                    <div style="font-weight: 700; font-size: 15px; margin-top: 6px;">${order.customer_name}</div>
                    <div style="color: var(--text-2); margin-top: 4px;">📞 ${order.customer_phone}</div>
                    ${order.customer_email ? `<div style="color: var(--text-2);">✉️ ${order.customer_email}</div>` : ''}
                    ${phoneBtn}
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">📝 Note du client</div>
                    <div style="margin-top: 6px;">${noteHtml}</div>
                    
                    <div style="margin-top: 16px; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">📅 Date & Paiement</div>
                    <div style="margin-top: 4px;">${date}</div>
                    <div style="margin-top: 2px;">${payment}</div>
                </div>
            </div>

            <!-- PRODUCTS -->
            <div style="padding: 0 20px;">
                <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">🛍️ Produits commandés</div>
                <div style="display: flex; flex-direction: column;">
                    ${itemsHtml}
                </div>
            </div>

            <!-- TOTAL -->
            <div class="admin-total-row" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; margin-top: 20px; background: var(--bg-main); border-radius: var(--r);">
                <span style="font-size: 16px; font-weight: 800;">Total Général</span>
                <span style="font-size: 24px; font-weight: 900; color: var(--primary);">${order.total_amount} MAD</span>
            </div>

            <!-- DELETE BTN -->
            <button onclick="confirmDelete(${order.id}); closeModal('detail-modal')" class="btn btn-outline" style="margin-top: 20px; width: 100%; border-color: var(--accent-red); color: var(--accent-red);">
                🗑️ Supprimer cette commande
            </button>
        `;

        document.getElementById('detail-modal').style.display = 'block';
    }
</script>
<style>
.fade-up-item { opacity: 0; transform: translateY(20px); animation: fadeUpAnim 0.3s ease-out forwards; }
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

.admin-modal-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000;
    backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center;
}
.admin-modal-card {
    width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;
    background: var(--bg-card); border-radius: var(--r-lg); border: 1px solid var(--border);
    padding-bottom: 24px;
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
    .admin-detail-grid { grid-template-columns: 1fr !important; }
}
@media (min-width: 768px) {
    .admin-table-wrap { display: block; }
    .admin-mobile-cards { display: none; }
}
</style>
@endpush
