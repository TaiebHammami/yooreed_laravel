<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Repositories\AuthRepository;
use App\Traits\GlobalTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class UserRegisterController extends Controller
{
    use GlobalTrait;

    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UserRegisterRequest $request)
    {
        $userData = $this->getAttributes($request);

        try {
            $data = $this->authRepository->register($userData);

            return $this->globalResponse(trans('messages.REGISTER_SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Register Exception : ' . $exception->getMessage());

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
            'villeId' => $request->input('villeId'),
            'professionId' => $request->input('professionId'),
            'specialiteId' => $request->input('specialiteId'),
            'carteId' => $request->input('carteId'),
            'roleId' => $request->input('roleId'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'nomResponsable' => $request->input('nomResponsable'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'cin' => $request->input('cin'),
            'numero' => $request->input('numero'),
            'adresse' => $request->input('adresse'),
            'image' => $request->file('image'),
            'secteurId' => $request->input('secteurId'),
        ];
    }
}
