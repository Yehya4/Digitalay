@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="fade-up-item">
    <!-- PAGE HEADER -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">Tableau de bord</h1>
            <p class="admin-sub">Bienvenue sur votre espace administration Digitalay.</p>
        </div>
        <div class="admin-quick-actions">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="font-size: 13px; padding: 10px 18px;">
                + Nouveau Produit
            </a>
            <a href="{{ route('admin.orders') }}" class="btn btn-outline" style="font-size: 13px; padding: 10px 18px;">
                Voir Commandes
            </a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="admin-stats-grid">
        <div class="glass-card admin-stat-card fade-up-item" style="border-top: 4px solid #10B981; animation-delay: 0.1s;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="admin-stat-label">Chiffre d'Affaires</div>
                    <div class="admin-stat-value" style="color: #10B981;">{{ number_format($stats['total_revenue'], 2) }} MAD</div>
                    <div class="admin-stat-sub">Commandes livrées + confirmées</div>
                </div>
                <div class="admin-stat-icon" style="background: rgba(16,185,129,0.13);">💰</div>
            </div>
        </div>

        <div class="glass-card admin-stat-card fade-up-item" style="border-top: 4px solid #38BDF8; animation-delay: 0.15s;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="admin-stat-label">Commandes Aujourd'hui</div>
                    <div class="admin-stat-value" style="color: #38BDF8;">{{ $stats['today_orders'] }}</div>
                    <div class="admin-stat-sub">{{ $stats['total_orders'] }} commandes totales</div>
                </div>
                <div class="admin-stat-icon" style="background: rgba(56,189,248,0.13);">📈</div>
            </div>
        </div>

        <div class="glass-card admin-stat-card fade-up-item" style="border-top: 4px solid #F59E0B; animation-delay: 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="admin-stat-label">En Attente</div>
                    <div class="admin-stat-value" style="color: #F59E0B;">{{ $stats['pending_orders'] }}</div>
                    <div class="admin-stat-sub">Requièrent votre attention</div>
                </div>
                <div class="admin-stat-icon" style="background: rgba(245,158,11,0.13);">⏳</div>
            </div>
        </div>

        <div class="glass-card admin-stat-card fade-up-item" style="border-top: 4px solid #7C3AED; animation-delay: 0.25s;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="admin-stat-label">Produits Actifs</div>
                    <div class="admin-stat-value" style="color: #7C3AED;">{{ $stats['total_products'] }}</div>
                    <div class="admin-stat-sub">Dans le catalogue</div>
                </div>
                <div class="admin-stat-icon" style="background: rgba(124,58,237,0.13);">🛍️</div>
            </div>
        </div>
    </div>

    <!-- RECENT ORDERS -->
    <div class="glass-card fade-up-item" style="padding: 24px; margin-top: 24px; animation-delay: 0.3s;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: 800;">Dernières Commandes</h2>
            <a href="{{ route('admin.orders') }}" style="font-size: 13px; color: var(--primary-light); font-weight: 600;">
                Voir tout →
            </a>
        </div>

        @php
            $statusColors = [
                'pending' => ['bg' => 'rgba(245,158,11,0.12)', 'text' => '#F59E0B', 'label' => 'En attente'],
                'processing' => ['bg' => 'rgba(56,189,248,0.12)', 'text' => '#38BDF8', 'label' => 'En traitement'],
                'confirmed' => ['bg' => 'rgba(99,102,241,0.12)', 'text' => '#818CF8', 'label' => 'Confirmée'],
                'delivered' => ['bg' => 'rgba(16,185,129,0.12)', 'text' => '#10B981', 'label' => 'Livrée'],
                'cancelled' => ['bg' => 'rgba(239,68,68,0.12)', 'text' => '#EF4444', 'label' => 'Annulée'],
            ];
        @endphp

        <!-- TABLE – desktop -->
        <div class="admin-table-wrap" style="display: none;">
            <!-- Desktop mode hidden on very small screens handled by css, simplified here -->
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>N°</th><th>Client</th><th>Date</th><th>Total</th><th>Méthode</th><th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_orders as $order)
                        @php $st = $statusColors[$order->status] ?? $statusColors['pending']; @endphp
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>
                                <div style="font-weight: 600;">{{ $order->customer_name }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ $order->customer_email ?: $order->customer_phone }}</div>
                            </td>
                            <td style="color: var(--text-2); font-size: 13px;">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td><strong style="color: var(--primary-light);">{{ $order->total_amount }} MAD</strong></td>
                            <td style="font-size: 13px;">{{ $order->payment_method === 'bank_transfer' ? '🏦 Virement' : '💬 WhatsApp' }}</td>
                            <td>
                                <span class="admin-status-badge" style="background: {{ $st['bg'] }}; color: {{ $st['text'] }};">
                                    {{ $st['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 30px; text-align: center; color: var(--text-muted);">
                                Aucune commande récente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="admin-mobile-cards" style="display: block;">
            @forelse($recent_orders as $order)
                @php $st = $statusColors[$order->status] ?? $statusColors['pending']; @endphp
                <div class="admin-order-card-mobile" style="background: var(--bg-card); border: 1px solid var(--border); padding: 12px; border-radius: var(--r); margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <strong>#{{ $order->id }} – {{ $order->customer_name }}</strong>
                        <span class="admin-status-badge" style="background: {{ $st['bg'] }}; color: {{ $st['text'] }}; padding: 4px 8px; font-size: 11px; border-radius: 20px; font-weight: 700;">
                            {{ $st['label'] }}
                        </span>
                    </div>
                    <div style="margin-top: 8px; color: var(--primary-light); font-weight: 700;">
                        {{ $order->total_amount }} MAD
                    </div>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                        {{ $order->created_at->format('d/m/Y') }} • 
                        {{ $order->payment_method === 'bank_transfer' ? '🏦 Virement' : '💬 WhatsApp' }}
                    </div>
                </div>
            @empty
                <div style="padding: 30px; text-align: center; color: var(--text-muted);">
                    Aucune commande récente.
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.fade-up-item { opacity: 0; transform: translateY(20px); animation: fadeUpAnim 0.4s ease-out forwards; }
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

/* Quick responsive fix for the table display */
@media (min-width: 768px) {
    .admin-table-wrap { display: block !important; }
    .admin-mobile-cards { display: none !important; }
}
</style>
@endsection
