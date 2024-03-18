<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Consultorio;
use App\Models\Estado;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\PagoTipo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CitaController extends Controller
{

    public function mostrarSelects()
    {
        $consultorios = Consultorio::all();
        $pacientes = Paciente::all();
        $pagos = PagoTipo::all();
        $estados = Estado::all();
        $medicos = Medico::all();

        $citas = Cita::where('paciente_id', 1)
              ->where('medico_id', 1)
              ->get();

        return $citas;

        return response ()->json([
            "consultorios"=> $consultorios,
            "pacientes"=> $pacientes,
            "pagos"=> $pagos,
            "estados"=> $estados,
            "medicos"=> $medicos
        ]);
    }
    public function confirmarCita(Request $request, string $id)
    {
        $datos = Cita::find($id);
        $datos->confirmar = $request->confirmar;
        $datos->save();
        return response()->json($datos);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datePage = \Request::query('date', '');
        $datos = Medico::with([
            'citas' => function ($query) use ($datePage) {
                $query->whereDate('fecha', $datePage)
                    ->where('multiuso', false)
                    ->orderBy('hora');
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
            'observacion' => $request->observacion,
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
        // $cita = Cita::find($id);
        // if (!$cita) {
        //     return response()->json(['message' => 'Registro no encontrado'], 404);
        // }
        // $cita->silla = $request->silla;
        // $cita->pago = $request->pago;
        // $cita->confirmar = $request->confirmar;
        // $cita->multiuso = false;
        // $cita->llego = $request->llego;
        // $cita->observacion = $request->observacion;
        // $cita->entro = $request->entro;
        // $cita->user_id = $request->user_id;
        // $cita->paciente_id = $request->paciente_id;
        // $cita->pago_tipo_id = $request->pago_tipo_id;

        // $cita->fecha = $request->fecha;
        // $cita->medico_id = $request->medico_id;
        // $cita->hora = $request->hora;

        // $cita->save();
        // return response()->json($cita);
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Comprueba si hay otra cita con la misma fecha y hora para el mismo médico
        $existingCita = Cita::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('medico_id', $request->medico_id)
            ->where('id', '<>', $id) // Excluye la cita actual para permitir la actualización
            ->first();

        if ($existingCita) {
            return response()->json(['error' => 'Ya existe una cita para esta fecha y hora con el mismo médico.'], 409);
        }

        // Actualiza los campos
        $cita->update($request->all());
        // $cita->update($request->except('fecha', 'hora'));

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
