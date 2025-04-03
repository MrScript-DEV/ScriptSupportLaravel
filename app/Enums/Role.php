<?php

namespace App\Enums;

enum Role: int
{
    case ADMIN = 1;
    case SUPPORT = 2;
    case USER = 3;
}
