<?php

namespace Core\Repositories;

use Core\Entities\Proveedor;

interface ProveedorRepositoryInterface
{
    public function guardarProveedor(Proveedor $proveedor): void;

    public function actualizarProveedor(Proveedor $proveedor): void;

    public function buscarProveedorPorId(int $id): ?Proveedor;

    public function buscarProveedorPorNombre(string $nombre): ?Proveedor;

    public function buscarProveedorPorRuc(int $ruc): ?Proveedor;

    public function listarProveedores(): ?array;
}
