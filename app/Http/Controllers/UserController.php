<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Piemērs: neparādīt pašreizējo lietotāju
        $users = User::where('id', '!=', Auth::id())->get();

        // Vai ja gribi lapot: ->paginate(12)
        // $users = User::where('id', '!=', Auth::id())->paginate(12);

        return view('main', compact('users'));

    }
}
