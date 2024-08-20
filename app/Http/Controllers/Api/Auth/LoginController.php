<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->firstorfail();

        //Verificamos que el usuario exista y que la contraseña sea correcta
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Estas credenciales no coinciden con nuestros registros']
                , 404);
        }else{
            return UserResource::make($user);
        }
    }
}
