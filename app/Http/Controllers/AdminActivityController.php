<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{

    public function index(User $user)
    {
        $activities = Activity::where('user_id', $user->id)->get();
        return view('admin.activities.index', compact('activities', 'user'));
    }

    /**
     * Memberikan nilai pada kegiatan peserta
     */
    public function grade(Request $request, Activity $activity)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        $activity->update([
            'nilai' => $request->nilai,
            'sudah_dinilai' => true,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil diberikan.');
    }
}
