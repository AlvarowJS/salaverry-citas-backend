<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\AuthController as Auth;
use App\Http\Controllers\Api\V1\MedicoController as Medico;
use App\Http\Controllers\Api\V1\PacienteController as Paciente;
use App\Http\Controllers\Api\V1\UbicacionController as Ubicacion;
use App\Http\Controllers\Api\V1\ConsultorioController as Consultorio;

use Illuminate\Support\Facades\Route;

Route::post('v1/login', [Auth::class, 'login']);
Route::post('v1/register-user', [Auth::class, 'registerUser']);
Route::post('v1/register-admin', [Auth::class, 'registerAdmin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/token-auth', [Auth::class, 'authToken']);
    Route::apiResource('/v1/medicos', Medico::class);
    Route::apiResource('/v1/pacientes', Paciente::class);
    Route::apiResource('/v1/ubicacion', Ubicacion::class);
    Route::apiResource('/v1/consultorio', Consultorio::class);

});