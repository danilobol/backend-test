<?php

namespace App\Http\Controllers;

use App\Helpers\Errors\ServerErrors;
use App\Services\Contracts\ITransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(ITransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @OA\Post(
     *     path="/api/transaction/new",
     *     tags={"Transaction"},
     *     summary="Create a new transaction",
     *     operationId="createANewTransaction",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="type", type="string", example="invest", description="types: invest / withdraw"),
     *          @OA\Property(property="amount", type="number", example="3000.00"),
     *          @OA\Property(property="investment_id", type="integer"),
     *          @OA\Property(property="transaction_date", type="string", example="2021-12-16 06:51:44"),
     *          )
     *     ),
     *     security={{"BearerAuth":{}}}
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $type = $request->get('type') ?: 'invest';
            $amount = $request->get('amount') ?: 'invest';
            $investment_id = $request->get('investment_id') ?: null;
            $transaction_date = $request->get('transaction_date') ?: date('Y-m-d H:i:s');
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            return response()->json($this->transactionService->createNewTransaction(
                $type,
                $transaction_date,
                $amount,
                $investment_id,
                $user->id
            ));
        }catch (\Exception $e)
        {
            return response()->json([
                'message' => ServerErrors::getError(ServerErrors::ERROR_1001),
                'code' => ServerErrors::ERROR_1001,
                'error' => $e->getMessage()
            ], 403);
        }

    }

    /**
     * @OA\Get(
     *     path="/api/transaction/show",
     *     tags={"Transaction"},
     *     summary="Show User Transactions by Investment Investment",
     *     operationId="showUserTransactions",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Parameter(in="query", name="investmentId", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="rowPerPage", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="page", required=false, @OA\Schema(type="integer")),
     *     security={{"BearerAuth":{}}}
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $investmentId = $request->input('investmentId') !== null ? $request->input('investmentId') : null;
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            $rowPerPage = $request->input('rowPerPage') !== null ? $request->input('rowPerPage') : 10;
            $page = $request->input('page') !== null ? $request->input('page') : 1;
            return response()->json($this->transactionService->getUserTransactionsByinvestmentId($user->id, $investmentId, $rowPerPage, $page));
        }catch (\Exception $e)
        {
            return response()->json([
                'message' => ServerErrors::getError(ServerErrors::ERROR_1001),
                'code' => ServerErrors::ERROR_1001,
                'error' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/transaction/expected-balance",
     *     tags={"Transaction"},
     *     summary="Show User expected balance by Investment Investment",
     *     operationId="showUserExpectedBalance",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Parameter(in="query", name="investmentId", required=true, @OA\Schema(type="integer")),
     *     security={{"BearerAuth":{}}}
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showExpectedBalance(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $investmentId = $request->input('investmentId') !== null ? $request->input('investmentId') : null;
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            return response()->json($this->transactionService->calculateViewOfAnInvestmentWithExpectedBalance($user->id, $investmentId));
        }catch (\Exception $e)
        {
            return response()->json([
                'message' => ServerErrors::getError(ServerErrors::ERROR_1001),
                'code' => ServerErrors::ERROR_1001,
                'error' => $e->getMessage()
            ], 403);
        }
    }
}
