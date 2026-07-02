<?php

namespace App\Enums;

enum RoleUtilisateur: string
{
    case Client = 'client';
    case Tailleur = 'tailleur';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Client => 'Client',
            self::Tailleur => 'Tailleur',
            self::Admin => 'Administrateur',
        };
    }
}
