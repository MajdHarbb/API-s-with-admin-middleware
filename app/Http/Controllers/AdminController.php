<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return response()->json([
            'users' => $users
        ]);
    }

    public function todos(){
        $todos = Todo::all();
        return response()->json([
            'todos' => $todos
        ]);
    }
}
