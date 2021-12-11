<?php

namespace App\Services\Product;


use App\Repositories\Contracts\IProductRepository;
use App\Services\Contracts\IProductService;

class ProductService implements IProductService
{
    protected $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(
        int $institution_id,
        string $name,
        ?string $description,
        string $financial_index,
        float $interest_rate
    ){
        return $this->productRepository->createProduct(
            $institution_id,
            $name, $description,
            $financial_index,
            $interest_rate
        );
    }

    public function getProductById(int $productId){
        return $this->productRepository->getProductById($productId);
    }

    public function getAllProducts(){
        return $this->productRepository->getAllProducts();
    }
}
