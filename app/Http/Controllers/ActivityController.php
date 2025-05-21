<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {   
        // Hanya menampilkan kegiatan milik user yang login
        $activities = Activity::where('user_id', Auth::id())
                            ->orderBy('date', 'desc')
                            ->get();
        return view('user.activities.index', compact('activities'));
    }

    public function create()
    {
        $currentDate = now()->format('d-m-Y');
        return view('user.activities.create', compact('currentDate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = [
            'date' => now()->format('d-m-Y'),
            'description' => $request->description,
            'user_id' => Auth::id()
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('activity_photos', 'public');
        }

        Activity::create($data);

        return redirect()->route('user.activities.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    // public function show(Activity $activity)
    // {
    //     // Pastikan kegiatan milik user yang login
    //     if ($activity->user_id !== Auth::id()) {
    //         return redirect()->route('user.activities.index')->with('error', 'Anda tidak memiliki izin untuk melihat kegiatan ini.');
    //     }

    //     return view('user.activities.show', compact('activity'));
    // }

    public function edit(Activity $activity)
    {
        // Memastikan kegiatan milik user yang login
        if ($activity->user_id !== Auth::id()) {
            return redirect()->route('user.activities.index')->with('error', 'Anda tidak memiliki izin untuk mengedit kegiatan ini.');
        }

        // Tambahan: Cegah edit jika sudah dinilai
        if ($activity->sudah_dinilai) {
            return redirect()->route('user.activities.index')->with('error', 'Kegiatan yang sudah dinilai tidak dapat diedit.');
        }

        return view('user.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        // Memastikan kegiatan milik user yang login
        if ($activity->user_id !== Auth::id()) {
            return redirect()->route('user.activities.index')->with('error', 'Anda tidak memiliki izin untuk mengupdate kegiatan ini.');
        }

        // Tambahan: Cegah update jika sudah dinilai
        if ($activity->sudah_dinilai) {
            return redirect()->route('user.activities.index')->with('error', 'Kegiatan yang sudah dinilai tidak dapat diperbarui.');
        }

        $request->validate([
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['description']);

        if ($request->hasFile('photo')) {
            if ($activity->photo) {
                Storage::disk('public')->delete($activity->photo);
            }
            $data['photo'] = $request->file('photo')->store('activity_photos', 'public');
        }

        $activity->update($data);

        return redirect()->route('user.activities.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        // Memastikan kegiatan milik user yang login
        if ($activity->user_id !== Auth::id()) {
            return redirect()->route('user.activities.index')->with('error', 'Anda tidak memiliki izin untuk menghapus kegiatan ini.');
        }

        if ($activity->photo) {
            Storage::disk('public')->delete($activity->photo);
        }

        $activity->delete();

        return redirect()->route('user.activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
