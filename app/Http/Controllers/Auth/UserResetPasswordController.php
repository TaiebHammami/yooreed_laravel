<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserResetPasswordRequest;
use App\Repositories\AuthRepository;
use App\Traits\GlobalTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class UserResetPasswordController extends Controller
{
    use GlobalTrait;

    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @param UserResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UserResetPasswordRequest $request)
    {
        $userData = $this->getAttributes($request);

        try {
            $data = $this->authRepository->resetPassword($userData);

            return $this->globalResponse(trans('messages.RESET_PASSWORD_SUCCESS'), Response::HTTP_OK, $data);

        } catch (Exception $exception) {
            Log::error('Exception Reset Password : '. $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $request
     * @return array
     */
    private function getAttributes($request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
    }
}
