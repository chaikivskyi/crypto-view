<?php

namespace App\Enums;

enum WebhookStateEnum: string
{
    case Pending = 'pending';
    case Processed = 'processed';
    case Failed = 'failed';
    case Canceled = 'canceled';
}
