<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_pagina_principal_redirige_al_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }
}
