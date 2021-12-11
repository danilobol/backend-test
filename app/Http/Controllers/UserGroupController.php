<?php

namespace App\Http\Controllers;

use App\Helpers\Errors\ServerErrors;
use App\Services\Contracts\IUserGroupService;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    protected $userGroupService;

    public function __construct(IUserGroupService $userGroupService)
    {
        $this->userGroupService = $userGroupService;
    }

    /**
     * @OA\Post(
     *     path="/api/group/user/add",
     *     tags={"Group"},
     *     summary="Add user to grupos",
     *     operationId="addUserToGroup",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="groupId", type="integer"),
     *          @OA\Property(property="type", type="string"),
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
            $groupId = $request->get('groupId') ?: null;
            $type = $request->get('type') ?: 'normal';
            $user = (object)$data->userData->userInfo;
            return response()->json($this->userGroupService->addUserToGroup($user->id, $groupId, $type));
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
     * @OA\Delete(
     *     path="/api/group/user/delete",
     *     tags={"Group"},
     *     summary="remove user of grupos",
     *     operationId="removeUserOfGroup",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="groupId", type="integer"),
     *          )
     *     ),
     *     security={{"BearerAuth":{}}}
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $data = (object)$request->only([
                'userData'
            ]);
            $groupId = $request->get('groupId') ?: null;
            $user = (object)$data->userData->userInfo;
            $this->userGroupService->removeUserToGroup($user->id, $groupId);
            return response()->json([
                'status' => 'success',
                'message' => 'User removed from group!',
            ]);
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
     *     path="/api/group/user/show",
     *     tags={"Group"},
     *     summary="show user grupos",
     *     operationId="showUserGroup",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     security={{"BearerAuth":{}}}
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = (object)$request->only([
                'userData'
            ]);
            $user = (object)$data->userData->userInfo;
            return response()->json($this->userGroupService->getGroupsOfUser($user->id));
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
