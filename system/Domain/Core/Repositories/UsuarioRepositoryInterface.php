<?php

namespace Core\Repositories;

use Core\Entities\Usuario;

interface UsuarioRepositoryInterface
{
    public function guardarUsuario(Usuario $usuario): void;

    public function actualizarUsuario(Usuario $usuario): void;

    public function buscarUsuarioPorId(int $id): ?Usuario;

    public function buscarUsuarioPorNombreUsuario(string $nombreUsuario): ?Usuario;

    public function buscarUsuarioPorEmail(string $email): ?Usuario;

    public function listarUsuario(): ?Usuario;

    public function existeUsuario(): bool;
}
