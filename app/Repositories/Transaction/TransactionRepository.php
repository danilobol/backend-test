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
        float $amount,
        int $user_id,
        int $group_id,
        ? int $product_id
    ){
        return Transaction::create([
            'type'            => $type,
            'amount'          => $amount,
            'user_id'         => $user_id,
            'group_id'        => $group_id,
            'product_id'      => $product_id,
        ]);
    }

    public function detailedStatementOfTransactionsPerGroup(
        int $userId,
        int $groupId,
        int $rowPerPage,
        int $page
    ){
        return Transaction::query()->where('user_id','=', $userId)
            ->where('group_id','=', $groupId)
            ->paginate($rowPerPage);
    }

    public function getFirstInvestmentDatePerGroup(int $userId, int $groupId){
        return Transaction::query()->where('user_id','=', $userId)
            ->where('group_id','=', $groupId)
            ->select('created_at')
            ->orderBy('created_at', 'ASC')
            ->first();
    }

    public function getTotalUserBalancePerGroup(int $userId, int $groupId){
        return Transaction::query()->where('user_id','=', $userId)
            ->where('group_id','=', $groupId)
            ->select(
                DB::raw("
                    group_id,
                    SUM(IF(type IN ('invest', 'profit'), amount, amount * -1)) as invested_amount
                ")
            )
            ->groupBy('group_id')
            ->first();
    }

    public function getLastDateOfInvestedAmountOfProfit(int $userId, int $groupId){
        return Transaction::query()->where('user_id','=', $userId)
            ->where('group_id','=', $groupId)
            ->where('type', '=', 'profit')
            ->select('created_at')
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}
