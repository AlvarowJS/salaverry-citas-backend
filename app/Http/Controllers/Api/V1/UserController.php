<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::where('role_id', 2)->get();
        if ($usuarios->isEmpty()) {
            return response()->json(['message' => 'No se encontraron medicos'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Asegura que el correo no se repita
            'password' => 'required|string|min:8',
        ]);
        
        $user = User::create([
            'nombres' => $validatedData['nombres'],
            'apellidos' => $validatedData['apellidos'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => 2,
            'status' => true
        ]);
        
        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'user' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = User::where('role_id', 2)->find($id);

        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json($user);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = User::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
