<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminConfig;
use App\Models\Category;

class AdminConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminConfig::setPassword('admin123');

        Category::insert([
            ['name' => 'Streaming', 'slug' => 'streaming', 'icon' => 'fas fa-tv', 'color' => '#E50914', 'description' => 'Abonnements streaming vidéo'],
            ['name' => 'Musique', 'slug' => 'musique', 'icon' => 'fas fa-music', 'color' => '#1DB954', 'description' => 'Abonnements streaming audio'],
            ['name' => 'Jeux Vidéo', 'slug' => 'jeux-video', 'icon' => 'fas fa-gamepad', 'color' => '#00439C', 'description' => 'Jeux et abonnements gaming'],
            ['name' => 'Logiciels', 'slug' => 'logiciels', 'icon' => 'fas fa-laptop-code', 'color' => '#F25022', 'description' => 'Licences logicielles'],
        ]);
    }
}
