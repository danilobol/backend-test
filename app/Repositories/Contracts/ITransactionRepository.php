<?php

namespace App\Repositories\Contracts;

interface ITransactionRepository {
    public function createNewTransaction(
        string $type,
        string $transaction_date,
        float $amount,
        int $investment_id
    );
    public function detailedStatementOfTransactionsPerInvestment(
        int $investmentId,
        int $rowPerPage,
        int $page
    );
    public function getTransactionsByInvestments(int $investmentId);
    public function getTotalUserBalancePerInvestmentId(int $investmentId);
    public function getLastDateOfInvestedAmountOfProfit(int $investment_id);
}
