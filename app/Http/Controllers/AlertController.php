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
        $tradingPlotHistory = TradingPlotHistory::create([
            'plot_data' => $request->post('plot_data'),
            'ticker' => $request->post('ticker', ''),
            'exchange' => $request->post('exchange', ''),
            'state' => WebhookStateEnum::Pending->value,
            'client_ip' => $request->ip(),
        ]);

        $changePercent = MathHelper::percentageDifference(
            $tradingPlotHistory->min_plot_value,
            $tradingPlotHistory->max_plot_value
        );
dd($settings->changePercentage);
        if ($changePercent > $settings->changePercentage) {
            ProcessWebhook::dispatch($tradingPlotHistory);
        } else {
            $tradingPlotHistory->update(['state' => WebhookStateEnum::Canceled->value]);
        }

        return response()->json(['message' => 'Webhook process added to queue.']);
    }
}
