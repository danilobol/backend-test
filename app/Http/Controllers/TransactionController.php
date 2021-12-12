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
     *          @OA\Property(property="type", type="string"),
     *          @OA\Property(property="amount", type="number"),
     *          @OA\Property(property="group_id", type="integer"),
     *          @OA\Property(property="product_id", type="integer"),
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
            $group_id = $request->get('group_id') ?: null;
            $product_id = $request->get('product_id') ?: null;
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            return response()->json($this->transactionService->createNewTransaction(
                $type,
                $amount,
                $user->id,
                $group_id,
                $product_id
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
     *     summary="Show User Transactions by Investment Group",
     *     operationId="showUserTransactions",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Parameter(in="query", name="groupId", required=true, @OA\Schema(type="integer")),
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
            $groupId = $request->input('groupId') !== null ? $request->input('groupId') : null;
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            $rowPerPage = $request->input('rowPerPage') !== null ? $request->input('rowPerPage') : 10;
            $page = $request->input('page') !== null ? $request->input('page') : 1;
            return response()->json($this->transactionService->getUserTransactionsByGroupId($user->id, $groupId, $rowPerPage, $page));
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
     *     summary="Show User expected balance by Investment Group",
     *     operationId="showUserExpectedBalance",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Parameter(in="query", name="groupId", required=true, @OA\Schema(type="integer")),
     *     security={{"BearerAuth":{}}}
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showExpectedBalance(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $groupId = $request->input('groupId') !== null ? $request->input('groupId') : null;
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            return response()->json($this->transactionService->viewOfAnInvestmentWithExpectedBalance($user->id, $groupId));
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
