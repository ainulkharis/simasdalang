<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Berita;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function index()
    {
        // Ambil tanggal hari ini
        $today = Carbon::today()->toDateString();

        // Hitung jumlah pengunjung unik hari ini
        $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

        return view('home', [
            'title' => 'Home',
            'visitorCount' => $visitorCount,
        ]);
    }

    public function showNews()
    {
        $today = Carbon::today()->toDateString();
        $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;
        $berita = Berita::latest()->paginate(6);

        return view('news', [
            'title' => 'Berita',
            'berita' => $berita,
            'visitorCount' => $visitorCount
        ]);
    }

    public function showNewsDetail($slug)
    {
        $today = Carbon::today()->toDateString();
        $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;
        $berita = Berita::where('slug', $slug)->firstOrFail();

        return view('news-detail', [
            'title' => 'Detail Berita',
            'berita' => $berita,
            'visitorCount' => $visitorCount
        ]);
    }

    public function showAbout()
    {
        $today = Carbon::today()->toDateString();
        $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

        return view('about', [
            'title' => 'Tentang',
            'visitorCount' => $visitorCount
        ]);
    }

    public function showContact()
    {
        $today = Carbon::today()->toDateString();
        $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

        return view('contact', [
            'title' => 'Kontak',
            'visitorCount' => $visitorCount
        ]);
    }

    public function showRules()
    {
        $today = \Carbon\Carbon::today()->toDateString();
        $visitorCount = \App\Models\Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

        return view('rules', [
            'title' => 'Peraturan',
            'visitorCount' => $visitorCount
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