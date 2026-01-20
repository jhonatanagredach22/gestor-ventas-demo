<?php
use phpunit\Framework\TestCase;

use Application\UseCases\Usuario\ModificarClaveUsuarioUseCase;
use Core\Repositories\UsuarioRepositoryInterface;
use Core\Entities\Usuario;

final class ModificarClaveUsuarioTest extends TestCase
{
    public function testModificarClaveUsuario(): void
    {
        $usuario = new Usuario(
            id: 1,
            nombreUsuario: Usuario::crearNombreUsuario('jhonatanac'),
            email: 'jhonatan@hotmail.com',
            clave: Usuario::hashearClave('$A03_c2026$')
        );

        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('buscarUsuarioPorId')
            ->with(1)
            ->willReturn($usuario);

        $repo->expects($this->once())
            ->method('actualizarUsuario')
            ->with($this->callback(function (Usuario $user) {
                return password_verify('$A03_c202603$', $user->getPassword());
            }));

        $useCase = new ModificarClaveUsuarioUseCase($repo);

        $useCase(1, '$A03_c2026$', '$A03_c202603$');
    }
}
