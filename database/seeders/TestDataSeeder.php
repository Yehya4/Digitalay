<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ContactMessage;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Categories exist (already in AdminConfigSeeder, but let's be safe or just use them)
        $streaming = Category::where('slug', 'streaming')->first();
        $musique = Category::where('slug', 'musique')->first();
        $gaming = Category::where('slug', 'jeux-video')->first();
        $logiciel = Category::where('slug', 'logiciels')->first();

        // 2. Add Products
        $products = [
            // Streaming
            [
                'category_id' => $streaming->id,
                'name' => 'Netflix Premium 4K (1 Mois)',
                'description' => 'Compte Netflix Premium avec résolution 4K Ultra HD. 4 écrans simultanés.',
                'price' => 35.00,
                'original_price' => 120.00,
                'image_url' => 'https://images.unsplash.com/photo-1574375927938-d5a98e8f85f9?q=80&w=500&auto=format&fit=crop',
                'features' => "Ultra HD 4K\n4 Écrans\nProfil Privé\nActivation Immédiate",
                'badge' => 'Populaire',
                'badge_color' => '#E50914',
                'is_featured' => true,
            ],
            [
                'category_id' => $streaming->id,
                'name' => 'Disney+ Premium (Annuel)',
                'description' => 'Accès illimité à Disney, Pixar, Marvel, Star Wars et National Geographic.',
                'price' => 250.00,
                'original_price' => 450.00,
                'image_url' => 'https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?q=80&w=500&auto=format&fit=crop',
                'features' => "Qualité 4K\n7 Profils\nMode Hors-ligne\nTout le catalogue Marvel",
                'badge' => 'Offre 12 Mois',
                'badge_color' => '#006E99',
                'is_featured' => false,
            ],
            [
                'category_id' => $streaming->id,
                'name' => 'IPTV Pro Max (12 Mois)',
                'description' => 'Plus de 15,000 chaînes mondiales et 50,000 VOD en 4K/FHD.',
                'price' => 300.00,
                'original_price' => 600.00,
                'image_url' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?q=80&w=500&auto=format&fit=crop',
                'features' => "Chaînes BeIN Sports\nCanal+ & Sky\nStabilité 99%\nCompatible Smart TV/Box/Mobile",
                'badge' => 'Top Vente',
                'badge_color' => '#8B5CF6',
                'is_featured' => true,
            ],

            // Musique
            [
                'category_id' => $musique->id,
                'name' => 'Spotify Premium (Individuel)',
                'description' => 'Musique sans pub et mode hors-ligne. Écoutez partout.',
                'price' => 25.00,
                'original_price' => 50.00,
                'image_url' => 'https://images.unsplash.com/photo-1614680376593-902f74cf0d41?q=80&w=500&auto=format&fit=crop',
                'features' => "Sans publicités\nMode hors-ligne\nQualité audio max\nSauts illimités",
                'badge' => '-50%',
                'badge_color' => '#1DB954',
                'is_featured' => true,
            ],

            // Gaming
            [
                'category_id' => $gaming->id,
                'name' => 'PlayStation Plus Essential (3 Mois)',
                'description' => 'Jeux mensuels, multijoueur en ligne et réductions exclusives.',
                'price' => 180.00,
                'original_price' => 250.00,
                'image_url' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?q=80&w=500&auto=format&fit=crop',
                'features' => "Multijoueur en ligne\nJeux du mois\nStockage Cloud\nRemises exclusives",
                'is_featured' => false,
            ],

            // Logiciels (AI & Work)
            [
                'category_id' => $logiciel->id,
                'name' => 'ChatGPT Plus (Personnel)',
                'description' => 'Accédez à GPT-4, DALL-E, et aux fonctionnalités avancées d\'OpenAI.',
                'price' => 150.00,
                'original_price' => 250.00,
                'image_url' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?q=80&w=500&auto=format&fit=crop',
                'features' => "Accès à GPT-4o\nAnalyse de données\nGénération d'images DALL-E\nRéponse prioritaire",
                'badge' => 'IA Propulsé',
                'badge_color' => '#10A37F',
                'is_featured' => true,
            ],
            [
                'category_id' => $logiciel->id,
                'name' => 'Canva Pro (Équipe)',
                'description' => 'Design sans limites avec tous les outils Premium de Canva.',
                'price' => 49.00,
                'original_price' => 120.00,
                'image_url' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=500&auto=format&fit=crop',
                'features' => "Images Premium illimitées\nSuppression de l'arrière-plan\nKit de marque\nPlanification RS",
                'badge' => 'Essentiel',
                'badge_color' => '#00D1FF',
                'is_featured' => true,
            ],
            [
                'category_id' => $logiciel->id,
                'name' => 'Pack Google One Complet',
                'description' => 'Le pack ultime pour votre espace de travail et stockage Cloud.',
                'price' => 189.00,
                'original_price' => 350.00,
                'image_url' => 'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?q=80&w=500&auto=format&fit=crop',
                'features' => "2 To de stockage Cloud\nGemini Advanced (AI)\nGoogle Workspace Premium\nPartage familial (5 pers)",
                'badge' => '🔥 MEILLEURE OFFRE',
                'badge_color' => '#FBBC05',
                'is_featured' => true,
            ],
        ];

        foreach ($products as $pData) {
            Product::create($pData);
        }

        // 3. Add Orders
        $order1 = Order::create([
            'customer_name' => 'Yassine El Amrani',
            'customer_phone' => '0612345678',
            'customer_email' => 'yassine@example.com',
            'payment_method' => 'bank_transfer',
            'total_amount' => 210.00,
            'status' => 'pending',
            'note' => 'C\'est ma première commande, s\'il vous plaît activez rapidement.',
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => Product::where('name', 'like', '%Netflix%')->first()->id,
            'quantity' => 1,
            'unit_price' => 35.00,
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => Product::where('name', 'like', '%PlayStation%')->first()->id,
            'quantity' => 1,
            'unit_price' => 175.00,
        ]);

        $order2 = Order::create([
            'customer_name' => 'Latifa Bennani',
            'customer_phone' => '0788990011',
            'customer_email' => 'latifa.b@gmail.com',
            'payment_method' => 'whatsapp',
            'total_amount' => 150.00,
            'status' => 'confirmed',
            'note' => null,
            'created_at' => now()->subDays(1),
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => Product::where('name', 'like', '%ChatGPT%')->first()->id,
            'quantity' => 1,
            'unit_price' => 150.00,
        ]);

        $order3 = Order::create([
            'customer_name' => 'Mohamed Karim',
            'customer_phone' => '0655443322',
            'customer_email' => null,
            'payment_method' => 'bank_transfer',
            'total_amount' => 189.00,
            'status' => 'delivered',
            'note' => 'Compte activé, merci !',
            'created_at' => now()->subDays(5),
        ]);
        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => Product::where('name', 'like', '%Google One%')->first()->id,
            'quantity' => 1,
            'unit_price' => 189.00,
        ]);

        // 4. Add Contact Messages
        ContactMessage::create([
            'name' => 'Ali Mansour',
            'email' => 'ali@contact.ma',
            'phone' => '0600112233',
            'subject' => 'Question sur IPTV',
            'message' => 'Bonjour, est-ce que l\'IPTV fonctionne sur une Smart TV Samsung Tizen ? Merci.',
            'is_read' => false,
        ]);

        ContactMessage::create([
            'name' => 'Siham Kadiri',
            'email' => 'siham@yahoo.fr',
            'phone' => '0611223344',
            'subject' => 'Virement effectué',
            'message' => 'Je viens de faire le virement pour ma commande Netflix. Voici mon numéro de transaction : #987654.',
            'is_read' => true,
        ]);
    }
}
