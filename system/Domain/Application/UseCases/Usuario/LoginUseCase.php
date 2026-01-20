<?php

namespace Application\UseCases\Usuario;

use Core\Entities\Usuario;
use Core\Repositories\UsuarioRepositoryInterface;

use Core\Exceptions\Usuario\UsuarioNoEncontradoException;
use Core\Exceptions\Generales\CredencialesInvalidasException;

class LoginUseCase
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    private function obtenerUsuario(string $input): Usuario
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return $this->usuarioRepository->buscarUsuarioPorEmail($input)
                ?? throw new UsuarioNoEncontradoException();
        }

        return $this->usuarioRepository->buscarUsuarioPorNombreUsuario($input)
            ?? throw new UsuarioNoEncontradoException();
    }

    public function __invoke(string $nombreUsuario, string $clave): Usuario
    {
        $usuario = $this->obtenerUsuario($nombreUsuario);

        if (!password_verify($clave, $usuario->getPassword())) {
            throw new CredencialesInvalidasException('Credenciales incorrectas');
        }

        return $usuario;
    }
}
