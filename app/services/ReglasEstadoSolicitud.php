<?php

namespace App\Services;

class ReglasEstadoSolicitud
{
    private const TRANSICIONES = [
        'Pendiente' => 'En proceso',
        'En proceso' => 'Finalizada',
    ];

    public function puedeCambiar(
        string $estadoActual,
        string $estadoNuevo
    ): bool {
        return isset(self::TRANSICIONES[$estadoActual])
            && self::TRANSICIONES[$estadoActual] === $estadoNuevo;
    }
}
