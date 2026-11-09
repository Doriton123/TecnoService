@extends('layouts.admin')

@section('title', 'Gestión de Equipos')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Equipos registrados</h3>

                <a href="{{ route('admin.equipos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nuevo equipo
                </a>
            </div>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('admin.equipos.index') }}" class="row g-2 mb-3">

                <div class="col-md-9">
                    <input type="text" name="buscar" class="form-control"
                        placeholder="Buscar por cliente, marca, modelo o serie..." value="{{ $busqueda }}">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Buscar
                    </button>

                    <a href="{{ route('admin.equipos.index') }}" class="btn btn-secondary">
                        Limpiar
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Número de serie</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($equipos as $equipo)
                            <tr>
                                <td>{{ $equipo->id }}</td>
                                <td>{{ $equipo->cliente->nombre_completo }}</td>
                                <td>{{ $equipo->tipo_equipo }}</td>
                                <td>{{ $equipo->marca }}</td>
                                <td>{{ $equipo->modelo }}</td>
                                <td>{{ $equipo->numero_serie ?? 'Sin serie' }}</td>
                                <td>
                                    <a href="{{ route('admin.equipos.show', $equipo) }}" class="btn btn-info btn-sm"
                                        title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.equipos.edit', $equipo) }}" class="btn btn-warning btn-sm"
                                        title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No se encontraron equipos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $equipos->links('pagination::bootstrap-5') }}

        </div>
    </div>

@endsection