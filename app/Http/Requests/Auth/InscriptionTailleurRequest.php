<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valide les donnees d inscription d un tailleur.
 * Champs issus de la maquette Inscription_Tailleur.png :
 *   Section 1-2 : identiques au client
 *   Section 3 : nom_atelier, localisation, specialites
 *   Section 4 : commandes_max_semaine, delai_moyen_jours
 */
class InscriptionTailleurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Identite
            'prenom'                 => ['required', 'string', 'max:100'],
            'nom'                    => ['required', 'string', 'max:100'],
            // Identifiants
            'email'                  => ['required', 'email', 'max:255', 'unique:users,email'],
            'telephone'              => ['required', 'string', 'max:20', 'unique:users,telephone'],
            'password'               => ['required', 'string', 'min:8', 'confirmed'],
            // Informations atelier
            'nom_atelier'            => ['required', 'string', 'max:255'],
            'localisation'           => ['required', 'string', 'max:255'],
            'specialites'            => ['nullable', 'string', 'max:500'],
            // Gestion & capacite
            'commandes_max_semaine'  => ['required', 'integer', 'min:1', 'max:100'],
            'delai_moyen_jours'      => ['nullable', 'integer', 'min:1', 'max:365'],
        ];
    }

    public function messages(): array
    {
        return [
            'prenom.required'               => 'Le prenom est obligatoire.',
            'nom.required'                  => 'Le nom est obligatoire.',
            'email.required'                => 'L adresse email est obligatoire.',
            'email.unique'                  => 'Cette adresse email est deja utilisee.',
            'telephone.required'            => 'Le numero de telephone est obligatoire.',
            'telephone.unique'              => 'Ce numero de telephone est deja utilise.',
            'password.required'             => 'Le mot de passe est obligatoire.',
            'password.min'                  => 'Le mot de passe doit contenir au moins 8 caracteres.',
            'password.confirmed'            => 'La confirmation du mot de passe ne correspond pas.',
            'nom_atelier.required'          => 'Le nom de l atelier est obligatoire.',
            'localisation.required'         => 'La localisation est obligatoire.',
            'commandes_max_semaine.required'=> 'Le nombre maximum de commandes par semaine est obligatoire.',
            'commandes_max_semaine.min'     => 'La capacite minimale est 1 commande par semaine.',
        ];
    }
}
