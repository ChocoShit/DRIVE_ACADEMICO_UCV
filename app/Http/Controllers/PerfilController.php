<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerfilController extends Controller
{
    public function obtenerPerfil(Request $request)
    {
        try {
            Log::info('Iniciando obtenerPerfil');

            // Obtener el usuario autenticado
            $user = auth()->user();

            if (!$user) {
                Log::warning('Usuario no autenticado');
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            // Llamar al procedimiento almacenado
            $perfil = DB::select('CALL getUserProfile(?)', [$user->id_usuario]);
            Log::info('Resultado del procedimiento:', $perfil ?? ['No hay resultados']);

            if (empty($perfil)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró información del perfil'
                ], 404);
            }

            // Devolver el primer resultado del procedimiento
            return response()->json([
                'success' => true,
                'data' => $perfil[0]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en obtenerPerfil: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el perfil: ' . $e->getMessage()
            ], 500);
        }
    }
}
