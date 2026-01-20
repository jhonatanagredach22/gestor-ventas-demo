<?php

use PHPUnit\Framework\TestCase;
use Core\Repositories\ProveedorRepositoryInterface;
use Application\UseCases\Proveedor\EliminarProveedorUseCase;
use Core\Entities\Proveedor;
use Core\Enum\Estado;

class EliminarProveedorTest extends TestCase
{
    public function testEliminarProveedor(): void
    {
        $proveedor = new Proveedor(
            id: 1,
            nombre: 'Proveedor X',
            telefono: null,
            ruc: 12345678910,
            estado: Estado::Activo
        );

        $repo = $this->createMock(ProveedorRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('buscarProveedorPorId')
            ->with(1)
            ->willReturn($proveedor);

        $repo->expects($this->once())
            ->method('actualizarProveedor')
            ->with($this->callback(function (Proveedor $prov) {
                return $prov->getEstado() === Estado::Inactivo;
            }));

        $useCase = new EliminarProveedorUseCase($repo);

        $useCase(1);
    }
}
