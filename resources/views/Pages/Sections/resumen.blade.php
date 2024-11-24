
<div class="flex min-h-screen bg-gray-100">
    <!-- Contenido Principal -->
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Panel de Reportes</h1>

        <!-- Tarjetas de Resumen -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Reporte Individual -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Seguimiento Individual</h2>
                    <button onclick="generarReporteIndividual()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-file-alt mr-2"></i>
                        Generar Reporte
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Seleccionar Sección</label>
                        <select id="seccion-individual" class="border rounded-lg p-2" onchange="cargarAlumnosSeccion()">
                            <option value="">Seleccione una sección</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Seleccionar Alumno</label>
                        <select id="alumno-individual" class="border rounded-lg p-2">
                            <option value="">Seleccione un alumno</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Reporte por Sección -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Seguimiento por Sección</h2>
                    <button onclick="generarReporteSeccion()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        Generar Reporte
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Seleccionar Sección</label>
                        <select id="seccion-grupal" class="border rounded-lg p-2">
                            <option value="">Seleccione una sección</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Reportes -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Historial de Reportes</h2>
                <div class="flex gap-2">
                    <input type="date" id="fecha-inicio" class="border rounded-lg p-2">
                    <input type="date" id="fecha-fin" class="border rounded-lg p-2">
                    <button onclick="filtrarReportes()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sección</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alumno</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progreso</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-reportes">
                        <!-- Se llenará dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Cargado');
    cargarSecciones();
    cargarHistorialReportes();
});

async function cargarSecciones() {
    console.log('Iniciando carga de secciones');
    try {
        const response = await fetch('/drive_ucv/resumen/secciones/listar');
        console.log('Respuesta recibida:', response);
        const result = await response.json();
        console.log('Datos recibidos:', result);

        if (result.success) {
            const secciones = result.data;
            const selectIndividual = document.getElementById('seccion-individual');
            const selectGrupal = document.getElementById('seccion-grupal');

            console.log('Secciones obtenidas:', secciones);

            const options = secciones.map(seccion =>
                `<option value="${seccion.id_seccion}">${seccion.nombre_seccion}</option>`
            ).join('');

            selectIndividual.innerHTML = '<option value="">Seleccione una sección</option>' + options;
            selectGrupal.innerHTML = '<option value="">Seleccione una sección</option>' + options;
        }
    } catch (error) {
        console.error('Error en cargarSecciones:', error);
        mostrarError('No se pudieron cargar las secciones');
    }
}

// Función para cargar alumnos de una sección
async function cargarAlumnosSeccion() {
    const seccionId = document.getElementById('seccion-individual').value;
    if (!seccionId) return;

    try {
        const response = await fetch(`/drive_ucv/resumen/seccion/${seccionId}/alumnos`);
        const result = await response.json();

        if (result.success) {
            const selectAlumno = document.getElementById('alumno-individual');
            selectAlumno.innerHTML = '<option value="">Seleccione un alumno</option>' +
                result.data.map(alumno =>
                    `<option value="${alumno.id_usuario}">${alumno.apellidos}, ${alumno.nombres}</option>`
                ).join('');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError('No se pudieron cargar los alumnos');
    }
}

// Función para generar reporte individual
async function generarReporteIndividual() {
    const alumnoId = document.getElementById('alumno-individual').value;
    if (!alumnoId) {
        mostrarError('Por favor seleccione un alumno');
        return;
    }

    try {
        const response = await fetch('/drive_ucv/resumen/reportes/individual', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ alumno_id: alumnoId })
        });

        const result = await response.json();

        if (result.success) {
            await cargarHistorialReportes();
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Reporte generado correctamente'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError('Error al generar el reporte individual');
    }
}

// Función para generar reporte de sección
async function generarReporteSeccion() {
    const seccionId = document.getElementById('seccion-grupal').value;
    if (!seccionId) {
        mostrarError('Por favor seleccione una sección');
        return;
    }

    try {
        const response = await fetch('/drive_ucv/resumen/reportes/seccion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ seccion_id: seccionId })
        });

        const result = await response.json();

        if (result.success) {
            await cargarHistorialReportes();
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Reporte generado correctamente'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError('Error al generar el reporte de sección');
    }
}

// Función para cargar historial de reportes
async function cargarHistorialReportes() {
    try {
        const fechaInicio = document.getElementById('fecha-inicio')?.value || '';
        const fechaFin = document.getElementById('fecha-fin')?.value || '';

        const response = await fetch(`/drive_ucv/resumen/historial?${new URLSearchParams({
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin
        })}`);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            const tablaReportes = document.getElementById('tabla-reportes');
            if (!tablaReportes) return;

            tablaReportes.innerHTML = result.data.map(reporte => `
                <tr>
                    <td class="px-6 py-4">${new Date(reporte.fecha_generacion).toLocaleString()}</td>
                    <td class="px-6 py-4">${reporte.tipo}</td>
                    <td class="px-6 py-4">${reporte.nombre_seccion}</td>
                    <td class="px-6 py-4">${reporte.nombre_alumno || '-'}</td>
                    <td class="px-6 py-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: ${reporte.progreso}%"></div>
                        </div>
                        <span class="text-sm text-gray-600">${reporte.progreso}%</span>
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="descargarReporte(${reporte.id})"
                                class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-download"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError('Error al cargar el historial de reportes');
    }
}

// Función para descargar reporte
async function descargarReporte(id) {
    try {
        window.location.href = `/resumen/descargar/${id}`;
    } catch (error) {
        console.error('Error:', error);
        mostrarError('Error al descargar el reporte');
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
</script>


<style>
    .nav-link.active {
        background-color: rgb(55 65 81);
    }

    .progress-bar {
        transition: width 0.3s ease-in-out;
    }

    .table-hover tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
</style>

