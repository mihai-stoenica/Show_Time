<?php

namespace App\Enum;

enum BookingStatus: string
{
    case pending = 'pending';
    case successful = 'successful';

}
