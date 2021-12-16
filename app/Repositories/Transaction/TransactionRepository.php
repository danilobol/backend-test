<?php

namespace App\Repositories\Transaction;


use App\Models\Transaction;
use App\Repositories\Contracts\ITransactionRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository.
 */
class TransactionRepository implements ITransactionRepository
{
    public function createNewTransaction(
        string $type,
        string $transaction_date,
        float $amount,
        int $investment_id
    ){
        return Transaction::create([
            'type'                  => $type,
            '$transaction_date'     => $transaction_date,
            'amount'                => $amount,
            'investment_id'         => $investment_id
        ]);
    }

    public function detailedStatementOfTransactionsPerInvestment(
        int $investmentId,
        int $rowPerPage,
        int $page
    ){
        return Transaction::query()
            ->where('investment_id','=', $investmentId)
            ->with('investment')
            ->paginate($rowPerPage);
    }

    public function getTransactionsByInvestments(int $investmentId){
        return Transaction::query()
            ->where('investment_id','=', $investmentId)
            ->orderBy('transaction_date', 'ASC')
            ->get();
    }

    public function getTotalUserBalancePerInvestmentId(int $investmentId){
        return Transaction::query()
            ->where('investment_id','=', $investmentId)
            ->select(
                DB::raw("
                    investment_id,
                    SUM(IF(type IN ('invest', 'profit'), amount, amount * -1)) as invested_amount
                ")
            )
            ->groupBy('investment_id')
            ->with('investment')
            ->first();
    }

    public function getLastDateOfInvestedAmountOfProfit(int $investment_id){
        return Transaction::query()
            ->where('investment_id','=', $investment_id)
            ->where('type', '=', 'profit')
            ->select('transaction_date')
            ->orderBy('transaction_date', 'ASC')
            ->first();
    }
}
