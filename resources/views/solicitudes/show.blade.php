@extends('layouts.admin')

@section('title', 'Detalle de Solicitud')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Solicitud {{ $solicitud->numero_solicitud }}
            </h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Cliente</th>
                    <td>{{ $solicitud->cliente?->nombre_completo ?? 'Cliente no encontrado' }}</td>
                </tr>
                <tr>
                    <th>Equipo</th>
                    <td>
                        {{ $solicitud->equipo?->marca ?? 'Equipo no encontrado' }}
                        {{ $solicitud->equipo?->modelo ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>Fecha de recepción</th>
                    <td>{{ $solicitud->fecha_recepcion->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Tipo de servicio</th>
                    <td>{{ $solicitud->tipo_servicio }}</td>
                </tr>
                <tr>
                    <th>Problema</th>
                    <td>{{ $solicitud->descripcion_problema }}</td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td>{{ $solicitud->observaciones ?? 'Sin observaciones' }}</td>
                </tr>
                <tr>
                    <th>Estado actual</th>
                    <td><strong>{{ $solicitud->estado }}</strong></td>
                </tr>
            </table>

            @if($solicitud->estado !== 'Finalizada')
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Actualizar estado</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitudes.estado', $solicitud) }}">
                            @csrf
                            @method('PATCH')

                            @php
                                $siguienteEstado = match ($solicitud->estado) {
                                    'Pendiente' => 'En proceso',
                                    'En proceso' => 'Finalizada',
                                    default => null,
                                };
                            @endphp

                            @if($siguienteEstado)
                                <p>
                                    Estado siguiente:
                                    <strong>{{ $siguienteEstado }}</strong>
                                </p>

                                <input type="hidden" name="estado" value="{{ $siguienteEstado }}">

                                <button type="submit" class="btn btn-primary"
                                    onclick="return confirm('¿Confirmar cambio de estado?')">
                                    <i class="bi bi-arrow-repeat"></i>
                                    Cambiar a {{ $siguienteEstado }}
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @endif

            <h5 class="mt-4">
                <i class="bi bi-clock-history"></i>
                Historial de cambios de estado
            </h5>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha y hora</th>
                            <th>Estado anterior</th>
                            <th>Estado nuevo</th>
                            <th>Usuario responsable</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($solicitud->historialEstados as $historial)
                            <tr>
                                <td>{{ $historial->fecha_cambio->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $historial->estado_anterior }}</td>
                                <td>{{ $historial->estado_nuevo }}</td>
                                <td>{{ $historial->usuario->name ?? 'Usuario no disponible' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Todavía no hay cambios de estado registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>

        </div>
    </div>

@endsection