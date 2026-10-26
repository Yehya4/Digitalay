@extends('layouts.admin')

@section('title', $post ? 'Modifier l\'article' : 'Nouvel Article')

@section('content')
<div class="admin-card">
    <div style="margin-bottom: 25px;">
        <a href="{{ route('admin.blog') }}" style="text-decoration: none; color: var(--text-muted); font-size: 14px;">← Retour à la liste</a>
        <h2 style="margin: 10px 0 0 0;">{{ $post ? 'Modifier l\'article' : 'Créer un nouvel article' }}</h2>
    </div>

    <form action="{{ $post ? route('admin.blog.update', $post->id) : route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($post) @method('PUT') @endif

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            <!-- Main Content -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="form-group">
                    <label for="title" class="form-label">Titre de l'article</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required placeholder="Ex: Comment choisir son abonnement IPTV">
                    @error('title') <div style="color: var(--accent-rose); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="slug" class="form-label">Slug (URL)</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}" placeholder="Laissez vide pour générer automatiquement">
                    @error('slug') <div style="color: var(--accent-rose); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="excerpt" class="form-label">Résumé court (Excerpt)</label>
                    <textarea name="excerpt" id="excerpt" class="form-control" style="height: 80px;" placeholder="Bref résumé qui apparaîtra sur la page listing...">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    @error('excerpt') <div style="color: var(--accent-rose); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="content" class="form-label">Contenu de l'article (Markdown supporté)</label>
                    <textarea name="content" id="content" class="form-control" style="height: 400px; font-family: monospace;" required placeholder="Écrivez votre contenu ici...">{{ old('content', $post->content ?? '') }}</textarea>
                    @error('content') <div style="color: var(--accent-rose); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Sidebar Info -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Image de couverture</label>
                    @if(isset($post) && $post->cover_image)
                        <img src="{{ $post->cover_image }}" alt="Preview" style="width: 100%; border-radius: 8px; margin-bottom: 10px;">
                    @endif
                    <input type="file" name="image" class="form-control">
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 5px;">Max: 2MB. JPG, PNG, WebP.</div>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Catégorie</label>
                    <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $post->category ?? '') }}" placeholder="Ex: Tuto, IPTV, News">
                </div>

                <div class="form-group">
                    <label for="read_time" class="form-label">Temps de lecture (minutes)</label>
                    <input type="number" name="read_time" id="read_time" class="form-control" value="{{ old('read_time', $post->read_time ?? 5) }}" min="1">
                </div>

                <div class="form-group">
                    <label for="published_at" class="form-label">Date de publication</label>
                    <input type="datetime-local" name="published_at" id="published_at" class="form-control" 
                           value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                </div>

                <div class="form-group" style="background: var(--bg); padding: 15px; border-radius: 8px; border: 1px solid var(--border);">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }}>
                        <span style="font-weight: 600;">Publier l'article</span>
                    </label>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 5px;">Cochez pour rendre l'article visible publiquement.</div>
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary btn-full" style="padding: 15px;">
                        {{ $post ? '💾 Mettre à jour' : '🚀 Créer l\'article' }}
                    </button>
                    <a href="{{ route('admin.blog') }}" class="btn btn-outline btn-full" style="margin-top: 10px; padding: 12px; display: block; text-align: center; text-decoration: none;">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

