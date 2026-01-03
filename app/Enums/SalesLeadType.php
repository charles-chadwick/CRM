<?php
namespace App\Enums;

use App\Traits\EnumToSelect;

enum SalesLeadType : string
{
    use EnumToSelect;

    case New = 'new';
    case Contacted = 'contacted';
    case Qualified = 'qualified';
    case Lost = 'lost';
}