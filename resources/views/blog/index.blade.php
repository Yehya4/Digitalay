@extends('layouts.app')

@section('title', 'Blog | Digitalay')

@section('content')
<!-- Hero Section -->
<div class="blog-hero" style="background: radial-gradient(circle at top left, #1e3a8a, #0f172a); padding: 120px 20px 140px; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(59, 130, 246, 0.1); filter: blur(100px); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -150px; left: -100px; width: 500px; height: 500px; background: rgba(30, 58, 138, 0.15); filter: blur(120px); border-radius: 50%;"></div>
    
    <div class="container" style="position: relative; z-index: 2;">
        <span style="display: inline-block; padding: 8px 20px; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 30px; color: #60a5fa; font-size: 14px; font-weight: 700; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px; animation: fadeInDown 0.6s ease;">Insights & Knowledge</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; margin-bottom: 24px; color: white; line-height: 1.1; letter-spacing: -2px; animation: fadeInUp 0.8s ease;">Conseils & Actualités <span style="background: linear-gradient(to right, #60a5fa, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Digitalay</span></h1>
        <p style="font-size: 1.25rem; color: rgba(255, 255, 255, 0.7); max-width: 800px; margin: 0 auto; line-height: 1.6; animation: fadeInUp 1s ease;">Plongez dans l'univers du streaming, de l'IPTV et des innovations technologiques avec nos experts.</p>
    </div>
</div>

<div class="container" style="margin-top: -60px; position: relative; z-index: 10; margin-bottom: 100px;">
    <!-- Filters & Search Bar -->
    <div style="display: flex; flex-direction: column; gap: 30px; margin-bottom: 60px;">
        <div class="blog-filters-container" style="display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">
            <div class="blog-tabs" style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; -ms-overflow-style: none; scrollbar-width: none;">
                <a href="{{ route('blog') }}" class="blog-tab {{ !request('category') ? 'active' : '' }}">Tout voir</a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog', ['category' => $cat]) }}" class="blog-tab {{ request('category') == $cat ? 'active' : '' }}">{{ $cat }}</a>
                @endforeach
            </div>
            
            <form action="{{ route('blog') }}" method="GET" style="flex: 1; max-width: 350px; min-width: 250px; position: relative;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un article..." 
                       style="width: 100%; border-radius: 40px; border: 1px solid var(--border); background: var(--bg-card); padding: 14px 25px 14px 50px; color: var(--text); outline: none; transition: 0.3s; backdrop-filter: blur(10px);">
                <span style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">🔍</span>
            </form>
        </div>
    </div>

    <!-- Blog Grid -->
    <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 40px;">
        @forelse($posts as $post)
        <article class="premium-blog-card" style="animation: fadeInUp 0.6s ease backwards {{ $loop->index * 0.1 }}s;">
            <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration: none; color: inherit; display: block; height: 100%;">
                <div class="card-image-wrapper">
                    @if($post->cover_image)
                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="card-img">
                    @else
                        <div class="card-img-placeholder">📝</div>
                    @endif
                    <div class="category-badge">{{ $post->category ?: 'Actualité' }}</div>
                    <div class="image-overlay"></div>
                </div>
                
                <div class="card-content">
                    <div class="card-meta">
                        <span><i class="far fa-calendar-alt"></i> {{ $post->published_at ? $post->published_at->format('d M, Y') : $post->created_at->format('d M, Y') }}</span>
                        <span><i class="far fa-clock"></i> {{ $post->read_time }} min de lecture</span>
                    </div>
                    
                    <h3 class="card-title">{{ $post->title }}</h3>
                    
                    <p class="card-excerpt">
                        {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                    </p>
                    
                    <div class="card-footer">
                        <span class="read-more">Lire l'article <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>
        </article>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 120px 40px; background: var(--bg-card); border-radius: 30px; border: 1px dashed var(--border);">
            <div style="font-size: 5rem; margin-bottom: 30px; opacity: 0.5;">🔎</div>
            <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 10px;">Aucun article trouvé</h3>
            <p style="color: var(--text-muted);">Nous n'avons trouvé aucun article correspondant à vos critères.</p>
            <a href="{{ route('blog') }}" class="btn btn-primary" style="margin-top: 30px; border-radius: 30px;">Voir tout le blog</a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div>
    @endif
</div>

<style>
    /* Premium Tabs */
    .blog-tab {
        padding: 10px 24px;
        border-radius: 30px;
        text-decoration: none;
        color: var(--text-muted);
        background: var(--bg-card);
        border: 1px solid var(--border);
        font-weight: 600;
        font-size: 14px;
        transition: 0.3s;
        white-space: nowrap;
    }
    .blog-tab:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    .blog-tab.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
    }

    /* Premium Cards */
    .premium-blog-card {
        background: var(--bg-card);
        border-radius: 30px;
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        position: relative;
    }
    .premium-blog-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
        border-color: rgba(59, 130, 246, 0.3);
    }
    .card-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
    }
    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.19, 1, 0.22, 1);
    }
    .premium-blog-card:hover .card-img {
        transform: scale(1.1);
    }
    .card-img-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--bg) 0%, var(--border) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
    }
    .category-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(8px);
        color: white;
        padding: 6px 18px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 2;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, transparent 100%);
        opacity: 0;
        transition: 0.3s;
    }
    .premium-blog-card:hover .image-overlay { opacity: 1; }

    .card-content { padding: 30px; }
    .card-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 20px;
        font-weight: 600;
    }
    .card-meta i { color: var(--primary); margin-right: 6px; }
    .card-title {
        font-size: 1.6rem;
        font-weight: 900;
        line-height: 1.3;
        margin-bottom: 16px;
        color: var(--text);
        letter-spacing: -0.5px;
        transition: 0.3s;
    }
    .premium-blog-card:hover .card-title { color: var(--primary); }
    .card-excerpt {
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 24px;
        font-size: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-footer {
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }
    .read-more {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--primary);
        font-weight: 800;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    .read-more i { transition: 0.3s; }
    .premium-blog-card:hover .read-more i { transform: translateX(8px); }

    .pagination-wrapper {
        margin-top: 80px;
        display: flex;
        justify-content: center;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 992px) {
        .blog-grid { grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; }
    }
    @media (max-width: 768px) {
        .blog-hero { padding: 80px 20px 100px; }
        .blog-tabs { width: 100%; order: 2; }
        form { max-width: 100% !important; order: 1; }
        .card-content { padding: 24px; }
        .card-title { font-size: 1.4rem; }
    }
</style>
@endsection
