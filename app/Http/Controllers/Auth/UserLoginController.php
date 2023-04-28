<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Repositories\AuthRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserLoginController extends Controller
{
    use GlobalTrait;

    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UserLoginRequest $request)
    {
        $userData = $this->getAttribute($request);
        try {
            $data = $this->authRepository->login($userData);

            return $this->globalResponse(trans('messages.LOGIN_SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Login Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $request
     * @return array
     */
    private function getAttribute($request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
    }
}
