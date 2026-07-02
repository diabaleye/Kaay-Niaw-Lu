<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valide les donnees d inscription d un client.
 * Champs issus de la maquette Inscription_Client.png
 */
class InscriptionClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route publique : tout le monde peut s inscrire
        return true;
    }

    public function rules(): array
    {
        return [
            'prenom'                => ['required', 'string', 'max:100'],
            'nom'                   => ['required', 'string', 'max:100'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'telephone'             => ['required', 'string', 'max:20', 'unique:users,telephone'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'prenom.required'       => 'Le prenom est obligatoire.',
            'nom.required'          => 'Le nom est obligatoire.',
            'email.required'        => 'L adresse email est obligatoire.',
            'email.email'           => 'L adresse email n est pas valide.',
            'email.unique'          => 'Cette adresse email est deja utilisee.',
            'telephone.required'    => 'Le numero de telephone est obligatoire.',
            'telephone.unique'      => 'Ce numero de telephone est deja utilise.',
            'password.required'     => 'Le mot de passe est obligatoire.',
            'password.min'          => 'Le mot de passe doit contenir au moins 8 caracteres.',
            'password.confirmed'    => 'La confirmation du mot de passe ne correspond pas.',
        ];
    }
}
