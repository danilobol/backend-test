<?php

namespace App\Services\Contracts;

interface ITransactionService {
    public function createNewTransaction(
        string $type,
        string $transaction_date,
        float $amount,
        int $investment_id,
        int $user_id
    );
    public function getUserTransactionsByInvestmentId(
        int $userId,
        int $investmentId,
        int $rowPerPage,
        int $page);

    public function calculateViewOfAnInvestmentWithExpectedBalance(
        int $userId,
        int $investment_id
    );
}
