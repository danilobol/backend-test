<?php

namespace App\Repositories\Contracts;

interface IInvestmentRepository {
    public function createNewInvestment(?string $name, int $user_id, string $date_investment);
    public function getInvestment(int $investmentId);
    public function getInvestmentsByUserId(int $userId);
    public function findUserInvestmentById(int $userId, int $investmentId);
}
