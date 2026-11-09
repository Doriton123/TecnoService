@extends('layouts.admin')

@section('title', 'Detalle del Equipo')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del equipo</h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Cliente propietario</th>
                    <td>{{ $equipo->cliente->nombre_completo }}</td>
                </tr>
                <tr>
                    <th>Tipo de equipo</th>
                    <td>{{ $equipo->tipo_equipo }}</td>
                </tr>
                <tr>
                    <th>Marca</th>
                    <td>{{ $equipo->marca }}</td>
                </tr>
                <tr>
                    <th>Modelo</th>
                    <td>{{ $equipo->modelo }}</td>
                </tr>
                <tr>
                    <th>Número de serie</th>
                    <td>{{ $equipo->numero_serie ?? 'Sin registro' }}</td>
                </tr>
                <tr>
                    <th>Fecha de registro</th>
                    <td>{{ $equipo->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>

            <h5 class="mt-4">
                <i class="bi bi-clock-history"></i>
                Historial de solicitudes
            </h5>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Fecha</th>
                            <th>Tipo de servicio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($equipo->solicitudes as $solicitud)
                            <tr>
                                <td>{{ $solicitud->numero_solicitud }}</td>
                                <td>{{ $solicitud->fecha_recepcion->format('d/m/Y') }}</td>
                                <td>{{ $solicitud->tipo_servicio }}</td>
                                <td>
                                    <span class="badge text-bg-primary">
                                        {{ $solicitud->estado }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Este equipo todavía no tiene solicitudes registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('admin.equipos.index') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>

        </div>
    </div>

@endsection