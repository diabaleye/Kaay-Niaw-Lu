<?php

namespace App\Enums;

enum StatutCommande: string
{
    case EnAttente = 'en_attente';
    case Acceptee = 'acceptee';
    case Refusee = 'refusee';
    case EnCours = 'en_cours';
    case Terminee = 'terminee';
    case Annulee = 'annulee';

    public function label(): string
    {
        return match ($this) {
            self::EnAttente => 'En attente',
            self::Acceptee => 'Acceptée',
            self::Refusee => 'Refusée',
            self::EnCours => 'En cours de réalisation',
            self::Terminee => 'Terminée',
            self::Annulee => 'Annulée',
        };
    }
}
