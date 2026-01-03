<?php

namespace App\Enums;

use App\Traits\EnumToSelect;

enum SalesLeadStatus : string
{
    use EnumToSelect;

    case Active      = 'Active';
    case Inactive    = 'Inactive';
    case Prospective = 'Prospective';
    case Dead        = 'Dead';
    case Completed   = 'Completed';
}