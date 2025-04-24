<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Collection;

class PostRepository implements PostRepositoryInterface
{

    public function searchByKeyword(string $keyword): Collection
    {
        return Post::where('name', 'like', "%{$keyword}%")->get();
    }

    public function getAllWithCategory(): Collection
    {
        return Post::with('category', 'pricings')->first()->get();
    }
}
