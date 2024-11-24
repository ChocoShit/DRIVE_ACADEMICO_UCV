<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\UsuariosModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResumenController extends Controller
{
    public function index()
    {
        return view('Pages.resumen');
    }

    public function listarSecciones()
    {
        try {
            // Usar el procedimiento almacenado sp_listar_secciones
            $secciones = DB::select('CALL sp_listar_secciones_por_usuario(?)', [
                auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'data' => $secciones
            ]);
        } catch (\Exception $e) {
            Log::error('Error en listarSecciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las secciones: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listarAlumnosSeccion($id)
    {
        try {
            // Usar el procedimiento almacenado sp_listar_alumnos
            $alumnos = DB::select('CALL sp_listar_alumnos(?)', [
                $id
            ]);

            return response()->json([
                'success' => true,
                'data' => $alumnos
            ]);
        } catch (\Exception $e) {
            Log::error('Error en listarAlumnosSeccion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los alumnos'
            ], 500);
        }
    }

    public function historialReportes(Request $request)
    {
        try {
            $fechaInicio = $request->fecha_inicio ? $request->fecha_inicio : null;
            $fechaFin = $request->fecha_fin ? $request->fecha_fin : null;

            // Agregamos log para debug
            Log::info('Parámetros de búsqueda:', [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin
            ]);

            $reportes = DB::select('CALL sp_listar_reportes(?, ?)', [
                $fechaInicio,
                $fechaFin
            ]);

            // Agregamos log para ver el resultado
            Log::info('Resultado de sp_listar_reportes:', ['reportes' => $reportes]);

            return response()->json([
                'success' => true,
                'data' => $reportes
            ]);
        } catch (\Exception $e) {
            Log::error('Error en historialReportes: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el historial de reportes: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generarReporteIndividual(Request $request)
    {
        try {
            $idSeccion = $request->id_seccion;
            $idAlumno = $request->id_alumno;

            $reporte = DB::select('CALL sp_generar_reporte_individual(?, ?)', [
                $idSeccion,
                $idAlumno
            ]);

            return response()->json([
                'success' => true,
                'data' => $reporte
            ]);
        } catch (\Exception $e) {
            Log::error('Error en generarReporteIndividual: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte individual'
            ], 500);
        }
    }

    public function generarReporteSeccion(Request $request)
    {
        try {
            $idSeccion = $request->id_seccion;

            $reporte = DB::select('CALL sp_generar_reporte_seccion(?)', [
                $idSeccion
            ]);

            return response()->json([
                'success' => true,
                'data' => $reporte
            ]);
        } catch (\Exception $e) {
            Log::error('Error en generarReporteSeccion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte de sección'
            ], 500);
        }
    }
}
