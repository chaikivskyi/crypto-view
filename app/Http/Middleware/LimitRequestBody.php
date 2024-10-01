<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LimitRequestBody
{
    /**
     * 2 Mb
     */
    private const MAX_LENGTH = 2097152;

    public function handle(Request $request, Closure $next): Response
    {
        if (strlen($request->getContent()) > self::MAX_LENGTH) {
            return response()->json(['message' => 'Request body too large.'], 413);
        }

        return $next($request);
    }
}
