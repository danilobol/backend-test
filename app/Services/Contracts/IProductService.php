<?php

namespace App\Services\Contracts;

interface IProductService {
    public function createProduct(
        int $institution_id,
        string $name,
        ?string $description,
        string $financial_index,
        float $interest_rate
    );
    public function getProductById(int $productId);
    public function getAllProducts();
}
