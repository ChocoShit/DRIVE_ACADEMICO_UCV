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

    public function listarSecciones()
    {
        try {
            Log::info('Iniciando listarSecciones');

            // Ejecutar el procedimiento almacenado
            $secciones = DB::select('CALL sp_listar_secciones(NULL, NULL, NULL)');

            Log::info('Resultado de sp_listar_secciones:', [
                'cantidad' => count($secciones),
                'datos' => $secciones
            ]);

            // Verificar si hay datos
            if (empty($secciones)) {
                Log::info('No se encontraron secciones');
                return response()->json([
                    'success' => true,
                    'data' => []
                ]);
            }

            // Mapear los resultados
            $seccionesMapeadas = array_map(function($seccion) {
                return [
                    'id_seccion' => $seccion->id_seccion,
                    'nombre_seccion' => $seccion->nombre_seccion,
                    'nombre_curso' => $seccion->nombre_curso,
                    'ciclo' => $seccion->ciclo,
                    'total_alumnos' => $seccion->total_alumnos,
                    'docentes' => $seccion->docentes ?: 'Sin asignar',
                    'status' => $seccion->status
                ];
            }, $secciones);

            Log::info('Enviando respuesta con secciones mapeadas:', [
                'cantidad' => count($seccionesMapeadas)
            ]);

            return response()->json([
                'success' => true,
                'data' => $seccionesMapeadas
            ]);

        } catch (\Exception $e) {
            Log::error('Error en listarSecciones:', [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las secciones'
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
            $cursoId = $request->input('curso') ?: null;
            $ciclo = $request->input('ciclo') ?: null;
            $docenteId = $request->input('docente') ?: null;
            $status = $request->input('estado') !== '' ? $request->input('estado') : null;

            $secciones = DB::select('CALL sp_listar_secciones(?, ?, ?, ?)', [
                $cursoId,
                $ciclo,
                $docenteId,
                $status
            ]);

            return response()->json([
                'success' => true,
                'data' => $secciones
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar las secciones'
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

    public function cambiarEstado(Request $request, $idSeccion)
    {
        try {
            $nuevoEstado = $request->input('status');

            Log::info('Cambiando estado de sección:', [
                'id_seccion' => $idSeccion,
                'nuevo_estado' => $nuevoEstado
            ]);

            $resultado = DB::select('CALL sp_cambiar_estado_seccion(?, ?)', [
                $idSeccion,
                $nuevoEstado
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente',
                'data' => $resultado[0] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado'
            ], 500);
        }
    }

    public function listarNombresSecciones()
    {
        try {
            $secciones = DB::select('CALL sp_listar_nombres_secciones()');
            return response()->json([
                'success' => true,
                'data' => $secciones
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las secciones'
            ], 500);
        }
    }

    public function crearNuevaSeccion(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_seccion' => 'required|string|max:10'
            ]);

            $seccion = DB::select('CALL sp_crear_nueva_seccion(?)', [
                $validated['nombre_seccion']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sección creada correctamente',
                'data' => $seccion[0]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la sección'
            ], 500);
        }
    }

    public function asignarSeccion(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_seccion' => 'required|integer',
                'id_curso' => 'required|integer',
                'id_docente' => 'required|integer'
            ]);

            $resultado = DB::select('CALL sp_asignar_seccion(?, ?, ?)', [
                $validated['id_seccion'],
                $validated['id_curso'],
                $validated['id_docente']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sección asignada correctamente',
                'data' => $resultado[0]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

