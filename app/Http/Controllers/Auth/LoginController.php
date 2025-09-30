<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Parāda login formu
     */
    public function show()
    {
        // Blade fails: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Apstrādā login submit
     */
    public function login(Request $request)
    {
        // Validācija
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Atrodam lietotāju pēc e-pasta
        $user = User::where('email', $request->email)->first();

        // Ja lietotājs nav atrasts
        if (!$user) {
            // Flash error uz email lauku
            return back()->withErrors(['email' => 'Šāds e-pasts nav reģistrēts']);
        }

        // Pārbaudām paroli
        if (!Hash::check($request->password, $user->password)) {
            // Flash error uz password lauku
            return back()->withErrors(['password' => 'Nepareiza parole']);
        }

        // Autentificējam lietotāju
        Auth::login($user);

        // Veiksmīgs login – flash success ziņa
        return redirect('/')->with('success', 'Veiksmīgi pieteicies!');
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::logout();

        // Flash ziņa pēc logout
        return redirect('/')->with('success', 'Tu esi izrakstījies!');
    }
}
