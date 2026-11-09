@extends('layouts.admin')

@section('title', 'Gestión de Clientes')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Clientes registrados</h3>
                <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nuevo cliente
                </a>
            </div>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('admin.clientes.index') }}" class="row g-2 mb-3">
                <div class="col-md-9">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre, NIT o correo..."
                        value="{{ $busqueda }}">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">
                        Limpiar
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>NIT</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nombre_completo }}</td>
                                <td>{{ $cliente->nit }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>{{ $cliente->correo_electronico }}</td>
                                <td>
                                    <a href="{{ route('admin.clientes.show', $cliente) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No se encontraron clientes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $clientes->links('pagination::bootstrap-5') }}

        </div>
    </div>

@endsection