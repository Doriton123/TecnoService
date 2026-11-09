@extends('layouts.admin')

@section('title', 'Reportes de Servicio')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Reportes de solicitudes
            </h3>
        </div>

        <div class="card-body">

            <h5>Filtros de búsqueda</h5>

            <form method="GET" action="{{ route('admin.reportes.index') }}" class="row g-3 mb-4">

                <div class="col-md-4">
                    <label class="form-label">Estado</label>

                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>

                        @foreach(['Pendiente', 'En proceso', 'Finalizada'] as $estado)
                            <option value="{{ $estado }}" @selected(old('estado', $filtros['estado'] ?? '') === $estado)>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Fecha inicial</label>
                    <input type="date" name="fecha_inicio" class="form-control"
                        value="{{ old('fecha_inicio', $filtros['fecha_inicio'] ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Fecha final</label>
                    <input type="date" name="fecha_fin" class="form-control"
                        value="{{ old('fecha_fin', $filtros['fecha_fin'] ?? '') }}">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Consultar
                    </button>

                    <a href="{{ route('admin.reportes.index') }}" class="btn btn-secondary">
                        Limpiar
                    </a>

                    <a href="{{ route('admin.reportes.pdf', request()->only(['estado', 'fecha_inicio', 'fecha_fin'])) }}"
                        class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Descargar PDF
                    </a>
                </div>
            </form>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="alert alert-info">
                <strong>Total de solicitudes encontradas:</strong>
                {{ $total }}
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Equipo</th>
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($solicitudes as $solicitud)
                            <tr>
                                <td>{{ $solicitud->numero_solicitud }}</td>
                                <td>{{ $solicitud->cliente?->nombre_completo ?? 'No disponible' }}</td>
                                <td>
                                    {{ $solicitud->equipo?->marca ?? 'No disponible' }}
                                    {{ $solicitud->equipo?->modelo ?? '' }}
                                </td>
                                <td>
                                    {{ $solicitud->fecha_recepcion->format('d/m/Y') }}
                                </td>
                                <td>{{ $solicitud->tipo_servicio }}</td>
                                <td>
                                    @php
                                        $color = match ($solicitud->estado) {
                                            'Pendiente' => 'warning',
                                            'En proceso' => 'primary',
                                            'Finalizada' => 'success',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge text-bg-{{ $color }}">
                                        {{ $solicitud->estado }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No existen solicitudes con los filtros seleccionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $solicitudes->links('pagination::bootstrap-5') }}

        </div>
    </div>

@endsection