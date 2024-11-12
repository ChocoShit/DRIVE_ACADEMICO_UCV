<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DocenteController extends Controller
{
    public function listarDocentes()
    {
        try {
            Log::info('Iniciando listarDocentes');

            $docentes = DB::select('CALL sp_listar_docentes()');

            Log::info('Docentes encontrados: ' . count($docentes));

            return response()->json([
                'success' => true,
                'data' => $docentes
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar docentes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la lista de docentes'
            ], 500);
        }
    }

    public function obtenerDocente($id)
    {
        try {
            $docente = DB::select('SELECT
                u.id_usuario,
                dp.nombres,
                dp.apellidos,
                dp.edad,
                dp.email,
                dp.celular,
                u.username,
                u.status
            FROM usuario u
            INNER JOIN datos_persona dp ON u.id_usuario = dp.id_usuario
            WHERE u.id_usuario = ?', [$id]);

            if (empty($docente)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Docente no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $docente[0]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener docente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la información del docente'
            ], 500);
        }
    }

    public function cambiarEstado(Request $request, $id)
    {
        try {
            Log::info('Cambiando estado', ['id' => $id, 'status' => $request->status]);

            $result = DB::select('CALL sp_cambiar_estado_usuario(?, ?)', [
                $id,
                $request->status
            ]);

            if (empty($result)) {
                throw new \Exception('No se pudo actualizar el estado');
            }

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente',
                'data' => $result[0]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function crearDocente(Request $request)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'edad' => 'required|integer|min:18|max:100',
                'email' => 'required|email|max:100|unique:datos_persona,email',
                'celular' => 'nullable|string|max:15',
                'username' => 'required|string|max:50|unique:usuario,username',
                'password' => 'required|string|min:6|max:20'
            ]);

            // Encriptar contraseña antes de enviarla al SP
            $hashedPassword = bcrypt($request->password);

            $result = DB::select('CALL sp_crear_docente(?, ?, ?, ?, ?, ?, ?)', [
                $request->nombres,
                $request->apellidos,
                $request->edad,
                $request->email,
                $request->celular,
                $request->username,
                $hashedPassword  // Enviamos la contraseña ya encriptada
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Docente creado correctamente',
                'data' => $result[0] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear docente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el docente: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editarDocente(Request $request, $id)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'edad' => 'required|integer|min:18|max:100',
                'email' => 'required|email|max:100',
                'celular' => 'nullable|string|max:15',
                'username' => 'required|string|max:50'
            ]);

            $result = DB::select('CALL sp_editar_docente(?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->nombres,
                $request->apellidos,
                $request->edad,
                $request->email,
                $request->celular,
                $request->username
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Docente actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al editar docente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el docente: ' . $e->getMessage()
            ], 500);
        }
    }
}
