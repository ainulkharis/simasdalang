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

        // Cek apakah sudah ada record untuk hari ini
        $visitor = Visitor::where('visit_date', $today)->first();

        if (!$visitor) {
            // Jika belum ada, buat record baru
            Visitor::create([
                'visit_date' => $today,
                'visit_count' => 1, // Set visit_count ke 1
                'visitor_ips' => $hashedIp, // Simpan IP pertama
            ]);
        } else {
            // Jika sudah ada, periksa apakah IP sudah tercatat
            $existingIps = explode(',', $visitor->visitor_ips ?? ''); // Ambil daftar IP yang sudah ada
            if (!in_array($hashedIp, $existingIps)) {
                $visitor->increment('visit_count'); // Tambahkan visit_count
                $existingIps[] = $hashedIp; // Tambahkan IP baru ke daftar
                $visitor->visitor_ips = implode(',', $existingIps); // Simpan daftar IP yang diperbarui
                $visitor->save();
            }
        }

        return $next($request);
    }
}