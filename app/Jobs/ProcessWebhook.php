<?php

namespace App\Jobs;

use App\Enums\WebhookStateEnum;
use App\Models\TradingPlotHistory;
use App\Notifications\CurrencyUpdateAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class ProcessWebhook implements ShouldQueue
{
    use Queueable;

    public $backoff = 5;
    public $tries = 3;

    public function __construct(private TradingPlotHistory $webhook)
    {
    }

    public function handle(): void
    {
        try {
            $this->webhook->notifyNow(new CurrencyUpdateAlert(), ['telegram']);
            $this->webhook->update(['state' => WebhookStateEnum::Processed->value]);
        } catch (Throwable $e) {
            $this->webhook->update(['state' => WebhookStateEnum::Failed->value]);

            throw $e;
        }
    }
}
