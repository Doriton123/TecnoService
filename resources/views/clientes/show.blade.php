@extends('layouts.admin')

@section('title', 'Detalle del Cliente')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Información del cliente
            </h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nombre completo</th>
                    <td>{{ $cliente->nombre_completo }}</td>
                </tr>
                <tr>
                    <th>NIT</th>
                    <td>{{ $cliente->nit }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $cliente->telefono }}</td>
                </tr>
                <tr>
                    <th>Correo</th>
                    <td>{{ $cliente->correo_electronico }}</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>{{ $cliente->direccion }}</td>
                </tr>
            </table>

            <h5 class="mt-4">Equipos registrados</h5>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Número de serie</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cliente->equipos as $equipo)
                        <tr>
                            <td>{{ $equipo->tipo_equipo }}</td>
                            <td>{{ $equipo->marca }}</td>
                            <td>{{ $equipo->modelo }}</td>
                            <td>{{ $equipo->numero_serie ?? 'Sin registro' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Este cliente todavía no tiene equipos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

@endsection