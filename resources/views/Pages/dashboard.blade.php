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

<!------------------------------------------------------- Modal para Crear/Editar Alumno ---------------------------------------------------------------------->
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

<!--------------------------------------- Sección de Gestión de Secciones -------------------------------------->
            <section id="secciones-section" class="section-content hidden">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestión de Secciones</h2>
                        <button onclick="mostrarModalCrearSeccion()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Nueva Sección
                        </button>
                    </div>

<!---------------------------------------- Filtros ------------------------------------------>
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
                                    <option value="IX">IX</option>
                                    <option value="X">X</option>
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

<!---------------------------------------- Tabla de Secciones ------------------------------------------>
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

<!------------------------------------------------------------ Modal para Crear/Editar Sección ---------------------------------------------------->
                <div id="modal-seccion" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium" id="modal-seccion-titulo">Nueva Sección</h3>
                            <button onclick="cerrarModalSeccion()" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="form-seccion" onsubmit="guardarSeccion(event)">
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Curso</label>
                                        <select name="id_curso" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">Seleccione un curso</option>
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
                                    </select>
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

<!---------------------------------------------------------------------------- Sección Asignaciones ---------------------------------------------------------------------------->
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

<!------------------------------------------------------------------ Modal para Crear/Editar Docente ------------------------------------------------------------------->
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
                <!-- Nombres -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombres</label>
                    <input type="text"
                           name="nombres"
                           id="docente-nombres"
                           required
                           onchange="guardarDatosTemporalesDocente(event)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Apellidos -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                    <input type="text"
                           name="apellidos"
                           id="docente-apellidos"
                           required
                           onchange="guardarDatosTemporalesDocente(event)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Código -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Código</label>
                    <input type="text"
                           name="codigo"
                           id="docente-codigo"
                           required
                           minlength="10"
                           maxlength="10"
                           pattern="\d{10}"
                           onchange="validarCodigo(this)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <span class="text-xs codigo-message"></span>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email"
                           name="email"
                           id="docente-email"
                           required
                           pattern="[a-zA-Z0-9._+-]+@ucvvirtual\.edu\.pe$"
                           onchange="validarEmailInstitucional(this)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <span class="text-xs"></span>
                </div>

                <!-- Celular -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Celular</label>
                    <input type="text"
                           name="celular"
                           id="docente-celular"
                           maxlength="9"
                           pattern="9[0-9]{8}"
                           onchange="validarCelular(this)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <span class="text-xs celular-message"></span>
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input type="text"
                           name="username"
                           id="docente-username"
                           required
                           minlength="4"
                           onchange="validarUsuarioDisponible(this.value)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <span id="username-message" class="text-xs"></span>
                </div>

                <!-- Password -->
                <div id="password-container-docente">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                    <input type="password"
                           name="password"
                           id="docente-password"
                           minlength="6"
                           onchange="guardarDatosTemporalesDocente(event)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                        onclick="cerrarModalDocente()"
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
////////////////////////////////////////// document ready //////////////////////////////////////////
$(document).ready(function() {
    const ultimaSeccion = localStorage.getItem('seccionActiva') || 'resumen';
    activarSeccion(ultimaSeccion);

    $('.nav-link').click(function(e) {
        e.preventDefault();
        const sectionId = $(this).data('section');
        activarSeccion(sectionId);
        localStorage.setItem('seccionActiva', sectionId);
    });

////////////////////////////////////////// cerrar menú de perfil //////////////////////////////////////////
    $(document).click(function(e) {
        if (!$(e.target).closest('#profile-dropdown').length) {
            $('#profile-dropdown').addClass('hidden');
        }
    });

////////////////////////////////////////// mostrar perfil //////////////////////////////////////////
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
                text: 'No se pudo cargar la informacin del perfil: ' + error.message
            });
        }
    };
    window.cerrarModalPerfil = function() {
        $('#modal-perfil').addClass('hidden');
    };

    $('#resumen-section').removeClass('hidden');
});

////////////////////////////////////////// activar una sección específica //////////////////////////////////////////
function activarSeccion(sectionId) {
    $('.nav-link').removeClass('active bg-gray-700');
    $(`[data-section="${sectionId}"]`).addClass('active bg-gray-700');
    $('.section-content').addClass('hidden');
    $(`#${sectionId}-section`).removeClass('hidden');
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

////////////////////////////////////////// gestión de alumnos //////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    const alumnosLink = document.querySelector('[data-section="alumnos"]');
    if (alumnosLink) {
        alumnosLink.addEventListener('click', function() {
            setTimeout(cargarAlumnos, 100);
        });
    }
});

////////////////////////////////////////// cargar la lista de alumnos //////////////////////////////////////////
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
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox"
                                           class="sr-only peer"
                                           ${alumno.status == 1 ? 'checked' : ''}
                                           onchange="cambiarEstado('alumnos', ${alumno.id_usuario}, this.checked)">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium status-text ${alumno.status == 1 ? 'text-green-600' : 'text-red-600'}">
                                        ${alumno.status == 1 ? 'Activo' : 'Inactivo'}
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

////////////////////////////////////////// validar el formulario del alumno //////////////////////////////////////////
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
    if (!password) {
        throw new Error('La contraseña es obligatoria');
    }
    if (password.length < 6) {
        throw new Error('La contraseña debe tener al menos 6 caracteres');
    }
}
////////////////////////////////////////// mostrar el modal de crear alumno //////////////////////////////////////////
function mostrarModalCrearAlumno() {
    const form = document.getElementById('form-alumno');
    const modalTitulo = document.getElementById('modal-titulo');
    form.reset();
    delete form.dataset.editId;
    const passwordField = form.querySelector('[name="password"]');
    const passwordContainer = passwordField?.closest('.form-group') || form.querySelector('#password-container');
    if (passwordContainer) {
        passwordContainer.style.display = 'block';
        if (passwordField) {
            passwordField.required = true;
            passwordField.disabled = false;
        }
    }
    modalTitulo.textContent = 'Nuevo Alumno';
    document.getElementById('modal-alumno').classList.remove('hidden');
}

////////////////////////////////////////// cerrar el modal //////////////////////////////////////////
function cerrarModalAlumno() {
    const modalAlumno = document.getElementById('modal-alumno');
    const formAlumno = document.getElementById('form-alumno');

    if (modalAlumno) {
        const formData = new FormData(formAlumno);
        const hasData = Array.from(formData.values()).some(value => value !== '');

        if (hasData) {
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
        const modalContent = modalAlumno.querySelector('.relative');
        if (modalContent) {
            modalContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
        modalAlumno.removeEventListener('click', cerrarModalAlumno);
    }
});

setTimeout(() => {
    const modal = document.getElementById('modal-alumno');
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
        const email = formData.get('email');
        const emailPattern = /^[a-zA-Z0-9._%+-]+@ucvvirtual\.edu\.pe$/;
        if (!email.match(emailPattern)) {
            Swal.fire({
                icon: 'warning',
                title: 'Correo inválido',
                text: 'El correo debe ser institucional (@ucvvirtual.edu.pe)',
                confirmButtonText: 'Entendido'
            });
            return false;
            return;
        }

        const data = {
            nombres: formData.get('nombres'),
            apellidos: formData.get('apellidos'),
            codigo: formData.get('codigo').toString().padStart(10, '0'),
            email: email,
            celular: formData.get('celular') ? formData.get('celular').toString().padStart(9, '0') : null,
            username: formData.get('username'),
            ciclo: formData.get('ciclo').substring(0, 2)
        };

        const response = await fetch(editId ? `/drive_ucv/alumnos/editar/${editId}` : '/drive_ucv/alumnos/crear', {
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
                const errores = result.errors || {};
                const mensajesError = Object.values(errores).flat();

                await Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    html: mensajesError.join('<br>'),
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            throw new Error(result.message || `Error al ${editId ? 'actualizar' : 'crear'} el alumno: ${result.error || ''}`);
        }

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: editId ? 'Alumno actualizado correctamente' : 'Alumno creado correctamente',
                timer: 1500,
                showConfirmButton: false
            });

            localStorage.removeItem('formAlumnoTemp');
            form.reset();
            document.getElementById('modal-alumno').classList.add('hidden');
            await cargarAlumnos();
        } else {
            throw new Error(result.message || 'Error al procesar la solicitud');
        }
    } catch (error) {
        console.error('Error:', error);

        await Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al procesar la solicitud',
            confirmButtonText: 'Entendido'
        });
    }
}

////////////////////////////////////////// cambiar el estado //////////////////////////////////////////
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
            const seccionActual = localStorage.getItem('seccionActiva');
            activarSeccion(seccionActual);
        } else {
            throw new Error(result.message || 'Error al actualizar el estado');
        }
    } catch (error) {
        console.error('Error:', error);
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

////////////////////////////////////////// editar alumno //////////////////////////////////////////
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
            const passwordField = form.querySelector('[name="password"]');
            const passwordContainer = passwordField?.closest('.form-group') || form.querySelector('#password-container');
            if (passwordContainer) {
                passwordContainer.style.display = 'none';
                if (passwordField) {
                    passwordField.removeAttribute('required');
                    passwordField.disabled = true;
                }
            }

            form.querySelector('[name="nombres"]').value = alumno.nombres;
            form.querySelector('[name="apellidos"]').value = alumno.apellidos;
            form.querySelector('[name="codigo"]').value = alumno.codigo;
            form.querySelector('[name="email"]').value = alumno.email;
            form.querySelector('[name="celular"]').value = alumno.celular || '';
            form.querySelector('[name="username"]').value = alumno.username;
            form.querySelector('[name="ciclo"]').value = alumno.ciclo;

            modalTitulo.textContent = 'Editar Alumno';
            form.dataset.editId = id;
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
async function filtrarAlumnos() {
    try {
        const busqueda = document.getElementById('searchAlumno').value;
        const ciclo = document.getElementById('filterCiclo').value;
        const estado = document.getElementById('filterEstadoAlumno').value;
        const fechaInicio = document.getElementById('fechaInicioAlumno').value;
        const fechaFin = document.getElementById('fechaFinAlumno').value;

        const response = await fetch('/drive_ucv/alumnos/filtrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                busqueda: busqueda,
                ciclo: ciclo,
                estado: estado,
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin
            })
        });

        const result = await response.json();

        if (result.success) {
            actualizarTablaAlumnos(result.data);
        } else {
            throw new Error(result.message || 'Error al filtrar alumnos');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al filtrar alumnos'
        });
    }
}

////////////////////////////////////////// actualizar tabla alumnos //////////////////////////////////////////
function actualizarTablaAlumnos(alumnos) {
    const tbody = document.getElementById('tabla-alumnos');
    if (!tbody) return;

    tbody.innerHTML = alumnos.map(alumno => `
        <tr data-user-id="${alumno.id_usuario}">
            <td class="px-6 py-4">${alumno.nombres || ''}</td>
            <td class="px-6 py-4">${alumno.apellidos || ''}</td>
            <td class="px-6 py-4">${alumno.codigo || ''}</td>
            <td class="px-6 py-4">${alumno.ciclo || ''}</td>
            <td class="px-6 py-4">${alumno.email || ''}</td>
            <td class="px-6 py-4">${alumno.celular || ''}</td>
            <td class="px-6 py-4">${alumno.username || ''}</td>
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               class="sr-only peer"
                               ${alumno.status == 1 ? 'checked' : ''}
                               onchange="cambiarEstado('alumnos', ${alumno.id_usuario}, this.checked)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium status-text ${alumno.status == 1 ? 'text-green-600' : 'text-red-600'}">
                            ${alumno.status == 1 ? 'Activo' : 'Inactivo'}
                        </span>
                    </label>
                </div>
            </td>
            <td class="px-6 py-4">${alumno.fecha_actualizacion || ''}</td>
            <td class="px-6 py-4 text-center">
                <button onclick="editarAlumno(${alumno.id_usuario})"
                        class="text-blue-600 hover:text-blue-900">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

////////////////////////////////////////// Event listeners para los filtros //////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    const searchAlumno = document.getElementById('searchAlumno');
    let timeoutId;
    if (searchAlumno) {
        searchAlumno.addEventListener('input', () => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(filtrarAlumnos, 300);
        });
    }
    const filterCiclo = document.getElementById('filterCiclo');
    const filterEstadoAlumno = document.getElementById('filterEstadoAlumno');
    const fechaInicioAlumno = document.getElementById('fechaInicioAlumno');
    const fechaFinAlumno = document.getElementById('fechaFinAlumno');

    filterCiclo?.addEventListener('change', filtrarAlumnos);
    filterEstadoAlumno?.addEventListener('change', filtrarAlumnos);
    fechaInicioAlumno?.addEventListener('change', filtrarAlumnos);
    fechaFinAlumno?.addEventListener('change', filtrarAlumnos);
});

// Variables globales
let cursoSeleccionadoId = null;

////////////////////////////////////////// Función única para cargar cursos //////////////////////////////////////////
/*async function cargarCursos() {
    try {
        console.log('Iniciando carga de cursos');
        const response = await fetch('/cursos/listar', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const result = await response.json();
        console.log('Respuesta de cursos:', result);

        if (result.success) {
            const filtroCurso = document.querySelector('select[name="filtro_curso"]');
            const selectCursoModal = document.querySelector('select[name="id_curso"]');
            const opcionesHTML = `
                <option value="">Todos los cursos</option>
                ${result.data.map(curso => `
                    <option value="${curso.id_curso}">
                        ${curso.nombre_curso} (Ciclo ${curso.ciclo})
                    </option>
                `).join('')}
            `;

            if (filtroCurso) {
                filtroCurso.innerHTML = opcionesHTML;
                console.log('Select de filtro actualizado');
            }

            if (selectCursoModal) {
                selectCursoModal.innerHTML = opcionesHTML.replace('Todos los cursos', 'Seleccione un curso');
                console.log('Select del modal actualizado');
            }
        } else {
            throw new Error(result.message || 'Error al cargar los cursos');
        }
    } catch (error) {
        console.error('Error al cargar cursos:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los cursos: ' + error.message
        });
    }
}*/

////////////////////////////////////////// Event Listeners //////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Cargado - Inicializando eventos');

////////////////////////////////////////// Cargar cursos al entrar a la sección de secciones //////////////////////////////////////////
    const seccionesLink = document.querySelector('[data-section="secciones"]');
    if (seccionesLink) {
        seccionesLink.addEventListener('click', async () => {
            console.log('Click en secciones - Cargando cursos');
            await cargarCursos();
            await cargarSecciones();
        });
    }

////////////////////////////////////////// Cargar cursos al abrir el modal de nueva sección //////////////////////////////////////////
    const btnNuevaSeccion = document.querySelector('.btn-nueva-seccion');
    if (btnNuevaSeccion) {
        btnNuevaSeccion.addEventListener('click', async () => {
            console.log('Click en nueva sección - Cargando cursos');
            await cargarCursos();
            mostrarModalCrearSeccion();
        });
    }

    if (window.location.hash === '#secciones') {
        console.log('Carga inicial de secciones');
        cargarCursos();
        cargarSecciones();
    }
});

// Función para seleccionar un curso y mostrar sus secciones
async function seleccionarCurso(idCurso, nombreCurso) {
    cursoSeleccionadoId = idCurso;
    document.getElementById('curso-seleccionado').textContent = nombreCurso;
    document.getElementById('id-curso-seleccionado').value = idCurso;
    document.getElementById('secciones-curso').classList.remove('hidden');
    await cargarSecciones(idCurso);
}

////////////////////////////////////////// cargar secciones de un curso //////////////////////////////////////////
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

document.addEventListener('DOMContentLoaded', function() {
    const seccionesLink = document.querySelector('[data-section="secciones"]');
    if (seccionesLink) {
        seccionesLink.addEventListener('click', async function() {
            await cargarCursos();
            await cargarSecciones();
            const modalSeccion = document.getElementById('modal-seccion');
            if (!modalSeccion._initialized) {
                modalSeccion._initialized = true;
            }
        });
    }
});

////////////////////////////////////////// Filtro cargar cursos //////////////////////////////////////////
async function cargarCursos() {
    try {
        const response = await fetch('/drive_ucv/cursos/listar');
        const result = await response.json();

        if (result.success) {
            const filtroCurso = document.getElementById('filtro-curso');
            const selectCurso = document.querySelector('select[name="id_curso"]');
            const cursos = result.data;

            filtroCurso.innerHTML = '<option value="">Todos los cursos</option>';
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

////////////////////////////////////////// cargar secciones //////////////////////////////////////////
async function cargarSecciones() {
    try {
        const response = await fetch('/drive_ucv/secciones/listar', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || `Error HTTP: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            actualizarTablaSecciones(result.data);
        } else {
            throw new Error(result.message || 'Error al cargar las secciones');
        }
    } catch (error) {
        console.error('Error en cargarSecciones:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'No se pudieron cargar las secciones'
        });
    }
}

////////////////////////////////////////// mostrar modal crear sección //////////////////////////////////////////
function mostrarModalCrearSeccion() {
    editandoSeccionId = null;
    const form = document.getElementById('form-seccion');
    form.reset();
    document.getElementById('modal-seccion-titulo').textContent = 'Nueva Sección';
    document.getElementById('modal-seccion').classList.remove('hidden');
    cargarDocentesDisponibles();
}


function cerrarModalSeccion() {
    document.getElementById('modal-seccion').classList.add('hidden');
    document.getElementById('form-seccion').reset();
}

////////////////////////////////////////// cargar docentes disponibles //////////////////////////////////////////
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

////////////////////////////////////////// guardar sección //////////////////////////////////////////
async function guardarSeccion(event) {
    event.preventDefault();

    try {
        const form = document.getElementById('form-seccion');

        // Obtener los valores directamente de los elementos
        const idCurso = form.querySelector('[name="id_curso"]').value;
        const nombreSeccion = form.querySelector('[name="nombre_seccion"]').value.trim();
        const docentes = Array.from(form.querySelector('[name="docentes[]"]').selectedOptions)
                              .map(option => parseInt(option.value));

        // Validar que tengamos todos los datos necesarios
        if (!idCurso || !nombreSeccion || docentes.length === 0) {
            throw new Error('Por favor complete todos los campos requeridos');
        }

        const data = {
            id_curso: parseInt(idCurso),
            nombre_seccion: nombreSeccion,
            docentes: docentes
        };

        console.log('Datos a enviar:', data);
        const response = await fetch('/drive_ucv/secciones/crear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => null);
            throw new Error(errorData?.message || `Error HTTP: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Sección creada correctamente'
            });
            cerrarModalSeccion();
            await cargarSecciones();
        } else {
            throw new Error(result.message || 'Error al crear la sección');
        }

    } catch (error) {
        console.error('Error al guardar sección:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
        });
    }
}

function mostrarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje
    });
}

////////////////////////////////////////// cambiar estado seccion //////////////////////////////////////////
async function cambiarEstadoSeccion(idSeccion, nuevoEstado) {
    try {
        const response = await fetch(`/drive_ucv/secciones/estado/${idSeccion}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: nuevoEstado })
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Estado de la sección actualizado correctamente'
            });
            // Recargar la lista de secciones
            await cargarSecciones();
        } else {
            throw new Error(result.message || 'Error al actualizar el estado');
        }
    } catch (error) {
        console.error('Error al cambiar estado:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo actualizar el estado de la sección: ' + error.message
        });
    }
}

////////////////////////////////////////// cargar docentes //////////////////////////////////////////
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
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       class="sr-only peer"
                                       ${docente.status == 1 ? 'checked' : ''}
                                       onchange="cambiarEstado('docentes', ${docente.id_usuario}, this.checked)">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium status-text ${docente.status == 1 ? 'text-green-600' : 'text-red-600'}">
                                    ${docente.status == 1 ? 'Activo' : 'Inactivo'}
                                </span>
                            </label>
                        </div>
                    </td>
                    <td class="px-6 py-4">${docente.fecha_actualizacion || ''}</td>
                    <td class="px-6 py-4">
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

document.addEventListener('DOMContentLoaded', function() {
    const docentesLink = document.querySelector('[data-section="docentes"]');
    if (docentesLink) {
        docentesLink.addEventListener('click', function() {
            console.log('Click en enlace de docentes');
            cargarDocentes();
        });
    }
});
////////////////////////////////////////////////////////editar docente////////////////////////////////////////////////////////
async function editarDocente(id) {
    try {
        const response = await fetch(`/drive_ucv/docentes/${id}`);
        const result = await response.json();

        if (result.success) {
            const docente = result.data;
            const form = document.getElementById('form-docente');
            const modalTitulo = document.getElementById('modal-docente-titulo');

            document.getElementById('docente-nombres').value = docente.nombres || '';
            document.getElementById('docente-apellidos').value = docente.apellidos || '';
            document.getElementById('docente-codigo').value = docente.codigo || '';
            document.getElementById('docente-email').value = docente.email || '';
            document.getElementById('docente-celular').value = docente.celular || '';
            document.getElementById('docente-username').value = docente.username || '';

            const passwordContainer = document.getElementById('password-container-docente');
            if (passwordContainer) {
                passwordContainer.style.display = 'none';
                const passwordInput = document.getElementById('docente-password');
                if (passwordInput) {
                    passwordInput.removeAttribute('required');
                    passwordInput.disabled = true;
                }
            }


            modalTitulo.textContent = 'Editar Docente';
            form.dataset.editId = id;


            document.getElementById('modal-docente').classList.remove('hidden');
        } else {
            throw new Error(result.message || 'No se pudo cargar la información del docente');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'No se pudo cargar la información del docente'
        });
    }
}

////////////////////////////////////////// guardar docente //////////////////////////////////////////
async function guardarDocente(event) {
    event.preventDefault();

    try {
        const form = event.target;
        const formData = new FormData(form);
        const editId = form.dataset.editId;
        const codigo = formData.get('codigo');
        if (!/^\d{10}$/.test(codigo)) {
            await Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El código debe tener exactamente 10 dígitos',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        const data = {
            nombres: formData.get('nombres'),
            apellidos: formData.get('apellidos'),
            codigo: codigo.padStart(10, '0'),
            email: formData.get('email'),
            celular: formData.get('celular') ? formData.get('celular').padStart(9, '0') : null,
            username: formData.get('username')
        };

        if (!editId || formData.get('password')) {
            data.password = formData.get('password');
        }

        const response = await fetch(editId ? `/drive_ucv/docentes/editar/${editId}` : '/drive_ucv/docentes/crear', {
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
                const errores = result.errors || {};
                const mensajesError = Object.values(errores).flat();
                await Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    html: mensajesError.join('<br>'),
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            throw new Error(result.message || `Error al ${editId ? 'actualizar' : 'crear'} el docente`);
        }

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: editId ? 'Docente actualizado correctamente' : 'Docente creado correctamente',
                timer: 1500,
                showConfirmButton: false
            });

            localStorage.removeItem('formDocenteTemp');
            form.reset();
            document.getElementById('modal-docente').classList.add('hidden');
            await cargarDocentes();
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al procesar la solicitud',
            confirmButtonText: 'Entendido'
        });
    }
}

////////////////////////////////////////// inicializar eventos //////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    const formDocente = document.getElementById('form-docente');
    if (formDocente) {
        const inputs = formDocente.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', guardarDatosTemporalesDocente);
        });
    }
});

////////////////////////////////////////// guardar datos temporales docente //////////////////////////////////////////
function guardarDatosTemporalesDocente(event) {
    const input = event.target;
    const formData = JSON.parse(localStorage.getItem('formDocenteTemp') || '{}');
    formData[input.name] = input.value;
    localStorage.setItem('formDocenteTemp', JSON.stringify(formData));
}

////////////////////////////////////////// mostrar modal crear docente //////////////////////////////////////////
function mostrarModalCrearDocente() {
    const form = document.getElementById('form-docente');
    const modalTitulo = document.getElementById('modal-docente-titulo');

    form.reset();
    delete form.dataset.editId;

    const passwordField = document.getElementById('docente-password');
    const passwordContainer = document.getElementById('password-container-docente');
    if (passwordContainer) {
        passwordContainer.style.display = 'block';
        if (passwordField) {
            passwordField.required = true;
            passwordField.disabled = false;
        }
    }

    modalTitulo.textContent = 'Nuevo Docente';
    document.getElementById('modal-docente').classList.remove('hidden');
}

////////////////////////////////////////// cerrar modal docente //////////////////////////////////////////
function cerrarModalDocente() {
    const modalDocente = document.getElementById('modal-docente');
    const formDocente = document.getElementById('form-docente');

    if (modalDocente) {
        const formData = new FormData(formDocente);
        const hasData = Array.from(formData.values()).some(value => value !== '');

        if (hasData) {
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
                    if (formDocente) formDocente.reset();
                    modalDocente.classList.add('hidden');
                }
            });
        } else {
            modalDocente.classList.add('hidden');
        }
    }
}

////////////////////////////////////////// validar email institucional //////////////////////////////////////////
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

////////////////////////////////////////// validar si el usuario es disponible //////////////////////////////////////////
let timeoutId = null;
async function validarUsuarioDisponible(username) {
    try {
        const messageSpan = document.getElementById('username-message');
        if (!username) {
            messageSpan.textContent = '';
            messageSpan.className = 'text-xs';
            return;
        }

        const response = await fetch('/drive_ucv/verificar-usuario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ username })
        });

        const result = await response.json();

        if (result.available) {
            messageSpan.textContent = '✓ Usuario disponible';
            messageSpan.className = 'text-xs text-green-600';
        } else {
            messageSpan.textContent = '✗ Usuario no disponible';
            messageSpan.className = 'text-xs text-red-600';
        }
    } catch (error) {
        console.error('Error al verificar usuario:', error);
    }
}

////////////////////////////////////////// validar formulario docente //////////////////////////////////////////
function validarFormularioDocente(form) {
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
    if (!form.dataset.editId && !password) {
        throw new Error('La contraseña es obligatoria');
    }
    if (password && password.length < 6) {
        throw new Error('La contraseña debe tener al menos 6 caracteres');
    }
}

////////////////////////////////////////// validar código //////////////////////////////////////////
function validarCodigo(input) {
    const messageSpan = input.nextElementSibling;
    const codigo = input.value.trim();

    if (!codigo) {
        messageSpan.textContent = '';
        messageSpan.className = 'text-xs codigo-message';
        return;
    }

    if (!/^\d{10}$/.test(codigo)) {
        messageSpan.textContent = '✗ El código debe tener 10 dígitos';
        messageSpan.className = 'text-xs codigo-message text-red-600';
        return false;
    }

    messageSpan.textContent = '✓ Código válido';
    messageSpan.className = 'text-xs codigo-message text-green-600';
    return true;
}

////////////////////////////////////////// validar celular //////////////////////////////////////////
function validarCelular(input) {
    const messageSpan = input.nextElementSibling;
    const celular = input.value.trim();

    if (!celular) {
        messageSpan.textContent = '';
        messageSpan.className = 'text-xs celular-message';
        return;
    }

    if (!/^9[0-9]{8}$/.test(celular)) {
        messageSpan.textContent = '✗ El celular debe empezar con 9 y tener 9 dígitos';
        messageSpan.className = 'text-xs celular-message text-red-600';
        return false;
    }

    messageSpan.textContent = '✓ Número válido';
    messageSpan.className = 'text-xs celular-message text-green-600';
    return true;
}

////////////////////////////////////////// filtrar docentes //////////////////////////////////////////
async function filtrarDocentes() {
    try {
        const busqueda = document.getElementById('searchDocente')?.value || '';
        const estado = document.getElementById('filterEstadoDocente')?.value || '';
        const fechaInicio = document.getElementById('fechaInicioDocente')?.value || '';
        const fechaFin = document.getElementById('fechaFinDocente')?.value || '';

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

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            const tbody = document.querySelector('#tabla-docentes tbody') || document.getElementById('tabla-docentes');
            if (!tbody) return;

            tbody.innerHTML = result.data.map(docente => `
                <tr data-user-id="${docente.id_usuario}">
                    <td class="px-6 py-4">${docente.nombres || ''}</td>
                    <td class="px-6 py-4">${docente.apellidos || ''}</td>
                    <td class="px-6 py-4">${docente.codigo || ''}</td>
                    <td class="px-6 py-4">${docente.email || ''}</td>
                    <td class="px-6 py-4">${docente.celular || ''}</td>
                    <td class="px-6 py-4">${docente.username || ''}</td>
                    <td class="px-6 py-4">${docente.secciones_asignadas || 'Sin asignaciones'}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       class="sr-only peer"
                                       ${docente.status == 1 ? 'checked' : ''}
                                       onchange="cambiarEstado('docentes', ${docente.id_usuario}, this.checked)">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium status-text ${docente.status == 1 ? 'text-green-600' : 'text-red-600'}">
                                    ${docente.status == 1 ? 'Activo' : 'Inactivo'}
                                </span>
                            </label>
                        </div>
                    </td>
                    <td class="px-6 py-4">${docente.fecha_actualizacion || ''}</td>
                    <td class="px-6 py-4">
                        <button onclick="editarDocente(${docente.id_usuario})"
                                class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        } else {
            throw new Error(result.message || 'Error al filtrar docentes');
        }
    } catch (error) {
        console.error('Error al filtrar docentes:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al filtrar docentes: ' + error.message
        });
    }
}

////////////////////////////////////////// event listeners con debounce //////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    const searchDocente = document.getElementById('searchDocente');
    const filterEstadoDocente = document.getElementById('filterEstadoDocente');
    const fechaInicioDocente = document.getElementById('fechaInicioDocente');
    const fechaFinDocente = document.getElementById('fechaFinDocente');

    let timeoutId;
    const debounceFilter = () => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(filtrarDocentes, 300);
    };

    searchDocente?.addEventListener('input', debounceFilter);
    filterEstadoDocente?.addEventListener('change', filtrarDocentes);
    fechaInicioDocente?.addEventListener('change', filtrarDocentes);
    fechaFinDocente?.addEventListener('change', filtrarDocentes);

    filtrarDocentes();
});

////////////////////////////////////////// cambiar estado docente //////////////////////////////////////////
async function cambiarEstadoDocente(id, estado) {
    try {
        const response = await fetch(`/drive_ucv/docentes/estado/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: estado ? 1 : 0
            })
        });

        const result = await response.json();

        if (result.success) {
            const statusText = estado ? 'Activo' : 'Inactivo';
            const statusElement = document.querySelector(`#estado-${id}`).parentElement.nextElementSibling;
            if (statusElement) {
                statusElement.textContent = statusText;
            }
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cambiar el estado del docente'
        });
        const checkbox = document.querySelector(`#estado-${id}`);
        if (checkbox) {
            checkbox.checked = !estado;
        }
    }
}

////////////////////////////////////////// filtrar secciones //////////////////////////////////////////
async function filtrarSecciones() {
    try {
        const filtroCurso = document.getElementById('filtro-curso');
        const filtroCiclo = document.getElementById('filtro-ciclo');
        const filtroEstado = document.getElementById('filtro-estado');

        const cursoId = filtroCurso ? filtroCurso.value : '';
        // Extraer solo IX o X del valor del ciclo
        const ciclo = filtroCiclo ? filtroCiclo.value.replace('Ciclo ', '') : '';
        const estado = filtroEstado ? filtroEstado.value : '';

        console.log('Filtrando con valores:', { cursoId, ciclo, estado });

        // Ajustar la URL para incluir el prefijo correcto
        const response = await fetch('/drive_ucv/secciones/filtrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                curso_id: cursoId,
                ciclo: ciclo,
                estado: estado
            })
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            actualizarTablaSecciones(result.data);
        } else {
            throw new Error(result.message || 'Error al filtrar secciones');
        }
    } catch (error) {
        console.error('Error al filtrar secciones:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al filtrar las secciones'
        });
    }
}

////////////////////////////////////////// actualizar tabla secciones //////////////////////////////////////////
function actualizarTablaSecciones(secciones) {
    const tablaSecciones = document.getElementById('tabla-secciones');
    tablaSecciones.innerHTML = '';

    secciones.forEach(seccion => {
        tablaSecciones.innerHTML += `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">${seccion.nombre_curso}</td>
                <td class="px-6 py-4 whitespace-nowrap">Ciclo ${seccion.ciclo}</td>
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

////////////////////////////////////////// cargar cursos en select //////////////////////////////////////////
async function cargarCursosEnSelect() {
    try {
        const response = await fetch('/drive_ucv/cursos/listar');
        const result = await response.json();

        if (result.success) {
            const selectCurso = document.querySelector('select[name="id_curso"]');
            selectCurso.innerHTML = '<option value="">Seleccione un curso</option>';

            result.data.forEach(curso => {
                selectCurso.innerHTML += `
                    <option value="${curso.id_curso}">
                        ${curso.nombre_curso} (Ciclo ${curso.ciclo})
                    </option>
                `;
            });
        } else {
            throw new Error(result.message || 'Error al cargar los cursos');
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

////////////////////////////////////////// abrir modal crear seccion //////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    const btnNuevaSeccion = document.querySelector('.btn-nueva-seccion');
    if (btnNuevaSeccion) {
        btnNuevaSeccion.addEventListener('click', function() {
            cargarCursosEnSelect();
            mostrarModalCrearSeccion();
        });
    }
});

// Cargar cursos cuando se carga la página
document.addEventListener('DOMContentLoaded', async () => {
    if (document.getElementById('secciones-section')) {
        console.log('Cargando cursos inicialmente...');
        await cargarCursos();
    }
});
// Event listeners para filtrar secciones
document.addEventListener('DOMContentLoaded', function() {
    const filtroCurso = document.getElementById('filtro-curso');
    const filtroCiclo = document.getElementById('filtro-ciclo');
    const filtroEstado = document.getElementById('filtro-estado');

    filtroCurso?.addEventListener('change', filtrarSecciones);
    filtroCiclo?.addEventListener('change', filtrarSecciones);
    filtroEstado?.addEventListener('change', filtrarSecciones);
});

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

