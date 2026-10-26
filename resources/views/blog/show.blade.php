@extends('layouts.app')

@section('title', $post->title . ' | Blog Digitalay')

@section('content')
<!-- Article Hero -->
<div class="article-hero" style="position: relative; height: 60vh; min-height: 500px; display: flex; align-items: flex-end; padding-bottom: 80px; overflow: hidden; background: #0f172a;">
    @if($post->cover_image)
        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.5; animation: scaleIn 20s infinite alternate;">
    @endif
    <div style="position: absolute; inset: 0; background: linear-gradient(to top, #0f172a 0%, rgba(15, 23, 42, 0.4) 50%, transparent 100%);"></div>
    
    <div class="container" style="position: relative; z-index: 10; color: white;">
        <nav class="article-breadcrumb" style="margin-bottom: 30px; animation: fadeInDown 0.8s ease;">
            <a href="{{ route('home') }}">Accueil</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 12px; opacity: 0.5;"></i>
            <a href="{{ route('blog') }}">Blog</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 12px; opacity: 0.5;"></i>
            <span style="color: var(--primary-light);">{{ $post->category ?: 'Actualité' }}</span>
        </nav>
        
        <h1 style="font-size: clamp(2.5rem, 5vw, 4.5rem); font-weight: 950; line-height: 1.1; max-width: 1000px; margin-bottom: 35px; letter-spacing: -2px; animation: fadeInUp 0.8s ease;">{{ $post->title }}</h1>
        
        <div style="display: flex; align-items: center; gap: 40px; flex-wrap: wrap; animation: fadeInUp 1s ease;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: var(--primary); width: 48px; height: 48px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 20px; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);">D</div>
                <div>
                    <div style="font-weight: 800; font-size: 15px;">Digitalay Team</div>
                    <div style="font-size: 12px; opacity: 0.6;">Expert Streaming</div>
                </div>
            </div>
            
            <div style="display: flex; gap: 25px; font-size: 14px; font-weight: 600; color: rgba(255,255,255,0.7);">
                <span><i class="far fa-calendar-alt" style="margin-right: 8px; color: var(--primary-light);"></i> {{ $post->published_at ? $post->published_at->format('d M, Y') : $post->created_at->format('d M, Y') }}</span>
                <span><i class="far fa-clock" style="margin-right: 8px; color: var(--primary-light);"></i> {{ $post->read_time }} min de lecture</span>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 80px; margin-bottom: 120px;">
    <div class="article-layout" style="display: grid; grid-template-columns: 1fr 350px; gap: 80px; align-items: start;">
        
        <!-- Main Content Area -->
        <div class="article-body-wrapper">
            <div class="article-content" style="font-size: 1.2rem; line-height: 1.9; color: var(--text-2);">
                <div class="article-intro" style="font-size: 1.4rem; font-weight: 500; color: var(--text); margin-bottom: 50px; line-height: 1.6; border-left: 4px solid var(--primary); padding-left: 30px;">
                    {{ $post->excerpt }}
                </div>
                
                <div class="rich-text-content">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
            
            <!-- Tags & Share -->
            <div style="margin-top: 80px; padding: 40px; background: var(--bg-card); border-radius: 30px; border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span style="font-weight: 800; color: var(--text);">Partager :</span>
                    <div style="display: flex; gap: 10px;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" class="share-btn fb"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" class="share-btn tw"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}" class="share-btn wa"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <a href="{{ route('blog') }}" class="btn btn-outline" style="border-radius: 30px; padding: 12px 30px;">
                    <i class="fas fa-arrow-left" style="margin-right: 10px;"></i> Retour au blog
                </a>
            </div>

            <!-- Author Box -->
            <div style="margin-top: 40px; display: flex; gap: 30px; align-items: center; padding: 40px; background: linear-gradient(to right, var(--bg-card), transparent); border-radius: 30px; border: 1px solid var(--border);">
                <div style="width: 100px; height: 100px; border-radius: 30px; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 900; box-shadow: var(--shadow-xl);">D</div>
                <div>
                    <h4 style="font-size: 20px; font-weight: 900; margin-bottom: 8px;">Équipe Digitalay</h4>
                    <p style="color: var(--text-muted); font-size: 15px; line-height: 1.5;">Nous partageons notre passion pour la technologie et le divertissement numérique pour vous offrir le meilleur de l'IPTV.</p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="article-sidebar" style="position: sticky; top: 100px;">
            <div class="sidebar-card" style="margin-bottom: 30px;">
                <h3 class="sidebar-title">Articles Similaires</h3>
                <div style="display: flex; flex-direction: column; gap: 25px;">
                    @forelse($relatedPosts as $rp)
                    <a href="{{ route('blog.show', $rp->slug) }}" class="related-article-link">
                        <div class="related-thumb">
                            @if($rp->cover_image)
                                <img src="{{ $rp->cover_image }}" alt="">
                            @else
                                <div class="thumb-placeholder">📝</div>
                            @endif
                        </div>
                        <div class="related-info">
                            <h4>{{ Str::limit($rp->title, 55) }}</h4>
                            <span>{{ $rp->published_at ? $rp->published_at->format('d M, Y') : $rp->created_at->format('d M, Y') }}</span>
                        </div>
                    </a>
                    @empty
                        <p style="color: var(--text-muted); font-size: 14px; text-align: center; padding: 20px;">Aucun article similaire pour le moment.</p>
                    @endforelse
                </div>
            </div>

            <!-- CTA Card -->
            <div class="sidebar-cta" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 35px; border-radius: 30px; color: white; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);">
                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <h3 style="font-size: 22px; font-weight: 900; margin-bottom: 15px; position: relative;">Prêt pour le futur ?</h3>
                <p style="font-size: 15px; opacity: 0.9; margin-bottom: 25px; line-height: 1.6; position: relative;">Découvrez nos abonnements IPTV Premium avec plus de 10k chaînes en 4K.</p>
                <a href="{{ route('products') }}" class="btn" style="background: white; color: #1e3a8a; width: 100%; font-weight: 800; border-radius: 15px; padding: 14px; animation: pulse 2s infinite;">Voir les Offres</a>
            </div>
        </aside>

    </div>
</div>

<style>
    .article-breadcrumb a { text-decoration: none; color: white; opacity: 0.7; transition: 0.3s; font-weight: 600; font-size: 14px; }
    .article-breadcrumb a:hover { opacity: 1; color: var(--primary-light); }

    .rich-text-content h2 { font-size: 2.2rem; font-weight: 900; margin: 60px 0 25px; color: var(--text); letter-spacing: -1px; }
    .rich-text-content h3 { font-size: 1.8rem; font-weight: 800; margin: 40px 0 20px; color: var(--text); }
    .rich-text-content p { margin-bottom: 25px; }
    .rich-text-content ul, .rich-text-content ol { margin-bottom: 30px; padding-left: 20px; }
    .rich-text-content li { margin-bottom: 12px; }

    .share-btn {
        width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center;
        color: white; text-decoration: none; font-size: 18px; transition: 0.3s;
    }
    .share-btn.fb { background: #1877F2; }
    .share-btn.tw { background: #1DA1F2; }
    .share-btn.wa { background: #25D366; }
    .share-btn:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }

    .sidebar-card { background: var(--bg-card); border-radius: 30px; padding: 30px; border: 1px solid var(--border); }
    .sidebar-title { font-size: 1.25rem; font-weight: 900; margin-bottom: 25px; position: relative; padding-bottom: 12px; }
    .sidebar-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 40px; height: 4px; background: var(--primary); border-radius: 2px; }

    .related-article-link { display: flex; gap: 15px; text-decoration: none; align-items: center; transition: 0.3s; }
    .related-article-link:hover { transform: translateX(8px); }
    .related-thumb { min-width: 80px; height: 80px; border-radius: 18px; overflow: hidden; }
    .related-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .thumb-placeholder { width: 100%; height: 100%; background: var(--bg); display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .related-info h4 { font-size: 15px; font-weight: 700; color: var(--text); line-height: 1.4; margin-bottom: 5px; transition: 0.3s; }
    .related-article-link:hover h4 { color: var(--primary); }
    .related-info span { font-size: 12px; color: var(--text-muted); font-weight: 600; }

    @keyframes scaleIn { from { transform: scale(1); } to { transform: scale(1.1); } }
    @keyframes pulse { 
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
        70% { transform: scale(1.02); box-shadow: 0 0 0 15px rgba(255, 255, 255, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
    }

    @media (max-width: 1200px) {
        .article-layout { grid-template-columns: 1fr 320px; gap: 40px; }
    }

    @media (max-width: 992px) {
        .article-hero { height: auto; padding-top: 140px; padding-bottom: 60px; }
        .article-layout { grid-template-columns: 1fr; }
        .article-sidebar { position: static; margin-top: 60px; }
    }

    @media (max-width: 768px) {
        .article-hero h1 { font-size: 2.2rem; }
        .article-intro { font-size: 1.2rem; padding-left: 20px; }
        .sidebar-card { padding: 20px; }
    }
</style>
@endsection
