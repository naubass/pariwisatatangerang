<?php

namespace App\Repositories;

use App\Models\Pricing;
use Illuminate\Support\Collection;

class PricingRepository implements PricingRepositoryInterface
{
    protected $model;

    public function __construct(Pricing $model)
    {
        $this->model = $model;
    }

    public function findById(int $id): ?Pricing
    {
        return $this->model->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function findWithPostById(int $id): ?Pricing
    {
        return $this->model->with('post')->find($id);
    }
}
