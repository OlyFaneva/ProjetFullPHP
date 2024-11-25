<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodosConroller extends Controller
{
    public function index(){
        $todoAll = Todo::get();

        return response()->json($todoAll);

    }

    public function single(Todo $todo){
        return response()->json($todo);        
    }

    public function fafaina(Todo $todo){
        $todo->delete();
        if(!$todo){
            return response()->json([
                'message' => 'nope le izy'
            ]);
        }
        return response()->json([
            'message' => 'wep man izy'
        ]);
    }

    public function update(Todo $todo , Request $request){
        $todo->content = $request->content;
        $todo->save();
        return response()->json([
            'message' => 'nice shot mon pote'
        ]);
    }

    public function store(Request $request){
        $content = $request->content ; 
        $isDone = false; 

        

        if ($kim = Todo::create([
            "content" => $content , 
            "isDone" => $isDone
        ])) {
            return response()->json([
                'message' => 'cool mo pote'
            ] , 200);
        }
        return response()->json([
            'message' => 'nope'
        ] ,500);

    }
}
