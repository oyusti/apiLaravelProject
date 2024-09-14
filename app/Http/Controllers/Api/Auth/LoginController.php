<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->firstorfail();

        //Verificamos que el usuario exista y que la contraseña sea correcta
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Estas credenciales no coinciden con nuestros registros']
                , 404);
        }else{
            $userResource = UserResource::make($user);
            //create token with sanctum
            $token = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'user' => $userResource,
                'token' => $token
            ], 200);
            //return response()->json($userResource, 200);
        }
    }
}
