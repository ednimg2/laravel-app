<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequestLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //1. gaunam pradinį lauka
        //2. suvykdomas request
        //3. gaunam info po response
        //4. atimam galutinį laiką iš pradinio laiko

        $startTime = floor(microtime(true) * 1000);


        file_put_contents(
            storage_path() . '/request.log',
            date('Y-m-d H:i:s') . ': /' . $request->path() . ' | context: ' . json_encode($request->all()) . PHP_EOL,
            FILE_APPEND
        );

        /** @var Response $response */
        $response = $next($request);
        $endTime = floor(microtime(true) * 1000);
        $duration = $endTime - $startTime;

        file_put_contents(
            storage_path() . '/response.log',
            date('Y-m-d H:i:s') . ': /' . $request->path() . ' | response: ' .
            json_encode(['statusCode' => $response->getStatusCode(), 'content' => $response->getContent(), 'duration' => $duration . 'ms']) .
            PHP_EOL,
            FILE_APPEND
        );

        return $response;
    }
}
