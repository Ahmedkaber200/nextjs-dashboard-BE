<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email', // Corrected table name to 'users'
                'password' => 'required',
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'error' => $validateUser->errors()->all()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Password should be hashed
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'user' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email', // Added email validation
                'password' => 'required',
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication Fails',
                'error' => $validateUser->errors()->all()
            ], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'User Logged in Successfully',
                'data' => [
                    'token' => $authUser->createToken("API Token")->plainTextToken,
                'token_type' => 'bearer'
                ]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not matched',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
       $user = $request->user();
       $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => 'User Logged Out Successfully',
        ], 200);
    }
}