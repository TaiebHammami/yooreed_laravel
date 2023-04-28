<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\AuthRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserGetController extends Controller
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
    public function __invoke($userId)
    {
        try {
           $data =  $this->authRepository->getUser($userId);

            return $this->globalResponse(trans('messages.SUCCES'), Response::HTTP_OK,$data);
        } catch (Exception $exception) {
            Log::error('Get user Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
