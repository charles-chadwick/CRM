<?php

namespace App\Enums;

use App\Traits\EnumToSelect;

enum CompanyType: string
{

    use EnumToSelect;

    case Customer = 'Customer';
    case Vendor   = 'Vendor';
    case Partner  = 'Partner';
    case Prospect = 'Prospect';

}