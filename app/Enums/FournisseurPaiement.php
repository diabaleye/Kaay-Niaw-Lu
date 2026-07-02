<?php

namespace App\Enums;

enum FournisseurPaiement: string
{
    case Wave        = 'wave';
    case OrangeMoney = 'orange_money';

    public function label(): string
    {
        return match ($this) {
            self::Wave        => 'Wave',
            self::OrangeMoney => 'Orange Money',
        };
    }
}
