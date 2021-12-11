<?php

namespace App\Http\Controllers;

use App\Helpers\Errors\ServerErrors;
use App\Services\Contracts\IGroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected $groupService;
    public function __construct(IGroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * @OA\Post(
     *     path="/api/group/create",
     *     tags={"Group"},
     *     summary="Criar novos grupos",
     *     operationId="createGroup",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="name", type="string"),
     *          @OA\Property(property="institutions_id", type="integer"),
     *          @OA\Property(property="amount", type="number"),
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
            $institutions_id = $request->get('institutions_id') ?: null;
            $amount = $request->get('amount') ?: null;
            $user = (object)$data->userData->userInfo;
            return response()->json($this->groupService->createNewGroup($name, $institutions_id, $user->id, $amount));
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
     *     path="/api/group/show",
     *     tags={"Group"},
     *     summary="Listar grupos pelo id!",
     *     operationId="showGroup",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Parameter(in="query", name="groupId", required=false, @OA\Schema(type="string")),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $groupId = $request->input('groupId') !== null ? $request->input('groupId') : null;
            return response()->json($this->groupService->getGroup($groupId));
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
     *     path="/api/group/my-group-show",
     *     tags={"Group"},
     *     summary="Lista de grupos que o usuário é proprietário",
     *     operationId="getOwnerGroup",
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
    public function showOwnerGroup(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            return response()->json($this->groupService->getOwnerUserGroups($user->id));
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
