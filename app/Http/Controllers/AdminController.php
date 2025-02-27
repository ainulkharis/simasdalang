<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Method untuk menampilkan dashboard admin
    public function dashboard()
    {
        // Ambil jumlah user yang terdaftar
        $jumlahUser = User::where('role', 'user')->count();

        // Ambil jumlah surat masuk
        $jumlahSuratMasuk = SuratMasuk::count();

        // Kirim data ke view
        return view('dashboard.admin', compact('jumlahUser', 'jumlahSuratMasuk'));
    }

    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.profile.admin-user', compact('users'));
    }

    public function create()
    {
        return view('admin.profile.admin-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'place_birth' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'school' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'internship_start' => 'nullable|date',
            'internship_end' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $validated['role'] = 'user';
        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        User::create($validated);

        return redirect()->route('admin.profile.admin-user')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $activities = $user->activities()->orderBy('date', 'desc')->get();
        return view('admin.profile.admin-show', compact('user', 'activities'));
    }


    public function edit(User $user)
    {
        return view('admin.profile.admin-edit', compact('user'));
    }

    public function admin_update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'place_birth' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'school' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'internship_start' => 'nullable|date',
            'internship_end' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($validated);

        return redirect()->route('admin.profile.admin-user')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.profile.admin-user')->with('success', 'User berhasil dihapus.');
    }
}
