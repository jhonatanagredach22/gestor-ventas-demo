<?php

namespace Application\UseCases\Proveedor;

use Core\Repositories\ProveedorRepositoryInterface;

class MostrarProveedoresUseCase
{
    public function __construct(
        private ProveedorRepositoryInterface $proveedorRepository
    ) {}

    public function __invoke(): ?array
    {
        return $this->proveedorRepository->listarProveedores();
    }
}