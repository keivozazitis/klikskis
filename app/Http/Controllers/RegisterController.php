<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Parāda reģistrācijas formu
    public function show()
    {
        return view('auth.register');
    }

    // Saglabā lietotāju datubāzē
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'birth_date' => 'required|date|before:-16 years',
            'gender'     => 'required|in:male,female',
            'weight'     => 'nullable|integer|min:1',
            'bio'        => 'nullable|string|max:1067',
            'region_id'  => 'nullable|exists:regions,id',
            'augums'     => 'nullable|integer|min:1',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed|min:6',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'birth_date' => $request->birth_date,
            'gender'     => $request->gender,
            'weight'     => $request->weight,
            'bio'        => $request->bio,
            'region_id'  => $request->region_id,
            'augums'     => $request->augums,
            'images'     => json_encode([]), // tukš masīvs sākumā
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User registered!');
    }
}
