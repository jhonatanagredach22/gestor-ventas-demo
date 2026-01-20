<?php

use PHPUnit\Framework\TestCase;

use Core\Repositories\UsuarioRepositoryInterface;
use Application\UseCases\Usuario\VerificarUsuarioExistenteUseCase;

final class UsuarioExistenteTest extends TestCase
{
    public function test_retorna_true_si_existe_usuario(): void
    {
        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->once())->method('existeUsuario')->willReturn(true);

        $useCase = new VerificarUsuarioExistenteUseCase($repo);

        $resultado = $useCase();

        $this->assertTrue($resultado);
    }

    public function test_retorna_false_si_no_existe_usuario(): void
    {
        $repo = $this->createMock(UsuarioRepositoryInterface::class);

        $repo->expects($this->once())->method('existeUsuario')->willReturn(false);

        $useCase = new VerificarUsuarioExistenteUseCase($repo);

        $resultado = $useCase();

        $this->assertFalse($resultado);
    }
}
