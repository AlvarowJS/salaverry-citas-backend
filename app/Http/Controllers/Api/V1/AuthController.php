<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;
            $nombres = $user->nombres;
            $apellidos = $user->apellidos;
            $email = $user->email;
            $role_id = $user->role_id;
            $status = $user->status;

            if ($status) {
                return response()->json([
                    'token' => $token,
                    'email' => $email,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'role_id' => $role_id,
                ]);
            } else {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
        } else {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
    }
    public function registerUser(Request $request)
    {
        $user = User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'status' => true
        ]);
        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'user' => $user,
        ], 201);
    }
    public function registerAdmin(Request $request)
    {        
        $user = User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
            'status' => true
        ]);
        return response()->json([
            'message' => 'Administrador creado exitosamente.',
            'user' => $user,
        ], 201);
    }

    public function desactivarUser(Request $request)
    {

    }
}
