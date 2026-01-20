<?php

use PHPUnit\Framework\TestCase;
use Core\Entities\Proveedor;
use Core\Enum\Estado;

class ProveedorTest extends TestCase
{
    public function testCrearProveedor()
    {
        $proveedor = new Proveedor(
            1,
            'Proveedor S.A.C',
            '+51 912345678',
            12345678901,
            Estado::Activo
        );

        $this->assertSame(1, $proveedor->id);
        $this->assertSame('Proveedor S.A.C', $proveedor->getNombre());
        $this->assertSame('+51 912345678', $proveedor->getTelefono());
        $this->assertSame(12345678901, $proveedor->getRuc());
        $this->assertSame(Estado::Activo, $proveedor->getEstado());
    }
}
