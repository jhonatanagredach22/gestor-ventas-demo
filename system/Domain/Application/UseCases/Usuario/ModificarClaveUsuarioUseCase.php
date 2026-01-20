<?php

namespace Application\UseCases\Usuario;

use Core\Repositories\UsuarioRepositoryInterface;

use Core\Exceptions\Usuario\ClaveIncorrectaException;
use Core\Exceptions\Usuario\UsuarioNoEncontradoException;
use Core\Exceptions\Generales\SinModificacionesException;

class ModificarClaveUsuarioUseCase
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    public function __invoke(int $id, string $claveActual, string $claveNueva): void
    {
        $usuario = $this->usuarioRepository->buscarUsuarioPorId($id)
            ?? throw new UsuarioNoEncontradoException('Usuario no encontrado');

        if (!password_verify($claveActual, $usuario->getPassword())) {
            throw new ClaveIncorrectaException('Clave incorrecta');
        }

        if (password_verify($claveNueva, $usuario->getPassword())) {
            throw new SinModificacionesException('No se realizaron modificaciones');
        }

        $usuario->cambiarClave($claveNueva);

        $this->usuarioRepository->actualizarUsuario($usuario);
    }
}
