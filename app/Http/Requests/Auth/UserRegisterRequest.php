<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'specialiteId' => ['numeric'],
            'villeId' => ['numeric'],
            'professionId' => ['numeric'],
            'secteurId' => ['numeric'],
            'carteId' => ['numeric'],
            'roleId' => ['required', 'numeric'],
            'nom' => ['required', 'string', 'min:' . User::NAME_MIN_LENGTH],
            'prenom' => ['string', 'min:' . User::NAME_MIN_LENGTH - 1],
            'nomResponsable' => ['string', 'min:' . User::NAME_MIN_LENGTH],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min('8')],
            'image' => ['required', 'file'],
            'cin' => ['required', 'numeric'],
            'numero' => ['required', 'numeric'],
            'adresse' => ['required', 'string', 'min:' . User::ADDRESS_MIN_LENGTH]
        ];
    }
}
