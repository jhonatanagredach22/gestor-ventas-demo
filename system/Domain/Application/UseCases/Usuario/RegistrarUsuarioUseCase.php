<?php

namespace Application\UseCases\Usuario;

use Core\Entities\Usuario;
use Core\Repositories\UsuarioRepositoryInterface;
use Core\Exceptions\Usuario\YaExisteUnUsuarioRegistradoException;

class RegistrarUsuarioUseCase
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    public function __invoke(int $id, string $nombre, ?string $email, string $clave): void
    {
        $usuarioExistente = $this->usuarioRepository->listarUsuario();

        if ($usuarioExistente) {
            throw new YaExisteUnUsuarioRegistradoException('Ya existe un usuario registrado, inicia sesión');
        }

        $validarUsername = Usuario::crearNombreUsuario($nombre);

        $validarClave = Usuario::crearClave($clave);

        $nuevoUsuario = new Usuario($id, $validarUsername, $email, Usuario::hashearClave($validarClave));

        $this->usuarioRepository->guardarUsuario($nuevoUsuario);
    }
}
