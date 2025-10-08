<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Parāda reģistrācijas formu
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Apstrādā reģistrācijas pieprasījumu
     */
    public function store(Request $request)
    {
        $request->validate([
            // ✅ Vārds un uzvārds: tikai burti, atstarpes un domuzīmes
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZĀ-ž\s\-]+$/u'
            ],
            'last_name'  => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZĀ-ž\s\-]+$/u'
            ],
            'birth_date' => 'required|date|before:-16 years',
            'gender'     => 'required|in:male,female',
            'weight'     => 'nullable|integer|min:1',
            'bio'        => 'nullable|string|max:1067',
            'region_id'  => 'nullable|exists:regions,id',
            'augums'     => 'nullable|integer|min:1',
            'email'      => 'required|email|unique:users,email',

            // ✅ Paroles validācija: vismaz 6 rakstzīmes, viens lielais burts un viens cipars
            'password'   => [
                'required',
                'confirmed',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
            ],
        ], [
            // Pielāgoti kļūdu paziņojumi
            'first_name.regex' => 'Vārds drīkst saturēt tikai burtus, atstarpes vai domuzīmes.',
            'last_name.regex'  => 'Uzvārds drīkst saturēt tikai burtus, atstarpes vai domuzīmes.',
            'password.regex'   => 'Parolei jābūt vismaz 6 simboliem, ar vismaz vienu lielo burtu un ciparu.',
            'birth_date.before'=> 'Tev jābūt vismaz 16 gadus vecam.',
        ]);

        // Lietotāja izveide
        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'birth_date' => $request->birth_date,
            'gender'     => $request->gender,
            'weight'     => $request->weight,
            'bio'        => $request->bio,
            'region_id'  => $request->region_id,
            'augums'     => $request->augums,
            'images'     => json_encode([]),
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        // Redirect ar flash paziņojumu uz login lapu
        return redirect('/login')->with('success', 'Reģistrācija veiksmīga! Tagad vari pieteikties.');
    }
}
