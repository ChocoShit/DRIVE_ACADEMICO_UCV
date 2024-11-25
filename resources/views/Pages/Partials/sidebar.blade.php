<div class="w-64 bg-gray-800 text-white fixed h-full">
    <div class="p-4">
        <h2 class="text-xl font-bold mb-6 text-center">LeDrive</h2>
        <nav>
            @if(auth()->user()->id_tipo_usuario == 1)
            <a href="#" data-section="resumen" class="nav-link flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded mb-1 active">
                <i class="fas fa-chart-bar w-6"></i>
                <span>Reportes</span>
            </a>
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
            @elseif(auth()->user()->id_tipo_usuario == 2)
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
