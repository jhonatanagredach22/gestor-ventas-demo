<?php

use PHPUnit\Framework\TestCase;

use Core\Repositories\ProveedorRepositoryInterface;
use Application\UseCases\Proveedor\ActualizarProveedorUseCase;
use Core\Entities\Proveedor;
use Core\Enum\Estado;

final class ActualizarProveedorTest extends TestCase
{
    public function testActualizarProveedor(): void
    {
        $proveedor = new Proveedor(
            id: 1,
            nombre: 'proveedor01',
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
            ->with($this->callback(function (Proveedor $proveedor) {
                return $proveedor->getNombre() === 'Mark';
            }));

        $useCase = new ActualizarProveedorUseCase($repo);
        $useCase(1, 'Mark', null, 12345678910);
    }
}
