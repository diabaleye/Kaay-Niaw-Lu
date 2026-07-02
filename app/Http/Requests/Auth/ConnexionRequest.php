<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valide les donnees de connexion.
 * Login par numero de telephone + mot de passe (maquette Connection.png).
 */
class ConnexionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'telephone' => ['required', 'string'],
            'password'  => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'telephone.required' => 'Le numero de telephone est obligatoire.',
            'password.required'  => 'Le mot de passe est obligatoire.',
        ];
    }
}
