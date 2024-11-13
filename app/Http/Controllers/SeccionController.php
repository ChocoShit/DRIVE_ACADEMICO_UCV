<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listarSecciones(Request $request)
    {
        try {
            // Obtener parámetros de filtro (opcionales)
            $cursoId = $request->input('curso_id');
            $ciclo = $request->input('ciclo');
            $estado = $request->input('estado');

            // Llamar al procedimiento almacenado
            $secciones = DB::select(
                'CALL sp_listar_secciones(?, ?, ?)',
                [
                    $cursoId ?: null,
                    $ciclo ?: null,
                    $estado ?: null
                ]
            );

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

    public function listarCursos()
    {
        try {
            $cursos = DB::table('cursos')
                ->select('id_curso', 'nombre_curso', 'ciclo')
                ->where('status', '1')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $cursos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los cursos: ' . $e->getMessage()
            ], 500);
        }
    }
}

