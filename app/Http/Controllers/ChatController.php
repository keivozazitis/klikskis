<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Rāda chat lapu ar matched lietotājiem
     */
    public function index()
    {
        $user = auth()->user();

        // Izgūst visus ziņojumus, kur lietotājs ir sūtītājs vai saņēmējs
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Izgūst visus matched lietotājus
        $matchedUsers = DB::table('likes')
            ->where('matched', true)
            ->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('liked_user_id', $user->id);
            })
            ->get()
            ->map(function($like) use ($user) {
                $matchedId = $like->user_id == $user->id ? $like->liked_user_id : $like->user_id;
                return User::find($matchedId);
            })
            ->filter() // no null
            ->unique('id'); // unikāli lietotāji

        return view('chat', compact('messages', 'matchedUsers'));
    }

    /**
     * Nosūta ziņu matched lietotājam
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Pārbauda, vai ir match starp lietotājiem
        $isMatched = DB::table('likes')
            ->where('matched', true)
            ->where(function($q) use ($user, $request) {
                $q->where(function($q2) use ($user, $request) {
                    $q2->where('user_id', $user->id)
                       ->where('liked_user_id', $request->receiver_id);
                })->orWhere(function($q3) use ($user, $request) {
                    $q3->where('user_id', $request->receiver_id)
                       ->where('liked_user_id', $user->id);
                });
            })->exists();

        if (!$isMatched) {
            return response()->json(['error' => 'Nav atļauts sūtīt ziņu šim lietotājam'], 403);
        }

        // Saglabā ziņu
        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json(['message' => $message]);
    }
}
