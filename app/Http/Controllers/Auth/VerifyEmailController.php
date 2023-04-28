<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forgot\emailVerifyRequest;
use App\Repositories\EmailRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class VerifyEmailController extends Controller
{

    use GlobalTrait;

    private $emailRepository;

    public function __construct(EmailRepository $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    /**
     * @param EmailVerifyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(EmailVerifyRequest $request)
    {
        $requestPin = $request->input('pin');

        try {
            $data = $this->emailRepository->verifyMyEmail($requestPin);

            return $this->globalResponse(trans('messages.VERIFIED'), Response::HTTP_OK, $data);

        } catch (Exception $exception) {
            DB::rollBack();
            return $this->globalResponse($exception->getMessage(), $exception->getCode());
        }


    }
}
