<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function userTodos(Request $request)
    {
        //without relationship
        // $todos = Todo::where('user_id', '=', $request->user_id);
        // return response()->json([
        //     'status' => 'success',
        //     'todos' => $todos,
        // ]);
        
        //with relationship
        try {
            $user = User::find($request->user_id);
            $todos = $user->todos;
            return response()->json([
                'status' => 'success',
                'todos' => $todos,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function addTodo(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
    
            $todo = Todo::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Todo created successfully',
                'todo' => $todo,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function getTodo(Request $request)
    {
        try {
            $todo = Todo::find($request->user_id);
            return response()->json([
                'status' => 'success',
                'todo' => $todo,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function updateTodo(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
    
            $todo = Todo::find($request->todo_id);
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Todo updated successfully',
                'todo' => $todo,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteTodo($id)
    {
        try {
            $todo = Todo::find($id);
            $todo->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Todo deleted successfully',
                'todo' => $todo,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }
}