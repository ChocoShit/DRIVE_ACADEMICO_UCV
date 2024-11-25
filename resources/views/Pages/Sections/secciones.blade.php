<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Gestión de Secciones</h2>
        <div class="flex justify-end mb-4 space-x-2">
            <button onclick="mostrarModalCrear()" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                Crear Sección
            </button>
            <button onclick="mostrarModalAsignar()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Asignar Sección
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <select id="filtro-curso"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los cursos</option>
                </select>
            </div>
            <div>
                <select id="filtro-ciclo"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los ciclos</option>
                    <option value="IX">Ciclo IX</option>
                    <option value="X">Ciclo X</option>
                </select>
            </div>
            <div>
                <select id="filtro-docente"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los docentes</option>
                </select>
            </div>
            <div>
                <select id="filtro-estado"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los estados</option>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ciclo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sección</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Docente(s)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Alumnos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-secciones">
                <!-- Se llena dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Editar Sección -->
<div id="modal-editar-seccion" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium" id="modal-editar-titulo">Editar Sección</h3>
            <button onclick="cerrarModalEditar()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="form-editar-seccion" onsubmit="actualizarSeccion(event)">
            <input type="hidden" name="id_seccion" id="editar_id_seccion">
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
                        <select name="nombre_seccion" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccione una sección</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Docente(s)</label>
                    <select name="docentes[]"
                            multiple
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Puede seleccionar múltiples docentes manteniendo presionada la tecla Ctrl</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                        onclick="cerrarModalEditar()"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Asignar Sección Existente -->
<div id="modal-asignar-seccion" class="fixed inset-0 hidden overflow-y-auto px-4 py-6 sm:px-0 z-50">
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg mx-auto">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-medium" id="modal-asignar-titulo">Asignar Sección</h3>
                <button onclick="cerrarModalAsignar()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Cerrar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="form-asignar-seccion" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Curso</label>
                    <select name="id_curso" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Seleccione un curso</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Sección</label>
                    <select name="id_seccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Seleccione una sección</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Docente</label>
                    <select name="id_docente" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Seleccione un docente</option>
                    </select>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" onclick="cerrarModalAsignar()" class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                        Asignar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Crear Nueva Sección -->
<div id="modal-crear-seccion" class="fixed inset-0 hidden overflow-y-auto px-4 py-6 sm:px-0 z-50">
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg mx-auto">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-medium">Crear Nueva Sección</h3>
                <button onclick="cerrarModalCrear()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Cerrar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="form-crear-seccion" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre de la Sección</label>
                    <input type="text" name="nombre_seccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" onclick="cerrarModalCrear()" class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Event listeners principales
document.addEventListener('DOMContentLoaded', async function() {
    console.log('DOM Cargado');
    const seccionesSection = document.getElementById('secciones-section');

    if (seccionesSection) {
        console.log('Sección de secciones encontrada, iniciando carga...');
        try {
            await cargarCursos();
            await cargarDocentes();
            await cargarSecciones(); // Esta es la función principal que necesitamos
            console.log('Carga inicial completada');
        } catch (error) {
            console.error('Error en la carga inicial:', error);
        }
    } else {
        console.log('No se encontró la sección de secciones');
    }
});

// Función unificada para cargar cursos
async function cargarCursos() {
    try {
        const response = await fetch('/drive_ucv/cursos/listar');
        const result = await response.json();

        if (result.success) {
            // Para el modal de asignar
            const selectCursoModal = document.querySelector('#modal-asignar-seccion select[name="id_curso"]');
            if (selectCursoModal) {
                selectCursoModal.innerHTML = '<option value="">Seleccione un curso</option>';
                result.data.forEach(curso => {
                    selectCursoModal.innerHTML += `
                        <option value="${curso.id_curso}">${curso.nombre_curso} - ${curso.ciclo}</option>
                    `;
                });
            }

            // Para el filtro de cursos
            const selectCursoFiltro = document.getElementById('filtro-curso');
            if (selectCursoFiltro) {
                selectCursoFiltro.innerHTML = '<option value="">Todos los cursos</option>';
                result.data.forEach(curso => {
                    selectCursoFiltro.innerHTML += `
                        <option value="${curso.id_curso}">${curso.nombre_curso} - ${curso.ciclo}</option>
                    `;
                });
            }
        }
    } catch (error) {
        console.error('Error al cargar cursos:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los cursos'
        });
    }
}


async function guardarSeccion(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const idCurso = formData.get('id_curso');
    const nombreSeccion = formData.get('nombre_seccion');
    const idSeccion = form.dataset.editId;

    try {
        // Validar disponibilidad
        const disponible = await validarSeccionDisponible(idCurso, nombreSeccion, idSeccion);
        if (!disponible) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Esta sección ya está asignada a este curso'
            });
            return;
        }

        // Continuar con el guardado...
        const response = await fetch(`/drive_ucv/secciones/${idSeccion ? 'actualizar/' + idSeccion : 'crear'}`, {
            method: idSeccion ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const result = await response.json();

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: idSeccion ? 'Sección actualizada correctamente' : 'Sección creada correctamente',
                timer: 1500,
                showConfirmButton: false
            });

            document.getElementById('modal-seccion').classList.add('hidden');
            cargarSecciones();
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al guardar la sección'
        });
    }
}
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
async function cargarDocentes() {
    try {
        const response = await fetch('/drive_ucv/docentes/listar');
        const result = await response.json();

        if (result.success) {
            // Para el filtro de docentes
            const selectDocenteFiltro = document.getElementById('filtro-docente');
            if (selectDocenteFiltro) {
                selectDocenteFiltro.innerHTML = '<option value="">Todos los docentes</option>';
                result.data.forEach(docente => {
                    selectDocenteFiltro.innerHTML += `
                        <option value="${docente.id_usuario}">${docente.nombres} ${docente.apellidos}</option>
                    `;
                });
            }

            // Para los modales (mantener el código existente para los modales)
            const selectDocenteModal = document.querySelector('select[name="id_docente"]');
            if (selectDocenteModal) {
                selectDocenteModal.innerHTML = '<option value="">Seleccione un docente</option>';
                result.data.forEach(docente => {
                    selectDocenteModal.innerHTML += `
                        <option value="${docente.id_usuario}">${docente.nombres} ${docente.apellidos}</option>
                    `;
                });
            }
        }
    } catch (error) {
        console.error('Error al cargar docentes:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los docentes'
        });
    }
}
async function cargarSecciones() {
    try {
        console.log('Iniciando carga de secciones...');
        const response = await fetch('/drive_ucv/secciones/listar', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const result = await response.json();
        console.log('Respuesta del servidor:', result);

        if (result.success) {
            console.log('Secciones recibidas:', result.data);
            actualizarTablaSecciones(result.data);
        } else {
            throw new Error(result.message || 'Error al cargar las secciones');
        }
    } catch (error) {
        console.error('Error en cargarSecciones:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar las secciones'
        });
    }
}
function actualizarTablaSecciones(secciones) {
    console.log('Actualizando tabla con secciones:', secciones);
    const tablaSecciones = document.getElementById('tabla-secciones');

    if (!tablaSecciones) {
        console.error('No se encontró el elemento tabla-secciones');
        return;
    }

    tablaSecciones.innerHTML = '';

    if (!secciones || secciones.length === 0) {
        tablaSecciones.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    No hay secciones disponibles
                </td>
            </tr>
        `;
        return;
    }

    secciones.forEach(seccion => {
        const estado = seccion.status == 1 ? 'checked' : '';
        tablaSecciones.innerHTML += `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">${seccion.nombre_curso || 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap">Ciclo ${seccion.ciclo || 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap">${seccion.nombre_seccion || 'N/A'}</td>
                <td class="px-6 py-4">${seccion.docentes || 'Sin asignar'}</td>
                <td class="px-6 py-4 text-center">${seccion.total_alumnos || '0'}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                   class="sr-only peer"
                                   ${estado}
                                   onchange="cambiarEstadoSeccion(${seccion.id_seccion}, this.checked)">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4
                                      peer-focus:ring-blue-300 peer-checked:after:translate-x-full
                                      peer-checked:bg-blue-600 after:content-[''] after:absolute
                                      after:top-0.5 after:left-[2px] after:bg-white after:rounded-full
                                      after:h-5 after:w-5 after:transition-all"></div>
                        </label>
                    </div>
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium">
                    <button onclick="editarSeccion(${seccion.id_seccion})"
                            class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

// Función para filtrar secciones
async function filtrarSecciones() {
    try {
        const cursoId = document.getElementById('filtro-curso').value;
        const ciclo = document.getElementById('filtro-ciclo').value;
        const docenteId = document.getElementById('filtro-docente').value;
        const estado = document.getElementById('filtro-estado').value;

        const response = await fetch('/drive_ucv/secciones/filtrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                curso: cursoId,
                ciclo: ciclo,
                docente: docenteId,
                estado: estado
            })
        });

        const result = await response.json();

        if (result.success) {
            actualizarTablaSecciones(result.data);
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error al filtrar:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al filtrar las secciones'
        });
    }
}

async function cambiarEstadoSeccion(id, estado) {
    try {
        const response = await fetch(`/drive_ucv/secciones/estado/${id}`, {
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
            await Swal.fire({
                icon: 'success',
                title: 'Estado actualizado',
                text: `La sección ha sido ${estado ? 'activada' : 'desactivada'} correctamente`,
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
            text: 'Error al cambiar el estado de la sección'
        });
        // Revertir el checkbox
        const checkbox = document.querySelector(`#estado-${id}`);
        if (checkbox) {
            checkbox.checked = !estado;
        }
    }
}

// Función helper para mostrar errores (mantener esta función útil)
function mostrarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje
    });
}



// Modificar el modal para usar select en lugar de input
function actualizarSelectSecciones() {
    const selectSeccion = document.querySelector('select[name="nombre_seccion"]');
    selectSeccion.innerHTML = '<option value="">Seleccione una sección</option>';
    SECCIONES_PREDEFINIDAS.forEach(seccion => {
        selectSeccion.innerHTML += `<option value="${seccion}">${seccion}</option>`;
    });
}

// Función para validar disponibilidad de sección
async function validarSeccionDisponible(idCurso, nombreSeccion, idSeccionActual = null) {
    try {
        const response = await fetch('/drive_ucv/secciones/validar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                id_curso: idCurso,
                nombre_seccion: nombreSeccion,
                id_seccion: idSeccionActual
            })
        });

        const result = await response.json();
        return result.disponible;
    } catch (error) {
        console.error('Error al validar sección:', error);
        return false;
    }
}

async function validarSeccionCurso(nombreSeccion, idCurso) {
    try {
        const response = await fetch('/drive_ucv/secciones/validar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nombre_seccion: nombreSeccion,
                id_curso: idCurso
            })
        });

        const result = await response.json();
        return !result.existe; // retorna true si la sección está disponible
    } catch (error) {
        console.error('Error al validar sección:', error);
        return false;
    }
}

async function crearSeccion(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    try {
        // Primero validar
        const seccionDisponible = await validarSeccionCurso(
            formData.get('nombre_seccion'),
            formData.get('id_curso')
        );

        if (!seccionDisponible) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Esta sección ya existe en este curso'
            });
            return;
        }

        // Si está disponible, crear la sección
        const response = await fetch('/drive_ucv/secciones/crear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nombre_seccion: formData.get('nombre_seccion'),
                id_curso: formData.get('id_curso'),
                id_docente: formData.get('id_docente')
            })
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Sección creada correctamente'
            });
            cerrarModalSeccion();
            await cargarSecciones();
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al crear la sección'
        });
    }
}

// Funciones para abrir/cerrar modales
function mostrarModalAsignar() {
    document.getElementById('modal-asignar-seccion').classList.remove('hidden');
    Promise.all([
        cargarCursos(),
        cargarDocentes(),
        cargarSecciones()
    ]).catch(error => {
        console.error('Error al cargar datos:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cargar los datos necesarios'
        });
    });
}

function cerrarModalAsignar() {
    document.getElementById('modal-asignar-seccion').classList.add('hidden');
    document.getElementById('form-asignar-seccion').reset();
}

function mostrarModalCrear() {
    document.getElementById('modal-crear-seccion').classList.remove('hidden');
    Promise.all([
        cargarCursos(),
        cargarDocentes()
    ]).catch(error => {
        console.error('Error al cargar datos:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cargar los datos necesarios'
        });
    });
}

function cerrarModalCrear() {
    document.getElementById('modal-crear-seccion').classList.add('hidden');
    document.getElementById('form-crear-seccion').reset();
}

// Cargar datos para los selects
async function cargarSecciones() {
    try {
        const response = await fetch('/drive_ucv/secciones/nombres');
        const result = await response.json();

        if (result.success) {
            const select = document.querySelector('select[name="id_seccion"]');
            select.innerHTML = '<option value="">Seleccione una sección</option>';

            result.data.forEach(seccion => {
                select.innerHTML += `<option value="${seccion.id_seccion}">${seccion.nombre_seccion}</option>`;
            });
        }
    } catch (error) {
        console.error('Error al cargar secciones:', error);
    }
}

// Manejar envío de formularios
document.getElementById('form-asignar-seccion').addEventListener('submit', async function(e) {
    e.preventDefault();

    try {
        const formData = new FormData(this);
        const response = await fetch('/drive_ucv/secciones/asignar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Sección asignada correctamente'
            });
            cerrarModalAsignar();
            await cargarSecciones();
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al asignar la sección'
        });
    }
});

document.getElementById('form-crear-seccion').addEventListener('submit', async function(e) {
    e.preventDefault();

    try {
        const formData = new FormData(this);
        const response = await fetch('/drive_ucv/secciones/crear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Sección creada correctamente'
            });
            cerrarModalCrear();
            await cargarSecciones();
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al crear la sección'
        });
    }
});

function mostrarModalEditar(idSeccion) {
    document.getElementById('modal-editar-seccion').classList.remove('hidden');
    document.getElementById('editar_id_seccion').value = idSeccion;

    Promise.all([
        cargarCursos(),
        cargarDocentes(),
        cargarDatosSeccion(idSeccion)
    ]).catch(error => {
        console.error('Error al cargar datos para edición:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cargar los datos de la sección'
        });
    });
}

function cerrarModalEditar() {
    document.getElementById('modal-editar-seccion').classList.add('hidden');
    document.getElementById('form-editar-seccion').reset();
}

async function actualizarSeccion(event) {
    event.preventDefault();

    try {
        const formData = new FormData(event.target);
        const response = await fetch(`/drive_ucv/secciones/actualizar/${formData.get('id_seccion')}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Sección actualizada correctamente'
            });
            cerrarModalEditar();
            await cargarSecciones();
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al actualizar la sección'
        });
    }
}

</script>

