<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forgot\ForgotPasswordRequest;
use App\Repositories\EmailRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PasswordForgotController extends Controller
{
    use GlobalTrait;

    private $emailRepository;

    public function __construct(EmailRepository $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $email = $request->input('email');

        try {
            $this->emailRepository->forgotMyPassword($email);

            return $this->globalResponse(trans('messages.RESET_PASSWORD_PIN'), ResponseAlias::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('forgot password Exception : ' . $exception->getMessage());

            return $this->globalResponse($exception->getMessage(), $exception->getCode());
        }
    }
}



