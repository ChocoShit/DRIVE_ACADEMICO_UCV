<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Gestión de Docentes</h2>
        <button type="button" onclick="mostrarModalCrearDocente()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Nuevo Docente
        </button>
    </div>

    <!-- Buscador y Filtros -->
    <div class="mb-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text"
                       id="searchDocente"
                       placeholder="Buscar docente..."
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Última Modificación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-docentes">
                <!-- Se llena dinámicamente -->
            </tbody>
        </table>
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
                <!-- Nombres -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombres</label>
                    <input type="text"
                           name="nombres"
                           id="docente-nombres"
                           required
                           placeholder="Ingrese nombres"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Apellidos -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                    <input type="text"
                           name="apellidos"
                           id="docente-apellidos"
                           required
                           placeholder="Ingrese apellidos"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Código -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Código</label>
                    <input type="text"
                           name="codigo"
                           id="docente-codigo"
                           required
                           maxlength="10"
                           placeholder="El código debe tener 10 dígitos"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                           pattern="\d{10}"
                           onchange="validarCodigo(this)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <span class="text-xs codigo-message"></span>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Institucional</label>
                    <input type="email"
                           name="email"
                           id="docente-email"
                           required
                           placeholder="ejemplo@ucvvirtual.edu.pe"
                           pattern="[a-zA-Z0-9._+-]+@ucvvirtual\.edu\.pe$"
                           onchange="validarEmailInstitucional(this)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <span class="text-xs email-message"></span>
                </div>

                <!-- Celular -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Celular</label>
                    <input type="tel"
                           name="celular"
                           id="docente-celular"
                           maxlength="9"
                           placeholder="El número debe empezar con 9 y tener 9 dígitos"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                           pattern="9[0-9]{8}"
                           onchange="validarCelularDocente(this)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <span class="text-xs celular-message"></span>
                </div>

                <!-- Usuario -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input type="text"
                           name="username"
                           id="docente-username"
                           required
                           placeholder="Ingrese nombre de usuario"
                           onchange="validarUsuarioDisponible(this.value)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <span class="text-xs" id="username-message"></span>
                </div>

                <!-- Contraseña -->
                <div id="password-container-docente">
                    <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password"
                           name="password"
                           id="docente-password"
                           minlength="6"
                           placeholder="La contraseña debe tener al menos 6 caracteres"
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando eventos de docentes...');
    cargarDocentes();

    // Event listeners para los filtros con debounce
    const searchDocente = document.getElementById('searchDocente');
    const filterEstadoDocente = document.getElementById('filterEstadoDocente');
    const fechaInicioDocente = document.getElementById('fechaInicioDocente');
    const fechaFinDocente = document.getElementById('fechaFinDocente');
    const docentesLink = document.querySelector('[data-section="docentes"]');
    if (docentesLink) {
        docentesLink.addEventListener('click', function() {
            console.log('Click en enlace de docentes');
            cargarDocentes();
        });
    }
    let timeoutId;
    const debounceFilter = () => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(filtrarDocentes, 300);
    };

    searchDocente?.addEventListener('input', debounceFilter);
    filterEstadoDocente?.addEventListener('change', filtrarDocentes);
    fechaInicioDocente?.addEventListener('change', filtrarDocentes);
    fechaFinDocente?.addEventListener('change', filtrarDocentes);

    // Event listeners para el formulario
    const formDocente = document.getElementById('form-docente');
    if (formDocente) {
        const inputs = formDocente.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', guardarDatosTemporalesDocente);
        });
    }
});


// Funciones principales
async function cargarDocentes() {
    try {
        const response = await fetch('/drive_ucv/docentes/listar');
        const result = await response.json();

        if (result.success) {
            const tablaDocentes = document.getElementById('tabla-docentes');
            tablaDocentes.innerHTML = '';

            result.data.forEach(docente => {
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
                                       onchange="cambiarEstadoDocente(${docente.id_usuario}, this.checked)">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                          peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full
                                          peer dark:bg-gray-700 peer-checked:after:translate-x-full
                                          peer-checked:after:border-white after:content-[''] after:absolute
                                          after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300
                                          after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                          dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium status-text
                                           ${docente.status == 1 ? 'text-green-600' : 'text-red-600'}">
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

// Funciones de gestión del modal y formulario
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

// Funciones de guardado y edición
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

// Funciones de filtrado
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
            // Actualizar la interfaz
            const row = document.querySelector(`tr[data-user-id="${id}"]`);
            if (row) {
                const statusText = estado ? 'Activo' : 'Inactivo';
                const statusSpan = row.querySelector('.status-text');
                if (statusSpan) {
                    statusSpan.textContent = statusText;
                    statusSpan.className = `ml-3 text-sm font-medium status-text ${estado ? 'text-green-600' : 'text-red-600'}`;
                }
            }

            // Mostrar mensaje de éxito
            await Swal.fire({
                icon: 'success',
                title: 'Estado actualizado',
                text: `El docente ha sido ${estado ? 'activado' : 'desactivado'} correctamente`,
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            throw new Error(result.message || 'Error al cambiar el estado');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al cambiar el estado del docente'
        });
        // Revertir el estado del checkbox
        const checkbox = document.querySelector(`tr[data-user-id="${id}"] input[type="checkbox"]`);
        if (checkbox) {
            checkbox.checked = !estado;
        }
    }
}

// Función para actualizar la tabla de docentes
function actualizarTablaDocentes(docentes) {
    const tbody = document.getElementById('tabla-docentes');
    tbody.innerHTML = '';

    docentes.forEach(docente => {
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
                               onchange="cambiarEstadoDocente(${docente.id_usuario}, this.checked)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                  peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full
                                  peer dark:bg-gray-700 peer-checked:after:translate-x-full
                                  peer-checked:after:border-white after:content-[''] after:absolute
                                  after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300
                                  after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                  dark:border-gray-600 peer-checked:bg-blue-600"></div>
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
        tbody.appendChild(row);
    });
}

// Función para guardar datos temporales
function guardarDatosTemporalesDocente(event) {
    const input = event.target;
    const formData = JSON.parse(localStorage.getItem('formDocenteTemp') || '{}');
    formData[input.name] = input.value;
    localStorage.setItem('formDocenteTemp', JSON.stringify(formData));
}

// Función para validar usuario disponible
let timeoutId = null;
async function validarUsuarioDisponible(username) {
    try {
        const messageSpan = document.getElementById('username-message');
        if (!username) {
            messageSpan.textContent = '';
            messageSpan.className = 'text-xs';
            return;
        }

        clearTimeout(timeoutId);
        timeoutId = setTimeout(async () => {
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
        }, 500);
    } catch (error) {
        console.error('Error al verificar usuario:', error);
    }
}

// Funciones de validación
function validarEmailInstitucional(input) {
    const messageSpan = input.nextElementSibling;
    const email = input.value.trim();
    const emailPattern = /^[a-zA-Z0-9._+-]+@ucvvirtual\.edu\.pe$/;

    if (!email) {
        messageSpan.textContent = '';
        messageSpan.className = 'text-xs email-message';
        return;
    }

    if (!emailPattern.test(email)) {
        messageSpan.textContent = '✗ Debe usar su correo institucional (@ucvvirtual.edu.pe)';
        messageSpan.className = 'text-xs email-message text-red-600';
        return false;
    }

    messageSpan.textContent = '✓ Email válido';
    messageSpan.className = 'text-xs email-message text-green-600';
    return true;
}

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

function validarCelularDocente(input) {
    const messageSpan = input.nextElementSibling;
    const celular = input.value.trim();

    if (!celular) {
        messageSpan.textContent = '';
        messageSpan.className = 'text-xs celular-message';
        return;
    }

    if (!/^9\d{8}$/.test(celular)) {
        messageSpan.textContent = '✗ El celular debe empezar con 9 y tener 9 dígitos';
        messageSpan.className = 'text-xs celular-message text-red-600';
        return false;
    }

    messageSpan.textContent = '✓ Número válido';
    messageSpan.className = 'text-xs celular-message text-green-600';
    return true;
}

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


</script>
