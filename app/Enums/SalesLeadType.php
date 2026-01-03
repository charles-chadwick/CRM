<?php
namespace App\Enums;

use App\Traits\EnumToSelect;

enum SalesLeadType : string
{
    use EnumToSelect;

    case New = 'New';
    case Contacted = 'Contacted';
    case Qualified = 'Qualified';
    case Lost = 'Lost';
}