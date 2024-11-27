@extends('Layouts.AppLayout')

@section('title')
LeDrive - Dashboard
@endsection

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    @include('Pages.Partials.sidebar')
    <!-- Contenido Principal -->
    <div class="ml-64 flex-1">
        <!-- Header con perfil -->
        @include('Pages.Partials.header')

        <!-- Contenido de las secciones -->
        <div class="p-8 pt-24">
            <!-- Secciones -->
            <section id="resumen-section" class="section-content hidden">
                @include('Pages.Sections.resumen')
            </section>
            <section id="alumnos-section" class="section-content hidden">
                @include('Pages.Sections.alumnos')
            </section>
            <section id="docentes-section" class="section-content hidden">
                @include('Pages.Sections.docentes')
            </section>
            <section id="secciones-section" class="section-content hidden">
                @include('Pages.Sections.secciones')
            </section>
            <section id="asignaciones-section" class="section-content hidden">
                @include('Pages.Sections.asignaciones')
            </section>
            <section id="archivos-section" class="section-content hidden">
                @include('Pages.Sections.archivos')
            </section>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Restablecer scroll
    window.scrollTo(0, 0);

    function cambiarSeccion(seccionId) {
        // Ocultar todas las secciones
        document.querySelectorAll('.section-content').forEach(section => {
            section.classList.add('hidden');
        });

        // Mostrar la sección seleccionada
        const seccionActiva = document.getElementById(`${seccionId}-section`);
        if (seccionActiva) {
            seccionActiva.classList.remove('hidden');
        }

        // Actualizar estado activo en el menú
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
            if (link.dataset.section === seccionId) {
                link.classList.add('active');
            }
        });

        // Guardar la sección activa
        localStorage.setItem('lastActiveSection', seccionId);
    }

    // Agregar event listeners a los enlaces del menú
    document.querySelectorAll('[data-section]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const seccionId = this.dataset.section;
            cambiarSeccion(seccionId);
        });
    });

    // Cargar la última sección activa o la sección por defecto
    const lastActiveSection = localStorage.getItem('lastActiveSection') || 'resumen';
    cambiarSeccion(lastActiveSection);
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

    /* Estilos para el scroll */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #666;
    }

    /* Ajustes para la tabla */
    .table-container {
        max-height: calc(100vh - 300px);
        overflow-y: auto;
    }

    /* Ajustes para el modal */
    @media (max-width: 768px) {
        .modal-content {
            margin: 1rem;
            width: calc(100% - 2rem);
        }
    }

    button {
        transition: background-color 0.3s ease;
    }

    button:hover {
        transform: scale(1.05);
    }
</style>
@endsection

