<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Foto default hanya digunakan untuk ditampilkan, bukan untuk diubah di database
        $userPhotoPath = $user->photo
            ? asset('storage/' . $user->photo)
            : asset('assets/compiled/jpg/profile.jpg');

        return view('user.profile.index', ['user' => $user, 'userPhotoPath' => $userPhotoPath]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Cek apakah profil terkunci
        if ($user->is_profile_locked) {
            return redirect()->route('user.profile.index')->with('error', 'Profil Anda telah dikunci oleh pembimbing dan tidak dapat diubah.');
        }

        $request->validate([
            'place_birth' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'school' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'internship_start' => 'nullable|date',
            'internship_end' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->hasFile('photo')) {

            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru
            $filePath = $request->file('photo')->store('photos', 'public');
            $user->photo = $filePath;
        }

        $user->fill($request->except('photo'));
        $user->save();

        return redirect()->route('user.profile.index')->with('success', 'Profil berhasil diperbarui');
    }
}
