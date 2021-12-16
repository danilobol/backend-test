<?php

namespace App\Services\Contracts;

interface IInvestmentService {
    public function createNewInvestment(?string $name, int $user_id, float $amount, string $date_investment);
    public function getInvestmentById(int $investmentId);
    public function getInvestmentsByUserId(int $userId);
    public function checkIfInvestmentIsFromUser(int $user_id, int $investmentId):void;
}
