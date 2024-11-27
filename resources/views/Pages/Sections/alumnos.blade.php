<div class="flex flex-col h-full">
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 w-full">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">Gestión de Alumnos</h2>
            <button type="button" onclick="mostrarModalCrearAlumno()"
                    class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Nuevo Alumno
            </button>
        </div>

        <div class="mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text"
                           id="searchAlumno"
                           placeholder="Buscar alumno..."
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="flex flex-col md:flex-row gap-2">
                    <select id="filterCiclo" class="w-full md:w-auto px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Todos los ciclos</option>
                        <option value="IX">IX Ciclo</option>
                        <option value="X">X Ciclo</option>
                    </select>
                    <select id="filterEstadoAlumno" class="w-full md:w-auto px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Todos los estados</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                    <div class="flex flex-col md:flex-row items-center gap-2">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">Desde:</span>
                            <input type="date"
                                   id="fechaInicioAlumno"
                                   class="w-full md:w-auto px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">Hasta:</span>
                            <input type="date"
                                   id="fechaFinAlumno"
                                   class="w-full md:w-auto px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>


   <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alumno</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-alumnos" class="bg-white divide-y divide-gray-200">
                            <!-- Las filas se generarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-alumno" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative min-h-screen md:flex md:items-center md:justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-[95%] md:max-w-[800px] lg:max-w-[1000px] mx-auto">
            <div class="p-4 md:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 id="modal-titulo" class="text-lg md:text-xl font-medium text-gray-900">Nuevo Alumno</h3>
                    <button type="button" onclick="cerrarModalAlumno()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="form-alumno" onsubmit="guardarAlumno(event)" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div>
                            <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                            <input type="text" name="nombres" id="nombres" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                            <input type="text" name="codigo" id="codigo" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
                            <input type="text" name="celular" id="celular" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                            <input type="text" name="username" id="username" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input type="password" name="password" id="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="ciclo" class="block text-sm font-medium text-gray-700">Ciclo</label>
                            <select id="ciclo" name="ciclo" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="IX">IX Ciclo</option>
                                <option value="X">X Ciclo</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div id="cursos-container" class="mt-4">
                    <!-- Aquí se cargarán los cursos dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>







<script>
    // Event listeners principales
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Inicializando eventos de alumnos...');
        cargarAlumnos();

        // Event listeners para los filtros
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

    // Mantén tu función guardarAlumno actual
    async function guardarAlumno(event) {
        event.preventDefault();
        const form = event.target;

        // Agregar logs para depuración
        console.log('Iniciando guardarAlumno');
        console.log('Email:', form.querySelector('[name="email"]').value);

        if (!validarFormulario(form)) {
            return;
        }

        try {
            const formData = new FormData(form);
            const editId = form.dataset.editId;

            const data = {
                nombres: formData.get('nombres'),
                apellidos: formData.get('apellidos'),
                codigo: formData.get('codigo').toString().padStart(10, '0'),
                email: formData.get('email').trim(),
                celular: formData.get('celular') ? formData.get('celular').toString().padStart(9, '0') : null,
                username: formData.get('username'),
                ciclo: formData.get('ciclo').substring(0, 2),
                password: formData.get('password'),
                id_curso: formData.get('curso'),
                id_seccion: formData.get('seccion')
            };

            console.log('Datos a enviar:', data);

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
            console.log('Respuesta del servidor:', result);

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
            console.error('Error completo:', error);

            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Error al procesar la solicitud',
                confirmButtonText: 'Entendido'
            });
        }
    }

    // Agrega la función validarUsuarioDisponible
    async function validarUsuarioDisponible(username) {
        if (!username) {
            document.getElementById('username-message').textContent = '';
            return;
        }

        try {
            const response = await fetch('/drive_ucv/alumnos/verificar-username', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ username })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            const messageElement = document.getElementById('username-message');

            if (result.available) {
                messageElement.textContent = '✓ Usuario disponible';
                messageElement.className = 'text-xs text-green-600';
            } else {
                messageElement.textContent = '✗ Usuario no disponible';
                messageElement.className = 'text-xs text-red-600';
            }
        } catch (error) {
            console.error('Error:', error);
            const messageElement = document.getElementById('username-message');
            messageElement.textContent = 'Error al verificar usuario';
            messageElement.className = 'text-xs text-red-600';
        }
    }

    // Asegúrate de que la función filtrarAlumnos esté correctamente implementada
    async function filtrarAlumnos() {
        try {
            const busqueda = document.getElementById('searchAlumno').value || '';
            const ciclo = document.getElementById('filterCiclo').value || '';
            const estado = document.getElementById('filterEstadoAlumno').value || '';
            const fechaInicio = document.getElementById('fechaInicioAlumno').value || '';
            const fechaFin = document.getElementById('fechaFinAlumno').value || '';

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

    ////////////////////////////////////////// gestionar la lista de alumnos //////////////////////////////////////////
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

                    tablaAlumnos.innerHTML += `
                        <tr data-user-id="${alumno.id_usuario}">
                            <td class="px-6 py-4">${alumno.nombres} ${alumno.apellidos}</td>
                            <td class="px-6 py-4">${alumno.codigo}</td>
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
                            <td class="px-6 py-4 text-center">
                                <button onclick="mostrarInformacionAlumno(${alumno.id_usuario})" class="text-blue-600 hover:text-blue-900 bg-gray-200 hover:bg-gray-300 rounded px-2 py-1">
                                    <i class="fas fa-eye"></i> Ver Info
                                </button>
                                <button onclick="editarAlumno(${alumno.id_usuario})" class="text-white bg-green-600 hover:bg-green-700 rounded px-2 py-1">
                                    <i class="fas fa-edit"></i> Editar
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

    ////////////////////////////////////////// actualizar tabla alumnos //////////////////////////////////////////
    function actualizarTablaAlumnos(alumnos) {
        const tbody = document.getElementById('tabla-alumnos');
        if (!tbody) return;

        tbody.innerHTML = alumnos.map(alumno => `
            <tr data-user-id="${alumno.id_usuario}">
                <td class="px-6 py-4">${alumno.nombres} ${alumno.apellidos}</td>
                <td class="px-6 py-4">${alumno.codigo}</td>
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
                <td class="px-6 py-4 text-center">
                    <button onclick="mostrarInformacionAlumno(${alumno.id_usuario})" class="text-blue-600 hover:text-blue-900 bg-gray-200 hover:bg-gray-300 rounded px-2 py-1">
                        <i class="fas fa-eye"></i> Ver Info
                    </button>
                    <button onclick="editarAlumno(${alumno.id_usuario})" class="text-white bg-green-600 hover:bg-green-700 rounded px-2 py-1">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                </td>
            </tr>
        `).join('');
    }

    ////////////////////////////////////////// cerrar el modal //////////////////////////////////////////
    function cerrarModalAlumno() {
        const modal = document.getElementById('modal-alumno');
        modal.classList.add('hidden');

        // Limpiar datos temporales al cerrar
        localStorage.removeItem('formAlumnoTemp');
    }

    // Agregar event listener para cerrar el modal con la tecla Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            cerrarModalAlumno();
        }
    });

    // Cerrar el modal si se hace clic fuera de él
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('modal-alumno');
        const modalContent = modal.querySelector('.relative');

        if (event.target === modal) {
            cerrarModalAlumno();
        }
    });

    ////////////////////////////////////////// mostrar modal crear alumno //////////////////////////////////////////
    async function mostrarModalCrearAlumno() {
        // Limpiar el formulario
        const form = document.getElementById('form-alumno');
        form.reset();

        // Limpiar el contenedor de cursos
        const cursosContainer = document.getElementById('cursos-container');
        cursosContainer.innerHTML = '';

        // Mostrar el modal
        const modal = document.getElementById('modal-alumno');
        modal.classList.remove('hidden');

        // Cambiar el título del modal
        document.getElementById('modal-titulo').textContent = 'Nuevo Alumno';

        // Remover ID de edición si existe
        form.removeAttribute('data-edit-id');

        // Limpiar datos temporales almacenados
        localStorage.removeItem('formAlumnoTemp');

        // Cargar cursos por ciclo inicial
        await cargarCursosPorCiclo('IX'); // Cargar cursos para el ciclo IX por defecto

        // Agregar event listener al select de ciclo
        const cicloSelect = document.getElementById('ciclo');
        cicloSelect.addEventListener('change', async (event) => {
            const cicloSeleccionado = event.target.value;
            await cargarCursosPorCiclo(cicloSeleccionado);
        });
    }

    ////////////////////////////////////////// guardar datos temporales //////////////////////////////////////////
    function guardarDatosTemporales(event) {
        const input = event.target;
        const formData = JSON.parse(localStorage.getItem('formAlumnoTemp') || '{}');
        formData[input.name] = input.value;
        localStorage.setItem('formAlumnoTemp', JSON.stringify(formData));
    }

    // También deberías agregar los event listeners para todos los campos del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const formAlumno = document.getElementById('form-alumno');
        if (formAlumno) {
            const inputs = formAlumno.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('change', guardarDatosTemporales);
            });
        }
    });

    function validarFormulario(form) {
        const emailInput = form.querySelector('[name="email"]');
        if (!validarEmailInstitucional(emailInput)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'Debe usar su correo institucional (@ucvvirtual.edu.pe)'
            });
            return false;
        }

        const codigoInput = form.querySelector('[name="codigo"]');
        const celularInput = form.querySelector('[name="celular"]');

        // Validar código
        if (!validarCodigo(codigoInput)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El código debe tener exactamente 10 dígitos'
            });
            return false;
        }

        // Validar celular (si tiene valor)
        if (celularInput && celularInput.value && !validarCelularAlumno(celularInput)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El número de celular debe empezar con 9 y tener 9 dígitos'
            });
            return false;
        }

        return true;
    }

    function validarCelularAlumno(input) {
        let valor = input.value.replace(/[^0-9]/g, '');
        const messageSpan = input.nextElementSibling;

        // Si es el primer dígito y no es 9, forzar 9
        if (valor.length === 1 && valor !== '9') {
            valor = '9';
        }

        // Limitar a 9 dígitos
        valor = valor.slice(0, 9);
        input.value = valor;

        if (valor.length === 9 && valor.startsWith('9')) {
            messageSpan.textContent = '✓ Número válido';
            messageSpan.className = 'text-xs text-green-600';
            return true;
        } else if (valor.length > 0) {
            messageSpan.textContent = 'El número debe empezar con 9 y tener 9 dígitos';
            messageSpan.className = 'text-xs text-red-600';
            return false;
        } else {
            messageSpan.textContent = 'El número debe tener 9 dígitos';
            messageSpan.className = 'text-xs text-gray-500';
            return false;
        }
    }

    function validarCodigo(input) {
        // Reemplazar cualquier caracter que no sea número con ''
        let valor = input.value.replace(/[^0-9]/g, '');

        // Actualizar el valor del input solo con números
        input.value = valor;

        // Limitar a 10 dígitos
        valor = valor.slice(0, 10);
        input.value = valor;

        const messageSpan = input.nextElementSibling;

        if (valor.length === 10) {
            messageSpan.textContent = '✓ Código válido';
            messageSpan.className = 'text-xs text-green-600';
            return true;
        } else if (valor.length > 0) {
            messageSpan.textContent = 'El código debe tener 10 dígitos';
            messageSpan.className = 'text-xs text-red-600';
            return false;
        } else {
            messageSpan.textContent = 'Ingrese un código de 10 dígitos';
            messageSpan.className = 'text-xs text-gray-500';
            return false;
        }
    }

    function validarEmailInstitucional(input) {
        const email = input.value.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@ucvvirtual\.edu\.pe$/;
        const messageSpan = input.nextElementSibling;

        console.log('Validando email:', email);
        console.log('¿Cumple con regex?:', emailRegex.test(email));

        if (email.length === 0) {
            messageSpan.textContent = 'Ingrese su correo institucional';
            messageSpan.className = 'text-xs text-gray-500';
            return false;
        } else if (emailRegex.test(email)) {
            messageSpan.textContent = '✓ Correo institucional válido';
            messageSpan.className = 'text-xs text-green-600';
            return true;
        } else {
            messageSpan.textContent = 'Debe usar su correo institucional (@ucvvirtual.edu.pe)';
            messageSpan.className = 'text-xs text-red-600';
            return false;
        }
    }

    // Función para cargar cursos
    async function cargarCursos() {
        try {
            const response = await fetch('/drive_ucv/cursos/listar');
            const result = await response.json();

            if (result.success) {
                const selectCurso = document.getElementById('select-curso');
                selectCurso.innerHTML = '<option value="">Seleccione un curso</option>';

                result.data.forEach(curso => {
                    selectCurso.innerHTML += `
                        <option value="${curso.id_curso}">
                            ${curso.nombre_curso} - ${curso.ciclo}
                        </option>
                    `;
                });
            }
        } catch (error) {
            console.error('Error al cargar cursos:', error);
        }
    }

        // Función para cargar cursos según el ciclo
        async function cargarCursosPorCiclo(ciclo) {
        if (!ciclo) return;

        try {
            const response = await fetch(`/drive_ucv/alumnos/cursos/por-ciclo/${ciclo}`);
            const result = await response.json();

            const cursosContainer = document.getElementById('cursos-container');
            cursosContainer.innerHTML = ''; // Limpiar contenedor

            if (result.success) {
                // Crear una tabla para mostrar los cursos
                const table = document.createElement('table');
                table.className = 'min-w-full divide-y divide-gray-200';
                table.innerHTML = `
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sección</th>
                        </tr>
                    </thead>
                    <tbody id="cursos-list"></tbody>
                `;
                cursosContainer.appendChild(table);

                result.data.forEach(curso => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-2">${curso.nombre_curso}</td>
                        <td class="px-4 py-2">
                            <select name="seccion_${curso.id_curso}" class="w-full border-gray-300 rounded-md">
                                <option value="">Seleccione una sección</option>
                                <!-- Aquí se llenarán las secciones dinámicamente -->
                            </select>
                        </td>
                    `;
                    document.getElementById('cursos-list').appendChild(row);
                });
            }
        } catch (error) {
            console.error('Error al cargar cursos:', error);
            mostrarError('Error al cargar los cursos');
        }
    }
    // Función para cargar secciones según el curso seleccionado
    /*async function cargarSecciones(cursoId) {
        if (!cursoId) return;

        try {
            const response = await fetch(`/drive_ucv/secciones/por-curso/${cursoId}`);
            const result = await response.json();

            const selectSeccion = document.getElementById('select-seccion');
            selectSeccion.innerHTML = '<option value="">Seleccione una sección</option>';

            if (result.success) {
                result.data.forEach(seccion => {
                    selectSeccion.innerHTML += `
                        <option value="${seccion.id_seccion}">
                            ${seccion.nombre_seccion}
                        </option>
                    `;
                });
            }
        } catch (error) {
            console.error('Error al cargar secciones:', error);
        }
    }*/



    // Función para cargar secciones de un curso
    async function cargarSeccionesPorCurso(cursoId, selectElement) {
        try {
            const response = await fetch(`/drive_ucv/alumnos/secciones/por-curso/${cursoId}`);
            const result = await response.json();

            if (result.success) {
                selectElement.innerHTML = '<option value="">Seleccione una sección</option>'; // Limpiar opciones
                result.data.forEach(seccion => {
                    const option = document.createElement('option');
                    option.value = seccion.id_seccion;
                    option.textContent = seccion.nombre_seccion;
                    selectElement.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error al cargar secciones:', error);
        }
    }
    // Función para verificar capacidad de sección
    function verificarCapacidadSeccion(select) {
        const seccionId = select.value;
        const infoDiv = document.getElementById(`info_seccion_${select.name.split('_')[1]}`);

        if (!seccionId) {
            infoDiv.innerHTML = '';
            return;
        }

        const option = select.options[select.selectedIndex];
        const capacidad = parseInt(option.dataset.capacidad);

        if (capacidad >= 30) {
            infoDiv.innerHTML = `
                <span class="text-red-600">
                    <i class="fas fa-exclamation-circle"></i>
                    Esta sección está llena (30/30 alumnos)
                </span>
            `;
            select.value = ''; // Limpiar selección
            return;
        }

        infoDiv.innerHTML = `
            <span class="text-green-600">
                <i class="fas fa-check-circle"></i>
                Capacidad disponible: ${capacidad}/30 alumnos
            </span>
        `;
    }

    async function mostrarInformacionAlumno(id) {
        try {
            const response = await fetch(`/drive_ucv/alumnos/obtener/${id}`);
            const result = await response.json();

            if (result.success) {
                // Mostrar la información en un modal o en un alert
                console.log(result.data); // Aquí puedes mostrar la información en un modal
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error al obtener información del alumno:', error);
        }
    }
</script>


