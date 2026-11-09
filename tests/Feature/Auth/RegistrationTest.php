<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registro_publico_no_esta_disponible(): void
    {
        $response = $this->get('/register');

        $response->assertNotFound();
    }

    public function test_no_se_pueden_registrar_usuarios_publicamente(): void
    {
        $response = $this->post('/register', [
            'name' => 'Usuario Prueba',
            'email' => 'prueba@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertNotFound();

        $this->assertGuest();

        $this->assertDatabaseMissing('users', [
            'email' => 'prueba@example.com',
        ]);
    }
}
