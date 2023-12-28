<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $perPage = \Request::query('per_page', 10);
        // $currentPage = \Request::query('page', 1);
        // $searchTerm = \Request::query('search', '');

        // $paciente = Paciente::orderBy('created_at', 'desc');
        $paciente = Paciente::all();
        // if (!empty($searchTerm)) {
        //     $paciente->where(function($q) use ($searchTerm) {
        //         $q->where('nombre', 'LIKE', "%$searchTerm%");
        //     });
        // }

        // $paciente = $paciente->paginate($perPage, ['*'], 'page', $currentPage);

        if ($paciente->isEmpty()){
            return response()->json(['message' => 'No se encontraron pacientes']);
        }
        return response()->json(['data' => $paciente]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'telefono' => 'required|string'
        ]);

        $paciente = Paciente::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'telefono' => $request->telefono,
            'status' => true
        ]);

        return response()->json($paciente, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = Paciente::find($id);
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
        $paciente = Paciente::find($id);
        if (!$paciente) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $paciente->nombre = $request->nombre;
        $paciente->apellido_paterno = $request->apellido_paterno;
        $paciente->apellido_materno = $request->apellido_materno;
        $paciente->telefono = $request->telefono;
        $paciente->status = $request->status;
        $paciente->save();
        return response()->json($paciente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = Paciente::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
