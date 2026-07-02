<?php

namespace App\Enums;

enum StatutPaiement: string
{
    case EnAttente  = 'en_attente';
    case Confirme   = 'confirme';
    case Echoue     = 'echoue';
    case Rembourse  = 'rembourse';

    public function label(): string
    {
        return match ($this) {
            self::EnAttente => 'En attente',
            self::Confirme  => 'Confirmé',
            self::Echoue    => 'Échoué',
            self::Rembourse => 'Remboursé',
        };
    }
}
