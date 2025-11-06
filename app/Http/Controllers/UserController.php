<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Iegūst visus ne-admin lietotājus, izņemot sevi
        $users = User::where('is_admin', false)
                     ->where('id', '!=', Auth::id())
                     ->get();

        return view('main', compact('users'));
    }

    public function report(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Neļauj ziņot par sevi
    if ($user->id === Auth::id()) {
        return back()->with('error', 'Tu nevari ziņot par sevi!');
    }

    // Validē izvēlēto iemeslu
    $request->validate([
        'reason' => 'required|in:underage,impersonation,pornographic',
    ]);

    // Saglabā report datubāzē
    Report::create([
        'reported_user_id' => $user->id,
        'reporter_user_id' => Auth::id(),
        'reason' => $request->reason,
    ]);

    return back()->with('success', 'Lietotājs ziņots!');
}
public function freakclick()
{
    $users = \App\Models\User::where('tags', 'LIKE', '%Freakclick%')->get();
    return view('auth.freak', compact('users'));
}
}
