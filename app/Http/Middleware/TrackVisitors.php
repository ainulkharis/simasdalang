<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Carbon\Carbon;

class TrackVisitors
{
    public function handle(Request $request, Closure $next): Response
    {
        $today = Carbon::today()->toDateString(); // Ambil tanggal hari ini

        $visitorIp = $request->ip(); // Ambil IP pengguna
        $hashedIp = hash('sha256', $visitorIp); // Hash IP pengguna

        // Cek apakah pengunjung dengan IP ini sudah mengakses hari ini
        $visitor = Visitor::where('visit_date', $today)
            ->where('visitor_ip', $hashedIp)
            ->first();

        // Jika belum, tambahkan record baru
        if (!$visitor) {
            Visitor::create([
                'visit_date' => $today,
                'visitor_ip' => $hashedIp,
                'visit_count' => 1, // Set visit_count ke 1
            ]);
        }

        return $next($request);
    }
}