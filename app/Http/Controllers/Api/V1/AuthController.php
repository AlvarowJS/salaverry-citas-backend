<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authToken(Request $request)
    {
        $token = $request->header('Authorization');
        $user = Auth::user();
        $tableName = $user->getTable();
        $rol = $user->role->role_number;
        $user->role = $rol;
        $user->token = $token;
        $user->table = $tableName;
        return $user;
    }
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $token = $user->createToken('api_token')->plainTextToken;
            $userId = $user->id;
            $nombres = $user->nombres;
            $apellidos = $user->apellidos;
            $email = $user->email;
            $role_id = $user->role_id;
            $status = $user->status;

            if ($status) {
                return response()->json([
                    'user' => $userId,
                    'api_token' => $token,
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
