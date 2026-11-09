@extends('layouts.admin')

@section('title', 'Editar Cliente')

@section('content')

    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">Modificar datos del cliente</h3>
        </div>

        <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">

                    @foreach([
                            'nombre_completo' => 'Nombre completo',
                            'nit' => 'NIT',
                            'telefono' => 'Teléfono',
                            'correo_electronico' => 'Correo electrónico'
                        ] as $campo => $etiqueta)

                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ $etiqueta }}</label>
                            <input type="{{ $campo === 'correo_electronico' ? 'email' : 'text' }}" name="{{ $campo }}"
                                class="form-control @error($campo) is-invalid @enderror"
                                value="{{ old($campo, $cliente->$campo) }}" required>
                            @error($campo)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    @endforeach

                    <div class="col-12 mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror" rows="3"
                            required>{{ old('direccion', $cliente->direccion) }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Actualizar
                </button>

                <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

@endsection