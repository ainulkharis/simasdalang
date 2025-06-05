<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminProfileLockController extends Controller
{
    public function toggleLock(Request $request, User $user)
    {
        $user->update(['is_profile_locked' => !$user->is_profile_locked]);

        $status = $user->is_profile_locked ? 'dikunci' : 'dibuka';
        return back()->with('success', "Profil peserta {$user->name} berhasil $status.");
    }
}
