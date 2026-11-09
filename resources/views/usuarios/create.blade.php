@extends('layouts.admin')

@section('title', 'Registrar Usuario')

@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Registrar nuevo usuario</h3>
        </div>

        <form method="POST" action="{{ route('admin.usuarios.store') }}">
            @csrf

            <div class="card-body">
                @include('usuarios._form')

                <div class="alert alert-info">
                    El usuario podrá iniciar sesión con el correo y la contraseña registrados.
                    Sus opciones de menú dependerán del rol asignado.
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar usuario
                </button>

                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

@endsection