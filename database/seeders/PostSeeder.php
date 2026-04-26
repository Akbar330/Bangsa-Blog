<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $categories = Category::all();
        
        // Buat beberapa tag dulu kalau belum ada
        $tagNames = ['Laravel', 'Tutorial', 'Viral', 'Update', 'Tips'];
        foreach ($tagNames as $name) {
            Tag::firstOrCreate(['name' => $name, 'slug' => Str::slug($name)]);
        }
        $tags = Tag::all();

        if ($categories->isEmpty()) return;

        $dummyPosts = [
            ['title' => 'Revolusi AI: Bagaimana ChatGPT Mengubah Cara Kita Bekerja', 'cat' => 'Teknologi'],
            ['title' => '10 Destinasi Wisata Tersembunyi di Bali yang Wajib Dikunjungi', 'cat' => 'Lifestyle'],
            ['title' => 'Strategi Investasi Crypto di Tahun 2026 untuk Pemula', 'cat' => 'Teknologi'],
            ['title' => 'Resep Rahasia Sambal Bawang yang Awet Tahan Lama', 'cat' => 'Lifestyle'],
            ['title' => 'Analisis Politik: Menakar Peluang Koalisi di Pemilu Mendatang', 'cat' => 'Politik'],
            ['title' => 'Cara Meningkatkan Performa Website Laravel hingga 2x Lipat', 'cat' => 'Teknologi'],
            ['title' => 'Mengenal Diet Intermittent Fasting: Manfaat dan Risikonya', 'cat' => 'Lifestyle'],
            ['title' => 'Laporan Khusus: Kondisi Terkini Stadion Kebanggaan Kita', 'cat' => 'Olahraga'],
        ];

        foreach ($dummyPosts as $d) {
            $category = $categories->where('name', $d['cat'])->first() ?? $categories->random();

            $post = Post::create([
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'title' => $d['title'],
                'slug' => Str::slug($d['title']) . '-' . rand(1, 100),
                'content' => "Ini adalah konten lengkap untuk artikel berjudul " . $d['title'] . ".\n\nKonten ini disusun untuk mensimulasikan sistem portal berita profesional. Dalam dunia nyata, bagian ini akan diisi dengan narasi berita yang mendalam, kutipan narasumber, dan opini editor.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                'excerpt' => 'Pelajari lebih lanjut tentang ' . $d['title'] . ' dalam artikel mendalam ini.',
                'status' => 'published',
                'published_at' => now(),
                'views_count' => rand(100, 9999),
                'is_featured' => rand(0, 1),
            ]);

            // Pasang 2 tag acak ke artikel
            $post->tags()->sync($tags->random(2)->pluck('id'));
        }
    }
}
