<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class AlumnoController extends Controller
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
            $validator = Validator::make($request->all(), [
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'codigo' => [ 'required','string','regex:/^\d{10}$/','unique:datos_persona,codigo,' . $request->id_usuario . ',id_usuario'],
                'ciclo' => 'required|string|max:2',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@ucvvirtual\.edu\.pe$/',
                    'unique:datos_persona,email'
                ],
                'celular' => ['nullable','regex:/^9\d{8}$/' ],
                'username' => [
                    'required',
                    'string',
                    'min:4',
                    'unique:usuario,username'
                ],
                'password' => ['required','string', 'min:6' ],


                //mensajes de validacion
                'nombres.required' => 'El nombre es obligatorio',
                'apellidos.required' => 'Los apellidos son obligatorios',
                'codigo.required' => 'El código es obligatorio',
                'codigo.regex' => 'El código debe tener exactamente 10 dígitos numéricos',
                'codigo.unique' => 'El código ya está registrado',
                'ciclo.required' => 'El ciclo es obligatorio',
                'ciclo.in' => 'El ciclo debe ser IX o X',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El formato del email no es válido',
                'email.regex' => 'Debe usar su correo institucional (@ucvvirtual.edu.pe)',
                'email.unique' => 'Este correo ya está registrado',
                'celular.regex' => 'El número de celular debe empezar con 9 y tener 9 dígitos',
                'username.required' => 'El nombre de usuario es obligatorio',
                'username.min' => 'El nombre de usuario debe tener al menos 4 caracteres',
                'username.unique' => 'Este nombre de usuario ya está registrado',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            ], [
                'email.regex' => 'Debe usar su correo institucional (@ucvvirtual.edu.pe)',
                'email.unique' => 'Este correo ya está registrado',
                'username.unique' => 'Este nombre de usuario ya está registrado',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Iniciar transacción
            DB::beginTransaction();

            // Llamar al procedimiento almacenado para crear alumno
            $resultado = DB::select('CALL sp_crear_alumno(?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->nombres,
                $request->apellidos,
                $request->codigo,
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
                'message' => 'Error al crear el alumno: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verificarUsuario(Request $request)
    {
        try {
            $username = $request->username;

            $exists = DB::table('usuario')
                ->where('username', $username)
                ->exists();

            return response()->json([
                'disponible' => !$exists
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al verificar usuario'
            ], 500);
        }
    }
    public function actualizarAlumno(Request $request, $id)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'codigo' => 'required|integer|min:18|max:100',
                'email' => 'required|email|unique:datos_persona,email,'.$id.',id_usuario',
                'celular' => 'nullable|string|max:15',
                'username' => 'required|string|unique:usuario,username,'.$id.',id_usuario',
                'ciclo' => 'required|string|max:2'
            ]);

            $result = DB::select('CALL sp_editar_alumno(?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->nombres,
                $request->apellidos,
                $request->codigo,
                $request->email,
                $request->celular,
                $request->ciclo,
                $request->username
            ]);
            if (empty($result)) {
                throw new \Exception('No se pudo actualizar el alumno');
            }
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
    public function filtrar(Request $request)
{
    try {
        $busqueda = $request->busqueda ?? null;
        $ciclo = $request->ciclo ?? null;
        $estado = $request->estado ?? null;
        $fechaInicio = $request->fecha_inicio ? date('Y-m-d', strtotime($request->fecha_inicio)) : null;
        $fechaFin = $request->fecha_fin ? date('Y-m-d', strtotime($request->fecha_fin)) : null;

        // Llamada al procedimiento almacenado
        $alumnos = DB::select('CALL sp_filtrar_alumnos(?, ?, ?, ?, ?)', [
            $busqueda,
            $ciclo,
            $estado,
            $fechaInicio,
            $fechaFin
        ]);

        return response()->json([
            'success' => true,
            'data' => $alumnos
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al filtrar alumnos: ' . $e->getMessage()
        ], 500);
    }
}


///repetico////
    public function editarAlumno(Request $request, $id)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'codigo' => 'required|integer|min:16|max:100',
                'email' => 'required|email|max:100',
                'celular' => 'nullable|string|max:15',
                'ciclo' => 'required|string|max:2',
                'username' => 'required|string|max:50'
            ]);

            $result = DB::select('CALL sp_editar_alumno(?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->nombres,
                $request->apellidos,
                $request->codigo,
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
