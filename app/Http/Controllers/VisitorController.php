<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class VisitorController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString(); // Ambil tanggal hari ini
        $visitorIp = request()->ip(); // Ambil IP pengguna
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

        // Hitung jumlah pengunjung unik hari ini
        $visitorCount = Visitor::where('visit_date', $today)->count();

        return view('home', [
            'title' => 'Home',
            'visitorCount' => $visitorCount,
        ]);
    }

    public function showVisitorStats()
    {
        // Ambil data pengunjung dari database
        $visitors = Visitor::orderBy('visit_date', 'desc')->get();

        // Ambil waktu sekarang
        $waktuSekarang = now(); // atau Carbon::now()

        // Hitung total pengunjung unik
        $totalUniqueVisitors = Visitor::distinct('visitor_ip')->count('visitor_ip');

        // Ambil data pengunjung dengan pagination
        $visitors = Visitor::orderBy('visit_date', 'desc')->paginate(10); // 10 data per halaman

        // Kirim data ke view
        return view('admin.visitors', [
            'title' => 'Statistik Pengunjung',
            'visitors' => $visitors,
            'waktuSekarang' => $waktuSekarang,
            'totalUniqueVisitors' => $totalUniqueVisitors, // Kirim total pengunjung unik ke view
        ]);
    }
}
