<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Login vigilante
     * Generate an access token to use in the rest of the app
     * 
	 * @group  v 1.0.0
     * 
     * @bodyParam user String required Contractor Email.
     * @bodyParam pass String required Contractor password.
     * 
     * 
	 */
    public function login(LoginRequest $request){

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                "message" => "Correo o contraseña incorrectos"
            ], 401);
        }

        $user = User::whereEmail($request->email)->first();
        $token = $user->createToken("auth_token")->plainTextToken;
        return response()->json([
            "message" => "Bienvenido ".$user->name,
            "token" => $token   
        ], 200);
    }

    /**
     * Logout vigilante
     * Remove access token
     * 
	 * @group  v 1.0.0
     * 
     * 
     * @authenticated
     * 
	 */
    public function logout(Request $request){
        /** @var User $user */
        $user = auth('sanctum')->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            "message" => "Se ha cerrado la sesión correctamente",
            "success" => true   
        ], 200);
    }
    
}
