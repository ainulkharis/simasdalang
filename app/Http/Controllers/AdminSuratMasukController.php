<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Storage; 

class AdminSuratMasukController extends Controller
{
    public function index()
    {
        // Ambil semua data Surat Masuk dari database dan urutkan berdasarkan tanggal
        $suratMasuk = SuratMasuk::orderBy('tanggal', 'desc')->get(); 

        // Kirim data ke tampilan admin
        return view('admin.surat-masuk.index', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $surat_masuk)
    {
        return view('admin.surat-masuk.edit', compact('surat_masuk'));
    }

    public function destroy(SuratMasuk $surat_masuk)
    {
        // Hapus file PDF jika ada
        if ($surat_masuk->file_pdf && Storage::disk('public')->exists($surat_masuk->file_pdf)) {
            Storage::disk('public')->delete($surat_masuk->file_pdf);
        }

        // Hapus file balasan PDF jika ada
        if ($surat_masuk->balasan_pdf && Storage::disk('public')->exists($surat_masuk->balasan_pdf)) {
            Storage::disk('public')->delete($surat_masuk->balasan_pdf);
        }

        // Hapus data dari database
        $surat_masuk->delete();

        return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }

    public function balasSurat(Request $request, $id)
    {
        $request->validate([
            'balasan_pdf' => 'required|mimes:pdf|max:2048'
        ]);

        $surat = SuratMasuk::findOrFail($id);

        if ($request->hasFile('balasan_pdf')) {
            // Hapus file balasan lama jika ada
            if ($surat->balasan_pdf && Storage::disk('public')->exists($surat->balasan_pdf)) {
                Storage::disk('public')->delete($surat->balasan_pdf);
            }

            // Simpan file balasan baru
            $file = $request->file('balasan_pdf');
            $filePath = $file->store('balasan_surat', 'public');

            // Simpan path ke database
            $surat->balasan_pdf = $filePath;
            $surat->save();
        }

        // Set session untuk admin
        session()->flash('success', 'Surat balasan berhasil dikirim.');

        // Set session untuk user
        session()->flash('balasan', 'Surat balasan sudah tersedia di halaman user.');

        // Redirect ke halaman index admin
        return redirect()->route('admin.surat-masuk.index');
    }
}
