<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $suratMasuk = SuratMasuk::all(); // Menampilkan semua surat masuk

        // Ambil semua data surat masuk beserta balasan PDF
        $suratMasuk = SuratMasuk::orderBy('tanggal', 'desc')->get();
        
        return view('user.surat-masuk.index', compact('suratMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.surat-masuk.create'); // Menampilkan form tambah surat masuk
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_surat' => 'required|string|unique:surat_masuks',
            'tanggal' => 'required|date',
            'asal_pengirim' => 'required|string|max:255',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Menyimpan file PDF jika ada
        if ($request->hasFile('file_pdf')) {
            $validatedData['file_pdf'] = $request->file('file_pdf')->store('pdfs', 'public');
        }

        // Tambahkan user_id berdasarkan pengguna yang sedang login
        $validatedData['user_id'] = \Illuminate\Support\Facades\Auth::user()->id;

        // Membuat entri baru di database
        SuratMasuk::create($validatedData);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('user.surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        return view('user.surat-masuk.show', compact('suratMasuk')); // Menampilkan detail surat masuk
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        return view('user.surat-masuk.edit', compact('suratMasuk')); // Menampilkan form edit surat masuk
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validatedData = $request->validate([
            'no_surat' => 'required|string|unique:surat_masuks,no_surat,' . $suratMasuk->id, // Validasi untuk nomor surat dengan pengecualian surat yang sedang diedit
            'tanggal' => 'required|date',
            'asal_pengirim' => 'required|string|max:255',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Menyimpan file PDF jika ada
        if ($request->hasFile('file_pdf')) {
            // Menghapus file PDF lama jika ada
            if ($suratMasuk->file_pdf && Storage::disk('public')->exists($suratMasuk->file_pdf)) {
                Storage::disk('public')->delete($suratMasuk->file_pdf);
            }

            // Menyimpan file PDF yang baru
            $validatedData['file_pdf'] = $request->file('file_pdf')->store('pdfs', 'public');
        }

        // Memperbarui data surat masuk
        $suratMasuk->update($validatedData);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('user.surat-masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        // Menghapus file PDF jika ada
        if ($suratMasuk->file_pdf && Storage::disk('public')->exists($suratMasuk->file_pdf)) {
            Storage::disk('public')->delete($suratMasuk->file_pdf);
        }

        // Menghapus data surat masuk dari database
        $suratMasuk->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('user.surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}
