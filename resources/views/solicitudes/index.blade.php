@extends('layouts.admin')

@section('title', 'Solicitudes de Servicio')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Solicitudes registradas</h3>

                @role('Administrador')
                <a href="{{ route('admin.solicitudes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nueva solicitud
                </a>
                @endrole
            </div>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('solicitudes.index') }}" class="row g-2 mb-3">

                <div class="col-md-6">
                    <input type="text" name="buscar" class="form-control" placeholder="Número, cliente, marca o modelo"
                        value="{{ $buscar }}">
                </div>

                <div class="col-md-3">
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        @foreach(['Pendiente', 'En proceso', 'Finalizada'] as $estado)
                            <option value="{{ $estado }}" @selected(request('estado') === $estado)>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i> Buscar
                    </button>

                    <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
                        Limpiar
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Equipo</th>
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($solicitudes as $solicitud)
                            <tr>
                                <td>{{ $solicitud->numero_solicitud }}</td>
                                <td>{{ $solicitud->cliente->nombre_completo }}</td>
                                <td>
                                    {{ $solicitud->equipo->marca }}
                                    {{ $solicitud->equipo->modelo }}
                                </td>
                                <td>{{ $solicitud->fecha_recepcion->format('d/m/Y') }}</td>
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
                                <td>
                                    <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @role('Administrador')
                                    @if($solicitud->estado !== 'Finalizada')
                                        <a href="{{ route('admin.solicitudes.edit', $solicitud) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif
                                    @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    No se encontraron solicitudes.
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