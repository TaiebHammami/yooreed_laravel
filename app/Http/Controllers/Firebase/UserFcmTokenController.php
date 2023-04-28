<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Firebase\FcmTokenRequest;
use App\Models\FirebaseToken;
use App\Repositories\FirebaseRepository;
use App\Repositories\Notification;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserFcmTokenController extends Controller
{
    use GlobalTrait;

    private $firebaseToken;


    public function __construct(FirebaseRepository $firebaseToken)
    {
        $this->firebaseToken = $firebaseToken;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(FcmTokenRequest $request)
    {
        $userData = $this->getAttributes($request);

        try {
            $data = $this->firebaseToken->createUserToken($userData);

            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error(' create fcm  Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getAttributes($request)
    {
        return [
            'userId' => $request->input('userId'),
            'fcmToken' => $request->input('fcmToken'),
        ];
    }
}
