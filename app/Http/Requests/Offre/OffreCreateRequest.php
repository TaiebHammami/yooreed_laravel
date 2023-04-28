<?php

namespace App\Http\Requests\Offre;

use App\Models\Offre;
use Illuminate\Foundation\Http\FormRequest;

class OffreCreateRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:' . Offre::OFFRE_NAME_MIN_LENGTH],
            'description' => ['required', 'string', 'min:' . Offre::OFFRE_DESC_MIN_LENGTH],
            'image' => ['required', 'file'],
            'date_debut' => ['required'],
            'date_fin' => ['required'],
            'prix' => ['numeric'],
            'promo' => ['integer'],
            'like' => ['integer'],
            'typeId' => ['numeric']
        ];
    }
}
