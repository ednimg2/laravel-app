<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class IpRestrictionMiddleware
{
    public const IP_BLACKLIST = [
        '172.25.0.1',
        '172.25.0.4',
        '112.25.0.4',
    ];

    public const IP_WHITELIST = [
        '172.25.0.5',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // gaunam current ip addressa
        // pasiziurim ar jis yra blokuojamu ip sarase
        // jeigu yra tuomet metam access denied

        //BLACKLIST
//        if (in_array($request->ip(), self::IP_BLACKLIST)) {
//            throw new AccessDeniedHttpException();
//        }

        //WHITELIST
        if (!in_array($request->ip(), self::IP_WHITELIST)) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }
}
