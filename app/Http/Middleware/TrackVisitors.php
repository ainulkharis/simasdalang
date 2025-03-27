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

        // Ambil IP pengunjung (support proxy dan Cloudflare)
        $ip = $request->header('CF-Connecting-IP') ?: ($request->header('X-Forwarded-For') ?: $request->ip());

        // Ambil IP pertama jika ada banyak (untuk X-Forwarded-For)
        if (strpos($ip, ',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }
        $hashedIp = hash('sha256', $ip); // Hash IP pengguna

        // Cek atau buat record pengunjung hari ini
        $visitor = Visitor::firstOrCreate(
            ['visit_date' => $today],
            ['visit_count' => 0, 'visitor_ips' => '']
        );

        // Tambahkan hitungan jika IP baru
        if (!str_contains($visitor->visitor_ips, $hashedIp)) {
            $visitor->increment('visit_count');
            $visitor->visitor_ips .= ($visitor->visitor_ips ? ',' : '') . $hashedIp;
            $visitor->save();
        }

        return $next($request);
    }
}