<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forgot\VerifyPinRequest;
use App\Repositories\EmailRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PasswordVerifyPinController extends Controller
{
    use GlobalTrait;

    private $emialRepository;

    public function __construct(EmailRepository $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    /**
     * @param VerifyPinRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(VerifyPinRequest $request)
    {
        $userData = $this->getAttributes($request);
        try {
            $this->emailRepository->verifyMyPin($userData);

            return $this->globalResponse(trans('messages.VERIFIED_PIN'), Response::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->globalResponse($exception->getMessage(), $exception->getCode());
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
            'pin' => $request->input('pin')
        ];
    }

}
