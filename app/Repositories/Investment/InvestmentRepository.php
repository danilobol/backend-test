<?php

namespace App\Repositories\Investment;


use App\Models\Investment;
use App\Repositories\Contracts\IInvestmentRepository;


class InvestmentRepository implements IInvestmentRepository
{
    public function createNewInvestment(?string $name, int $user_id, string $date_investment){
        return Investment::create([
            'name'             => $name,
            'user_id'          => $user_id,
            'investment_creation'  => $date_investment,
        ]);
    }

    public function getInvestment(int $investmentId){
        return Investment::query()->where('id','=', $investmentId)
            ->with('transactions')
            ->first();
    }

    public function getInvestmentsByUserId(int $userId){
        return Investment::query()->where('user_id', '=', $userId)
            ->with('transactions')
            ->get();
    }

    public function findUserInvestmentById(int $userId, int $investmentId){
        return Investment::query()->where('id', '=', $investmentId)
            ->where('user_id', '=', $userId)
            ->with('transactions')
            ->first();
    }
}
