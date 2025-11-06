<?php
namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeUser($likedUserId)
    {
        $user = Auth::user();

        // Pārbauda, vai jau ir like
        $like = Like::firstOrCreate([
            'user_id' => $user->id,
            'liked_user_id' => $likedUserId
        ]);

        // Pārbauda, vai otrs lietotājs jau like uz mani
        $reverseLike = Like::where('user_id', $likedUserId)
                            ->where('liked_user_id', $user->id)
                            ->first();

        if ($reverseLike) {
            $like->matched = true;
            $like->save();

            $reverseLike->matched = true;
            $reverseLike->save();

            return response()->json(['message' => 'Match izveidots!']);
        }

        return response()->json(['message' => 'Like saglabāts!']);
    }
}
