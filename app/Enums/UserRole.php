<?php

namespace App\Enums;

enum UserRole: string
{
    case Student = 'student';
    case Company = 'company';
    case Administrator = 'administrator';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
