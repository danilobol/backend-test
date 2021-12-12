<?php

namespace App\Repositories\Contracts;

interface ITransactionRepository {
    public function createNewTransaction(
        string $type,
        float $amount,
        int $user_id,
        int $group_id,
        ? int $product_id
    );
    public function detailedStatementOfTransactionsPerGroup(
        int $userId,
        int $groupId,
        int $rowPerPage,
        int $page
    );
    public function getFirstInvestmentDatePerGroup(int $userId, int $groupId);
    public function getTotalUserBalancePerGroup(int $userId, int $groupId);
    public function getLastDateOfInvestedAmountOfProfit(int $userId, int $groupId);
}
