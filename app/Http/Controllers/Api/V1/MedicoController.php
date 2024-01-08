<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Medico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicoController extends Controller
{
    public function medicoCita()
    {
        // $datePage = \Request::query('date', '');
        $startDate = \Request::query('start_date', '');
        $endDate = \Request::query('end_date', '');
        $medicoId = \Request::query('medico_id', null);

        // $fecha = Carbon::parse($datePage)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
        $fechaInicio = Carbon::parse($startDate)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
        $fechaFin = Carbon::parse($endDate)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');

        $medico = DB::table('medicos')
            ->select('medicos.*', 'consultorios.numero_consultorio')
            ->join('consultorios', 'medicos.consultorio_id', '=', 'consultorios.id')
            ->where('medicos.id', '=', $medicoId)
            ->get();

        $citas = DB::table('citas')
            ->select(
                'citas.*',
                DB::raw("DATE_FORMAT(citas.fecha, '%d-%m-%Y') AS fecha"),
                'pacientes.nombre',
                'pacientes.apellido_paterno',
                'pacientes.apellido_materno'
            )
            ->join('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
            ->join('medicos', 'citas.medico_id', '=', 'medicos.id')
            // ->where('citas.fecha', '=', $datePage)
            ->where('citas.fecha', '>=', $startDate)
            ->where('citas.fecha', '<=', $endDate)
            ->where('citas.medico_id', '=', $medicoId)
            ->orderBy('citas.hora', 'asc')
            ->get();

        $sumaTotal = DB::table('citas')
            ->where('fecha', '>=', $startDate)
            ->where('fecha', '<=', $endDate)
            ->where('medico_id', '=', $medicoId)
            ->sum('pago');
        // return [$citas, $medico, $fecha, $sumaTotal];
        $pdf = Pdf::loadView(
            'pdf.template',
            compact('citas', 'fechaInicio', 'fechaFin', 'medico', 'sumaTotal')
        )
            ->setPaper('a4', 'portrait');

        return $pdf->stream('reporte_medico.pdf');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicos = Medico::with('consultorio', 'consultorio.ubicacion')->get();
        if ($medicos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron medicos'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($medicos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string'
        ]);

        $medico = Medico::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'consultorio_id' => $request->consultorio_id,
            'status' => true
        ]);

        return response()->json($medico, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = Medico::find($id);
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
        $medico = Medico::find($id);
        if (!$medico) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $medico->nombre = $request->nombre;
        $medico->apellido_paterno = $request->apellido_paterno;
        $medico->apellido_materno = $request->apellido_materno;
        $medico->consultorio_id = $request->consultorio_id;
        $medico->status = $request->status;
        $medico->save();
        return response()->json($medico);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = Medico::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }


}
