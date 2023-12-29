<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estado = Estado::all();
        if ($estado->isEmpty()) {
            return response()->json(['message' => 'No se encontraron medicos'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($estado);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_estado' => 'required|string',
            'signo_estado' => 'required|string',

        ]);

        $pago = Estado::create([
            'nombre_estado' => $request->nombre_estado,
            'signo_estado' => $request->signo_estado,
        ]);

        return response()->json($pago, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = Estado::find($id);
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
        $estado = Estado::find($id);
        if (!$estado) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $estado->nombre_estado = $request->nombre_estado;
        $estado->signo_estado = $request->signo_estado;
        $estado->save();
        return response()->json($estado);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = Estado::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
