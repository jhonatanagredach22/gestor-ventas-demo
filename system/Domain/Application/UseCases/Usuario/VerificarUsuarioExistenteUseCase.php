<?php 

namespace Application\UseCases\Usuario;

use Core\Repositories\UsuarioRepositoryInterface;

class VerificarUsuarioExistenteUseCase
{
    public function __construct(
        private readonly UsuarioRepositoryInterface $usuarioRepository
    ) {}

    public function __invoke(): bool
    {
        return $this->usuarioRepository->existeUsuario();
    }
}