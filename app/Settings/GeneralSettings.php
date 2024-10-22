<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public int $changePercentage;

    public ?string $telegramToken;

    public ?string $telegramChatId;

    public static function group(): string
    {
        return 'general';
    }
}
