<?php

use phpunit\Framework\TestCase;

use Application\UseCases\Usuario\LoginUseCase;
use Core\Repositories\UsuarioRepositoryInterface;
use Core\Entities\Usuario;
use Core\Exceptions\Generales\CredencialesInvalidasException;
use Core\Exceptions\Usuario\UsuarioNoEncontradoException;

final class LoginTest extends TestCase
{
    public function testLoginEmail(): void
    {
        $usuario = new Usuario(
            id: 1,
            nombreUsuario: Usuario::crearNombreUsuario('jhonatanac'),
            email: 'jhonatan@hotmail.com',
            clave: Usuario::hashearClave('$A03_c2026$')
        );

        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('buscarUsuarioPorEmail')
            ->with('jhonatan@hotmail.com')
            ->willReturn($usuario);

        $repo->expects($this->never())
            ->method('buscarUsuarioPorNombreUsuario');

        $useCase = new LoginUseCase($repo);

        $resultado = $useCase('jhonatan@hotmail.com', '$A03_c2026$');

        $this->assertSame($usuario, $resultado);
    }

    public function testLoginNombreUsuario(): void
    {
        $usuario = new Usuario(
            id: 1,
            nombreUsuario: Usuario::crearNombreUsuario('jhonatanac'),
            email: 'jhonatan@hotmail.com',
            clave: Usuario::hashearClave('$A03_c2026$')
        );

        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->never())
            ->method('buscarUsuarioPorEmail');

        $repo->expects($this->once())
            ->method('buscarUsuarioPorNombreUsuario')
            ->with('jhonatanac')
            ->willReturn($usuario);


        $useCase = new LoginUseCase($repo);

        $resultado = $useCase('jhonatanac', '$A03_c2026$');

        $this->assertSame($usuario, $resultado);
    }

    public function testLoginConClaveIncorrecta(): void
    {
        $usuario = new Usuario(
            id: 1,
            nombreUsuario: Usuario::crearNombreUsuario('jhonatanac'),
            email: 'jhonatan@hotmail.com',
            clave: Usuario::hashearClave('$A03_c2026$')
        );

        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('buscarUsuarioPorEmail')
            ->with('jhonatan@hotmail.com')
            ->willReturn($usuario);

        $repo->expects($this->never())->method('buscarUsuarioPorNombreUsuario');

        $this->expectException(CredencialesInvalidasException::class);

        $useCase = new LoginUseCase($repo);

        $useCase('jhonatan@hotmail.com', 'clave_mal');
    }

    public function testLoginUsuarioInexistente(): void
    {
        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('buscarUsuarioPorEmail')
            ->willReturn(null);

        $repo->expects($this->never())
            ->method('buscarUsuarioPorNombreUsuario');

        $this->expectException(UsuarioNoEncontradoException::class);

        $useCase = new LoginUseCase($repo);

        $useCase('noexiste@hotmail.com', '$A03_c2026$');
    }
}
