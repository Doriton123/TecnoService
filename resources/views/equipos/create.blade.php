@extends('layouts.admin')

@section('title', 'Registrar Equipo')

@section('content')

    <div class="card card-primary card-outline">

        <div class="card-header">
            <h3 class="card-title">Datos del nuevo equipo</h3>
        </div>

        <form action="{{ route('admin.equipos.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Cliente propietario</label>

                        <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>

                            <option value="">Seleccione un cliente</option>

                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" @selected(old('cliente_id') == $cliente->id)>
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
                            <option value="">Seleccione un tipo</option>

                            @foreach(['Laptop', 'Computadora de escritorio', 'Impresora', 'Monitor', 'Otro'] as $tipo)
                                <option value="{{ $tipo }}" @selected(old('tipo_equipo') == $tipo)>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror"
                            value="{{ old('marca') }}" required>
                        @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror"
                            value="{{ old('modelo') }}" required>
                        @error('modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Número de serie</label>
                        <input type="text" name="numero_serie"
                            class="form-control @error('numero_serie') is-invalid @enderror"
                            value="{{ old('numero_serie') }}">
                        @error('numero_serie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar equipo
                </button>

                <a href="{{ route('admin.equipos.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

@endsection