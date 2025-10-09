<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validācija
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Atrodam lietotāju pēc e-pasta
        $user = User::where('email', $request->email)->first();

        // Ja lietotājs neeksistē vai parole nepareiza
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Viena vispārīga kļūda
            return back()->withErrors([
                'login' => 'E-pasts vai parole ir nepareiza.'
            ])->withInput(['email' => $request->email]);
        }

        // Ja viss pareizi, pieteicam lietotāju
        Auth::login($user);

        return redirect('/users')->with('success', 'Veiksmīgi pieteicies!');
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Tu esi izrakstījies!');
    }
}
