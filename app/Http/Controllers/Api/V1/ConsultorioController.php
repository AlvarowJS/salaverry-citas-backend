<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Consultorio;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConsultorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultorios = Consultorio::with('ubicacion')->get();
        if ($consultorios->isEmpty()) {
            return response()->json(['message' => 'No se encontraron consultorios'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($consultorios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_consultorio' => 'required|string',
        ]);

        $medico = Consultorio::create([
            'numero_consultorio' => $request->numero_consultorio,
            'ubicacion_id' => $request->ubicacion_id,
            'status' => true
        ]);

        return response()->json($medico, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = Consultorio::find($id);
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
        $consultorio = Consultorio::find($id);
        if (!$consultorio) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $consultorio->numero_consultorio = $request->numero_consultorio;
        $consultorio->ubicacion_id = $request->ubicacion_id;
        $consultorio->status = $request->status;
        $consultorio->save();
        return response()->json($consultorio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = Consultorio::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
