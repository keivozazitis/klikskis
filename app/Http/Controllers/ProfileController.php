<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Rāda profila rediģēšanas formu.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('auth.profile', compact('user'));

    }

    /**
     * Saglabā izmaiņas lietotāja profilā.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Atjaunojam pamata informāciju
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;

        // Paroles atjaunināšana (ja ievadīta)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Profila bildes atjaunināšana (ja augšupielādēta)
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        // Saglabā izmaiņas datubāzē
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profils veiksmīgi atjaunināts!');
    }
}
