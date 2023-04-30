<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Referrer
{   
    public function handle(Request $request, Closure $next)
    {
        $referer = $request->headers->has('referer') ? $request->headers->get('referer') : '/home'; // previous page URL
        $expected_url = ['/home', '/login', '/data']; // expected page array

        if(in_array($referer, $expected_url)) {
            return abort(404);
        }
    
        return $next($request);
    }
}
