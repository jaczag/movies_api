<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\auth\UserLoginRequest;
use App\Http\Requests\v1\auth\UserRegisterRequest;
use App\Http\Resources\v1\UserResource;
use App\Services\Auth\v1\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param UserRegisterRequest $request
     * @param UserService $service
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request, UserService $service): JsonResponse
    {
        try {
            $service->assignData($request->validated());
            return $this->successResponse();
        } catch (Exception $e) {
            reportError($e);
        }
        return $this->errorResponse();
    }

    /**
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        $authData = $request->validated();

        try {
            if (!Auth::attempt($authData)) {
                return $this->errorResponse(
                    __('auth.failed'),
                    Response::HTTP_UNAUTHORIZED,
                );
            }

            $token = Auth::user()->createToken('auth')->plainTextToken;

            return $this->successResponse([
                'user' => UserResource::make(Auth::user()),
                'token' => $token,
            ]);
        } catch (Exception $e) {
            reportError($e);
        }
        return $this->errorResponse(__('messages.Something went wrong'));
    }
}
