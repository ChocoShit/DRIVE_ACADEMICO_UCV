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

    <!-- Tabla de Alumnos -->
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
    <!-- ... contenido del modal ... -->
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
                    <input type="text"
                           name="codigo"
                           required
                           maxlength="10"
                           oninput="validarCodigo(this)"
                           onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) ||
                                    (event.keyCode >= 96 && event.keyCode <= 105) ||
                                    event.keyCode == 8 ||
                                    event.keyCode == 46"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Ingrese código">
                    <span class="text-xs text-gray-500">Ingrese un código de 10 dígitos</span>
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
                           id="email"
                           name="email"
                           required
                           pattern="[a-zA-Z0-9._%+-]+@ucvvirtual\.edu\.pe$"
                           oninput="validarEmailInstitucional(this)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="ejemplo@ucvvirtual.edu.pe">
                    <span class="text-xs text-gray-500">Use su correo institucional (@ucvvirtual.edu.pe)</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Celular</label>
                    <input type="tel"
                           name="celular"
                           required
                           pattern="9[0-9]{8}"
                           maxlength="9"
                           oninput="validarCelularAlumno(this)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Ingrese número de celular">
                    <span class="text-xs text-gray-500">El número debe empezar con 9 y tener 9 dígitos</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input type="text" name="username"required minlength="4" onkeyup="validarUsuarioDisponible(this.value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Ingrese nombre de usuario">
                    <span id="username-message" class="text-xs"></span>
                </div>
                <div id="password-container">
                    <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password"
                           id="password-alumno"
                           name="password"
                           required
                           minlength="6"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Ingrese contraseña">
                    <span class="text-xs text-gray-500">La contraseña debe tener al menos 6 caracteres</span>
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
                password: formData.get('password')
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
            const busqueda = document.getElementById('searchAlumno')?.value || '';
            const ciclo = document.getElementById('filterCiclo')?.value || '';
            const estado = document.getElementById('filterEstadoAlumno')?.value || '';
            const fechaInicio = document.getElementById('fechaInicioAlumno')?.value || '';
            const fechaFin = document.getElementById('fechaFinAlumno')?.value || '';

            console.log('Filtrando alumnos con:', { busqueda, ciclo, estado, fechaInicio, fechaFin });

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

    ////////////////////////////////////////// mostrar modal crear alumno //////////////////////////////////////////
    function mostrarModalCrearAlumno() {
        const form = document.getElementById('form-alumno');
        const modalTitulo = document.getElementById('modal-titulo');
        const passwordContainer = document.getElementById('password-container');
        const passwordField = document.getElementById('password-alumno');

        // Resetear el formulario
        form.reset();
        form.removeAttribute('data-edit-id');

        // Mostrar el campo de contraseña para nuevo alumno
        if (passwordContainer) {
            passwordContainer.style.display = 'block';
            if (passwordField) {
                passwordField.setAttribute('required', 'required');
                passwordField.disabled = false;
            }
        }

        // Cambiar el título del modal
        modalTitulo.textContent = 'Nuevo Alumno';

        // Mostrar el modal
        document.getElementById('modal-alumno').classList.remove('hidden');
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
</script>
