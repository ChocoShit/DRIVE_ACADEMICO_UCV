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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileButton = document.getElementById('profile-menu-button');
    const profileDropdown = document.getElementById('profile-dropdown');

    // Función para mostrar/ocultar el menú desplegable
    function toggleDropdown() {
        const isExpanded = profileButton.getAttribute('aria-expanded') === 'true';
        profileButton.setAttribute('aria-expanded', !isExpanded);
        profileDropdown.classList.toggle('hidden');
    }

    // Click en el botón de perfil
    profileButton?.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleDropdown();
    });

    // Click fuera del menú para cerrarlo
    document.addEventListener('click', function(e) {
        if (!profileDropdown?.contains(e.target) && !profileButton?.contains(e.target)) {
            profileButton?.setAttribute('aria-expanded', 'false');
            profileDropdown?.classList.add('hidden');
        }
    });
});

// Función para mostrar el modal de perfil
function mostrarPerfil() {
    Swal.fire({
        title: 'Mi Perfil',
        html: `
            <div class="text-left">
                <p class="mb-2"><strong>Usuario:</strong> ${document.querySelector('#profile-menu-button span').textContent}</p>
                <p class="mb-2"><strong>Tipo:</strong> ${document.querySelector('#profile-dropdown .text-gray-500').textContent.replace('Tipo: ', '')}</p>
            </div>
        `,
        showCloseButton: true,
        showConfirmButton: false,
        customClass: {
            popup: 'swal2-show-profile',
            closeButton: 'swal2-close-profile'
        }
    });
}

// Función para cambiar contraseña
function cambiarPassword() {
    Swal.fire({
        title: 'Cambiar Contraseña',
        html: `
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contraseña Actual</label>
                    <input type="password" id="current-password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                    <input type="password" id="new-password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                    <input type="password" id="confirm-password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Cambiar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            // Aquí iría la lógica para cambiar la contraseña
            return new Promise((resolve) => {
                setTimeout(() => {
                    resolve();
                }, 1000);
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('¡Éxito!', 'Contraseña cambiada correctamente', 'success');
        }
    });
}
</script>
