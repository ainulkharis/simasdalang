<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class TrackVisitors
{
    public function handle(Request $request, Closure $next): Response
    {
        $today = Carbon::today()->toDateString(); // Ambil tanggal hari ini

        $visitorIp = $request->ip(); // Ambil IP pengguna
        $hashedIp = Hash::make($visitorIp); // Hash IP pengguna

        // Cek apakah pengunjung dengan IP ini sudah mengakses hari ini
        $visitor = Visitor::where('visit_date', $today)
            ->where('visitor_ip', $hashedIp)
            ->first();

        // Jika belum, tambahkan record baru
        if (!$visitor) {
            Visitor::updateOrCreate(
                ['visit_date' => $today], // Cari berdasarkan tanggal
                [
                    'visitor_ip' => $hashedIp, // Simpan hash IP
                    'visit_count' => 1, // Tambah visit_count
                ]
            );
        }

        return $next($request);
    }
}
