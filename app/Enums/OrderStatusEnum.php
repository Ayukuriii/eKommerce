<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case SUCCESS = 'success';
    case PENDING = 'pending';
    case FAILED = 'failed';
}
