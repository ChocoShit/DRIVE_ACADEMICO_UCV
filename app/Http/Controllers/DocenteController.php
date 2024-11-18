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
                dp.codigo,
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
                'codigo' => [
                    'required',
                    'string',
                    'size:10',
                    'unique:datos_persona,codigo',
                    'regex:/^\d{10}$/'
                ],
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    'regex:/^[a-zA-Z0-9._%+-]+@ucvvirtual\.edu\.pe$/',
                    'unique:datos_persona,email'
                ],
                'celular' => ['required', 'regex:/^9\d{8}$/'],
                'username' => [
                    'required',
                    'string',
                    'min:4',
                    'unique:usuario,username'
                ],
                'password' => ['required', 'string', 'min:6']
            ], [
                'nombres.required' => 'El nombre es obligatorio',
                'apellidos.required' => 'Los apellidos son obligatorios',
                'codigo.required' => 'El código es obligatorio',
                'codigo.regex' => 'El código debe tener exactamente 10 dígitos numéricos',
                'codigo.unique' => 'El código ya está registrado',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El formato del email no es válido',
                'email.regex' => 'Debe usar su correo institucional (@ucvvirtual.edu.pe)',
                'email.unique' => 'Este correo ya está registrado',
                'celular.required' => 'El número de celular es obligatorio',
                'celular.regex' => 'El número de celular debe empezar con 9 y tener 9 dígitos',
                'username.required' => 'El nombre de usuario es obligatorio',
                'username.min' => 'El nombre de usuario debe tener al menos 4 caracteres',
                'username.unique' => 'Este nombre de usuario ya está registrado',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres'
            ]);

            // Encriptar contraseña
            $hashedPassword = bcrypt($request->password);


            Log::info('Datos a enviar:', [
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'codigo' => $request->codigo,
                'email' => $request->email,
                'celular' => $request->celular,
                'username' => $request->username
            ]);

            $result = DB::select('CALL sp_crear_docente(?, ?, ?, ?, ?, ?, ?)', [
                $request->nombres,
                $request->apellidos,
                $request->codigo,
                $request->email,
                $request->celular,
                $request->username,
                $hashedPassword
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Docente creado correctamente',
                'data' => $result[0] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear docente: ' . $e->getMessage());
            if (strpos($e->getMessage(), 'datos_persona.codigo_UNIQUE') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => 'El código ingresado ya está registrado en el sistema'
                ], 422);
            }
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
                'codigo' => [
                    'required',
                    'string',
                    'size:10',
                    'unique:datos_persona,codigo,'.$id.',id_usuario',
                    'regex:/^\d{10}$/'
                ],
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    'regex:/^[a-zA-Z0-9._%+-]+@ucvvirtual\.edu\.pe$/',
                    'unique:datos_persona,email,'.$id.',id_usuario'
                ],
                'celular' => [
                    'required',
                    'string',
                    'size:9',
                    'regex:/^9\d{8}$/'
                ],
                'username' => [
                    'required',
                    'string',
                    'max:50',
                    'unique:usuario,username,'.$id.',id_usuario'
                ]
            ]);

            $result = DB::select('CALL sp_editar_docente(?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->nombres,
                $request->apellidos,
                $request->codigo,
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
    public function filtrar(Request $request)
    {
        try {
            Log::info('Iniciando filtrado de docentes', $request->all());

            $busqueda = $request->busqueda;
            $estado = $request->estado !== '' ? $request->estado : null;
            $fechaInicio = $request->fecha_inicio ? date('Y-m-d', strtotime($request->fecha_inicio)) : null;
            $fechaFin = $request->fecha_fin ? date('Y-m-d', strtotime($request->fecha_fin)) : null;

            $docentes = DB::select('CALL sp_filtrar_docentes(?, ?, ?, ?)', [
                $busqueda,
                $estado,
                $fechaInicio,
                $fechaFin
            ]);

            Log::info('Docentes filtrados:', ['count' => count($docentes)]);

            return response()->json([
                'success' => true,
                'data' => $docentes
            ]);
        } catch (\Exception $e) {
            Log::error('Error al filtrar docentes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar docentes: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verificarCodigo(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|size:10'
            ]);

            $existe = DB::table('datos_persona')
                ->where('codigo', $request->codigo)
                ->exists();

            return response()->json([
                'success' => true,
                'available' => !$existe,
                'message' => $existe ? 'Código ya registrado' : 'Código disponible'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al verificar código: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar el código'
            ], 500);
        }
    }
}
