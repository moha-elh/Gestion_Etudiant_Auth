<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student; // Ensure Student model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class FirebaseController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        $token = $request->input('id_token');

        if (!$token) {
            return response()->json(['error' => 'No token provided'], 400);
        }

        try {
            // 1. Fetch Google's Public Keys using Laravel HTTP Client
            $response = \Illuminate\Support\Facades\Http::get('https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com');
            
            if ($response->failed()) {
                throw new \Exception('Failed to fetch Google public keys');
            }
            
            $keys = $response->json();
            
            // 2. Decode the Token
            $keyObjects = [];
            foreach ($keys as $kid => $publicKey) {
                $keyObjects[$kid] = new Key($publicKey, 'RS256');
            }

            $decoded = JWT::decode($token, $keyObjects);

            // 4. Extract User Info
            $email = $decoded->email;
            $name = $decoded->name ?? 'Google User';
            
            // 5. Find or Create User
            $user = User::where('email', $email)->first();

            if (!$user) {
                \Illuminate\Support\Facades\DB::beginTransaction();
                try {
                    $user = User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make(uniqid()), // Random password
                        'role' => 'student', // Default role
                        'photo' => $decoded->picture ?? null, // Save Google profile picture
                    ]);
                    // DO NOT create Student record here. Let the completion flow handle it.
                    \Illuminate\Support\Facades\DB::commit();
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\DB::rollBack();
                    throw $e;
                }
            }

            // 6. Log in the user
            Auth::login($user);

            // 7. Determine Redirect URL
            if ($user->role === 'admin') {
                $redirectUrl = route('admin.dashboard');
            } elseif ($user->student) {
                 // Student record exists, go to dashboard
                $redirectUrl = route('student.dashboard');
            } else {
                 // No student record, go to completion page
                $redirectUrl = route('student.complete-registration');
            }

            return response()->json([
                'success' => true,
                'redirect_url' => $redirectUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Firebase Login Error: ' . $e->getMessage());
            // Return the specific error message for debugging
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
