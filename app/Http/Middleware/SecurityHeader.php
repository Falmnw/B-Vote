<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Mencegah XSS (script injection)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Mencegah website ditampilkan dalam iframe (clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');

        // Mencegah browser menebak tipe konten
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Membatasi sumber konten eksternal
        $response->headers->set('Content-Security-Policy', "default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self' 'unsafe-inline';");

        // Meningkatkan privasi dan keamanan koneksi
        $response->headers->set('Referrer-Policy', 'no-referrer');

        // Untuk browser modern — opsional tapi bagus
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }
}
