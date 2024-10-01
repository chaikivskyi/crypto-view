<?php

namespace App\Notifications;

use App\Helper\MathHelper;
use App\Models\TradingPlotHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class CurrencyUpdateAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram(TradingPlotHistory $notifiable): TelegramMessage
    {
        $route = $notifiable->routes['telegram'] ?? config()->string('services.telegram-bot-api.chat_id');
        $percentageDiff = MathHelper::percentageDifference($notifiable->plot_one_value, $notifiable->plot_two_value);

        return TelegramMessage::create()
            ->to($route)
            ->line(sprintf('Plot 1: %s', $notifiable->plot_one_value))
            ->line(sprintf('Plot 2: %s', $notifiable->plot_two_value))
            ->line(sprintf('Difference: *%s%%*', $percentageDiff))
            ->lineIf($notifiable->exchange, sprintf('Exchange: %s', $notifiable->exchange))
            ->lineIf($notifiable->ticker, sprintf('Ticker: %s', $notifiable->ticker));
    }
}
