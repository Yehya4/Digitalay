<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\AdminConfig;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        if (AdminConfig::verifyPassword($request->password)) {
            Session::put('admin_logged_in', true);
            $request->session()->regenerate(); // Prevent session fixation
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['password' => 'Mot de passe incorrect']);
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $stats = [
            'total_orders' => Order::count(),
            'today_orders' => Order::whereDate('created_at', \Carbon\Carbon::today())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'total_products' => Product::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count()
        ];
        
        $recent_orders = Order::orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return redirect()->back()->with('success', 'Statut de la commande mis à jour');
    }

    public function destroyOrder($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Commande supprimée avec succès');
    }

    public function products()
    {
        $categories = Category::all();
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        $product = null; // or new Product() if preferred, depending on form logic
        return view('admin.products.form', compact('categories', 'product'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'features' => 'nullable|string',
            'whatsapp_message' => 'nullable|string',
            'original_price' => 'nullable|numeric',
            'badge' => 'nullable|string',
            'badge_color' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'duration_months' => 'nullable|integer|min:1|max:360',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'durations' => 'nullable|array',
            'durations.*.duration_name' => 'required|string|max:100',
            'durations.*.price' => 'required|numeric',
            'durations.*.original_price' => 'nullable|numeric'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $validated['image_url'] = url('uploads/products/' . $filename);
        }

        $product = Product::create($validated);

        if ($request->has('durations')) {
            foreach ($request->durations as $index => $d) {
                $product->durations()->create([
                    'duration_name' => $d['duration_name'],
                    'price' => $d['price'],
                    'original_price' => $d['original_price'],
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Produit créé avec succès');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'features' => 'nullable|string',
            'whatsapp_message' => 'nullable|string',
            'original_price' => 'nullable|numeric',
            'badge' => 'nullable|string',
            'badge_color' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'duration_months' => 'nullable|integer|min:1|max:360',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'durations' => 'nullable|array',
            'durations.*.duration_name' => 'required|string|max:100',
            'durations.*.price' => 'required|numeric',
            'durations.*.original_price' => 'nullable|numeric'
        ]);
        
        // Handle checkbox fields that might not be in request if unchecked
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $validated['image_url'] = url('uploads/products/' . $filename);
        }

        $product->update($validated);

        // Sync durations
        $product->durations()->delete();
        if ($request->has('durations')) {
            foreach ($request->durations as $index => $d) {
                $product->durations()->create([
                    'duration_name' => $d['duration_name'],
                    'price' => $d['price'],
                    'original_price' => $d['original_price'],
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Produit mis à jour avec succès');
    }

    public function toggleProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $field = $request->input('field');
        
        if (in_array($field, ['is_active', 'is_featured'])) {
            $product->$field = !$product->$field;
            $product->save();
            return redirect()->back()->with('success', 'Statut du produit mis à jour.');
        }
        
        return redirect()->back()->with('error', 'Champ invalide.');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->orderItems()->exists()) {
            return redirect()->back()->with('error', 'Ce produit a été commandé et ne peut pas être supprimé. Veuillez le désactiver à la place.');
        }

        $product->delete();
        return redirect()->back()->with('success', 'Produit supprimé');
    }

    // --- CATEGORIES ---

    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:categories',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'icon' => $request->icon ?: 'fas fa-star',
            'color' => $request->color ?: '#7C3AED',
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Catégorie créée.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'icon' => $request->icon ?: 'fas fa-star',
            'color' => $request->color ?: '#7C3AED',
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Catégorie mise à jour.');
    }

    public function destroyCategory($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Catégorie supprimée.');
    }

    // --- MESSAGES COMMANDES / CONTACT ---

    public function messages()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        return view('admin.messages', compact('messages'));
    }

    public function toggleMessageRead($id)
    {
        $msg = ContactMessage::findOrFail($id);
        $msg->is_read = !$msg->is_read;
        $msg->save();
        return redirect()->back()->with('success', 'Statut du message modifié.');
    }

    public function markAllMessagesRead()
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Tous les messages ont été marqués comme lus.');
    }

    public function destroyMessage($id)
    {
        ContactMessage::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Message supprimé.');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        if (!AdminConfig::verifyPassword($request->current_password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        AdminConfig::setPassword($request->new_password);
        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès.');
    }

    // --- BLOG MANAGEMENT ---

    public function blogIndex()
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.blog.index', compact('posts'));
    }

    public function blogCreate()
    {
        $post = null;
        return view('admin.blog.form', compact('post'));
    }

    public function blogStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'read_time' => 'required|integer|min:1',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048'
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        
        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blog'), $filename);
            $validated['cover_image'] = url('uploads/blog/' . $filename);
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog')->with('success', 'Article créé avec succès.');
    }

    public function blogEdit($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('admin.blog.form', compact('post'));
    }

    public function blogUpdate(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'read_time' => 'required|integer|min:1',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048'
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blog'), $filename);
            $validated['cover_image'] = url('uploads/blog/' . $filename);
        }

        $post->update($validated);

        return redirect()->route('admin.blog')->with('success', 'Article mis à jour avec succès.');
    }

    public function blogDestroy($id)
    {
        BlogPost::findOrFail($id)->delete();
        return redirect()->route('admin.blog')->with('success', 'Article supprimé.');
    }
}
