<?php

use PHPUnit\Framework\TestCase;

use Core\Repositories\ProveedorRepositoryInterface;
use Application\UseCases\Proveedor\MostrarProveedoresUseCase;

final class MostrarProveedoresTest extends TestCase
{
    public function testMostrarProveedores(): void
    {
        $proveedores = [
            [1, 'proveedor01', null, 12345678910, 1],
            [2, 'proveedor02', null, 12345678912, 1]
        ];

        $repo = $this->createMock(ProveedorRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('listarProveedores')
            ->willReturn($proveedores);
        
        $useCase = new MostrarProveedoresUseCase($repo);
        
        $resultado = $useCase();

        $this->assertSame($proveedores, $resultado);
    }
}
