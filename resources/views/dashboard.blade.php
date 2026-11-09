@extends('layouts.admin')

@section('title', 'Dashboard - TecnoService')

@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <h4>Panel de Control</h4>
            <p class="text-muted">
                Bienvenido, {{ auth()->user()->name }}.
                Aquí puedes consultar el estado general de TecnoService.
            </p>
        </div>
    </div>

    <!-- TARJETAS ESTADÍSTICAS -->
    <div class="row">

        @role('Administrador')
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $totalClientes }}</h3>
                    <p>Clientes registrados</p>
                </div>
                <i class="small-box-icon bi bi-people"></i>
                <a href="{{ route('admin.clientes.index') }}" class="small-box-footer">
                    Ver clientes <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ $totalEquipos }}</h3>
                    <p>Equipos registrados</p>
                </div>
                <i class="small-box-icon bi bi-pc-display"></i>
                <a href="{{ route('admin.equipos.index') }}" class="small-box-footer">
                    Ver equipos <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        @endrole

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $pendientes }}</h3>
                    <p>Solicitudes pendientes</p>
                </div>
                <i class="small-box-icon bi bi-clock-history"></i>
                <a href="{{ route('solicitudes.index', ['estado' => 'Pendiente']) }}" class="small-box-footer">
                    Ver solicitudes <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ $finalizadas }}</h3>
                    <p>Solicitudes finalizadas</p>
                </div>
                <i class="small-box-icon bi bi-check-circle"></i>
                <a href="{{ route('solicitudes.index', ['estado' => 'Finalizada']) }}" class="small-box-footer">
                    Ver solicitudes <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- RESUMEN GENERAL -->
    <div class="row">

        <div class="col-lg-4 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-bar-chart"></i>
                        Resumen de solicitudes
                    </h3>
                </div>

                <div class="card-body">
                    <p><strong>Total:</strong> {{ $totalSolicitudes }}</p>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Pendientes</span>
                            <strong>{{ $pendientes }}</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning"
                                style="width: {{ $totalSolicitudes > 0 ? ($pendientes / $totalSolicitudes) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>En proceso</span>
                            <strong>{{ $enProceso }}</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary"
                                style="width: {{ $totalSolicitudes > 0 ? ($enProceso / $totalSolicitudes) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Finalizadas</span>
                            <strong>{{ $finalizadas }}</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success"
                                style="width: {{ $totalSolicitudes > 0 ? ($finalizadas / $totalSolicitudes) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>

                    @role('Administrador')
                    <hr>
                    <p class="mb-0">
                        <strong>Usuarios registrados:</strong>
                        {{ $totalUsuarios }}
                    </p>
                    @endrole
                </div>
            </div>
        </div>

        <!-- ÚLTIMAS SOLICITUDES -->
        <div class="col-lg-8 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-list-check"></i>
                        Últimas solicitudes
                    </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Equipo</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($ultimasSolicitudes as $solicitud)
                                    <tr>
                                        <td>{{ $solicitud->numero_solicitud }}</td>
                                        <td>{{ $solicitud->cliente?->nombre_completo ?? 'No disponible' }}</td>
                                        <td>
                                            {{ $solicitud->equipo?->marca ?? '' }}
                                            {{ $solicitud->equipo?->modelo ?? '' }}
                                        </td>
                                        <td>
                                            @php
                                                $color = match ($solicitud->estado) {
                                                    'Pendiente' => 'warning',
                                                    'En proceso' => 'primary',
                                                    'Finalizada' => 'success',
                                                    default => 'secondary'
                                                };
                                            @endphp

                                            <span class="badge text-bg-{{ $color }}">
                                                {{ $solicitud->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('solicitudes.show', $solicitud) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No existen solicitudes registradas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('solicitudes.index') }}" class="btn btn-primary mt-2">
                        Ver todas las solicitudes
                    </a>
                </div>
            </div>
        </div>

    </div>

@endsection