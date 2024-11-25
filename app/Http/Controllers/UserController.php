<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $incomingsFields = $request->validate([
            'email' => 'required' ,
            'password' => 'required'
        ]);

        if(Auth::attempt($incomingsFields)){
            $user = User::where('email' , $incomingsFields['email'])->first();
            $token = $user->createToken('OurAppToken')->plainTextToken;
            return response()->json([
                'token' => $token , 
                'message' => 'Cool tu gere'
            ] , 200);
        }else{
            return response()->json([
                'message' => 'Wrong credentials'
            ]);
        }
    }
    public function registration(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'name' => ['required'],
        ]);
        $data = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name
        ]);

        if (!$data) {
            return response()->json([
                'message' => 'verifier ton credentials connard'
            ]);
        }
        return response()->json([
            'message' => "you're connected",
        ]);
    }
}