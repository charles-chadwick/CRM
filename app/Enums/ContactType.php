<?php

namespace App\Enums;

use App\Traits\EnumToSelect;

enum ContactType: string {
    use EnumToSelect;
    case Personal = 'Personal';
    case Cell = 'Cell';
    case Office = 'Office';
}