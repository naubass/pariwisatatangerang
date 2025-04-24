<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function searchByKeyword(string $keyword): Collection;

    public function getAllWithCategory(): Collection;

}