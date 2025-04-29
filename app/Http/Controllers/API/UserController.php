<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        $data['users'] = User::all();

        return response()->json([
            'status' => true,
            'message' => 'All Users Data Show.',
            'data' => $data,
        ], 200);
    }
}