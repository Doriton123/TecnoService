
@extends('layouts.admin')

@section('title', 'Editar Equipo')

@section('content')

<div class="card card-warning card-outline">

    <div class="card-header">
        <h3 class="card-title">Modificar información del equipo</h3>
    </div>

    <form action="{{ route('admin.equipos.update', $equipo) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">

                <div class="col-md-12 mb-3">
                    <label class="form-label">Cliente propietario</label>

                    <select name="cliente_id"
                            class="form-select @error('cliente_id') is-invalid @enderror"
                            required>

                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                @selected(old('cliente_id', $equipo->cliente_id) == $cliente->id)>
                                {{ $cliente->nombre_completo }} - {{ $cliente->nit }}
                            </option>
                        @endforeach
                    </select>

                    @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipo de equipo</label>

                    <select name="tipo_equipo" class="form-select" required>
                        @foreach(['Laptop', 'Computadora de escritorio', 'Impresora', 'Monitor', 'Otro'] as $tipo)
                            <option value="{{ $tipo }}"
                                @selected(old('tipo_equipo', $equipo->tipo_equipo) == $tipo)>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Marca</label>
                    <input type="text" name="marca"
                           class="form-control"
                           value="{{ old('marca', $equipo->marca) }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="modelo"
                           class="form-control"
                           value="{{ old('modelo', $equipo->modelo) }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Número de serie</label>
                    <input type="text" name="numero_serie"
                           class="form-control"
                           value="{{ old('numero_serie', $equipo->numero_serie) }}">
                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Actualizar equipo
            </button>

            <a href="{{ route('admin.equipos.index') }}"
               class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
