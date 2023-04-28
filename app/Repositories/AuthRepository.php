<?php

namespace App\Repositories;

use App\Models\Gouvernerat;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthRepository
{
    /**
     * @param $userData
     * @return array
     * @throws HttpClientException
     */
    public function login($userData)
    {
        $email = $userData['email'];
        $password = $userData['password'];

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new HttpClientException(trans('messages.CREDENTIALS'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $email)->first();

        $role = $user->role->role;
       // $carte = $user->carte->is_active;
        $ville = $user->ville->nom;
        $gouvernerat = $user->ville->gouvernerat;
        $profession = $user->profession->nom;
        $specialite = $user->specialite->nom;
        $token = $user->createToken('API Token Of ' . $user->nom)->plainTextToken;

        return [
            'user' => [
                'userData' => $user,
                'role' => $role
            ],
            'gouvernerat' =>  $gouvernerat->nom  ,
            'ville' => $ville,
            'specialite' => $specialite,
            'profession' => $profession,
            //'carte' => $carte,
            'token' => $token
        ];
    }

    /**
     * @param $userData
     * @return mixed
     */
    public function register($userData)
    {
        $imagPath = $userData['image']->store('public/users');
        $imageUrl = Storage::url($imagPath);
        $ville = Ville::findOrFail($userData['villeId']);
        $gouverneratId = $ville->gouvernerat->id;
    //    dd($gouverneratId);
        return User::create([
            'ville_id' => $userData['villeId'],
            'gouvernerat_id' => 1,
            'profession_id' => $userData['professionId'],
            'specialite_id' => $userData['specialiteId'],
            'carte_id' => $userData['carteId'],
            'role_id' => $userData['roleId'],
            'nom' => $userData['nom'],
            'prenom' => $userData['prenom'],
            'nom_responsable' => $userData['nomResponsable'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'cin' => $userData['cin'],
            'numero' => $userData['numero'],
            'adresse' => $userData['adresse'],
            'image' => env('APP_URL') . $imageUrl,
            'secteur_id' => $userData['secteurId'],

        ]);

    }

    /**
     * @param $userData
     * @return mixed
     */
    public function resetPassword($userData)
    {
        $user = User::where('email', $userData['email'])->first();

        $user->update([
            'password' => Hash::make($userData['password']),
            'is_first_time' => false
        ]);

        return $user;
    }

    /**
     * @return void
     */
    public function logout()
    {
        $user = Auth::user();

        $user->tokens()->delete();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getUser($userId)
    {
        return User::where('id', $userId)->first();

    }


}
