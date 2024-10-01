<?php

namespace App\Http\Controllers;

use App\Enums\WebhookStateEnum;
use App\Helper\MathHelper;
use App\Http\Requests\AlertHookRequest;
use App\Jobs\ProcessWebhook;
use App\Models\TradingPlotHistory;

class AlertController extends Controller
{
    private const MIN_DIFFERENCE_PERCENT = 5;

    public function process(AlertHookRequest $request)
    {
        $webhook = TradingPlotHistory::create([
            'plot_one_value' => $request->post('plot_one'),
            'plot_two_value' => $request->post('plot_two'),
            'ticker' => $request->post('ticker', ''),
            'exchange' => $request->post('exchange', ''),
            'state' => WebhookStateEnum::Pending->value,
            'client_ip' => $request->ip(),
        ]);

        if (MathHelper::percentageDifference($webhook->plot_one_value, $webhook->plot_two_value) > self::MIN_DIFFERENCE_PERCENT) {
            ProcessWebhook::dispatch($webhook);
        } else {
            $webhook->update(['state' => WebhookStateEnum::Canceled->value]);
        }

        return response()->json(['message' => 'Webhook process added to queue.']);
    }
}
