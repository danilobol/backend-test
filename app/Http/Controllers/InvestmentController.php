<?php

namespace App\Http\Controllers;

use App\Helpers\Errors\ServerErrors;
use App\Services\Contracts\IInvestmentService;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    protected $investmentService;
    public function __construct(IInvestmentService $investmentService)
    {
        $this->investmentService = $investmentService;
    }

    /**
     * @OA\Post(
     *     path="/api/investment/create",
     *     tags={"Investment"},
     *     summary="Create new investment",
     *     operationId="createInvestment",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="name", type="string", example="Investimentos BB"),
     *          @OA\Property(property="date_investment", type="string", example="2021-12-16 06:51:44"),
     *          @OA\Property(property="amount", type="number", example="3000.00"),
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
            $data = (object)$request->only([
                'userData'
            ]);
            $name = $request->get('name') ?: null;
            $date_investment = $request->get('date_investment') ?: date('Y-m-d H:i:s');
            $amount = $request->get('amount') ?: null;
            $user = (object)$data->userData->userInfo;
            return response()->json($this->investmentService->createNewInvestment($name, $user->id, $amount, $date_investment));
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
     *     path="/api/investment/show",
     *     tags={"Investment"},
     *     summary="show investment by id!",
     *     operationId="showInvestment",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Parameter(in="query", name="investmentId", required=false, @OA\Schema(type="integer")),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $investmentId = $request->input('investmentId') !== null ? $request->input('investmentId') : null;
            return response()->json($this->investmentService->getInvestmentById($investmentId));
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
     *     path="/api/investment/my-investment-show",
     *     tags={"Investment"},
     *     summary="show my investments",
     *     operationId="getOwnerInvestment",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     security={{"BearerAuth":{}}}
     *
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showOwnerInvestment(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            return response()->json($this->investmentService->getInvestmentsByUserId($user->id));
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
