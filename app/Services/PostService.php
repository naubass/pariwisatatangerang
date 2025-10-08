<?php

namespace App\Services;


use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Repositories\PostRepositoryInterface;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    
    
    
    public function enroll(Post $post)
    {
        $user = User::Auth();
        
        if(!$post->postUsers()->where('user_id', $user->id)->exist()) {
            $post->postUsers()->create([ 
                'user_id' => $user->id,
                'is_active' => true,
            ]); 
        }
    }
    
    public function groupByPostCategory(?string $categorySlug = null): Collection
    {
        $posts = $this->postRepository->getAllWithCategory();

        // Kelompokkan dulu berdasarkan kategori
        $grouped = $posts->groupBy(function ($post) {
            return $post->category->name ?? 'Uncategorized';
        });

        // Jika ada slug, filter hanya grup yang cocok
        if ($categorySlug) {
            return $grouped->filter(function ($posts, $categoryName) use ($categorySlug) {
                return Str::slug($categoryName) === $categorySlug;
            });
        }

        return $grouped;
    }

    public function searchPosts(string $keyword)
    {
        return $this->postRepository->searchByKeyword($keyword);
    }

    public function getPostTestimonials(Post $post)
    {
        return $post->testimonials()->get();
    }

}