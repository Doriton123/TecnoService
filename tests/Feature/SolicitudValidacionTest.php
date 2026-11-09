<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SolicitudValidacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_rechaza_tipo_de_servicio_no_permitido(): void
    {
        Role::firstOrCreate([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);

        $usuario = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $usuario->assignRole('Administrador');

        $this->actingAs($usuario);

        $response = $this->post(
            route('admin.solicitudes.store'),
            [
                'cliente_id' => 1,
                'equipo_id' => 1,
                'fecha_recepcion' => '2026-11-09',
                'tipo_servicio' => 'Instalación',
                'descripcion_problema' => 'Equipo de prueba',
            ]
        );

        $response->assertSessionHasErrors('tipo_servicio');
    }


    public function test_rechaza_equipo_de_otro_cliente(): void
    {
        \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);

        $usuario = \App\Models\User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $usuario->assignRole('Administrador');

        $this->actingAs($usuario);

        $cliente1 = \App\Models\Cliente::create([
            'nombre_completo' => 'Cliente Uno',
            'nit' => '1234567',
            'telefono' => '12345678',
            'direccion' => 'Dirección de prueba',
            'correo_electronico' => 'cliente1@example.com',
        ]);

        $cliente2 = \App\Models\Cliente::create([
            'nombre_completo' => 'Cliente Dos',
            'nit' => '7654321',
            'telefono' => '87654321',
            'direccion' => 'Otra dirección',
            'correo_electronico' => 'cliente2@example.com',
        ]);

        $equipo = \App\Models\Equipo::create([
            'cliente_id' => $cliente2->id,
            'tipo_equipo' => 'Laptop',
            'marca' => 'Dell',
            'modelo' => 'Latitude',
            'numero_serie' => 'SERIE-PRUEBA-001',
        ]);

        $response = $this->post(
            route('admin.solicitudes.store'),
            [
                'cliente_id' => $cliente1->id,
                'equipo_id' => $equipo->id,
                'fecha_recepcion' => '2026-11-09',
                'tipo_servicio' => 'Reparación',
                'descripcion_problema' => 'Equipo no enciende',
            ]
        );

        $response->assertSessionHasErrors('equipo_id');

        $this->assertDatabaseCount('solicitudes', 0);
    }


    public function test_rechaza_solicitud_sin_descripcion_del_problema(): void
    {
        \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);

        $usuario = \App\Models\User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $usuario->assignRole('Administrador');

        $this->actingAs($usuario);

        $cliente = \App\Models\Cliente::create([
            'nombre_completo' => 'Cliente Prueba Tres',
            'nit' => '9876543',
            'telefono' => '12345678',
            'direccion' => 'Dirección de prueba',
            'correo_electronico' => 'cliente3@example.com',
        ]);

        $equipo = \App\Models\Equipo::create([
            'cliente_id' => $cliente->id,
            'tipo_equipo' => 'Laptop',
            'marca' => 'HP',
            'modelo' => 'ProBook',
            'numero_serie' => 'SERIE-PRUEBA-003',
        ]);

        $response = $this->post(
            route('admin.solicitudes.store'),
            [
                'cliente_id' => $cliente->id,
                'equipo_id' => $equipo->id,
                'fecha_recepcion' => '2026-11-09',
                'tipo_servicio' => 'Mantenimiento',
                'descripcion_problema' => '',
            ]
        );

        $response->assertSessionHasErrors('descripcion_problema');

        $this->assertDatabaseCount('solicitudes', 0);
    }


    public function test_tecnico_no_puede_registrar_solicitudes(): void
    {
        \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Tecnico',
            'guard_name' => 'web',
        ]);

        $usuario = \App\Models\User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $usuario->assignRole('Tecnico');

        $this->actingAs($usuario);

        $response = $this->post(
            route('admin.solicitudes.store'),
            [
                'cliente_id' => 1,
                'equipo_id' => 1,
                'fecha_recepcion' => '2026-11-09',
                'tipo_servicio' => 'Reparación',
                'descripcion_problema' => 'La computadora no enciende',
            ]
        );

        $response->assertForbidden();

        $this->assertDatabaseCount('solicitudes', 0);
    }


    public function test_solicitud_nueva_se_registra_como_pendiente(): void
    {
        \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);

        $usuario = \App\Models\User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $usuario->assignRole('Administrador');

        $this->actingAs($usuario);

        $cliente = \App\Models\Cliente::create([
            'nombre_completo' => 'Cliente Prueba Cinco',
            'nit' => '5555555',
            'telefono' => '12345678',
            'direccion' => 'Dirección de prueba',
            'correo_electronico' => 'cliente5@example.com',
        ]);

        $equipo = \App\Models\Equipo::create([
            'cliente_id' => $cliente->id,
            'tipo_equipo' => 'Laptop',
            'marca' => 'Lenovo',
            'modelo' => 'ThinkPad',
            'numero_serie' => 'SERIE-PRUEBA-005',
        ]);

        $response = $this->post(
            route('admin.solicitudes.store'),
            [
                'cliente_id' => $cliente->id,
                'equipo_id' => $equipo->id,
                'fecha_recepcion' => '2026-11-09',
                'tipo_servicio' => 'Reparación',
                'descripcion_problema' => 'La computadora no enciende',
            ]
        );

        $response->assertRedirect(route('solicitudes.index'));

        $this->assertDatabaseHas('solicitudes', [
            'cliente_id' => $cliente->id,
            'equipo_id' => $equipo->id,
            'estado' => 'Pendiente',
            'tipo_servicio' => 'Reparación',
        ]);
    }

}
