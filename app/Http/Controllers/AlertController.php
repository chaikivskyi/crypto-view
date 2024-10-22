<?php

namespace App\Http\Controllers;

use App\Enums\WebhookStateEnum;
use App\Helper\MathHelper;
use App\Http\Requests\AlertHookRequest;
use App\Jobs\ProcessWebhook;
use App\Models\TradingPlotHistory;
use App\Settings\GeneralSettings;

class AlertController extends Controller
{
    public function process(AlertHookRequest $request, GeneralSettings $settings)
    {
        $webhook = TradingPlotHistory::create([
            'plot_data' => $request->post('plot_data'),
            'ticker' => $request->post('ticker', ''),
            'exchange' => $request->post('exchange', ''),
            'state' => WebhookStateEnum::Pending->value,
            'client_ip' => $request->ip(),
        ]);

        $changePercent = MathHelper::percentageDifference(
            $webhook->avg_plot_value,
            $webhook->max_plot_value
        );

        if ($changePercent > $settings->changePercentage) {
            ProcessWebhook::dispatch($webhook);
        } else {
            $webhook->update(['state' => WebhookStateEnum::Canceled->value]);
        }

        return response()->json(['message' => 'Webhook process added to queue.']);
    }
}
