<?php

namespace App\Repositories\Transaction;


use App\Models\Transaction;
use App\Repositories\Contracts\ITransactionRepository;

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
        int $product_id
    ){
        return Transaction::create([
            'type'            => $type,
            'amount'          => $amount,
            'user_id'         => $user_id,
            'group_id'        => $group_id,
            'product_id'      => $product_id,
        ]);
    }

    public function getTotalUserBalancePerGroup(int $userId, int $groupId){
        return Transaction::query()->where('user_id','=', $userId)
            ->where('group_id','=', $groupId)
            ->sum('amount')
            ->get();
    }
}
