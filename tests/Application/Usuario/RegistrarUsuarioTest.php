<?php

use PHPUnit\Framework\TestCase;

use Core\Entities\Usuario;
use Core\Repositories\UsuarioRepositoryInterface;
use Application\UseCases\Usuario\RegistrarUsuarioUseCase;

final class RegistrarUsuarioTest extends TestCase
{
    public function testRegistrarUsuario(): void
    {
        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('guardarUsuario')
            ->with($this->callback(function (Usuario $usr) {
                return $usr->id === 1 &&
                    $usr->getUsername() === Usuario::crearNombreUsuario('jhonatanac03') &&
                    $usr->getEmail() === 'jhonatan@hotmail.com' &&
                    password_verify('$A03_c2026$', $usr->getPassword());
            }));

        $useCase = new RegistrarUsuarioUseCase($repo);
        $useCase(1, 'jhonatanac03', 'jhonatan@hotmail.com', '$A03_c2026$');
    }
}
