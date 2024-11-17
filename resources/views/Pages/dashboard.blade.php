@extends('Layouts.AppLayout')

@section('title')
DRIVE UCV
@endsection

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-white fixed h-full">
        <div class="p-4">
            <h2 class="text-xl font-bold mb-6 text-center">DRIVE UCV</h2>
            <nav>
                <a href="#" data-section="resumen" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1 active">
                    <i class="fas fa-home w-6"></i>
                    <span>Resumen</span>
                </a>
                @if(auth()->user()->id_tipo_usuario == 1 )
                <a href="#" data-section="alumnos" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1">
                    <i class="fas fa-users w-6"></i>
                    <span>Gestión de Alumnos</span>
                </a>

                <a href="#" data-section="docentes" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1">
                    <i class="fas fa-chalkboard-teacher w-6"></i>
                    <span>Gestión de Docentes</span>
                </a>
                <a href="#" data-section="secciones" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1">
                    <i class="fas fa-layer-group w-6"></i>
                    <span>Gestión de Secciones</span>
                </a>

                <a href="#" data-section="asignaciones" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1">
                    <i class="fas fa-tasks w-6"></i>
                    <span>Asignaciones</span>
                </a>
                @elseif( auth()->user()->id_tipo_usuario == 2 )
                <a href="#" data-section="alumnos" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1">
                    <i class="fas fa-users w-6"></i>
                    <span>Gestión de Alumnos</span>
                </a>
                <a href="#" data-section="asignaciones" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1">
                    <i class="fas fa-tasks w-6"></i>
                    <span>Asignaciones</span>
                </a>
                @endif
                <a href="#" data-section="archivos" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1">
                    <i class="fas fa-folder w-6"></i>
                    <span>Explorador de Archivos</span>
                </a>
            </nav>
        </div>
        <div class="absolute bottom-4 w-full px-4">
            <form action="{{route('login.logout')}}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg flex items-center justify-center">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="ml-64 flex-1">
        <!-- Header con perfil -->
        <div class="bg-white shadow h-16 fixed right-0 left-64 top-0 z-10">
            <div class="flex justify-end h-full px-4">
                <div class="relative">
                    <button
                        id="profile-menu-button"
                        class="h-full flex items-center space-x-2 hover:bg-gray-50 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg"
                        aria-expanded="false"
                        aria-haspopup="true"
                        aria-controls="profile-dropdown"
                        title="Menú de perfil">
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold" aria-hidden="true">
                            {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                        </div>
                        <span class="text-gray-700">{{ auth()->user()->username }}</span>
                        <i class="fas fa-chevron-down text-gray-400 text-sm" aria-hidden="true"></i>
                    </button>

                    <!-- Menú desplegable mejorado -->
                    <div id="profile-dropdown"
                        class="absolute right-0 top-full mt-1 w-72 bg-white rounded-lg shadow-lg py-2 hidden"
                        role="menu"
                        aria-labelledby="profile-menu-button">

                        <!-- Información del usuario -->
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->username }}</p>
                            <p class="text-sm text-gray-500">
                                Tipo: {{ auth()->user()->id_tipo_usuario == 1 ? 'Administrador' : 'Usuario' }}
                            </p>
                        </div>

                        <!-- Opciones de Perfil -->
                        <a href="#"
                            onclick="mostrarPerfil(); return false;"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-circle mr-2"></i> Mi Perfil
                        </a>

                        <!-- Opciones de Configuración -->
                        <div class="px-4 py-2 border-t">
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Configuración</p>

                            <a href="#"
                                class="block py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 rounded-md px-2"
                                role="menuitem"
                                onclick="cambiarPassword()">
                                <i class="fas fa-key mr-2"></i> Cambiar contraseña
                            </a>
                            <a href="#"
                                class="block py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 rounded-md px-2"
                                role="menuitem"
                                onclick="configurarNotificaciones()">
                                <i class="fas fa-bell mr-2"></i> Notificaciones
                            </a>
                        </div>

                        <!-- Cerrar Sesión -->
                        <div class="border-t mt-2">
                            <form action="{{route('login.logout')}}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    role="menuitem">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido de las secciones - Agregar padding-top -->
        <div class="p-8 pt-24">
            <!-- Tus secciones existentes -->
            <section id="resumen-section" class="section-content hidden">
                <h1 class="text-2xl font-bold mb-6">Panel Principal</h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Tus tarjetas actuales -->
                </div>
            </section>

            <!------------------------------------------------------------------- Sección Alumnos ------------------------------------------------------>
            <section id="alumnos-section" class="section-content hidden">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestión de Alumnos</h2>
                        <button type="button" onclick="mostrarModalCrearAlumno()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Nuevo Alumno
                        </button>
                    </div>

                    <!-- Buscador -->
                    <div class="mb-4">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text"
                                       id="searchAlumno"
                                       placeholder="Buscar alumno..."
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="flex gap-2">
                                <select id="filterCiclo" class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="">Todos los ciclos</option>
                                    <option value="IX">IX Ciclo</option>
                                    <option value="X">X Ciclo</option>
                                </select>
                                <select id="filterEstadoAlumno" class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="">Todos los estados</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                <div class="flex gap-2">
                                    <input type="date"
                                           id="fechaInicioAlumno"
                                           class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                    <input type="date"
                                           id="fechaFinAlumno"
                                           class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!---- Tabla de Alumnos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombres</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellidos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Celular</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ultima Actualización</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-alumnos" class="divide-y divide-gray-200">
                                <!-- Los datos se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal para Crear/Editar Alumno -->
                <div id="modal-alumno" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
                    <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
                        <!-- Asegúrate de que este ID existe -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium" id="modal-titulo">Nuevo Alumno</h3>
                            <button type="button" onclick="cerrarModalAlumno()" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="form-alumno" onsubmit="guardarAlumno(event)">
                            <div class="grid grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nombres</label>
                                    <input type="text"
                                           name="nombres"
                                           required
                                           onchange="guardarDatosTemporales(event)"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                                    <input type="text" name="apellidos" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Código</label>
                                    <input type="text" name="codigo" requiredmaxlength="10" pattern="[0-9]{10}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Ingrese código de 10 dígitos">
                                    <span class="text-xs text-gray-500">El código debe tener 10 dígitos numéricos</span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ciclo</label>
                                    <select name="ciclo" required class="mt-1 block w-full rounded-md focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccione un ciclo</option>
                                        <option value="IX">IX Ciclo</option>
                                        <option value="X">X Ciclo</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email Institucional</label>
                                    <input type="email"
                                           name="email"
                                           required
                                           pattern="[a-zA-Z0-9._+-]+@ucvvirtual\.edu\.pe"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="ejemplo@ucvvirtual.edu.pe"
                                           title="Por favor ingrese un correo institucional válido (@ucvvirtual.edu.pe)">
                                    <span class="text-xs text-gray-500">Use su correo institucional (@ucvvirtual.edu.pe)</span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Celular</label>
                                    <input type="text" name="celular"  maxlength="9"pattern="[0-9]{9}"oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9)"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Ingrese número de celular"
                                           title="Por favor ingrese un número de 9 dígitos">
                                    <span class="text-xs text-gray-500">El número debe tener 9 dígitos</span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Usuario</label>
                                    <input type="text" name="username"required minlength="4" onkeyup="validarUsuarioDisponible(this.value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Ingrese nombre de usuario">
                                    <span id="username-message" class="text-xs"></span>
                                </div>
                                <div class="form-group" id="password-container">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" id="password-alumno" required>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="button"
                                        onclick="cerrarModalAlumno()"
                                        class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!------------------------------------------------------------------- Sección Docentes ----------------------------------------------------->
            <section id="docentes-section" class="section-content hidden">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestión de Docentes</h2>
                        <button onclick="mostrarModalCrearDocente()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Nuevo Docente
                        </button>
                    </div>

                    <div class="mb-4">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text"
                                       id="searchDocente"
                                       placeholder="Buscar docente..."
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="flex gap-2">
                                <select id="filterEstadoDocente" class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="">Todos los estados</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                <div class="flex gap-2">
                                    <input type="date"
                                           id="fechaInicioDocente"
                                           class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                    <input type="date"
                                           id="fechaFinDocente"
                                           class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Docentes -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombres</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apellidos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Celular</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Secciones Asignadas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ÚLTIMA MODIFICACIÓN</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-docentes">
                                <!-- Se llena dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Sección de Gestión de Secciones -->
            <section id="secciones-section" class="section-content hidden">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestión de Secciones</h2>
                        <button onclick="mostrarModalCrearSeccion()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Nueva Sección
                        </button>
                    </div>

                    <!-- Filtros -->
                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Curso</label>
                                <select id="filtro-curso" onchange="filtrarSecciones()"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Todos los cursos</option>
                                    <!-- Se llenará dinámicamente -->
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Ciclo</label>
                                <select id="filtro-ciclo" onchange="filtrarSecciones()"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Todos los ciclos</option>
                                    <option value="IX">Ciclo IX</option>
                                    <option value="X">Ciclo X</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                <select id="filtro-estado" onchange="filtrarSecciones()"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Todos</option>
                                    <option value="1">Activas</option>
                                    <option value="0">Inactivas</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Secciones -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Curso</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sección</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente(s)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Alumnos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-secciones">
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal para Crear/Editar Sección -->
                <div id="modal-seccion" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium" id="modal-seccion-titulo">Nueva Sección</h3>
                            <button onclick="cerrarModalSeccion()" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="form-seccion" onsubmit="guardarSeccion(event)">
                            <input type="hidden" id="seccion-id" name="id_seccion">
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Curso</label>
                                        <select name="id_curso" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <!-- Se llenará dinámicamente -->
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nombre de la Sección</label>
                                        <input type="text" name="nombre_seccion" required placeholder="Ejemplo: A"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Docente(s)</label>
                                    <select name="docentes[]" multiple required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <!-- Se llenará dinámicamente -->
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">Puede seleccionar múltiples docentes manteniendo presionada la tecla Ctrl</p>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="cerrarModalSeccion()"
                                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Sección Asignaciones -->
            <section id="asignaciones-section" class="section-content hidden">
                <h1 class="text-2xl font-bold mb-6">Asignaciones</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <p>Contenido de la sección de asignaciones</p>
                </div>
            </section>

            <!-- Sección Archivos -->
            <section id="archivos-section" class="section-content hidden">
                <h1 class="text-2xl font-bold mb-6">Explorador de Archivos</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <p>Contenido del explorador de archivos</p>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Agregar este div al final de tu contenido pero antes de cerrar el div principal -->
<div id="modal-perfil" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex flex-col">
            <!-- Header del modal -->
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-xl font-semibold text-gray-900">Mi Perfil</h3>
                <button onclick="cerrarModalPerfil()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Contenido del perfil -->
            <div class="mt-4">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center text-white text-3xl font-bold">
                        <!-- Inicial del usuario -->
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold" id="perfil-nombre"></h4>
                        <p class="text-gray-500" id="perfil-tipo"></p>
                    </div>
                </div>

                <!-- Información detallada -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500">Usuario</label>
                        <p class="font-medium" id="perfil-username"></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Email</label>
                        <p class="font-medium" id="perfil-email"></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Rol</label>
                        <p class="font-medium" id="perfil-rol"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear/Editar Docente -->
<div id="modal-docente" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium" id="modal-docente-titulo">Nuevo Docente</h3>
            <button onclick="cerrarModalDocente()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="form-docente" onsubmit="guardarDocente(event)">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombres</label>
                    <input type="text" name="nombres" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Apellidos -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                    <input type="text" name="apellidos" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Edad -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Código</label>
                    <input type="number" name="código" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Celular -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Celular</label>
                    <input type="text" name="celular"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input type="text" name="username" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Password (solo visible al crear) -->
                <div class="mb-4" id="password-container">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Contraseña
                    </label>
                    <input type="password"
                           name="password"
                           id="password-docente"
                           minlength="6"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="cerrarModalDocente()"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Docentes -->

@endsection
 <!-------------------------------------------------------- scripts --------------------------------------------------------------------->
@section('script')
<script>
$(document).ready(function() {
    // Recuperar la última sección activa del localStorage
    const ultimaSeccion = localStorage.getItem('seccionActiva') || 'resumen';

    // Activar la última sección vista
    activarSeccion(ultimaSeccion);

    // Manejo del menú de navegación
    $('.nav-link').click(function(e) {
        e.preventDefault();
        const sectionId = $(this).data('section');
        activarSeccion(sectionId);

        // Guardar la sección activa en localStorage
        localStorage.setItem('seccionActiva', sectionId);
    });

    // Manejo del menú de perfil
    $('#profile-menu-button').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Click en menú de perfil');
        $('#profile-dropdown').toggleClass('hidden');
    });

    // Cerrar menú de perfil al hacer click fuera
    $(document).click(function(e) {
        if (!$(e.target).closest('#profile-dropdown').length) {
            $('#profile-dropdown').addClass('hidden');
        }
    });

    // Función para mostrar perfil
    window.mostrarPerfil = async function() {
        try {
            const response = await fetch('/api/usuario/perfil', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                const datos = result.data;

                // Usar SweetAlert2 para mostrar el perfil
                Swal.fire({
                    title: 'Mi Perfil',
                    html: `
                        <div class="text-left">
                            <div class="flex items-center justify-center mb-4">
                                <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center text-white text-3xl font-bold">
                                    ${datos.nombres ? datos.nombres[0].toUpperCase() : 'U'}
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="text-lg font-semibold">${datos.nombres} ${datos.apellidos}</p>
                                <p class="text-gray-600">${datos.tipo_usuario}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-gray-500">Usuario</label>
                                    <p class="font-medium">${datos.username}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500">Email</label>
                                    <p class="font-medium">${datos.email}</p>
                                </div>
                            </div>
                        </div>
                    `,
                    showCloseButton: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal2-show-profile',
                        closeButton: 'swal2-close-profile'
                    }
                });
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar la información del perfil: ' + error.message
            });
        }
    };

    // Función para cerrar modal de perfil
    window.cerrarModalPerfil = function() {
        $('#modal-perfil').addClass('hidden');
    };

    // Mostrar sección inicial (resumen)
    $('#resumen-section').removeClass('hidden');
});

// Función para activar una sección específica
function activarSeccion(sectionId) {
    // Remover active de todos los enlaces
    $('.nav-link').removeClass('active bg-gray-700');

    // Agregar active al enlace correspondiente
    $(`[data-section="${sectionId}"]`).addClass('active bg-gray-700');

    // Ocultar todas las secciones
    $('.section-content').addClass('hidden');

    // Mostrar la sección seleccionada
    $(`#${sectionId}-section`).removeClass('hidden');

    // Cargar datos según la sección
    switch(sectionId) {
        case 'alumnos':
            cargarAlumnos();
            break;
        case 'docentes':
            cargarDocentes();
            break;
        case 'secciones':
            cargarSecciones();
            break;
        // Agregar más casos según sea necesario
    }
}

// Funciones para gestión de alumnos
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar eventos cuando el documento esté listo
    const alumnosLink = document.querySelector('[data-section="alumnos"]');
    if (alumnosLink) {
        alumnosLink.addEventListener('click', function() {
            setTimeout(cargarAlumnos, 100); // Pequeño retraso para asegurar que la sección esté visible
        });
    }
});

// Función para cargar la lista de alumnos
async function cargarAlumnos() {
    try {
        const response = await fetch('/drive_ucv/alumnos/listar', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            const tablaAlumnos = document.getElementById('tabla-alumnos');
            if (!tablaAlumnos) {
                throw new Error('No se encontró la tabla de alumnos');
            }

            tablaAlumnos.innerHTML = '';

            result.data.forEach(alumno => {
                const estadoActual = alumno.status == 1 || alumno.status === '1';
                const fechaActualizacion = alumno.fecha_actualizacion
                    ? new Date(alumno.fecha_actualizacion).toLocaleString()
                    : 'No actualizado';

                tablaAlumnos.innerHTML += `
                    <tr data-user-id="${alumno.id_usuario}">
                        <td class="px-6 py-4">${alumno.nombres}</td>
                        <td class="px-6 py-4">${alumno.apellidos}</td>
                        <td class="px-6 py-4">${alumno.codigo}</td>
                        <td class="px-6 py-4">${alumno.ciclo}</td>
                        <td class="px-6 py-4">${alumno.email}</td>
                        <td class="px-6 py-4">${alumno.celular || '-'}</td>
                        <td class="px-6 py-4">${alumno.username}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox"
                                           class="sr-only peer"
                                           ${estadoActual ? 'checked' : ''}
                                           onchange="cambiarEstado('alumnos', ${alumno.id_usuario}, this.checked)">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer
                                            peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                                            dark:peer-focus:ring-blue-800 dark:bg-gray-700
                                            peer-checked:after:translate-x-full peer-checked:after:border-white
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all dark:border-gray-600
                                            peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 status-text">
                                        ${estadoActual ? 'Activo' : 'Inactivo'}
                                    </span>
                                </label>
                            </div>
                        </td>
                        <td class="px-6 py-4">${fechaActualizacion}</td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="editarAlumno(${alumno.id_usuario})"
                                    class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            throw new Error(result.message || 'No se pudieron cargar los alumnos');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los alumnos'
        });
    }
}
function validarFormularioAlumno(form) {
    const codigo = form.querySelector('[name="codigo"]').value.trim();
    const email = form.querySelector('[name="email"]').value.trim();
    const celular = form.querySelector('[name="celular"]').value.trim();
    const username = form.querySelector('[name="username"]').value.trim();
    const password = form.querySelector('[name="password"]').value;

    if (!codigo) {
        throw new Error('El código es obligatorio');
    }
    if (!/^\d{10}$/.test(codigo)) {
        throw new Error('El código debe tener exactamente 10 dígitos numéricos');
    }
    if (!/^\S+@\S+$/.test(email)) {
        throw new Error('El email no es válido');
    }
    if (!/^[a-zA-Z0-9._%+-]+@ucvvirtual\.edu\.pe$/.test(email)) {
        throw new Error('Debe usar su correo institucional (@ucvvirtual.edu.pe)');
    }
    if (celular && !/^9\d{8}$/.test(celular)) {
        throw new Error('El número de celular debe empezar con 9 y tener 9 dígitos');
    }
    if (!username) {
        throw new Error('El nombre de usuario es obligatorio');
    }
    if (username.length < 4) {
        throw new Error('El nombre de usuario debe tener al menos 4 caracteres');
    }
    // Validar contraseña
    if (!password) {
        throw new Error('La contraseña es obligatoria');
    }
    if (password.length < 6) {
        throw new Error('La contraseña debe tener al menos 6 caracteres');
    }
}
// Función para mostrar el modal de crear alumno
function mostrarModalCrearAlumno() {
    const form = document.getElementById('form-alumno');
    const modalTitulo = document.getElementById('modal-titulo');

    // Resetear el formulario
    form.reset();
    delete form.dataset.editId;

    // Mostrar y habilitar el campo de contraseña para crear
    const passwordField = form.querySelector('[name="password"]');
    const passwordContainer = passwordField?.closest('.form-group') || form.querySelector('#password-container');
    if (passwordContainer) {
        passwordContainer.style.display = 'block';
        if (passwordField) {
            passwordField.required = true;
            passwordField.disabled = false;
        }
    }

    // Cambiar título
    modalTitulo.textContent = 'Nuevo Alumno';

    // Mostrar modal
    document.getElementById('modal-alumno').classList.remove('hidden');
}

// Función para cerrar el modal
function cerrarModalAlumno() {
    const modalAlumno = document.getElementById('modal-alumno');
    const formAlumno = document.getElementById('form-alumno');

    if (modalAlumno) {
        const formData = JSON.parse(localStorage.getItem('formAlumnoTemp') || '{}');

        if (Object.keys(formData).length > 0) {
            Swal.fire({
                title: '¿Está seguro de cerrar?',
                text: "Se perderán los datos ingresados",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar',
                cancelButtonText: 'Continuar editando',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('formAlumnoTemp');
                    if (formAlumno) formAlumno.reset();
                    modalAlumno.classList.add('hidden');
                }
            });
        } else {
            modalAlumno.classList.add('hidden');
        }
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const modalAlumno = document.getElementById('modal-alumno');
    if (modalAlumno) {
        // Prevenir cierre al hacer click dentro del contenido del modal
        const modalContent = modalAlumno.querySelector('.relative');
        if (modalContent) {
            modalContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
        modalAlumno.removeEventListener('click', cerrarModalAlumno);
    }
});

    // Opcional: Agregar clase para animación de fade
setTimeout(() => {
    const modal = document.getElementById('modal-alumno'); // o el ID que corresponda
    if (modal) {
        modal.classList.add('show');
    }
}, 10);



// ///////////////////////////////////////////////Función para guardar alumno////////////////////////////////////////////////////////////
async function guardarAlumno(event) {
    event.preventDefault();

    try {
        const form = event.target;
        const formData = new FormData(form);
        const editId = form.dataset.editId;

        // URL según si es edición o creación
        const url = editId
            ? `/drive_ucv/alumnos/editar/${editId}`
            : '/drive_ucv/alumnos/crear';

        // Convertir FormData a objeto
        const data = {};
        formData.forEach((value, key) => {
            if (key === 'codigo') {
                data[key] = value.toString().padStart(10, '0');
            } else if (key === 'celular') {
                data[key] = value ? value.toString().padStart(9, '0') : null;
            } else {
                data[key] = value;
            }
        });

        const response = await fetch(url, {
            method: editId ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (!response.ok) {
            if (response.status === 422) {
                // Manejar errores de validación
                const errores = result.errors || {};
                const mensajeError = Object.values(errores).flat()[0] || 'Error de validación';

                await Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: mensajeError,
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            throw new Error(result.message || 'Error al procesar la solicitud');
        }

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: editId ? 'Alumno actualizado correctamente' : 'Alumno creado correctamente',
                timer: 1500,
                showConfirmButton: false
            });

            // Limpiar y cerrar
            localStorage.removeItem('formAlumnoTemp');
            form.reset();
            document.getElementById('modal-alumno').classList.add('hidden');

            // Recargar la tabla
            await cargarAlumnos();
        } else {
            throw new Error(result.message || 'Error al procesar la solicitud');
        }
    } catch (error) {
        console.error('Error:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al guardar el alumno'
        });
    }
}

// Función para cambiar el estado
async function cambiarEstado(tipo, id, nuevoEstado) {
    try {
        console.log('Cambiando estado:', { tipo, id, nuevoEstado });

        const response = await fetch(`/drive_ucv/${tipo}/estado/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: nuevoEstado ? '1' : '0'
            })
        });

        const result = await response.json();

        if (result.success) {
            // Actualizar el DOM
            const row = document.querySelector(`tr[data-user-id="${id}"]`);
            if (row) {
                const toggleInput = row.querySelector('input[type="checkbox"]');
                const statusText = row.querySelector('.status-text');

                toggleInput.checked = nuevoEstado;
                statusText.textContent = nuevoEstado ? 'Activo' : 'Inactivo';
                statusText.className = `ml-3 text-sm font-medium status-text ${nuevoEstado ? 'text-green-600' : 'text-red-600'}`;
            }

            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: `Estado actualizado correctamente`,
                showConfirmButton: false,
                timer: 1500
            });

            // Mantener la sección actual
            const seccionActual = localStorage.getItem('seccionActiva');
            activarSeccion(seccionActual);
        } else {
            throw new Error(result.message || 'Error al actualizar el estado');
        }
    } catch (error) {
        console.error('Error:', error);

        // Revertir el cambio en la UI
        const row = document.querySelector(`tr[data-user-id="${id}"]`);
        if (row) {
            const toggleInput = row.querySelector('input[type="checkbox"]');
            const statusText = row.querySelector('.status-text');

            toggleInput.checked = !nuevoEstado;
            statusText.textContent = !nuevoEstado ? 'Activo' : 'Inactivo';
            statusText.className = `ml-3 text-sm font-medium status-text ${!nuevoEstado ? 'text-green-600' : 'text-red-600'}`;
        }

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo actualizar el estado'
        });
    }
}

// Función para editar alumno
async function editarAlumno(id) {
    try {
        console.log('Editando alumno:', id);
        const response = await fetch(`/drive_ucv/alumnos/obtener/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            const alumno = result.data;
            const form = document.getElementById('form-alumno');
            const modalTitulo = document.getElementById('modal-titulo');

            // Ocultar y deshabilitar el campo de contraseña
            const passwordField = form.querySelector('[name="password"]');
            const passwordContainer = passwordField?.closest('.form-group') || form.querySelector('#password-container');
            if (passwordContainer) {
                passwordContainer.style.display = 'none';
                if (passwordField) {
                    passwordField.removeAttribute('required');
                    passwordField.disabled = true;
                }
            }

            // Llenar el formulario con los datos existentes
            form.querySelector('[name="nombres"]').value = alumno.nombres;
            form.querySelector('[name="apellidos"]').value = alumno.apellidos;
            form.querySelector('[name="codigo"]').value = alumno.codigo;
            form.querySelector('[name="email"]').value = alumno.email;
            form.querySelector('[name="celular"]').value = alumno.celular || '';
            form.querySelector('[name="username"]').value = alumno.username;
            form.querySelector('[name="ciclo"]').value = alumno.ciclo;

            // Cambiar título y guardar ID para la edición
            modalTitulo.textContent = 'Editar Alumno';
            form.dataset.editId = id;

            // Mostrar modal
            document.getElementById('modal-alumno').classList.remove('hidden');
        } else {
            throw new Error(result.message || 'No se pudo cargar la información del alumno');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar la información del alumno'
        });
    }
}

/////////////////////////////////////////////////////////filtrar alumnos////////////////////////////////////////////////////////////
function filtrarAlumnos() {
    const searchInput = document.getElementById('searchInput');
    const searchField = document.getElementById('searchField');
    const searchText = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('#tabla-alumnos tr');

    rows.forEach(row => {
        let text = '';
        if (searchField.value === 'all') {
            // Buscar en todas las columnas excepto la última (acciones)
            const cells = row.querySelectorAll('td:not(:last-child)');
            text = Array.from(cells).map(cell => cell.textContent).join(' ').toLowerCase();
        } else {
            // Buscar solo en la columna seleccionada
            const cellIndex = {
                'nombres': 0,
                'apellidos': 1,
                'codigo': 2,  // Agregamos el índice para código
                'email': 4,
                'ciclo': 3,
                'username': 6
            }[searchField.value];

            const cell = row.querySelector(`td:nth-child(${cellIndex + 1})`);
            text = cell ? cell.textContent.toLowerCase() : '';
        }

        row.style.display = text.includes(searchText) ? '' : 'none';
    });
}

// Variables globales
let cursoSeleccionadoId = null;

// Cargar cursos al entrar a la sección
document.addEventListener('DOMContentLoaded', function() {
    const seccionesLink = document.querySelector('[data-section="secciones"]');
    if (seccionesLink) {
        seccionesLink.addEventListener('click', cargarCursos);
    }
});

// Función para cargar los cursos
async function cargarCursos() {
    try {
        const response = await fetch('/drive_ucv/cursos/listar');
        const result = await response.json();

        if (result.success) {
            const listaCursos = document.getElementById('lista-cursos');
            listaCursos.innerHTML = '';

            result.data.forEach(curso => {
                listaCursos.innerHTML += `
                    <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow cursor-pointer border"
                         onclick="seleccionarCurso(${curso.id_curso}, '${curso.nombre_curso}')">
                        <h4 class="font-semibold text-lg text-gray-800">${curso.nombre_curso}</h4>
                        <p class="text-sm text-gray-600">Ciclo: ${curso.ciclo}</p>
                        <p class="text-sm text-gray-600 mt-2">
                            <span class="font-medium">${curso.total_secciones || 0}</span> secciones
                        </p>
                    </div>
                `;
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los cursos'
        });
    }
}

// Función para seleccionar un curso y mostrar sus secciones
async function seleccionarCurso(idCurso, nombreCurso) {
    cursoSeleccionadoId = idCurso;
    document.getElementById('curso-seleccionado').textContent = nombreCurso;
    document.getElementById('id-curso-seleccionado').value = idCurso;
    document.getElementById('secciones-curso').classList.remove('hidden');
    await cargarSecciones(idCurso);
}

// Función para cargar las secciones de un curso
async function cargarSecciones(idCurso) {
    try {
        const response = await fetch(`/drive_ucv/secciones/curso/${idCurso}`);
        const result = await response.json();

        if (result.success) {
            const tablaSecciones = document.getElementById('tabla-secciones');
            tablaSecciones.innerHTML = '';

            result.data.forEach(seccion => {
                tablaSecciones.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">${seccion.nombre_seccion}</td>
                        <td class="px-6 py-4">${seccion.docentes}</td>
                        <td class="px-6 py-4 text-center">${seccion.total_alumnos}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                ${seccion.status === '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${seccion.status === '1' ? 'Activa' : 'Inactiva'}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="editarSeccion(${seccion.id_seccion})"
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="cambiarEstadoSeccion(${seccion.id_seccion}, '${seccion.status === '1' ? '0' : '1'}')"
                                    class="text-${seccion.status === '1' ? 'red' : 'green'}-600 hover:text-${seccion.status === '1' ? 'red' : 'green'}-900">
                                <i class="fas fa-${seccion.status === '1' ? 'ban' : 'check-circle'}"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar las secciones'
        });
    }
}

// Variables globales
let editandoSeccionId = null;

// Cargar datos iniciales al entrar a la sección
document.addEventListener('DOMContentLoaded', function() {
    const seccionesLink = document.querySelector('[data-section="secciones"]');
    if (seccionesLink) {
        seccionesLink.addEventListener('click', async function() {
            await cargarCursos();
            await cargarSecciones();
            // Preparar el modal
            const modalSeccion = document.getElementById('modal-seccion');
            if (!modalSeccion._initialized) {
                modalSeccion._initialized = true;
                // Cerrar modal al hacer clic fuera
                modalSeccion.addEventListener('click', function(e) {
                    if (e.target === this) {
                        cerrarModalSeccion();
                    }
                });
            }
        });
    }
});

// Función para cargar los cursos en los filtros y el formulario
async function cargarCursos() {
    try {
        const response = await fetch('/drive_ucv/cursos/listar');
        const result = await response.json();

        if (result.success) {
            const filtroCurso = document.getElementById('filtro-curso');
            const selectCurso = document.querySelector('select[name="id_curso"]');
            const cursos = result.data;

            // Llenar filtro de cursos
            filtroCurso.innerHTML = '<option value="">Todos los cursos</option>';
            // Llenar select del formulario
            selectCurso.innerHTML = '<option value="">Seleccione un curso</option>';

            cursos.forEach(curso => {
                filtroCurso.innerHTML += `
                    <option value="${curso.id_curso}">${curso.nombre_curso} (Ciclo ${curso.ciclo})</option>
                `;
                selectCurso.innerHTML += `
                    <option value="${curso.id_curso}">${curso.nombre_curso} (Ciclo ${curso.ciclo})</option>
                `;
            });
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError('No se pudieron cargar los cursos');
    }
}

// Función para cargar las secciones
async function cargarSecciones() {
    try {
        const response = await fetch('/drive_ucv/secciones/listar');
        const result = await response.json();

        if (result.success) {
            const tablaSecciones = document.getElementById('tabla-secciones');
            tablaSecciones.innerHTML = '';

            result.data.forEach(seccion => {
                tablaSecciones.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">${seccion.nombre_curso}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Ciclo ${seccion.ciclo}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${seccion.nombre_seccion}</td>
                        <td class="px-6 py-4">${seccion.docentes || 'Sin asignar'}</td>
                        <td class="px-6 py-4 text-center">${seccion.total_alumnos || 0}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                ${seccion.status === '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${seccion.status === '1' ? 'Activa' : 'Inactiva'}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="editarSeccion(${seccion.id_seccion})"
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="cambiarEstadoSeccion(${seccion.id_seccion}, '${seccion.status === '1' ? '0' : '1'}')"
                                    class="text-${seccion.status === '1' ? 'red' : 'green'}-600 hover:text-${seccion.status === '1' ? 'red' : 'green'}-900">
                                <i class="fas fa-${seccion.status === '1' ? 'ban' : 'check-circle'}"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar las secciones'
        });
    }
}

// Función para mostrar el modal de crear sección
function mostrarModalCrearSeccion() {
    editandoSeccionId = null;
    const form = document.getElementById('form-seccion');
    form.reset();
    document.getElementById('modal-seccion-titulo').textContent = 'Nueva Sección';
    document.getElementById('modal-seccion').classList.remove('hidden');
    cargarDocentesDisponibles();
}

// Función para cerrar el modal
function cerrarModalSeccion() {
    document.getElementById('modal-seccion').classList.add('hidden');
    document.getElementById('form-seccion').reset();
}

// Función para cargar docentes disponibles
async function cargarDocentesDisponibles() {
    try {
        const response = await fetch('/drive_ucv/secciones/docentes');
        const result = await response.json();

        if (result.success) {
            const selectDocentes = document.querySelector('select[name="docentes[]"]');
            selectDocentes.innerHTML = '';

            result.data.forEach(docente => {
                selectDocentes.innerHTML += `
                    <option value="${docente.id_usuario}">${docente.nombre_completo}</option>
                `;
            });
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError('No se pudieron cargar los docentes disponibles');
    }
}

// Función para guardar la sección
async function guardarSeccion(event) {
    event.preventDefault();

    try {
        const form = event.target;
        const formData = new FormData(form);

        // Convertir FormData a objeto
        const data = {
            nombre_seccion: formData.get('nombre_seccion'),
            id_curso: formData.get('id_curso'),
            docentes: Array.from(formData.getAll('docentes[]'))
        };

        const url = editandoSeccionId
            ? `/drive_ucv/secciones/actualizar/${editandoSeccionId}`
            : '/drive_ucv/secciones/crear';

        const response = await fetch(url, {
            method: editandoSeccionId ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: editandoSeccionId ? 'Sección actualizada correctamente' : 'Sección creada correctamente',
                timer: 1500,
                showConfirmButton: false
            });

            cerrarModalSeccion();
            activarSeccion('secciones');
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo guardar la sección: ' + error.message
        });
    }
}

// Función para mostrar errores
function mostrarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje
    });
}

// Cargar docentes////////////////////////////////////////////////////
async function cargarDocentes() {
    try {
        const response = await fetch('/drive_ucv/docentes/listar');
        const result = await response.json();

        if (result.success) {
            const tablaDocentes = document.getElementById('tabla-docentes');


            result.data.forEach(docente => {
                const estadoActual = docente.status == 1 || docente.status === '1';
                const fechaActualizacion = docente.fecha_actualizacion
                    ? new Date(docente.fecha_actualizacion).toLocaleString()
                    : 'No actualizado';

                const row = document.createElement('tr');
                row.setAttribute('data-user-id', docente.id_usuario);

                row.innerHTML = `
                    <td class="px-6 py-4">${docente.nombres}</td>
                    <td class="px-6 py-4">${docente.apellidos}</td>
                    <td class="px-6 py-4">${docente.codigo}</td>
                    <td class="px-6 py-4">${docente.email}</td>
                    <td class="px-6 py-4">${docente.celular || '-'}</td>
                    <td class="px-6 py-4">${docente.username}</td>
                    <td class="px-6 py-4">${docente.secciones_asignadas || 'Sin asignaciones'}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       class="sr-only peer"
                                       ${estadoActual ? 'checked' : ''}
                                       onchange="cambiarEstado('docentes', ${docente.id_usuario}, this.checked)">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                            peer-focus:ring-blue-300 rounded-full peer
                                            peer-checked:after:translate-x-full peer-checked:after:border-white
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ml-3 text-sm font-medium status-text ${estadoActual ? 'text-green-600' : 'text-red-600'}">
                                    ${estadoActual ? 'Activo' : 'Inactivo'}
                                </span>
                            </label>
                        </div>
                    </td>
                    <td class="px-6 py-4">${fechaActualizacion}</td>
                    <td class="px-6 py-4 text-center">
                        <button onclick="editarDocente(${docente.id_usuario})"
                                class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                `;

                tablaDocentes.appendChild(row);
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los docentes'
        });
    }
}

// Asegurarse de que la función se llame cuando se muestra la sección
document.addEventListener('DOMContentLoaded', function() {
    const docentesLink = document.querySelector('[data-section="docentes"]');
    if (docentesLink) {
        docentesLink.addEventListener('click', function() {
            console.log('Click en enlace de docentes');
            cargarDocentes();
        });
    }
});

async function editarDocente(id) {
    try {
        console.log('Editando docente:', id);
        const response = await fetch(`/drive_ucv/docentes/${id}`);
        const result = await response.json();

        if (result.success) {
            const docente = result.data;
            const form = document.getElementById('form-docente');

            // Llenar el formulario con los datos existentes

            form.querySelector('[name="nombres"]').value = docente.nombres;
            form.querySelector('[name="apellidos"]').value = docente.apellidos;
            form.querySelector('[name="codigo"]').value = docente.codigo;
            form.querySelector('[name="email"]').value = docente.email;
            form.querySelector('[name="celular"]').value = docente.celular || '';
            form.querySelector('[name="username"]').value = docente.username;

            // Ocultar campo de contraseña si existe
            const passwordField = form.querySelector('[name="password"]');
            if (passwordField) {
                passwordField.closest('div').style.display = 'none';
            }

            // Cambiar título y guardar ID para la edición
            document.getElementById('modal-docente-titulo').textContent = 'Editar Docente';
            form.dataset.editId = id;

            // Mostrar modal
            document.getElementById('modal-docente').classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar la información del docente'
        });
    }
}

// Función para guardar docente (crear/editar)
async function guardarDocente(event) {
    event.preventDefault();

    try {
        const form = event.target;
        const formData = new FormData(form);
        const editId = form.dataset.editId;

        const data = {

            nombres: formData.get('nombres'),
            apellidos: formData.get('apellidos'),
            codigo: formData.get('codigo'),
            edad: formData.get('edad'),
            email: formData.get('email'),
            celular: formData.get('celular'),
            username: formData.get('username')
        };

        // Solo incluir password si es nuevo docente o si se ha ingresado uno nuevo
        if (!editId || formData.get('password')) {
            data.password = formData.get('password');
        }

        const url = editId
            ? `/drive_ucv/docentes/editar/${editId}`
            : '/drive_ucv/docentes/crear';

        const response = await fetch(url, {
            method: editId ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: editId ? 'Docente actualizado correctamente' : 'Docente creado correctamente',
                timer: 1500,
                showConfirmButton: false
            });

            cerrarModalDocente();
            activarSeccion('docentes');
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al procesar la solicitud'
        });
    }
}

// Función para guardar alumno (crear/editar)
async function guardarAlumno(event) {
    event.preventDefault();

    try {
        const form = event.target;
        const formData = new FormData(form);

        // Validar contraseña
        const password = formData.get('password');
        if (password && password.length < 6) {
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La contraseña debe tener al menos 6 caracteres'
            });
            return;
        }

        const editId = form.dataset.editId;

        const data = {

            nombres: formData.get('nombres'),
            apellidos: formData.get('apellidos'),
            codigo: formData.get('codigo'),
            email: formData.get('email'),
            celular: formData.get('celular'),
            username: formData.get('username'),
            ciclo: formData.get('ciclo')
        };

        // Si es nuevo alumno, agregar password
        if (!editId) {
            data.password = formData.get('password');
        }

        const url = editId
            ? `/drive_ucv/alumnos/editar/${editId}`
            : '/drive_ucv/alumnos/crear';

        const response = await fetch(url, {
            method: editId ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: editId ? 'Alumno actualizado correctamente' : 'Alumno creado correctamente',
                timer: 1500,
                showConfirmButton: false
            });

            // Limpiar datos y cerrar directamente sin confirmación
            localStorage.removeItem('formAlumnoTemp');
            form.reset();
            document.getElementById('modal-alumno').classList.add('hidden');
            activarSeccion('alumnos');
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al guardar el alumno'
        });
    }
}


function cerrarModalDocente() {
    const modal = document.getElementById('modal-docente');
    const form = document.getElementById('form-docente');

    // Limpiar el formulario
    form.reset();
    // Eliminar el ID de edición si existe
    delete form.dataset.editId;
    // Ocultar el modal
    modal.classList.add('hidden');
}

function guardarDatosTemporales(event) {
    const input = event.target;
    const formData = JSON.parse(localStorage.getItem('formAlumnoTemp') || '{}');
    formData[input.name] = input.value;
    localStorage.setItem('formAlumnoTemp', JSON.stringify(formData));
    console.log('Datos guardados:', formData);
}

function cerrarModalAlumno() {
    const modalAlumno = document.getElementById('modal-alumno');
    const formAlumno = document.getElementById('form-alumno');

    if (modalAlumno) {
        const formData = JSON.parse(localStorage.getItem('formAlumnoTemp') || '{}');

        if (Object.keys(formData).length > 0) {
            Swal.fire({
                title: '¿Está seguro de cerrar?',
                text: "Se perderán los datos ingresados",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar',
                cancelButtonText: 'Continuar editando',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('formAlumnoTemp');
                    if (formAlumno) formAlumno.reset();
                    modalAlumno.classList.add('hidden');
                }
            });
        } else {
            modalAlumno.classList.add('hidden');
        }
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const formAlumno = document.getElementById('form-alumno');
    if (formAlumno) {
        const inputs = formAlumno.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', guardarDatosTemporales);
        });
    }
});

function mostrarModalCrearDocente() {
    const modal = document.getElementById('modal-docente');
    const form = document.getElementById('form-docente');
    const titulo = document.getElementById('modal-docente-titulo');
    const passwordField = form.querySelector('[name="password"]');
    const passwordContainer = passwordField.closest('div');

    // Limpiar el formulario
    form.reset();
    delete form.dataset.editId;

    // Mostrar y hacer requerido el campo de contraseña para nuevo docente
    if (passwordContainer) {
        passwordContainer.style.display = 'block';
        passwordField.required = true;
    }

    // Cambiar el título
    titulo.textContent = 'Nuevo Docente';

    // Mostrar el modal
    modal.classList.remove('hidden');
}
// Agregar event listeners para cerrar el modal con Escape o clicking fuera
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-docente');

    // Cerrar con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            cerrarModalDocente();
        }
    });

    // Cerrar al hacer click fuera del modal
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            cerrarModalDocente();
        }
    });
});
//////////////////////////////////////////////////////////////////filtros////////////////////////////////////////////////////////////

///////////////////////////////////////////////777 Función para filtrar alumnos////////////////////////////////////////////////////////////
async function filtrarAlumnos() {
    const busqueda = document.getElementById('searchAlumno').value;
    const ciclo = document.getElementById('filterCiclo').value;
    const estado = document.getElementById('filterEstadoAlumno').value;
    const fechaInicio = document.getElementById('fechaInicioAlumno').value;
    const fechaFin = document.getElementById('fechaFinAlumno').value;

    try {
        const response = await fetch('/drive_ucv/alumnos/filtrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                busqueda,
                ciclo,
                estado,
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin
            })
        });

        const result = await response.json();

        if (result.success) {
            actualizarTablaAlumnos(result.data);
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al filtrar alumnos'
        });
    }
    /////////////////////////////////////////777actualizar tabla alumnos////////////////////////////////////////////////////////////
    function actualizarTablaAlumnos(alumnos) {
    const tablaAlumnos = document.getElementById('tabla-alumnos');
    tablaAlumnos.innerHTML = '';

    alumnos.forEach(alumno => {
        const estadoActual = alumno.status == 1 || alumno.status === '1';
        const fechaActualizacion = alumno.fecha_actualizacion
            ? new Date(alumno.fecha_actualizacion).toLocaleString()
            : 'No actualizado';

        const row = `
            <tr data-user-id="${alumno.id_usuario}">
                <td class="px-6 py-4">${alumno.nombres}</td>
                <td class="px-6 py-4">${alumno.apellidos}</td>
                <td class="px-6 py-4">${alumno.codigo}</td>
                <td class="px-6 py-4">${alumno.ciclo}</td>
                <td class="px-6 py-4">${alumno.email}</td>
                <td class="px-6 py-4">${alumno.celular || '-'}</td>
                <td class="px-6 py-4">${alumno.username}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                   class="sr-only peer"
                                   ${estadoActual ? 'checked' : ''}
                                   onchange="cambiarEstado('alumnos', ${alumno.id_usuario}, this.checked)">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer
                                      peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                                      dark:peer-focus:ring-blue-800 dark:bg-gray-700
                                      peer-checked:after:translate-x-full peer-checked:after:border-white
                                      after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                      after:bg-white after:border-gray-300 after:border after:rounded-full
                                      after:h-5 after:w-5 after:transition-all dark:border-gray-600
                                      peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-medium status-text ${estadoActual ? 'text-green-600' : 'text-red-600'}">
                                ${estadoActual ? 'Activo' : 'Inactivo'}
                            </span>
                        </label>
                    </div>
                </td>
                <td class="px-6 py-4">${fechaActualizacion}</td>
                <td class="px-6 py-4 text-center">
                    <button onclick="editarAlumno(${alumno.id_usuario})"
                            class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
        `;
        tablaAlumnos.insertAdjacentHTML('beforeend', row);
    });
}
}

///////////////////////////////////////777 Función para filtrar docentes///////////////////////////////////77
async function filtrarDocentes() {
    const busqueda = document.getElementById('searchDocente').value;
    const estado = document.getElementById('filterEstadoDocente').value;
    const fechaInicio = document.getElementById('fechaInicioDocente').value;
    const fechaFin = document.getElementById('fechaFinDocente').value;

    try {
        const response = await fetch('/drive_ucv/docentes/filtrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                busqueda,
                estado,
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin
            })
        });

        const result = await response.json();

        if (result.success) {
            actualizarTablaDocentes(result.data);
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al filtrar docentes'
        });
    }
    /////////////////////////////////////////7////actualizar tabla docentes////////////////////////////////////////////////////////////
    function actualizarTablaDocentes(docentes) {
    const tablaDocentes = document.getElementById('tabla-docentes');
    tablaDocentes.innerHTML = '';

    docentes.forEach(docente => {
        const estadoActual = docente.status == 1 || docente.status === '1';
        const fechaActualizacion = docente.fecha_actualizacion
            ? new Date(docente.fecha_actualizacion).toLocaleString()
            : 'No actualizado';

        const row = document.createElement('tr');
        row.setAttribute('data-user-id', docente.id_usuario);

        row.innerHTML = `
            <td class="px-6 py-4">${docente.nombres}</td>
            <td class="px-6 py-4">${docente.apellidos}</td>
            <td class="px-6 py-4">${docente.codigo}</td>
            <td class="px-6 py-4">${docente.email}</td>
            <td class="px-6 py-4">${docente.celular || '-'}</td>
            <td class="px-6 py-4">${docente.username}</td>
            <td class="px-6 py-4">${docente.secciones_asignadas || 'Sin asignaciones'}</td>
            <td class="px-6 py-4">
                <div class="flex items-center justify-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               class="sr-only peer"
                               ${estadoActual ? 'checked' : ''}
                               onchange="cambiarEstado('docentes', ${docente.id_usuario}, this.checked)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-blue-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                        </div>
                        <span class="ml-3 text-sm font-medium status-text ${estadoActual ? 'text-green-600' : 'text-red-600'}">
                            ${estadoActual ? 'Activo' : 'Inactivo'}
                        </span>
                    </label>
                </div>
            </td>
            <td class="px-6 py-4">${fechaActualizacion}</td>
            <td class="px-6 py-4 text-center">
                <button onclick="editarDocente(${docente.id_usuario})"
                        class="text-blue-600 hover:text-blue-900">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        `;

        tablaDocentes.appendChild(row);
    });
}
}

// Agregar event listeners para los filtros
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners para filtros de alumnos
    ['searchAlumno', 'filterCiclo', 'filterEstadoAlumno', 'fechaInicioAlumno', 'fechaFinAlumno'].forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.addEventListener('change', filtrarAlumnos);
            if (id === 'searchAlumno') {
                elemento.addEventListener('keyup', filtrarAlumnos);
            }
        }
    });

    // Event listeners para filtros de docentes
    ['searchDocente', 'filterEstadoDocente', 'fechaInicioDocente', 'fechaFinDocente'].forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.addEventListener('change', filtrarDocentes);
            if (id === 'searchDocente') {
                elemento.addEventListener('keyup', filtrarDocentes);
            }
        }
    });
});

///////////////////////////////////////////////777 Función para validar si el usuario es disponible////////////////////////////////////////////////////////////
let timeoutId = null;
async function validarUsuarioDisponible(username) {
    const messageSpan = document.getElementById('username-message');

    // Limpiar timeout previo
    if (timeoutId) {
        clearTimeout(timeoutId);
    }

    // Validar campo vacío
    if (!username) {
        messageSpan.textContent = '';
        messageSpan.className = 'text-xs';
        return;
    }

    try {
        const response = await fetch('/drive_ucv/verificar-usuario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',  // Agregar este header
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ username })
        });

        if (!response.ok) {
            throw new Error('Error en la petición');
        }

        const result = await response.json();

        if (result.disponible) {
            messageSpan.textContent = 'Usuario disponible';
            messageSpan.className = 'text-xs text-green-600';
        } else {
            messageSpan.textContent = 'Usuario no disponible';
            messageSpan.className = 'text-xs text-red-600';
        }
    } catch (error) {
        console.error('Error:', error);
        messageSpan.textContent = 'Error al verificar usuario';
        messageSpan.className = 'text-xs text-red-600';
    }
}

// Validación en tiempo real para el email
function validarEmailInstitucional(input) {
    const messageSpan = input.nextElementSibling;
    const email = input.value.trim();
    const emailRegex = /^[a-zA-Z0-9._%+-]+@ucvvirtual\.edu\.pe$/;

    if (!email) {
        messageSpan.textContent = '';
        messageSpan.className = 'text-xs';
        return;
    }

    if (!emailRegex.test(email)) {
        messageSpan.textContent = '✗ Debe usar su correo institucional (@ucvvirtual.edu.pe)';
        messageSpan.className = 'text-xs text-red-600';
    } else {
        messageSpan.textContent = '✓ Formato de correo válido';
        messageSpan.className = 'text-xs text-green-600';
    }
}
</script>
@endsection

@section('styles')
<style>
    .nav-link.active {
        background-color: rgb(55 65 81);
    }

    #profile-dropdown {
        animation: fadeIn 0.1s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estilos para el modal de perfil */
    .swal2-show-profile {
        width: 32rem !important;
        padding: 2rem !important;
    }

    .swal2-close-profile {
        position: absolute !important;
        right: 1rem !important;
        top: 1rem !important;
    }
</style>
@endsection
