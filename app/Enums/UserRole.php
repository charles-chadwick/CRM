<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum UserRole: string
{
    use EnumToArray;

    case SuperAdmin = 'Super Admin';
    case Admin      = 'Admin';
    case Manager    = 'Manager';
    case SalesRep   = 'Sales Rep';

}
