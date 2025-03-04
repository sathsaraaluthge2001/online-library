<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OlUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class OlUserController extends Controller
{
    //user register 
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:olusers', 
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

    //user login
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
            // Return user details upon successful login
            return response()->json(['message' => 'Login successful', 'user' => $user], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
    }
}
//get all users
public function getAllUsers()
    {
        try {
            $users = OlUser::all();
            return response()->json(['users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function getUserByEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = OlUser::where('email', $request->input('email'))->first();

            if ($user) {
                return response()->json(['user' => $user], 200);
            }

            return response()->json(['message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

}
