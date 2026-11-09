<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\HistorialEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\ReglasEstadoSolicitud;
class EstadoSolicitudController extends Controller
{
    public function update(Request $request, Solicitud $solicitud)
    {
        $datos = $request->validate([
            'estado' => 'required|in:En proceso,Finalizada',
        ]);

        DB::transaction(function () use ($solicitud, $datos) {

            // Bloquear el registro durante la actualización
            $solicitudActual = Solicitud::whereKey($solicitud->id)
                ->lockForUpdate()
                ->firstOrFail();


            $estadoAnterior = $solicitudActual->estado;
            $estadoNuevo = $datos['estado'];

            // Validar la transición
            $reglas = new ReglasEstadoSolicitud();

            if (!$reglas->puedeCambiar($estadoAnterior, $estadoNuevo)) {
                throw ValidationException::withMessages([
                    'estado' => 'La transición de estado no está permitida.',
                ]);
            }

            // Actualizar estado
            $solicitudActual->update([
                'estado' => $estadoNuevo,
            ]);

            // Registrar historial
            HistorialEstado::create([
                'solicitud_id' => $solicitudActual->id,
                'usuario_id' => auth()->id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $estadoNuevo,
                'fecha_cambio' => now(),
            ]);
        });

        return redirect()
            ->route('solicitudes.show', $solicitud)
            ->with('success', 'Estado actualizado correctamente.');
    }
}
