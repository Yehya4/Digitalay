@extends('layouts.admin')

@section('title', 'Détails Commande #' . $order->id)

@section('content')
<div class="fade-up-item">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">Détails Commande #{{ $order->id }}</h1>
            <p class="admin-sub">Consultation et gestion de la commande client.</p>
        </div>
        <a href="{{ route('admin.orders') }}" class="btn btn-outline">← Retour à la liste</a>
    </div>

    <div class="glass-card" style="padding: 0; overflow: hidden;">
        <!-- INFO GRID -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1px; background: var(--border);">
            
            <!-- LEFT: DETAILS -->
            <div style="background: var(--bg-card); padding: 32px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
                    <div>
                        <div style="font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">👤 Informations Client</div>
                        <h2 style="font-size: 24px; font-weight: 900; margin-bottom: 4px;">{{ $order->customer_name }}</h2>
                        <div style="color: var(--text-2); display: flex; align-items: center; gap: 8px;">
                            <span>📞 {{ $order->customer_phone }}</span>
                            @if($order->customer_email)
                                <span style="color: var(--border);">|</span>
                                <span>✉️ {{ $order->customer_email }}</span>
                            @endif
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">📅 Date de commande</div>
                        <div style="font-weight: 700;">{{ $order->created_at->format('d/m/Y') }}</div>
                        <div style="font-size: 13px; color: var(--text-muted);">{{ $order->created_at->format('H:i:s') }}</div>
                    </div>
                </div>

                <div style="margin-bottom: 32px;">
                    <div style="font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">📝 Note du client</div>
                    <div style="padding: 16px; background: var(--bg-main); border-radius: var(--r); border: 1px dashed var(--border); color: var(--text-2); line-height: 1.6;">
                        {{ $order->note ?: 'Aucune note particulière.' }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">🛍️ Produits ({!! count($order->items) !!})</div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($order->items as $item)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: var(--bg-main); border-radius: var(--r); border: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div style="width: 48px; height: 48px; border-radius: 8px; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid var(--border); overflow: hidden;">
                                    @if($item->product && $item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" style="width: 100%; height: 100%; object-fit: cover;" />
                                    @else
                                        📦
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 700;">{{ $item->product ? $item->product->name : 'Produit inconnu' }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">Prix unitaire: {{ $item->unit_price }} MAD</div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; color: var(--primary-light);">{{ $item->quantity }} ×</div>
                                <div style="font-weight: 900;">{{ $item->unit_price * $item->quantity }} MAD</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- RIGHT: SUMMARY & ACTIONS -->
            <div style="background: var(--bg-main); padding: 32px; display: flex; flex-direction: column; gap: 24px;">
                
                <div>
                    <div style="font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">📊 Statut Actuel</div>
                    @php
                        $statusColors = [
                            'pending' => ['color' => '#F59E0B', 'bg' => 'rgba(245,158,11,0.1)'],
                            'processing' => ['color' => '#38BDF8', 'bg' => 'rgba(56,189,248,0.1)'],
                            'confirmed' => ['color' => '#818CF8', 'bg' => 'rgba(129,140,248,0.1)'],
                            'delivered' => ['color' => '#10B981', 'bg' => 'rgba(16,185,129,0.1)'],
                            'cancelled' => ['color' => '#EF4444', 'bg' => 'rgba(239,68,68,0.1)'],
                        ];
                        $st = $statusColors[$order->status] ?? $statusColors['pending'];
                    @endphp
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="admin-status-select" 
                                style="width: 100%; height: 48px; font-size: 15px; font-weight: 700; color: {{ $st['color'] }}; border-color: {{ $st['color'] }}44; background: {{ $st['bg'] }};">
                            @foreach($statusColors as $key => $val)
                                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                    {{ ucfirst($key) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div style="padding: 24px; background: var(--bg-card); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <div style="font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">💳 Paiement</div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                        <div style="font-size: 24px;">{{ $order->payment_method === 'bank_transfer' ? '🏦' : '💬' }}</div>
                        <div>
                            <div style="font-weight: 700;">{{ $order->payment_method === 'bank_transfer' ? 'Virement bancaire' : 'WhatsApp' }}</div>
                            <div style="font-size: 12px; color: var(--text-2);">Méthode choisie</div>
                        </div>
                    </div>
                    <div style="border-top: 1px solid var(--border); padding-top: 16px; display: flex; justify-content: space-between; align-items: flex-end;">
                        <span style="font-weight: 700;">Total</span>
                        <span style="font-size: 24px; font-weight: 900; color: var(--primary);">{{ $order->total_amount }} MAD</span>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px; margin-top: auto;">
                    @if($order->customer_phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}?text=Bonjour {{ $order->customer_name }}, concernant votre commande #{{ $order->id }}..." 
                       target="_blank" class="btn btn-whatsapp" style="width: 100%; justify-content: center; height: 44px;">
                        Contacter via WhatsApp
                    </a>
                    @endif
                    
                    <button onclick="document.getElementById('delete-form-{{ $order->id }}').submit()" 
                            class="btn btn-outline" style="width: 100%; border-color: var(--accent-red); color: var(--accent-red); justify-content: center; height: 44px;">
                        Supprimer la commande
                    </button>
                    <form id="delete-form-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.fade-up-item { opacity: 0; transform: translateY(20px); animation: fadeUpAnim 0.3s ease-out forwards; }
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
