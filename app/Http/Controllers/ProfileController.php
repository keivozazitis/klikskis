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
     * Dzēš lietotāja profilu
     */
    public function destroy()
    {
        
        $user = auth()->user();

        // Dzēš visas saglabātās bildes
        if ($user->images) {
            $images = json_decode($user->images, true);
            foreach ($images as $img) {
                if (Storage::exists('public/' . $img)) {
                    Storage::delete('public/' . $img);
                }
            }
        }

        // Dzēš arī profila bildi, ja ir
        if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
            Storage::delete('public/' . $user->profile_photo);
        }

        $user->delete();

        return redirect('/')->with('success', 'Tavs profils tika dzēsts!');
    }

    /**
     * Rediģēšanas forma
     */
    public function edit()
    {
        $user = Auth::user();
        $regions = Region::all();

        return view('auth.profile', compact('user', 'regions'));
    }

    /**
     * Profila datu atjaunināšana
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validācija
        $request->validate([
            'weight' => 'nullable|numeric|min:0|max:500',
            'bio' => 'nullable|string|max:500',
            'region_id' => 'required|exists:regions,id',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'augums' => 'nullable|numeric|min:0|max:500',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'remove_images' => 'nullable|string'

        ]);

        // Vienkāršie lauki
        $user->weight = $request->weight ?? $user->weight;
        $user->bio = $request->bio ?? $user->bio;
        $user->region_id = $request->region_id;
        $user->augums = $request->augums ?? $user->augums;

        // ✅ Profila bilde
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
                Storage::delete('public/' . $user->profile_photo);
            }

            $user->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // ✅ Esošās bildes
        $existingImages = $user->images ? json_decode($user->images, true) : [];

        // ✅ Jaunas bildes – pievieno klāt esošajām
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('profile_images', 'public');
                $existingImages[] = $path;
            }
        }

        // ✅ Noņemtās bildes
        if ($request->filled('remove_images')) {
            $removeList = explode(',', $request->remove_images);

            foreach ($removeList as $imgPath) {
                $imgPath = trim($imgPath);
                if (Storage::exists('public/' . $imgPath)) {
                    Storage::delete('public/' . $imgPath);
                }
                $existingImages = array_filter($existingImages, fn($img) => $img !== $imgPath);
            }
        }

        // Saglabā atlikušo sarakstu datubāzē
        $user->images = json_encode(array_values($existingImages));

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profils veiksmīgi atjaunināts!');
    }
}
