<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Consultorio;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ubicacion = Ubicacion::all();
        if ($ubicacion->isEmpty()) {
            return response()->json(['message' => 'No se encontraron ubicaciones'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($ubicacion);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_ubicacion' => 'required|string',            
        ]);

        $ubicacion = Ubicacion::create([
            'nombre_ubicacion' => $request->nombre_ubicacion,
        ]);

        return response()->json($ubicacion, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = Ubicacion::find($id);
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
        $ubicacion = Ubicacion::find($id);
        if (!$ubicacion) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $ubicacion->nombre_ubicacion = $request->nombre_ubicacion;        
        $ubicacion->save();
        return response()->json($ubicacion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = Ubicacion::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
