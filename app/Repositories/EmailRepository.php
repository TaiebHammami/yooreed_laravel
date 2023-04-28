<?php

namespace App\Repositories;

use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Traits\GlobalTrait;
use Carbon\Carbon;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class EmailRepository
{
    use GlobalTrait;

    /**
     * @param $requestPin
     * @return mixed
     * @throws HttpClientException
     */
    public function verifyMyEmail($requestPin)
    {
        DB::beginTransaction();

        $select = DB::table('password_resets')
            ->where('email', Auth::user()->email)
            ->where('pin', $requestPin);

        //Check if the pin is valid
        if ($select->get()->isEmpty()) {
            throw new HttpClientException(trans('messages.INVALID_PIN'), Response::HTTP_BAD_REQUEST);
        }

        //Delete the pin if it's valid
        $select->delete();

        //Update the email_verified_at column in users table
        $user = User::findOrFail(Auth::user()->id);
        $user->email_verified_at = Carbon::now()->getTimestamp();
        $user->save();

        DB::commit();

        return $user;
    }

    /**
     * @param $email
     * @return void
     * @throws HttpClientException
     */
    public function forgotMyPassword($email)
    {
        DB::beginTransaction();

        $user = User::where('email', $email);

        if ($user) {

            $verify = DB::table('password_resets')
                ->where('email', $email);

            if ($verify->exists()) {
                $verify->delete();
            }

            //Generate a pin
            $pin = rand(100000, 999999);
            $password_reset = DB::table('password_resets')
                ->insert([
                    'email' => $email,
                    'pin' => $pin,
                    'created_at' => Carbon::now()
                ]);

            //Send pin to the email to reset password
            if ($password_reset) {
                Mail::to($email)->send(new VerifyEmail($pin));
                DB::commit();
            }
        } else {
            throw new HttpClientException(trans('messages.EMAIL_NOT_FOUND'), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param $userData
     * @return void
     * @throws HttpClientException
     */
    public function verifyMyPin($userData)
    {
        DB::beginTransaction();

        //Check if the pin exist
        $check = DB::table('password_resets')
            ->where('email', $userData['email'])
            ->where('pin', $userData['pin']);


        if ($check->exists()) {

            //Difference in seconds since the pin has been sent
            $difference = Carbon::now()->diffInSeconds($check->first()->created_at);

            //The pin is expired if the difference is bigger than an hour
            $check->delete();
            if ($difference > config('constants.EXPIRATION_DELAY')) {
                throw new HttpClientException(trans('messages.RESET_PIN_EXPIRED'), Response::HTTP_BAD_REQUEST);
            }

            Db::commit();
        } else {
            throw new HttpClientException(trans('messages.INVALID_PIN'), Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @param $userData
     * @return array
     */
    public function resetMyPassword($userData)
    {
        //Find the user with the provided email
        $user = User::where('email', $userData['email']);

        //Update the password
        $user->update([
            'password' => Hash::make($userData['password'])
        ]);

        //Generate a token
        $token = Auth::login($user->first());

        return [
            'user' => $user->first(),
            'token' => $token
        ];
    }
}
