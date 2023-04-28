<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\AuthRepository;
use App\Traits\GlobalTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class UserLogoutController extends Controller
{
    use GlobalTrait;

    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        try {
            $this->authRepository->logout();

            return $this->globalResponse(trans('messages.LOGOUT'), Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error('Logout Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
