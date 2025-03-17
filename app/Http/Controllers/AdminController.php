<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Method untuk menampilkan dashboard admin
    public function dashboard()
    {
        // Ambil jumlah user yang terdaftar
        $jumlahUser = User::where('role', 'user')->count();

        // Ambil jumlah surat masuk
        $jumlahSuratMasuk = SuratMasuk::count();

        // Ambil jumlah pengunjung unik hari ini
        $today = Carbon::today()->toDateString();
        $visitorCountToday = Visitor::where('visit_date', $today)->count();

        // Kirim data ke view
        return view('dashboard.admin', compact('jumlahUser', 'jumlahSuratMasuk', 'visitorCountToday'));
    }

    public function index()
    {
        // Mengurutkan data berdasarkan kolom 'created_at' secara descending (dari yang terbaru)
        $users = User::where('role', 'user')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at descending
            ->get();
            
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

    public function update(Request $request, User $user)
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

    public function editActivity(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function updateActivity(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            if ($activity->photo && Storage::disk('public')->exists($activity->photo)) {
                Storage::disk('public')->delete($activity->photo);
            }
            $validated['photo'] = $request->file('photo')->store('activity-photos', 'public');
        }

        $activity->update($validated);

        return redirect()->route('admin.profile.show', $activity->user_id)->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function editProfile(User $user)
    {
        // Pastikan hanya admin yang bisa mengedit profilnya sendiri
        if ($user->id !== Auth::user()->id) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses untuk mengedit profil ini.');
        }

        return view('admin.profile.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request, User $user)
    {
        // Pastikan hanya admin yang bisa memperbarui profilnya sendiri
        if ($user->id !== Auth::user()->id) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses untuk memperbarui profil ini.');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Proses upload foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            // Simpan foto baru
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Update data profil
        $user->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
