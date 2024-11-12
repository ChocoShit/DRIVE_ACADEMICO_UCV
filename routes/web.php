<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\SeccionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class,'getLogin'])->name('login');
Route::get('/dashboard',[MainController::class,'RenderDashboard'])->name('dashboard');

Route::post('/login',[AuthController::class,'postLogin'])->name('login.post');
Route::post('/logout',[AuthController::class,'postLogout'])->name('login.logout');

//Route::get('/alumnos/listar', [AlumnoController::class, 'listarAlumnos'])->name('alumnos.listar');

Route::middleware(['auth'])->group(function () {
    Route::prefix('alumnos')->group(function () {
        Route::get('/listar', [AlumnoController::class, 'listarAlumnos'])->name('alumnos.listar');
        Route::post('/crear', [AlumnoController::class, 'crearAlumno'])->name('alumnos.crear');
        Route::put('/actualizar/{id}', [AlumnoController::class, 'actualizarAlumno'])->name('alumnos.actualizar');
        Route::put('/estado/{id}', [AlumnoController::class, 'cambiarEstado'])->name('alumnos.estado');
        Route::put('/editar/{id}', [AlumnoController::class, 'editarAlumno'])->name('alumnos.editar');
    });

    Route::prefix('docentes')->group(function () {
        Route::get('/listar', [DocenteController::class, 'listarDocentes']);
        Route::get('/{id}', [DocenteController::class, 'obtenerDocente']);
        Route::put('/estado/{id}', [DocenteController::class, 'cambiarEstado']);
        Route::put('/editar/{id}', [DocenteController::class, 'editarDocente']);
        Route::post('/crear', [DocenteController::class, 'crearDocente']);
    });

    Route::prefix('cursos')->group(function () {
        Route::get('/listar', [SeccionController::class, 'listarCursos']);
    });

    Route::prefix('secciones')->group(function () {
        Route::get('/listar', [SeccionController::class, 'listarSecciones']);
        Route::post('/crear', [SeccionController::class, 'crearSeccion']);
        Route::put('/estado/{id}', [SeccionController::class, 'cambiarEstado']);
        Route::get('/docentes', [SeccionController::class, 'listarDocentes']);
    });
});
