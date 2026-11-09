@extends('layouts.admin')

@section('title', 'Editar Solicitud')

@section('content')

    <div class="card card-warning card-outline">

        <div class="card-header">
            <h3 class="card-title">
                Editar solicitud {{ $solicitud->numero_solicitud }}
            </h3>
        </div>

        <form method="POST" action="{{ route('admin.solicitudes.update', $solicitud) }}">
            @csrf
            @method('PUT')

            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                @include('solicitudes._form')

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Actualizar
                </button>

                <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>

    </div>

@endsection