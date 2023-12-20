<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PagoTipo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pago = PagoTipo::all();
        if ($pago->isEmpty()) {
            return response()->json(['message' => 'No se encontraron medicos'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($pago);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipoPago' => 'required|string',

        ]);

        $pago = PagoTipo::create([
            'tipoPago' => $request->tipoPago,
            'status' => true
        ]);

        return response()->json($pago, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = PagoTipo::find($id);
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
        $pago = PagoTipo::find($id);
        if (!$pago) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $pago->tipoPago = $request->tipoPago;
        $pago->status = $request->status;
        $pago->save();
        return response()->json($pago);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = PagoTipo::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
