<?php

namespace Application\UseCases\Usuario;

use Core\Repositories\UsuarioRepositoryInterface;

use Core\Exceptions\Usuario\UsuarioNoEncontradoException;
use Core\Exceptions\Generales\SinModificacionesException;

class ActualizarUsuarioUseCase
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    public function __invoke(int $id, string $nombreUsuario, ?string $email): void
    {
        $usuario = $this->usuarioRepository->buscarUsuarioPorId($id)
            ?? throw new UsuarioNoEncontradoException('Usuario no encontrado');

        $modificado = false;
        
        if ($usuario->getUsername() !== $nombreUsuario) {
            $usuario->setUsername($nombreUsuario);
            $modificado = true;
        }

        if ($email !== null && $usuario->getEmail() !== $email) {
            $usuario->setEmail($email);
            $modificado = true;
        }

        if (!$modificado) {
            throw new SinModificacionesException('No se realizaron modificaciones');
        }

        $this->usuarioRepository->actualizarUsuario($usuario);
    }
}
