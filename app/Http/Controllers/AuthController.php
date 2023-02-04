<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api',[
            'except' => ['login','register']
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $creds = $request->only('email','password');

        $token = Auth::attempt($creds);

        if(!$token)
        {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ],401);
        }
        
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'Successfully Logged In',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|string',
            'address' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);


        // Assigning roles

        if($user->id == 1){
            $user->assignRole('Seller');
        }else{
            $user->assignRole('Customer');
        }

        $token = Auth::login($user);



        return response()->json([
            'status' => true,
            'message' => 'User created',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Logged Out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => true,
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}