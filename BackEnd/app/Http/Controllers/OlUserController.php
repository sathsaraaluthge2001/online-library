<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OlUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class OlUserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:olusers', // Ensure this matches the table name
            'contactnumber' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = OlUser::create([
            'username' => $request->username,
            'email' => $request->email,
            'contactnumber' => $request->contactnumber,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User successfully registered', 'user' => $user], 201);
    }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        $user = OlUser::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Login successful'], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
    }
}

}
