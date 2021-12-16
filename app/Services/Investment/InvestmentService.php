<?php

namespace App\Services\Investment;


use App\Repositories\Contracts\IInvestmentRepository;
use App\Repositories\Contracts\ITransactionRepository;
use App\Services\Contracts\IInvestmentService;


class InvestmentService implements IInvestmentService
{
    protected $investmentRepository;
    protected $transactionRepository;

    public function __construct(
        IInvestmentRepository $investmentRepository,
        ITransactionRepository $transactionRepository
    )
    {
        $this->investmentRepository = $investmentRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function createNewInvestment(?string $name, int $user_id, float $amount, string $date_investment){
        $this->checkIfCurrentDateIsLessDateInvestment($date_investment);
        $investment = $this->investmentRepository->createNewInvestment($name, $user_id, $date_investment);
        $this->transactionRepository->createNewTransaction('invest', $date_investment, $amount, $investment->id, $user_id);
        return $investment;
    }

    public function getInvestmentById(int $investmentId){
        return $this->investmentRepository->getInvestment($investmentId);
    }

    public function getInvestmentsByUserId(int $userId)
    {
        return $this->investmentRepository->getInvestmentsByUserId($userId);
    }

    public function checkIfInvestmentIsFromUser(int $user_id, int $investmentId):void{
        $investment = $this->investmentRepository->findUserInvestmentById($user_id, $investmentId);
        if (!$investment){
            throw new \InvalidArgumentException('You are not allowed to see other investments!');
        }
    }

    private function checkIfCurrentDateIsLessDateInvestment(string $date_investment):void{
        $currentDate = date('Y-m-d H:i:s');
        if ($date_investment > $currentDate){
            throw new \InvalidArgumentException('You cannot make an investment at a date in the future!');
        }
    }

}
