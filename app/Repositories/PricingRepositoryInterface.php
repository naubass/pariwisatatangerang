<?php

namespace App\Repositories;

use App\Models\Pricing;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

interface PricingRepositoryInterface
{
    public function findById(int $id): ?Pricing;

    public function getAll(): Collection;

    public function findWithPostById(int $id): ?Pricing;
}
