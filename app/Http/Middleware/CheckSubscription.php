<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Filament\Pages\SubscriptionPage;
use Filament\Facades\Filament; //

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
      // Ambil objek dari route binding('book' atau 'record' gatau belum kepikiran :D)
      $book = $request->route('book');
      // Jika buku tidak ditemukan
      if (!$book) {
        abort(404, 'Buku tidak ditemukan.');
      }
      // Buku gratis: Langsung diizinkan
      if ($book->is_free) {
        return $next($request);
      }
      // Mengecek login
      if (!Auth::check()) {
      return redirect(Filament::getLoginUrl())->with('error', 'Silahkan login terlebih dahulu');
      }
      $user = Auth::user();
      
      // Mengecek langganan aktif
      if (!$user->hasActiveSubscription()) {
         return redirect(SubscriptionPage::getUrl()) // <-- UBAH KE SINI
                ->with('error', 'Silakan berlangganan untuk membaca buku ini.');
      }
      
        return $next($request);
    }
}
