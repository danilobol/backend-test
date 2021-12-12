<?php

namespace App\Services\Contracts;

interface ITransactionService {
    public function createNewTransaction(
        string $type,
        float $amount,
        int $user_id,
        int $group_id,
        ? int $product_id
    );
    public function getUserTransactionsByGroupId(
        int $userId,
        int $groupId,
        int $rowPerPage,
        int $page);

    public function viewOfAnInvestmentWithExpectedBalance(int $userId, int $groupId);
}
