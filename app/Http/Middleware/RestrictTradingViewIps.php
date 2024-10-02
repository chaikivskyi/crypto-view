<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RestrictTradingViewIps
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = config()->array('services.trading-view.ips');
        $clientIp = $request->ip();

        if (!in_array($clientIp, $allowedIps)) {
            Log::info('IP address {ip} is not in the list of allowed addresses', ['ip' => $clientIp]);
            abort(403, 'Access denied: Your IP address is not allowed to access this resource.');
        }

        return $next($request);
    }
}
