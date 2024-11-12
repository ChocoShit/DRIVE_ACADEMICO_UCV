<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class alumnoController extends Controller
{
    public function listarAlumnos()
    {
        try {
            Log::info('Iniciando listarAlumnos');

            // Verificar si el procedimiento existe
            try {
                $procedureExists = DB::select("SHOW PROCEDURE STATUS WHERE Db = ? AND Name = ?", [
                    env('DB_DATABASE'), 'sp_listar_alumnos'
                ]);

                if (empty($procedureExists)) {
                    throw new \Exception('El procedimiento almacenado sp_listar_alumnos no existe');
                }

                // Llamar al procedimiento almacenado
                $alumnos = DB::select('CALL sp_listar_alumnos()');

                Log::info('Alumnos encontrados: ' . count($alumnos));

                return response()->json([
                    'success' => true,
                    'data' => $alumnos
                ]);
            } catch (\Exception $e) {
                Log::error('Error específico: ' . $e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Error en listarAlumnos: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la lista de alumnos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function crearAlumno(Request $request)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'edad' => 'required|integer|min:18|max:100',
                'ciclo' => 'required|string|max:2',
                'email' => 'required|email|unique:datos_persona,email',
                'celular' => 'nullable|string|max:15',
                'username' => 'required|string|unique:usuario,username',
                'password' => 'required|string|min:6'
            ]);

            // Iniciar transacción
            DB::beginTransaction();

            // Llamar al procedimiento almacenado para crear alumno
            $resultado = DB::select('CALL sp_crear_alumno(?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->nombres,
                $request->apellidos,
                $request->edad,
                $request->ciclo,
                $request->email,
                $request->celular,
                $request->username,
                Hash::make($request->password)
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Alumno creado exitosamente',
                'data' => $resultado[0] ?? null
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear alumno: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el alumno'
            ], 500);
        }
    }

    public function actualizarAlumno(Request $request, $id)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'edad' => 'required|integer|min:18|max:100',
                'email' => 'required|email|unique:datos_persona,email,'.$id.',id_usuario',
                'celular' => 'nullable|string|max:15',
                'username' => 'required|string|unique:usuario,username,'.$id.',id_usuario',
                'ciclo' => 'required|string|max:2'
            ]);

            $result = DB::select('CALL sp_editar_alumno(?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->nombres,
                $request->apellidos,
                $request->edad,
                $request->email,
                $request->celular,
                $request->username,
                $request->ciclo
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Alumno actualizado exitosamente',
                'fecha_actualizacion' => $result[0]->fecha_actualizacion ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar alumno: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el alumno: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cambiarEstado(Request $request, $id)
    {
        try {
            Log::info('Cambiando estado de alumno', [
                'id' => $id,
                'status' => $request->status,
                'request' => $request->all()
            ]);

            $result = DB::select('CALL sp_cambiar_estado_usuario(?, ?)', [
                $id,
                $request->status
            ]);

            if (empty($result)) {
                throw new \Exception('No se pudo actualizar el estado');
            }

            // Verificar que el estado se actualizó correctamente
            Log::info('Estado actualizado', ['resultado' => $result[0]]);

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente',
                'data' => $result[0]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado de alumno: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /* public function obtenerAlumno($id)
    {
        try {
            Log::info('Obteniendo información del alumno', ['id' => $id]);

            $alumno = DB::table('usuario as u')
                ->join('datos_persona as dp', 'u.id_usuario', '=', 'dp.id_usuario')
                ->select(
                    'u.id_usuario',
                    'dp.nombres',
                    'dp.apellidos',
                    'dp.edad',
                    'dp.ciclo',
                    'dp.email',
                    'dp.celular',
                    'u.username',
                    'u.status',
                    DB::raw("DATE_FORMAT(u.created_at, '%d/%m/%Y') as fecha_registro")
                )
                ->where('u.id_usuario', $id)
                ->first();

            if (!$alumno) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alumno no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $alumno
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener alumno: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la información del alumno: ' . $e->getMessage()
            ], 500);
        }
    } */

    public function editarAlumno(Request $request, $id)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'edad' => 'required|integer|min:16|max:100',
                'email' => 'required|email|max:100',
                'celular' => 'nullable|string|max:15',
                'ciclo' => 'required|string|max:2',
                'username' => 'required|string|max:50'
            ]);

            $result = DB::select('CALL sp_editar_alumno(?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->nombres,
                $request->apellidos,
                $request->edad,
                $request->email,
                $request->celular,
                $request->ciclo,
                $request->username
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Alumno actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al editar alumno: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el alumno: ' . $e->getMessage()
            ], 500);
        }
    }
}
