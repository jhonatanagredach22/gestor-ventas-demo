<?php

namespace Application\UseCases\Proveedor;

use Core\Repositories\ProveedorRepositoryInterface;

use Core\Exceptions\Proveedor\ProveedorNoEncontradoException;
use Core\Exceptions\Generales\SinModificacionesException;

class ActualizarProveedorUseCase
{
    public function __construct(
        private ProveedorRepositoryInterface $proveedorRepository
    ) {}

    public function __invoke(int $id, string $nombre, ?string $telefono, int $ruc): void
    {
        $proveedorExistente = $this->proveedorRepository->buscarProveedorPorId($id)
            ?? throw new ProveedorNoEncontradoException('Proveedor no encontrado');

        $modificado = false;

        if ($proveedorExistente->getNombre() !== $nombre) {
            $proveedorExistente->setNombre($nombre);
            $modificado = true;
        }

        if ($telefono !== null && $proveedorExistente->getTelefono() !== $telefono) {
            $proveedorExistente->setTelefono($telefono);
            $modificado = true;
        }

        if ($proveedorExistente->getRuc() !== $ruc) {
            $proveedorExistente->setRuc($ruc);
            $modificado = true;
        }

        if (!$modificado) {
            throw new SinModificacionesException('No se realizaron modificaciones');
        }

        $this->proveedorRepository->actualizarProveedor($proveedorExistente);
    }
}
