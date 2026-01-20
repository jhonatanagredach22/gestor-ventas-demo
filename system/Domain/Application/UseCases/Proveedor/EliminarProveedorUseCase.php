<?php

namespace Application\UseCases\Proveedor;

use Core\Repositories\ProveedorRepositoryInterface;
use Core\Exceptions\Proveedor\ProveedorNoEncontradoException;
use Core\Enum\Estado;

class EliminarProveedorUseCase
{
    public function __construct(
        private ProveedorRepositoryInterface $proveedorRepository
    ) {}

    public function __invoke(int $id): void
    {
        $proveedorExistente = $this->proveedorRepository->buscarProveedorPorId($id)
            ?? throw new ProveedorNoEncontradoException('Proveedor no encontrado');

        $proveedorExistente->setEstado(Estado::Inactivo);

        $this->proveedorRepository->actualizarProveedor($proveedorExistente);
    }
}