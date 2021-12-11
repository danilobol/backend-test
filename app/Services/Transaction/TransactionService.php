<?php

namespace App\Services\Transaction;


use App\Repositories\Contracts\ITransactionRepository;
use App\Services\Contracts\ITransactionService;

/**
 * Class UserRepository.
 */
class TransactionService implements ITransactionService
{
    protected $transactionRepository;

    public function __construct(ITransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function createNewTransaction(
        string $type,
        float $amount,
        int $user_id,
        int $group_id,
        int $product_id
    ){
        return $this->transactionRepository->createNewTransaction(
            $type,
            $amount,
            $user_id,
            $group_id,
            $product_id
        );
    }

    public function getTotalUserBalancePerGroup(int $userId, int $groupId){
        return $this->transactionRepository->getTotalUserBalancePerGroup(
            $userId,
            $groupId
        );
    }
}
