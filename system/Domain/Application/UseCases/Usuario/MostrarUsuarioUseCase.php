<?php

namespace Application\UseCases\Usuario;

use Core\Entities\Usuario;
use Core\Repositories\UsuarioRepositoryInterface;

class MostrarUsuarioUseCase
{
    public function __construct(
        private readonly UsuarioRepositoryInterface $usuarioRepository
    ) {}

    public function __invoke(): ?Usuario
    {
        return $this->usuarioRepository->listarUsuario();
    }
}