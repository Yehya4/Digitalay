@extends('layouts.admin')

@section('title', 'Gestion du Blog')

@section('content')
<div class="fade-up-item">
    <!-- HEADER -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-h1">Articles de Blog</h1>
            <p class="admin-sub">{{ $posts->total() }} article(s) au total</p>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">+ Nouvel Article</a>
    </div>

    <!-- MAIN TABLE/CARDS -->
    <div class="glass-card" style="overflow: hidden; padding: 0;">
        <!-- DESKTOP TABLE -->
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="padding-left: 24px;">Article</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Publication</th>
                        <th style="text-align: right; padding-right: 24px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td style="padding-left: 24px;">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div class="admin-product-thumb" style="width: 48px; height: 48px; border-radius: 12px;">
                                    @if($post->cover_image)
                                        <img src="{{ $post->cover_image }}" alt="" />
                                    @else
                                        <span>📝</span>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 800; font-size: 14px;">{{ $post->title }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">{{ Str::limit($post->excerpt, 60) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2);">
                                {{ $post->category ?: 'Non classé' }}
                            </span>
                        </td>
                        <td>
                            @if($post->is_published)
                                <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span> Publié
                                </span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #f59e0b;"></span> Brouillon
                                </span>
                            @endif
                        </td>
                        <td style="font-size: 13px; font-weight: 600; color: var(--text-muted);">
                            {{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}
                        </td>
                        <td style="padding-right: 24px;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-outline" style="padding: 6px 10px; font-size: 12px;" title="Voir">👁️</a>
                                <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-outline" style="padding: 6px 10px; font-size: 12px;" title="Modifier">✏️</a>
                                <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?')" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 6px 10px; font-size: 12px; border-color: var(--accent-red); color: var(--accent-red);" title="Supprimer">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="padding: 60px; text-align: center; color: var(--text-muted);">Aucun article trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="admin-mobile-cards">
            @forelse($posts as $post)
            <div style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; gap: 12px;">
                    <div style="width: 60px; height: 60px; border-radius: 12px; overflow: hidden; flex-shrink: 0;">
                        @if($post->cover_image)
                            <img src="{{ $post->cover_image }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: var(--border); display: flex; align-items: center; justify-content: center;">📝</div>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 800; font-size: 15px; margin-bottom: 4px;">{{ $post->title }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $post->category ?: 'Actualité' }} • {{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Non publié' }}</div>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    @if($post->is_published)
                        <span style="font-size: 12px; font-weight: 700; color: #10b981;">✅ Publié</span>
                    @else
                        <span style="font-size: 12px; font-weight: 700; color: #f59e0b;">⏳ Brouillon</span>
                    @endif
                    
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">👁️</a>
                        <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">✏️</a>
                        <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px; border-color: var(--accent-red); color: var(--accent-red);">🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div style="padding: 40px; text-align: center; color: var(--text-muted);">Aucun article trouvé.</div>
            @endforelse
        </div>

        @if($posts->hasPages())
        <div style="padding: 20px; border-top: 1px solid var(--border);">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.fade-up-item { opacity: 0; transform: translateY(20px); animation: fadeUpAnim 0.3s ease-out forwards; }
@keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

@media (max-width: 991px) {
    .admin-table-wrap { display: none; }
    .admin-mobile-cards { display: block; }
}
@media (min-width: 992px) {
    .admin-table-wrap { display: block; }
    .admin-mobile-cards { display: none; }
}
</style>
@endsection

