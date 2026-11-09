@extends('layouts.admin')

@section('title', 'Administración de Usuarios')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Usuarios registrados</h3>

                <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Nuevo usuario
                </a>
            </div>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('admin.usuarios.index') }}" class="row g-2 mb-3">

                <div class="col-md-9">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o correo..."
                        value="{{ $buscar }}">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Buscar
                    </button>

                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                        Limpiar
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th>Rol</th>
                            <th>Fecha de registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    @foreach($usuario->getRoleNames() as $rol)
                                        <span class="badge text-bg-{{ $rol === 'Administrador' ? 'primary' : 'info' }}">
                                            {{ $rol }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-warning btn-sm"
                                        title="Editar usuario">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No se encontraron usuarios.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $usuarios->links('pagination::bootstrap-5') }}

        </div>
    </div>

@endsection