@extends('layouts.admin')

@section('title', 'Messages Clients')

@section('content')
<div class="fade-up-item">
    <!-- HEADER -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">Messages Clients</h1>
            <p class="admin-sub">Formulaire de contact et demandes d'assistance.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            @php $unreadCount = $messages->where('is_read', false)->count(); @endphp
            @if($unreadCount > 0)
                <form action="{{ route('admin.messages.mark-all-read') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline" style="font-size: 13px; padding: 8px 16px;">
                        ✓ Tout marquer lu ({{ $unreadCount }})
                    </button>
                </form>
            @endif
            <div class="admin-badge-count">{{ $messages->count() }} messages</div>
        </div>
    </div>

    @php
        $search = request('search', '');
        $filterTab = request('filter', 'all');
    @endphp

    <!-- SEARCH -->
    <div class="admin-search-bar">
        <span class="admin-search-icon">🔍</span>
        <form action="{{ route('admin.messages') }}" method="GET" style="flex: 1; display: flex;">
            <input type="hidden" name="filter" value="{{ $filterTab }}">
            <input
                type="text"
                name="search"
                class="admin-search-input"
                placeholder="Rechercher par nom, sujet, email..."
                value="{{ $search }}"
                onchange="this.form.submit()"
            />
        </form>
        @if($search)
            <a href="{{ route('admin.messages', ['filter' => $filterTab]) }}" class="admin-search-clear" style="text-decoration:none; color:inherit;">×</a>
        @endif
    </div>

    <!-- TABS -->
    <div class="admin-filter-tabs">
        <a href="{{ route('admin.messages', ['search' => $search, 'filter' => 'all']) }}" class="admin-filter-tab {{ $filterTab === 'all' ? 'active' : '' }}">
            Tous <span class="admin-count-pill">{{ $messages->count() }}</span>
        </a>
        <a href="{{ route('admin.messages', ['search' => $search, 'filter' => 'unread']) }}" class="admin-filter-tab {{ $filterTab === 'unread' ? 'active' : '' }}" style="{{ $filterTab === 'unread' ? 'color: var(--accent-red); border-color: var(--accent-red);' : '' }}">
            Non lus @if($unreadCount > 0) <span class="admin-count-pill" style="{{ $filterTab === 'unread' ? 'background: rgba(239,68,68,0.12); color: var(--accent-red);' : 'background: var(--accent-red); color: white;' }}">{{ $unreadCount }}</span> @endif
        </a>
        <a href="{{ route('admin.messages', ['search' => $search, 'filter' => 'read']) }}" class="admin-filter-tab {{ $filterTab === 'read' ? 'active' : '' }}">
            Lus <span class="admin-count-pill">{{ $messages->count() - $unreadCount }}</span>
        </a>
    </div>

    @php
        $filtered = $messages;
        if($filterTab === 'unread') {
            $filtered = $filtered->where('is_read', false);
        } elseif($filterTab === 'read') {
            $filtered = $filtered->where('is_read', true);
        }
        if($search) {
            $filtered = $filtered->filter(function($m) use ($search) {
                return stripos($m->name, $search) !== false || 
                       stripos($m->subject, $search) !== false || 
                       stripos($m->email, $search) !== false;
            });
        }
    @endphp

    <!-- MESSAGES LIST -->
    <div style="display: flex; flex-direction: column; gap: 12px;">
        @forelse($filtered as $m)
            <div class="glass-card admin-msg-card" style="border-left: {{ $m->is_read ? 'none' : '4px solid var(--accent-red)' }}; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.005)'" onmouseout="this.style.transform='scale(1)'" onclick="openMessageModal({{ $m->toJson() }})">
                <div class="admin-msg-header">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <h3 class="admin-msg-subject">{{ $m->subject }}</h3>
                            @if(!$m->is_read)
                                <span class="admin-badge-new" style="background: var(--accent-red); color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase;">Nouveau</span>
                            @endif
                        </div>
                        <div class="admin-msg-meta">
                            De <strong style="color: var(--text);">{{ $m->name }}</strong> ({{ $m->email }}) · {{ $m->created_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                    <div class="admin-msg-actions" onclick="event.stopPropagation()">
                        <form action="{{ route('admin.messages.toggle-read', $m->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline" style="font-size: 11px; padding: 4px 10px; border-color: {{ $m->is_read ? 'var(--border)' : 'var(--primary-light)' }}; color: {{ $m->is_read ? 'var(--text-muted)' : 'var(--primary)' }};">
                                {{ $m->is_read ? '⬤ Marquer non-lu' : '✓ Marquer lu' }}
                            </button>
                        </form>
                        <button onclick="confirmDelete({{ $m->id }})" class="btn btn-outline" style="font-size: 11px; padding: 4px 10px; border-color: var(--accent-red); color: var(--accent-red);">
                            🗑
                        </button>
                    </div>
                </div>
                <div class="admin-msg-preview" style="color: var(--text-2); font-size: 14px; margin-top: 10px;">
                    {{ Str::limit($m->message, 120) }}
                </div>
            </div>
        @empty
            <div class="empty">
                <div class="empty-icon">✉️</div>
                <div class="empty-title">{{ $search ? "Aucun résultat pour \"$search\"" : "Aucun message" }}</div>
            </div>
        @endforelse
    </div>
</div>

<!-- MESSAGE DETAIL MODAL -->
<div class="admin-modal-backdrop" id="msg-modal" style="display: none;" onclick="closeModal('msg-modal')">
    <div class="glass-card admin-modal-card fade-up-item" style="max-width: 600px; margin: auto; margin-top: 5vh; width: 90%; max-height: 85vh; overflow-y: auto;" onclick="event.stopPropagation()">
        <div class="admin-modal-header" style="border-bottom: 1px solid var(--border); padding: 20px; display: flex; justify-content: space-between; align-items: flex-start;">
            <h2 class="admin-modal-title" id="modal-subject" style="font-size: 18px; font-weight: 800; margin: 0; padding-right: 20px;">Sujet</h2>
            <button class="admin-modal-close" onclick="closeModal('msg-modal')" style="background: none; border: none; font-size: 24px; color: var(--text-muted); cursor: pointer; line-height: 1;">×</button>
        </div>

        <div style="padding: 20px;">
            <div class="admin-detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--border);">
                <div class="admin-detail-section">
                    <div class="admin-detail-label" style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">👤 Expéditeur</div>
                    <div style="font-weight: 700; font-size: 15px;" id="modal-sender-name">Nom</div>
                    <div style="color: var(--text-2); font-size: 14px; margin-top: 4px;">✉️ <span id="modal-sender-email">Email</span></div>
                </div>
                <div class="admin-detail-section">
                    <div class="admin-detail-label" style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">📅 Date d'envoi</div>
                    <div style="font-size: 14px;" id="modal-date">Date</div>
                    
                    <div class="admin-detail-label" style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-top: 10px; margin-bottom: 4px;">Statut</div>
                    <div style="font-size: 14px; font-weight: bold;" id="modal-status">✅ Lu</div>
                </div>
            </div>

            <div class="admin-detail-section">
                <div class="admin-detail-label" style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 10px;">💬 Message</div>
                <div id="modal-body" style="background: var(--bg-main); border-radius: 10px; padding: 16px; line-height: 1.7; white-space: pre-wrap; color: var(--text); border: 1px solid var(--border); font-size: 15px;">
                    Message content
                </div>
            </div>

            <div style="margin-top: 24px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a id="modal-reply-btn" href="#" class="btn btn-primary" style="font-size: 13px; flex: 1; min-width: 140px; text-align: center;">
                    ✉️ Répondre par Email
                </a>
                
                <form id="modal-toggle-form" action="" method="POST" style="flex: 1; min-width: 140px; display: flex;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" id="modal-toggle-btn" class="btn btn-outline" style="font-size: 13px; width: 100%;">
                        ✓ Marquer lu
                    </button>
                </form>

                <button onclick="confirmDeleteFromModal()" class="btn btn-outline" style="font-size: 13px; border-color: var(--accent-red); color: var(--accent-red);">
                    🗑️ Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE CONFIRM -->
<div class="admin-modal-backdrop" id="delete-modal" style="display: none;" onclick="closeModal('delete-modal')">
    <div class="glass-card fade-up-item" style="max-width: 380px; width: 90%; padding: 28px; text-align: center; margin: auto; margin-top: 15vh;" onclick="event.stopPropagation()">
        <div style="font-size: 40px; margin-bottom: 12px;">🗑️</div>
        <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 10px;">Supprimer ce message ?</h3>
        <p style="color: var(--text-muted); margin-bottom: 20px; font-size: 14px;">Cette action est irréversible.</p>
        
        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 10px;">
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
    backdrop-filter: blur(4px); display: flex; align-items: flex-start; justify-content: center;
}
</style>

@push('scripts')
<script>
    let currentMsgId = null;

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function confirmDelete(id) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/messages/${id}`;
        document.getElementById('delete-modal').style.display = 'flex';
    }
    
    function confirmDeleteFromModal() {
        closeModal('msg-modal');
        if(currentMsgId) confirmDelete(currentMsgId);
    }

    function openMessageModal(m) {
        currentMsgId = m.id;
        
        document.getElementById('modal-subject').innerText = m.subject;
        document.getElementById('modal-sender-name').innerText = m.name;
        document.getElementById('modal-sender-email').innerText = m.email;
        
        const date = new Date(m.created_at);
        document.getElementById('modal-date').innerText = date.toLocaleString('fr-FR');
        
        const statusEl = document.getElementById('modal-status');
        const toggleBtn = document.getElementById('modal-toggle-btn');
        const toggleForm = document.getElementById('modal-toggle-form');
        
        if (m.is_read) {
            statusEl.innerText = '✅ Lu';
            statusEl.style.color = '#10B981';
            toggleBtn.innerText = '⬤ Marquer non-lu';
        } else {
            statusEl.innerText = '🔴 Non lu';
            statusEl.style.color = 'var(--accent-red)';
            toggleBtn.innerText = '✓ Marquer lu';
            
            // Auto mark as read via ajax if it's currently unread (optional, but good UX)
            fetch(`/admin/messages/${m.id}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).catch(console.error); // Silently try to mark as read
        }
        
        toggleForm.action = `/admin/messages/${m.id}/read`;
        
        document.getElementById('modal-body').innerText = m.message;
        
        document.getElementById('modal-reply-btn').href = `mailto:${m.email}?subject=Re: ${encodeURIComponent(m.subject)}`;
        
        document.getElementById('msg-modal').style.display = 'flex';
    }
</script>
@endpush
@endsection
