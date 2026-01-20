<?php

use PHPUnit\Framework\TestCase;

use Core\Repositories\ProveedorRepositoryInterface;
use Application\UseCases\Proveedor\AgregarProveedorUseCase;
use Core\Entities\Proveedor;
use Core\Enum\Estado;

final class AgregarProveedorTest extends TestCase
{
    public function testAgregarProveedor(): void
    {
        $repo = $this->createMock(ProveedorRepositoryInterface::class);

        $repo->expects($this->once())
            ->method('guardarProveedor')
            ->with($this->callback(function(Proveedor $p){
                return $p->id === 1 &&
                    $p->getNombre() === 'Proveedor Y' &&
                    $p->getTelefono() === '905325869' &&
                    $p->getRuc() === 12345678910 &&
                    $p->getEstado() === Estado::Activo;
            }));
        
        $useCase = new AgregarProveedorUseCase($repo);

        $useCase(1, 'Proveedor Y', '905325869', 12345678910, Estado::Activo);
    }
}