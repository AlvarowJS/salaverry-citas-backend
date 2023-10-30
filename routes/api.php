<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\AuthController as Auth;

use Illuminate\Support\Facades\Route;

Route::post('v1/login', [Auth::class, 'login']);
Route::post('v1/register-user', [Auth::class, 'registerUser']);
Route::post('v1/register-admin', [Auth::class, 'registerAdmin']);
