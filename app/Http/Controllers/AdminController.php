<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
    if (!Auth::check() || !Auth::user()->is_admin) {
        abort(403, 'Access denied');
    }

    $users = User::all();
    $reports = \App\Models\Report::with(['reportedUser', 'reporterUser'])->get();

    return view('admin', compact('users', 'reports'));
    }
    public function destroy($id)
    {
    // Pārbauda, vai lietotājs ir admins
    if (!\Illuminate\Support\Facades\Auth::check() || !\Illuminate\Support\Facades\Auth::user()->is_admin) {
        abort(403, 'Access denied');
    }

    $user = \App\Models\User::findOrFail($id);

    // Neļauj dzēst sevi
    if ($user->id === \Illuminate\Support\Facades\Auth::id()) {
        return redirect()->route('admin.dashboard')->with('error', 'Tu nevari dzēst sevi!');
    }

    $user->delete();

    return redirect()->route('admin.dashboard')->with('success', 'Lietotājs dzēsts!');
    }  
    public function deleteReport($id)
{ 
    $report = \App\Models\Report::findOrFail($id);
    $report->delete();

    return back()->with('success', 'Report dzēsts!');
}
}
