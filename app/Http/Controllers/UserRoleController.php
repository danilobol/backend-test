<?php

namespace App\Http\Controllers;

use App\Helpers\Errors\ServerErrors;
use App\Services\Contracts\IUserRoleService;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    protected $userRoleService;

    public function __construct(IUserRoleService $userRoleService)
    {
        $this->userRoleService = $userRoleService;
    }

    /**
     * @OA\Post(
     *   path="/api/admin/user-role/add",
     *   tags={"Admin"},
     *   summary="Add User Role",
     *   operationId="addUserRole",
     *   @OA\Response(
     *       response=200,
     *       description="successful operation",
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="user_id", type="string"),
     *         @OA\Property(property="role_id", type="integer"),
     *      )
     *   ),
     *   security={{"BearerAuth":{}}}
     * )
     */
    public function addUserRole(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = (object)$request->only([
                'user_id',
                'role_id'
            ]);
            $user = auth()->user();
            return response()->json([$this->userRoleService->createUserRole($data->user_id, $data->role_id, $user->id)]);
        }catch (\Exception $e){
            return response()->json([
                'message' => ServerErrors::getError(ServerErrors::ERROR_1012),
                'code' => ServerErrors::ERROR_1012,
                'error' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/admin/user-role/remove",
     *   tags={"Admin"},
     *   summary="Remove User Role",
     *   operationId="removeUserRole",
     *   @OA\Response(
     *       response=200,
     *       description="successful operation",
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="user_id", type="string"),
     *         @OA\Property(property="role_id", type="integer"),
     *      )
     *   ),
     *   security={{"BearerAuth":{}}}
     * )
     */
    public function removeUserRole(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = (object)$request->only([
                'user_id',
                'role_id'
            ]);
            return response()->json([$this->userRoleService->removeUserRole($data->user_id, $data->role_id)]);
        }catch (\Exception $e){
            return response()->json([
                'message' => ServerErrors::getError(ServerErrors::ERROR_1012),
                'code' => ServerErrors::ERROR_1012,
                'error' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * @OA\Get(
     *   path="/api/admin/user-role/list",
     *   tags={"Admin"},
     *   summary="Get users Roles",
     *   operationId="getUsersRoles",
     *   @OA\Response(
     *       response=200,
     *       description="successful operation",
     *   ),
     *   security={{"BearerAuth":{}}}
     * )
     */
    public function getUserRoles(): \Illuminate\Http\JsonResponse
    {
        try{
            return response()->json([$this->userRoleService->getAllUsersRole()]);
        }catch (\Exception $e){
            return response()->json([
                'message' => ServerErrors::getError(ServerErrors::ERROR_1012),
                'code' => ServerErrors::ERROR_1012,
                'error' => $e->getMessage()
            ], 403);
        }
    }

}
