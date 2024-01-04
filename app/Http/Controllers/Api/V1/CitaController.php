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
        $datos = Medico::with([
            'citas' => function ($query) use ($datePage) {
                $query->whereDate('fecha', $datePage)
                    ->where('multiuso', false);
            },
            'citas.paciente',
            'citas.pagotipo',
            'consultorio'
        ])
            ->get();

        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $citaExistente = Cita::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('medico_id', $request->medico_id)
            ->first();
        if ($citaExistente) {
            // Si ya existe una cita, retornar un error 409
            return response()->json(['error' => 'La cita ya está registrada para esta hora y fecha con el médico correspondiente.'], Response::HTTP_CONFLICT);
        }

        $cita = Cita::create([
            'fecha' => $request->fecha,
            'silla' => $request->silla,
            'pago' => $request->pago,
            'hora' => $request->hora,
            'confirmar' => $request->confirmar,
            'multiuso' => 0,
            'llego' => $request->llego,
            'entro' => $request->entro,
            'user_id' => $request->user_id,
            'paciente_id' => $request->paciente_id,
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
        $datos = Cita::with('paciente')->find($id);
        // $datos = Cliente::with('asesor')->find($id);

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
        $cita = Cita::find($id);
        if (!$cita) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $cita->silla = $request->silla;
        $cita->pago = $request->pago;
        $cita->confirmar = $request->confirmar;
        $cita->multiuso = false;
        $cita->llego = $request->llego;
        $cita->entro = $request->entro;
        $cita->user_id = $request->user_id;
        $cita->paciente_id = $request->paciente_id;
        $cita->pago_tipo_id = $request->pago_tipo_id;

        if (
            $cita->fecha != $request->fecha &&
            $cita->hora != $request->hora &&
            $cita->medico_id != $request->medico_id
        ) {
            $cita->fecha = $request->fecha;
            $cita->medico_id = $request->medico_id;
            $cita->hora = $request->hora;
        } else {
            $existingCita = Cita::where('fecha', $request->fecha)
                ->where('hora', $request->hora)
                ->where('medico_id', $request->medico_id)
                ->first();
            if ($existingCita) {
                return response()->json(['error' => 'La cita ya existe para esta fecha y hora.'], Response::HTTP_CONFLICT);
            }
        }
        return $cita;
        $cita->save();
        return response()->json($cita);

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
