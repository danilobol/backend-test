<?php

namespace App\Services\Transaction;


use App\Repositories\Contracts\ITransactionRepository;
use App\Services\Contracts\ITransactionService;
use DateTime;

/**
 * Class UserRepository.
 */
class TransactionService implements ITransactionService
{
    private $percentageEarnings = 0.52;

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
        ? int $product_id
    ){
        if ($type == 'withdraw') {
            $this->checkTheTimeToWithdraw($user_id, $group_id);
            $this->checkIfBalanceIsEnough($user_id, $group_id, $amount);
        }
        return $this->transactionRepository->createNewTransaction(
            $type,
            $amount,
            $user_id,
            $group_id,
            $product_id
        );
    }

    public function getUserTransactionsByGroupId(
        int $userId,
        int $groupId,
        int $rowPerPage,
        int $page)
    {
        return $this->transactionRepository->detailedStatementOfTransactionsPerGroup(
            $userId,
            $groupId,
            $rowPerPage,
            $page
        );
    }

    //pog alert! Sorry ='(
    //desculpa por esse erro grotesco a seguir, fiquei sem tempo de limpar o codigo...
    public function viewOfAnInvestmentWithExpectedBalance(int $userId, int $groupId){
        $daysProfit = $this->checkLastDataOfProfit($userId, $groupId);
        $partialProfitInvestedAmount = 0;
        $investmentMonths = $this->getInvestmentMonthInterval($userId, $groupId);
        $investedAmount = $this->getTotalUserBalancePerGroup($userId, $groupId);
        if ($daysProfit >0) {
            $partialProfitInvestedAmount = $this->getPartialProfitInvestedAmount($investmentMonths, $investedAmount->invested_amount);
            if ($partialProfitInvestedAmount > 0)
                $this->createNewTransaction(
                    'profit',
                    $partialProfitInvestedAmount,
                    $userId,
                    $groupId,
                    null);
        }
        $investedAmount->invested_amount = $investedAmount->invested_amount + $partialProfitInvestedAmount;
        return $investedAmount;
    }

    private function getTotalUserBalancePerGroup(int $userId, int $groupId){
        return $this->transactionRepository->getTotalUserBalancePerGroup(
            $userId,
            $groupId
        );
    }

    private function getInvestmentMonthInterval(int $userId, int $groupId): int
    {
        $dataFirstInvestment = $this->transactionRepository->getFirstInvestmentDatePerGroup(
            $userId,
            $groupId
        );
        $currentDate = new DateTime();
        $createdDate = new DateTime();
        $createdDate->modify($dataFirstInvestment->created_at);
        $interval = $currentDate->diff($createdDate);
        return ($interval->m);
    }

    private function checkTheTimeToWithdraw(int $user_id, int $group_id) : void
    {
        $investmentMonths = $this->getInvestmentMonthInterval($user_id, $group_id);
        if ($investmentMonths < 1)
            throw new \InvalidArgumentException('This investment does not have time to withdraw!');
    }

    private function getPartialProfitInvestedAmount(int $months, float $amount){
        $partialProfit = ($amount * $this->percentageEarnings)/100;
        return $partialProfit * $months;
    }

    private function checkIfBalanceIsEnough(int $user_id, int $group_id, float $amount){
        $currentBalance = $this->viewOfAnInvestmentWithExpectedBalance($user_id, $group_id);
        if($currentBalance->invested_amount < $amount)
            throw new \InvalidArgumentException('This investment does not have time to withdraw!');
    }

    private function checkLastDataOfProfit(int $user_id, int $group_id): int
    {
        $dateProfit = $this->transactionRepository->getLastDateOfInvestedAmountOfProfit($user_id, $group_id);
        $currentDate = new DateTime();
        $createdDate = new DateTime();
        $createdDate->modify($dateProfit->created_at);
        $interval = $currentDate->diff($createdDate);
        return ($interval->m);
    }

}
