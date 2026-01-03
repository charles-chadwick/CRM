<?php

namespace App\Enums;

use App\Traits\EnumToSelect;

enum SalesLeadStatus : string
{
    use EnumToSelect;

    case Active      = 'active';
    case Inactive    = 'inactive';
    case Prospective = 'prospective';
    case Dead        = 'dead';
    case Completed   = 'completed';
}