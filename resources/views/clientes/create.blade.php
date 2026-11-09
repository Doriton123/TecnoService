
@extends('layouts.admin')

@section('title', 'Registrar Cliente')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Datos del nuevo cliente</h3>
    </div>

    <form action="{{ route('admin.clientes.store') }}" method="POST">
        @csrf

        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre_completo"
                           class="form-control @error('nombre_completo') is-invalid @enderror"
                           value="{{ old('nombre_completo') }}" required>
                    @error('nombre_completo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">NIT</label>
                    <input type="text" name="nit"
                           class="form-control @error('nit') is-invalid @enderror"
                           value="{{ old('nit') }}" required>
                    @error('nit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono"
                           class="form-control @error('telefono') is-invalid @enderror"
                           value="{{ old('telefono') }}" required>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="correo_electronico"
                           class="form-control @error('correo_electronico') is-invalid @enderror"
                           value="{{ old('correo_electronico') }}" required>
                    @error('correo_electronico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Dirección</label>
                    <textarea name="direccion"
                              class="form-control @error('direccion') is-invalid @enderror"
                              rows="3" required>{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Guardar cliente
            </button>
            <a href="{{ route('admin.clientes.index') }}"
               class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
