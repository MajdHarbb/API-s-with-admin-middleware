<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;

class AdminController extends Controller
{
    public function users()
    {
        try {
            $users = User::all();
            return response()->json([
                'users' => $users
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function todos(){
        try {
            $todos = Todo::all();
            return response()->json([
                'todos' => $todos
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
