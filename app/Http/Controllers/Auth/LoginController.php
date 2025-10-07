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

        $user = User::where('email', $request->email)->first();

    
        if (!$user) {
            return back()->withErrors(['email' => 'Šāds e-pasts nav reģistrēts']);
        }

        if (!Hash::check($request->password, $user->password)) {
            // Flash error
            return back()->withErrors(['password' => 'Nepareiza parole']);
        }

        Auth::login($user);

        return redirect('/driz')->with('success', 'Veiksmīgi pieteicies!');
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
