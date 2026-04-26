<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostService
{
    /**
     * Create a new post.
     */
    public function createPost(array $data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        
        if (isset($data['featured_image']) && $data['featured_image']) {
            $data['featured_image'] = $this->uploadAndOptimize($data['featured_image']);
        }

        $post = Post::create($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    /**
     * Update an existing post.
     */
    public function updatePost(Post $post, array $data)
    {
        if (isset($data['title']) && $post->title !== $data['title']) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        if (isset($data['featured_image']) && $data['featured_image']) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $this->uploadAndOptimize($data['featured_image']);
        }

        $post->update($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    /**
     * Generate a unique slug for the post.
     */
    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Post::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }

    /**
     * Upload and optimize featured image.
     */
    protected function uploadAndOptimize($file)
    {
        // For basic demonstration, we use store. 
        // Optimization requires Intervention Image to be fully configured with drivers.
        // If driver is missing, it falls back to standard upload.
        try {
            $manager = new ImageManager(new Driver());
            $filename = time() . '_' . Str::random(10) . '.webp';
            $path = 'posts/' . $filename;

            $image = $manager->read($file);
            $image->scale(width: 1200);
            
            Storage::disk('public')->put($path, (string) $image->encodeByWebp(80));
            return $path;
        } catch (\Exception $e) {
            // Fallback to standard Laravel upload if Intervention fails
            return $file->store('posts', 'public');
        }
    }
}
