<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $activities = Activity::all();
        
        // Hanya menampilkan kegiatan milik user yang login
        $activities = Activity::where('user_id', Auth::id())->get();
        return view('user.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['date', 'description']);
        $data['user_id'] = Auth::id(); // Tambahkan user_id dari user yang login

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('activity_photos', 'public');
        }

        Activity::create($data);

        return redirect()->route('user.activities.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        // Pastikan kegiatan milik user yang login
        if ($activity->user_id !== Auth::id()) {
            return redirect()->route('user.activities.index')->with('error', 'Anda tidak memiliki izin untuk melihat kegiatan ini.');
        }

        return view('user.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        // Pastikan kegiatan milik user yang login
        if ($activity->user_id !== Auth::id()) {
            return redirect()->route('user.activities.index')->with('error', 'Anda tidak memiliki izin untuk mengedit kegiatan ini.');
        }

        return view('user.activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        // Pastikan kegiatan milik user yang login
        if ($activity->user_id !== Auth::id()) {
            return redirect()->route('user.activities.index')->with('error', 'Anda tidak memiliki izin untuk mengupdate kegiatan ini.');
        }

        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['date', 'description']);

        if ($request->hasFile('photo')) {
            if ($activity->photo) {
                Storage::disk('public')->delete($activity->photo);
            }
            $data['photo'] = $request->file('photo')->store('activity_photos', 'public');
        }

        $activity->update($data);

        return redirect()->route('user.activities.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        // Pastikan kegiatan milik user yang login
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
