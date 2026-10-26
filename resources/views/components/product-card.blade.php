@props(['product'])

<article class="product-card">
    <a href="{{ route('products.show', $product->id) }}" class="product-card__link">
        <div class="product-card-img">
            @if($product->badge)
                <span class="product-badge" style="background: {{ $product->badge_color ?? 'var(--grad-hot)' }}">
                    {{ $product->badge }}
                </span>
            @endif
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" />
            @else
                <div class="product-img-placeholder">
                    <i class="{{ $product->category->icon ?? 'fas fa-box' }}"></i>
                </div>
            @endif
        </div>
    </a>

    <div class="product-card-body">
        <div class="pc-cat">
            <i class="{{ $product->category->icon ?? 'fas fa-tag' }}"></i>
            {{ $product->category->name ?? 'Général' }}
        </div>
        
        <h3 class="pc-name">
            <a href="{{ route('products.show', $product->id) }}" class="pc-name-link">{{ $product->name }}</a>
        </h3>
        
        <div class="pc-price-row">
            <span class="pc-price">{{ number_format($product->price, 0) }} MAD</span>
            @if($product->original_price && $product->original_price > $product->price)
                <span class="pc-old" style="text-decoration: line-through; color: var(--text-muted); font-size: 0.85em; font-weight: 500;">
                    {{ number_format($product->original_price, 0) }} MAD
                </span>
            @endif
        </div>
        
        <div class="pc-actions" style="display: grid; grid-template-columns: 1fr auto; gap: 8px; margin-top: auto;">
            <button class="btn btn-primary btn-sm add-to-cart-btn" 
                style="border-radius: 12px; font-weight: 700; padding: 10px;"
                data-product="{{ json_encode([
                    'id' => $product->id, 
                    'name' => $product->name, 
                    'price' => $product->price, 
                    'image' => $product->image_url, 
                    'quantity' => 1
                ]) }}">
                <span>🛒 Ajouter</span>
            </button>
            <a href="{{ route('products.show', $product->id) }}" 
               class="btn btn-ghost btn-sm" 
               style="border-radius: 12px; width: 42px; padding: 0;" 
               title="Détails">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
</article>
