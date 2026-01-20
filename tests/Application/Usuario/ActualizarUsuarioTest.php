<?php

use PHPUnit\Framework\TestCase;

use Core\Entities\Usuario;
use Core\Repositories\UsuarioRepositoryInterface;
use Application\UseCases\Usuario\ActualizarUsuarioUseCase;

final class ActualizarUsuarioTest extends TestCase
{
    public function testActualizarUsuario(): void
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
             ->with($this->callback(function(Usuario $user){
                return $user->getUsername() === 'jhonatanac01';
             }));


        $useCase = new ActualizarUsuarioUseCase($repo);

        $useCase(1, Usuario::crearNombreUsuario('jhonatanac01'), 'jhonatan@hotmail.com');
    }
}
