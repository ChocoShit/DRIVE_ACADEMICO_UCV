<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SeccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listarSecciones(Request $request)
    {
        try {
            // Verificar si la conexión está activa
            if (!DB::connection()->getPdo()) {
                throw new \Exception('No se pudo conectar a la base de datos');
            }

            Log::info('Iniciando listarSecciones');

            // Llamar al procedimiento almacenado sin parámetros inicialmente
            $secciones = DB::select('CALL sp_listar_secciones(NULL, NULL, NULL)');

            Log::info('Secciones recuperadas:', [
                'cantidad' => count($secciones),
                'muestra' => array_slice($secciones, 0, 2) // Log de las primeras 2 secciones
            ]);

            return response()->json([
                'success' => true,
                'data' => array_map(function($seccion) {
                    return [
                        'id_seccion' => $seccion->id_seccion,
                        'nombre_seccion' => $seccion->nombre_seccion,
                        'nombre_curso' => $seccion->nombre_curso,
                        'ciclo' => $seccion->ciclo,
                        'status' => $seccion->status,
                        'total_alumnos' => $seccion->total_alumnos,
                        'docentes' => $seccion->docentes ?: 'Sin asignar'
                    ];
                }, $secciones)
            ]);

        } catch (\PDOException $e) {
            Log::error('Error de PDO en listarSecciones:', [
                'mensaje' => $e->getMessage(),
                'código' => $e->getCode(),
                'archivo' => $e->getFile(),
                'línea' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error de base de datos al cargar las secciones',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error general en listarSecciones:', [
                'mensaje' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'línea' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las secciones',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function listarCursos()
    {
        try {
            Log::info('Iniciando listarCursos');

            // Ejecutar el procedimiento almacenado
            $cursos = DB::select('CALL sp_listar_cursos()');

            Log::info('Cursos obtenidos:', ['cantidad' => count($cursos)]);

            return response()->json([
                'success' => true,
                'data' => $cursos
            ]);

        } catch (\Exception $e) {
            Log::error('Error en listarCursos:', [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los cursos'
            ], 500);
        }
    }

    public function listarDocentesDisponibles()
    {
        try {
            $docentes = DB::select('CALL sp_listar_docentes_disponibles()');

            return response()->json([
                'success' => true,
                'data' => $docentes
            ]);
        } catch (\Exception $e) {
            Log::error('Error en listarDocentesDisponibles:', [
                'mensaje' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'linea' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los docentes disponibles'
            ], 500);
        }
    }

    public function filtrarSecciones(Request $request)
    {
        try {
            Log::info('Iniciando filtrarSecciones con parámetros:', $request->all());

            $cursoId = $request->input('curso_id') ?: null;
            $estado = $request->input('estado') ?: null;
            $ciclo = $request->input('ciclo') ? trim($request->input('ciclo')) : null;

            Log::info('Parámetros procesados:', [
                'curso_id' => $cursoId,
                'estado' => $estado,
                'ciclo' => $ciclo
            ]);

            $secciones = DB::select(
                'CALL sp_filtrar_secciones(?, ?, ?)',
                [$cursoId, $estado, $ciclo]
            );

            return response()->json([
                'success' => true,
                'data' => array_map(function($seccion) {
                    return [
                        'id_seccion' => $seccion->id_seccion,
                        'nombre_seccion' => $seccion->nombre_seccion,
                        'nombre_curso' => $seccion->nombre_curso,
                        'ciclo' => $seccion->ciclo,
                        'status' => $seccion->status,
                        'total_alumnos' => $seccion->total_alumnos ?? 0,
                        'docentes' => $seccion->docentes ?: 'Sin asignar'
                    ];
                }, $secciones)
            ]);
        } catch (\Exception $e) {
            Log::error('Error en filtrarSecciones:', [
                'mensaje' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'linea' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar las secciones',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function crearSeccion(Request $request)
    {
        try {
            Log::info('Datos recibidos:', $request->all());

            $validated = $request->validate([
                'id_curso' => 'required|integer|exists:curso,id_curso',
                'nombre_seccion' => 'required|string|max:10',
                'docentes' => 'required|array',
                'docentes.*' => 'required|integer|exists:usuario,id_usuario'
            ]);

            DB::beginTransaction();

            // Asegurarse de que los valores sean del tipo correcto
            $idCurso = (int) $validated['id_curso'];
            $nombreSeccion = $validated['nombre_seccion'];
            $docentesJson = json_encode(array_map('intval', $validated['docentes']));

            Log::info('Ejecutando sp_crear_seccion con parámetros:', [
                'nombre_seccion' => $nombreSeccion,
                'id_curso' => $idCurso,
                'docentes' => $docentesJson
            ]);

            $seccion = DB::select(
                'CALL sp_crear_seccion(?, ?, ?)',
                [$nombreSeccion, $idCurso, $docentesJson]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sección creada correctamente',
                'data' => $seccion[0] ?? null
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear sección:', [
                'mensaje' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al crear la sección',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}

