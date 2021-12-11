<?php

namespace App\Repositories\Product;


use App\Models\Product;
use App\Repositories\Contracts\IProductRepository;

/**
 * Class UserRepository.
 */
class ProductRepository implements IProductRepository
{
    public function createProduct(
        int $institution_id,
        string $name,
        ?string $description,
        string $financial_index,
        float $interest_rate
    ){
        return Product::create([
            'institution_id'            => $institution_id,
            'name'                      => $name,
            'description'               => $description,
            'financial_index'           => $financial_index,
            'interest_rate'             => $interest_rate,
        ]);
    }

    public function getProductById(int $productId){
        return Product::query()->where('id','=', $productId)->first();
    }

    public function getAllProducts(){
        return Product::query()->get();
    }
}
