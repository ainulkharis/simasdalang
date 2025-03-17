<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString(); // Ambil tanggal hari ini

        // Hitung jumlah pengunjung unik hari ini
        $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

        return view('home', [
            'title' => 'Home',
            'visitorCount' => $visitorCount,
        ]);
    }

    public function showVisitorStats()
    {
        // Ambil data pengunjung dengan pagination
        $visitors = Visitor::orderBy('visit_date', 'desc')->paginate(10); // 10 data per halaman

        // Hitung total pengunjung unik
        $totalUniqueVisitors = Visitor::sum('visit_count');

        // Kirim data ke view
        return view('admin.visitors', [
            'title' => 'Statistik Pengunjung',
            'visitors' => $visitors,
            'totalUniqueVisitors' => $totalUniqueVisitors,
        ]);
    }
}