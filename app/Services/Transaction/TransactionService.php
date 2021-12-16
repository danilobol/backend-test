<?php

namespace App\Services\Transaction;


use App\Repositories\Contracts\IInvestmentRepository;
use App\Repositories\Contracts\ITransactionRepository;
use App\Services\Contracts\IInvestmentService;
use App\Services\Contracts\ITransactionService;
use DateTime;

/**
 * Class UserRepository.
 */
class TransactionService implements ITransactionService
{
    private $percentageEarnings = 0.52;

    protected $transactionRepository;
    protected $investmentService;

    public function __construct(
        ITransactionRepository $transactionRepository,
        IInvestmentService $investmentService
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->investmentService =$investmentService;
    }

    public function createNewTransaction(
        string $type,
        string $transaction_date,
        float $amount,
        int $investment_id,
        int $user_id
    ){
        $this->checkUserOwnsTheInvestment($user_id, $investment_id);
        if ($type == 'withdraw') {
            $this->checkTheTimeToWithdraw($user_id, $investment_id);
            $this->checkIfBalanceIsEnough($user_id, $investment_id, $amount);
        }
        return $this->transactionRepository->createNewTransaction(
            $type,
            $transaction_date,
            $amount,
            $investment_id
        );
    }

    public function getUserTransactionsByInvestmentId(
        int $userId,
        int $investmentId,
        int $rowPerPage,
        int $page)
    {
        $this->checkUserOwnsTheInvestment($userId, $investmentId);
        return $this->transactionRepository->detailedStatementOfTransactionsPerInvestment(
            $investmentId,
            $rowPerPage,
            $page
        );
    }

    //pog alert! Sorry ='(
    //From here I set fire to the Clean Code book
    public function calculateViewOfAnInvestmentWithExpectedBalance(
        int $userId,
        int $investment_id
    ){
        $this->checkUserOwnsTheInvestment($userId, $investment_id);
        $daysProfit = $this->intervalLastDataOfProfit($investment_id);
        if ($daysProfit >0 || $daysProfit < 0) {
            $partialProfitInvestedAmount = $this->calculateInvestmentProfits($investment_id);
            $this->createNewTransaction(
                'profit',
                date('Y-m-d H:i:s'),
                $partialProfitInvestedAmount,
                $investment_id,
                $userId);
        }

        return $this->transactionRepository->getTotalUserBalancePerInvestmentId($investment_id);
    }

    private function calculateInvestmentProfits(int $investment_id){
        $transactionsInvestment = $this->transactionRepository->getTransactionsByInvestments(
            $investment_id
        );
        $partialProfitInvestedAmount = 0;
        foreach ($transactionsInvestment as $transaction){
            $investmentTime = $this->getInvestmentMonthInterval($transaction->transaction_date);
            $partialProfitInvestedAmount += $this->getPartialProfitInvestedAmount($investmentTime, $transaction->amount);
        }
        return $partialProfitInvestedAmount;
    }

    private function getTotalUserBalancePerInvestment(int $userId, int $investmentId){
        return $this->transactionRepository->getTotalUserBalancePerInvestmentId(
            $userId,
            $investmentId
        );
    }

    private function getInvestmentMonthInterval(string $dateInvestment): int
    {
        $currentDate = new DateTime();
        $createdDate = new DateTime();
        $createdDate->modify($dateInvestment);
        $interval = $currentDate->diff($createdDate);
        return ($interval->m);
    }

    private function checkTheTimeToWithdraw(int $user_id, int $investment_id) : void
    {
        $investmentMonths = $this->getInvestmentMonthInterval($user_id, $investment_id);
        if ($investmentMonths < 1)
            throw new \InvalidArgumentException('This investment does not have time to withdraw!');
    }

    private function getPartialProfitInvestedAmount(int $months, float $amount){
        $partialProfit = ($amount * $this->percentageEarnings)/100;
        return $partialProfit * $months;
    }

    private function checkIfBalanceIsEnough(int $user_id, int $investment_id, float $amount){
        $currentBalance = $this->calculateViewOfAnInvestmentWithExpectedBalance($user_id, $investment_id);
        if($currentBalance->invested_amount < $amount)
            throw new \InvalidArgumentException('This investment does not have time to withdraw!');
    }

    private function intervalLastDataOfProfit(int $investment_id): int
    {
        $dateProfit = $this->getLastDateOfInvestedAmountOfProfit($investment_id);
        if (!$dateProfit) return -1;
        $currentDate = new DateTime();
        $transactionDate = new DateTime();
        $transactionDate->modify($dateProfit);
        $interval = $currentDate->diff($transactionDate);
        return ($interval->m);
    }

    private function checkUserOwnsTheInvestment(int $user_id, int $investment_id){
        $this->investmentService->checkIfInvestmentIsFromUser($user_id, $investment_id);
    }

    private function getLastDateOfInvestedAmountOfProfit(int $investment_id){
        $dateProfit = $this->transactionRepository->getLastDateOfInvestedAmountOfProfit($investment_id);
        if ($dateProfit)
            return $dateProfit->transaction_date;
        return null;
    }

}
