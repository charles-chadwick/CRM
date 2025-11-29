<?php

namespace App\Enums;

enum ContactType : string
{
    case Personal = 'Personal';
    case Business = 'Business';
    case Other    = 'Other';
}
