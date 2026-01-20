<?php

namespace Application\UseCases\Proveedor;

use Core\Entities\Proveedor;
use Core\Enum\Estado;
use Core\Repositories\ProveedorRepositoryInterface;

use Core\Exceptions\Proveedor\ProveedorConNombreExistente;
use Core\Exceptions\Proveedor\ProveedorConRUCExistente;

class AgregarProveedorUseCase
{
    public function __construct(
        private ProveedorRepositoryInterface $proveedorRepository
    ) {}

  public function __invoke(int $id, string $nombre, ?string $telefono,  int $ruc, Estado $estado = Estado::Activo): void
    {
        $proveedorExistente = $this->proveedorRepository->buscarProveedorPorNombre($nombre);

        if ($proveedorExistente !== null) {
            throw new ProveedorConNombreExistente('Ya existe un proveedor con el nombre ingresado');
        }

        $proveedorExistente = $this->proveedorRepository->buscarProveedorPorRuc($ruc);

        if ($proveedorExistente !== null) {
            throw new ProveedorConRUCExistente('Ya existe un proveedor con el RUC ingresado');
        }

        $proveedor = new Proveedor($id, $nombre, $telefono, $ruc, $estado);
        
        $this->proveedorRepository->guardarProveedor($proveedor);
    }
}
