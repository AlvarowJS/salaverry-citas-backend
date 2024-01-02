<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datePage = \Request::query('date', '');
        $datos = Medico::with(['citas' => function ($query) use ($datePage) {
            $query->whereDate('fecha', $datePage);
        }, 'citas.paciente', 'citas.pagotipo', 'consultorio'])
            ->get();

        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'fecha' => 'required|date',
        //     'hora' => 'required|time',
        // ]);

        $cita = Cita::create([
            'fecha' => $request->fecha,
            'silla' => $request->silla,
            'pago' => $request->pago,
            'hora' => $request->hora,
            'confirmar' => $request->confirmar,
            'llego' => $request->llego,
            'entro' => $request->entro,
            'user_id' => $request->user_id,
            'paciente_id' => $request->paciente_id,
            // 'consultorio_id' => $request->consultorio_id,
            'medico_id' => $request->medico_id,
            'pago_tipo_id' => $request->pago_tipo_id,
        ]);

        return response()->json($cita, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = Cita::find($id);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = Cita::find($id);

        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
