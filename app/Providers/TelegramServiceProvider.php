<?php

namespace App\Providers;

use App\Services\TelegramBotService;
use App\Settings\GeneralSettings;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\Telegram\Telegram;
use NotificationChannels\Telegram\TelegramChannel;

class TelegramServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /** @var GeneralSettings $settings */
        $settings = app(GeneralSettings::class);

        $this->app->bind(Telegram::class, static fn () => new Telegram(
            $settings->telegramToken ?: config('services.telegram-bot-api.token'),
            app(HttpClient::class),
            config('services.telegram-bot-api.base_uri')
        ));

        Notification::resolved(static function (ChannelManager $service) {
            $service->extend('telegram', static fn ($app) => $app->make(TelegramChannel::class));
        });
    }
}
