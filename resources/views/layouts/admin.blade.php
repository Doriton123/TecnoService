<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | TecnoService</title>

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <!-- Barra superior -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>

        <!-- Menú lateral -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none">
                    <i class="bi bi-pc-display-horizontal me-2"></i>
                    <span class="brand-text fw-light">
                        TecnoService
                    </span>
                </a>
            </div>


            <div class="sidebar-wrapper">

                <nav class="mt-2">

                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-header">MENÚ PRINCIPAL</li>

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>

                            </a>
                        </li>

                        <!-- Solo Administrador -->
                        @role('Administrador')

                        <li class="nav-item">
                            <a href="{{ route('admin.clientes.index') }}"
                                class="nav-link {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">

                                <i class="nav-icon bi bi-people"></i>
                                <p>Clientes</p>

                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.equipos.index') }}"
                                class="nav-link {{ request()->routeIs('admin.equipos.*') ? 'active' : '' }}">

                                <i class="nav-icon bi bi-pc-display"></i>
                                <p>Equipos</p>

                            </a>
                        </li>

                        @endrole

                        <!-- Administrador y Técnico -->
                        @hasanyrole('Administrador|Tecnico')

                        <li class="nav-item">
                            <a href="{{ route('solicitudes.index') }}"
                                class="nav-link {{ request()->routeIs('solicitudes.*') ? 'active' : '' }}">

                                <i class="nav-icon bi bi-tools"></i>
                                <p>Solicitudes</p>

                            </a>
                        </li>

                        @endhasanyrole

                        <!-- Administración -->
                        @role('Administrador')

                        <li class="nav-header">ADMINISTRACIÓN</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.usuarios.index') }}"
                                class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">

                                <i class="nav-icon bi bi-person-gear"></i>
                                <p>Usuarios</p>

                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.reportes.index') }}"
                                class="nav-link {{ request()->routeIs('admin.reportes.*') ? 'active' : '' }}">

                                <i class="nav-icon bi bi-file-earmark-pdf"></i>
                                <p>Reportes PDF</p>

                            </a>
                        </li>

                        @endrole

                    </ul>

                </nav>

            </div>

        </aside>

        <!-- Contenido principal -->
        <main class="app-main">

            <div class="app-content-header">
                <div class="container-fluid">
                    <h3 class="mb-0">@yield('title', 'Dashboard')</h3>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

        </main>

        <!-- Pie de página -->
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">
                Sistema de Gestión de Servicios
            </div>
            <strong>TecnoService &copy; {{ date('Y') }}</strong>
        </footer>

    </div>

</body>

</html>