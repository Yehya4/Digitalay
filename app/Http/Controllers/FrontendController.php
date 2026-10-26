<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\BlogPost;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featured = Product::with('category')->where('is_featured', true)->where('is_active', true)->get();
        $promoProduct = Product::where('name', 'LIKE', '%Google One%')->where('is_active', true)->first();
        return view('home', compact('categories', 'featured', 'promoProduct'));
    }

    public function products(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category')->where('is_active', true);

        if ($request->has('cat') && $request->cat !== '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->cat);
            });
        }

        if ($request->has('search') && $request->search !== '') {
            $search = '%' . $request->search . '%';
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', $search)
                  ->orWhere('description', 'LIKE', $search);
            });
        }

        $products = $query->paginate(12);
        return view('products.index', compact('products', 'categories'));
    }

    public function productShow($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        $upsellProduct = Product::where('is_featured', true)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->first();

        return view('products.show', compact('product', 'relatedProducts', 'upsellProduct'));
    }

    public function cart()
    {
        return view('cart');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|min:10|max:20',
            'customer_email' => 'nullable|email|max:150',
            'note' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:bank_transfer,whatsapp',
            'items' => 'required|string', // JSON string from frontend
            'total_amount' => 'required|numeric|min:0'
        ]);

        // Basic sanitization for note
        $validated['note'] = strip_tags($validated['note']);

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],
            'note' => $validated['note'],
            'payment_method' => $validated['payment_method'],
            'total_amount' => $validated['total_amount'],
            'status' => 'pending'
        ]);

        $items = json_decode($validated['items'], true);
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'duration' => $item['duration'] ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price']
            ]);
        }
        return redirect()->route('order.success', ['id' => $order->id]);
    }

    public function orderSuccess($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('order-success', compact('order'));
    }

    public function faq()
    {
        return view('faq');
    }

    public function about()
    {
        return view('about');
    }

    public function terms()
    {
        return view('cgv');
    }

    public function privacy()
    {
        return view('confidentialite');
    }

    public function legal()
    {
        return view('mentions-legales');
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000'
        ]);

        // Sanitization
        foreach (['name', 'subject', 'message'] as $field) {
            $validated[$field] = strip_tags($validated[$field]);
        }

        ContactMessage::create($validated);
        
        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès !');
    }
    public function blog(Request $request)
    {
        $categories = BlogPost::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        $query = BlogPost::published()->latest('published_at');

        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        $posts = $query->paginate(9);

        return view('blog.index', compact('posts', 'categories'));
    }

    public function blogShow($slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();
        
        $relatedPosts = BlogPost::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
