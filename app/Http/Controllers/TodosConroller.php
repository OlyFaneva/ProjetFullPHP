<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodosConroller extends Controller
{
    public function index()
    {
        $todoAll = Todo::get();

        if ($todoAll == null) {
            return response()->json([
                'message' => 'nope le izy',
            ]);
        }

        return response()->json($todoAll);

    }

    public function single($todo)
    {
        $todo = Todo::find($todo);

        if ($todo == null) {
            return response()->json([
                'message' => 'nope le izy',
            ]);
        }
        return response()->json($todo);
    }

    public function fafaina($todo)
    {
        $todo = Todo::find($todo);
        if ($todo == null) {
            return response()->json([
                'message' => 'nope le izy',
            ]);
        }

        $todo->delete();
        if (!$todo) {
            return response()->json([
                'message' => 'nope le izy',
            ]);
        }
        return response()->json([
            'message' => 'wep man izy',
        ]);
    }

    public function update(Todo $todo, Request $request)
    {
        $validators = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'message' => $validators->errors(),
            ]);
        }

        $todo->content = $request->content;
        $todo->save();
        return response()->json([
            'message' => 'nice shot mon pote',
        ]);
    }

    public function store(Request $request)
    {

        $validators = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'message' => $validators->errors(),
            ]);
        }

        $content = $request->content;
        $isDone = false;

        if ($kim = Todo::create([
            "content" => $content,
            "isDone" => $isDone,
        ])) {
            return response()->json([
                'message' => 'cool mo pote',
            ], 200);
        }
        return response()->json([
            'message' => 'nope',
        ], 500);
    }
}
