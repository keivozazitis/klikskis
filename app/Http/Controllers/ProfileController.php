<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Rāda profila rediģēšanas formu
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        $regions = Region::all(); // Iegūst visus novadus no datubāzes

        return view('auth.profile', compact('user', 'regions'));
    }

    /**
     * Atjaunina lietotāja profilu datubāzē
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validācija
        $request->validate([
            'weight' => 'nullable|numeric|min:0|max:500',
            'bio' => 'nullable|string|max:500',
            'region_id' => 'required|exists:regions,id',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        // Saglabā papildu laukus
        $user->weight = $request->weight ?? $user->weight;
        $user->bio = $request->bio ?? $user->bio;
        $user->region_id = $request->region_id;

        // Profila bilde
        if ($request->hasFile('profile_photo')) {
            // Dzēš veco bildi, ja tā eksistē
            if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
                Storage::delete('public/' . $user->profile_photo);
            }

            $user->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Saglabā izmaiņas datubāzē
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profils veiksmīgi atjaunināts!');
    }
}
