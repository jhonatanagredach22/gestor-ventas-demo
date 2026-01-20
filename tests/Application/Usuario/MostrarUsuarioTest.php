<?php

use PHPUnit\Framework\TestCase;

use Core\Repositories\UsuarioRepositoryInterface;
use Application\UseCases\Usuario\MostrarUsuarioUseCase;
use Core\Entities\Usuario;

final class MostrarUsuarioTest extends TestCase
{
    public function testMostrarUsuario(): void
    {
        $usuario = new Usuario(
            1,
            'jhonatanac',
            'jhonatan@hotmail.com',
            Usuario::hashearClave('12345648@cB')
        );

        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('listarUsuario')
            ->willReturn($usuario);

        $useCase = new MostrarUsuarioUseCase($repo);

        $resultado = $useCase();

        $this->assertSame($usuario, $resultado);
    }
}
