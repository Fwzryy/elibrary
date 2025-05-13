<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
      $book = $request->route('book');

      // Buku gratis: Langsung diizinkan
      if ($book->is_free) {
        return $next($request);
      }
      // Jika belum login atau tidak punya langganan aktif
      if (!Auth::check() || !Auth::user()->hasActiveSubscription()) {
        return redirect()
          ->route('subscription.page') 
          ->with('error', 'Silakan berlangganan untuk membaca buku ini.');
      }
      
        return $next($request);
    }
}
