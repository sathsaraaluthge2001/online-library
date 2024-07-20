<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OlUser;
use Illuminate\Support\Facades\Validator;

class OlUserController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:olusers',
            'contactnumber' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed', // Confirmation is still useful for client-side validation
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Create a new user
            $user = OlUser::create([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'contactnumber' => $request->input('contactnumber'),
                'password' => $request->input('password'), // Storing plain text password
            ]);

            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Check user credentials
            $user = OlUser::where('email', $request->input('email'))->first();

            if ($user && $user->password === $request->input('password')) {
                return response()->json([
                    'message' => 'Login successful',
                ], 200);
            }

            return response()->json(['error' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
