@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')

    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">
                Editar usuario: {{ $usuario->name }}
            </h3>
        </div>

        <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                @include('usuarios._form')
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Actualizar usuario
                </button>

                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

@endsection