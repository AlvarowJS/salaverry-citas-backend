<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\AuthController as Auth;
use App\Http\Controllers\Api\V1\MedicoController as Medico;
use App\Http\Controllers\Api\V1\PacienteController as Paciente;
use App\Http\Controllers\Api\V1\UbicacionController as Ubicacion;
use App\Http\Controllers\Api\V1\ConsultorioController as Consultorio;
use App\Http\Controllers\Api\V1\PagoController as Pago;
use App\Http\Controllers\Api\V1\UserController as User;
use App\Http\Controllers\Api\V1\CitaController as Cita;
use App\Http\Controllers\Api\V1\EstadoController as Estado;
use App\Http\Controllers\Api\V1\MultiusoController as Multiuso;

use Illuminate\Support\Facades\Route;

Route::post('v1/login', [Auth::class, 'login']);
Route::post('v1/register-user', [Auth::class, 'registerUser']);
Route::post('v1/register-admin', [Auth::class, 'registerAdmin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/token-auth', [Auth::class, 'authToken']);
    Route::apiResource('/v1/medicos', Medico::class);
    Route::apiResource('/v1/pacientes', Paciente::class);
    Route::get('/v1/paciente-citas/{id}', [Paciente::class, 'pacienteCita']);
    Route::apiResource('/v1/ubicacion', Ubicacion::class);
    Route::apiResource('/v1/consultorio', Consultorio::class);
    Route::apiResource('/v1/pagos', Pago::class);
    Route::apiResource('/v1/users', User::class);
    Route::apiResource('/v1/citas', Cita::class);
    Route::get('/v1/citas-selects', [Cita::class, 'mostrarSelects']);
    Route::get('/v1/citas-visitas', [Cita::class, 'confirmarVisita']);
    Route::apiResource('/v1/estados', Estado::class);
    Route::apiResource('/v1/multiusos', Multiuso::class);
    
    // Route::get('/v1/paciente-citas', [Medico::class, 'pacienteCita']);

});
Route::get('/v1/medico-citas', [Medico::class, 'medicoCita']);
