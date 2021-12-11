<?php

namespace App\Http\Controllers;

use App\Helpers\Errors\ServerErrors;
use App\Services\Contracts\IInstitutionService;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    protected $institutionService;

    public function __construct(IInstitutionService $institutionService)
    {
        $this->institutionService = $institutionService;
    }

    /**
     * @OA\Post(
     *     path="/api/institution/create",
     *     tags={"Institution"},
     *     summary="Create a new institution",
     *     operationId="createANewInstitution",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="name", type="string"),
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
            $name = $request->get('name') ?: null;
            return response()->json($this->institutionService->createInstitution($name));
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
     *     path="/api/institution/show/{id}",
     *     tags={"Institution"},
     *     summary="show institution by id",
     *     operationId="showInstitutionById",
     *     @OA\Parameter(
     *          name="id",
     *          description="Institution id",
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
            return response()->json($this->institutionService->getInstitution($id));
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
     *     path="/api/institution/all",
     *     tags={"Institution"},
     *     summary="show institution all",
     *     operationId="showInstitutionAll",
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
            return response()->json($this->institutionService->getAllInstitutions());
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
