@extends('layouts.admin')

@section('title', 'Nueva Solicitud')

@section('content')

    <div class="card card-primary card-outline">

        <div class="card-header">
            <h3 class="card-title">Registrar solicitud de servicio</h3>
        </div>

        <form method="POST" action="{{ route('admin.solicitudes.store') }}">
            @csrf

            <div class="card-body">
                @include('solicitudes._form')

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    El número de solicitud se generará automáticamente.
                    El estado inicial será <strong>Pendiente</strong>.
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar solicitud
                </button>

                <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>

    </div>

@endsection