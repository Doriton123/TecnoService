<?php

namespace Tests\Unit;

use App\Services\ReglasEstadoSolicitud;
use PHPUnit\Framework\TestCase;

class ReglasEstadoSolicitudTest extends TestCase
{
    private ReglasEstadoSolicitud $reglas;

    protected function setUp(): void
    {
        parent::setUp();

        $this->reglas = new ReglasEstadoSolicitud();
    }

    public function test_pendiente_puede_cambiar_a_en_proceso(): void
    {
        $this->assertTrue(
            $this->reglas->puedeCambiar('Pendiente', 'En proceso')
        );
    }

    public function test_en_proceso_puede_cambiar_a_finalizada(): void
    {
        $this->assertTrue(
            $this->reglas->puedeCambiar('En proceso', 'Finalizada')
        );
    }

    public function test_finalizada_no_puede_regresar_a_pendiente(): void
    {
        $this->assertFalse(
            $this->reglas->puedeCambiar('Finalizada', 'Pendiente')
        );
    }

    public function test_pendiente_no_puede_saltar_a_finalizada(): void
    {
        $this->assertFalse(
            $this->reglas->puedeCambiar('Pendiente', 'Finalizada')
        );
    }

    public function test_no_se_permite_un_estado_desconocido(): void
    {
        $this->assertFalse(
            $this->reglas->puedeCambiar('Pendiente', 'Cancelada')
        );
    }
}
