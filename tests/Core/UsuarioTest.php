<?php

use PHPUnit\Framework\TestCase;
use Core\Entities\Usuario;

class UsuarioTest extends TestCase
{
    public function testCrearUsuario()
    {
        $usuario = new Usuario(
            1,
            'usuario',
            null,
            'clave'
        );

        $this->assertSame(1, $usuario->id);
        $this->assertSame('usuario', $usuario->getUsername());
        $this->assertSame(null, $usuario->getEmail());
        $this->assertSame('clave', $usuario->getPassword());
    }
}