<?php

namespace App\Http\Controllers;

use App\Helpers\Errors\ServerErrors;
use App\Services\Contracts\IProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Post(
     *     path="/api/institution/product/create",
     *     tags={"Institution"},
     *     summary="Create a new institution product",
     *     operationId="createNewInstitutionProduct",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="institution_id", type="integer"),
     *          @OA\Property(property="name", type="string"),
     *          @OA\Property(property="description", type="string"),
     *          @OA\Property(property="financial_index", type="string"),
     *          @OA\Property(property="interest_rate", type="number"),
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
            $institution_id = $request->get('institution_id') ?: null;
            $name = $request->get('name') ?: null;
            $description = $request->get('description') ?: null;
            $financial_index = $request->get('financial_index') ?: null;
            $interest_rate = $request->get('interest_rate') ?: null;
            return response()->json($this->productService->createProduct(
                $institution_id,
                $name,
                $description,
                $financial_index,
                $interest_rate
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
     * @OA\Get (
     *     path="/api/institution/product/show/{id}",
     *     tags={"Institution"},
     *     summary="show product by id",
     *     operationId="showProductById",
     *     @OA\Parameter(
     *          name="id",
     *          description="product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *
     * )
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($this->productService->getProductById($id));
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
     * @OA\Get (
     *     path="/api/institution/product/all",
     *     tags={"Institution"},
     *     summary="show product all",
     *     operationId="showProductAll",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($this->productService->getAllProducts());
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
