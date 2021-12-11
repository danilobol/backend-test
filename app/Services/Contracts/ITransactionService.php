<?php

namespace App\Services\Contracts;

interface ITransactionService {
    public function createNewTransaction(
        string $type,
        float $amount,
        int $user_id,
        int $group_id,
        int $product_id
    );
    public function getTotalUserBalancePerGroup(int $userId, int $groupId);
}
