<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'Admin';
    case Operator = 'Operator';
}
