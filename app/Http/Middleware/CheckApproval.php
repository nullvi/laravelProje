<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApproval
{
    /**
     * Otel yöneticisinin onaylı olup olmadığını kontrol eder.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_approved) {
            return redirect()->route('home')->with('error', 'Hesabınız henüz onaylanmamış. Lütfen onay için bekleyiniz.');
        }

        return $next($request);
    }
}
