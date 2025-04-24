<?php

namespace App\Services;

use App\Models\Pricing;
use App\Repositories\PricingRepository;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\PricingRepositoryInterface;

class PricingService {
    
    protected $pricingrepository;
    protected $model;

    public function __construct(PricingRepositoryInterface $pricingrepository, Pricing $model)
    {
        $this->pricingrepository = $pricingrepository;
        $this->model = $model;
    }

    public function getAllPackages()
    {
        return $this->pricingrepository->getAll();
    }

    public function getPricingWithPost($id)
{
    return $this->pricingrepository->findWithPostById($id);
}

}