<?php

namespace App\Http\Controllers;

use App\Helpers\Errors\ServerErrors;
use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     summary="Registro de novos usuarios",
     *     operationId="registerUser",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="email", type="string", example="danilo@coderockr.com"),
     *          @OA\Property(property="name", type="string", example="Danilo"),
     *          @OA\Property(property="password", type="string", example="123456"),
     *          )
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = (object)$request->only([
                'email',
                'name',
                'password'
            ]);

            return response()->json($this->userService->registerUser($user->email, $user->name, $user->password));
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
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login usuarios",
     *     operationId="loginUser",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="email", type="string", example="danilo@coderockr.com"),
     *          @OA\Property(property="password", type="string", example="123456"),
     *          )
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = (object)$request->only([
                'email',
                'password'
            ]);

            return response()->json($this->userService->loginUser($user->email, $user->password));
        }catch (\Exception $e)
        {
            return response()->json([
                'message' => ServerErrors::getError(ServerErrors::ERROR_1002),
                'code' => ServerErrors::ERROR_1002,
                'error' => $e->getMessage()
            ], 403);
        }

    }
}
