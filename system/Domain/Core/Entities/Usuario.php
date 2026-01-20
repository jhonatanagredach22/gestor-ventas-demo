<?php

namespace Core\Entities;

use InvalidArgumentException;

class Usuario
{
    const MAX_LONGITUD_NOMBRE_USUARIO = 25;
    const MIN_LONGITUD_NOMBRE_USUARIO = 3;
    const MIN_LONGITUD_CLAVE = 10;
    const MAX_LONGITUD_EMAIL = 100;
    const MIN_LONGITUD_EMAIL = 6;

    public function __construct(
        public readonly int $id,
        private string $nombreUsuario,
        private ?string $email,
        private string $clave,
    ) {
        if ($id <= 0) {
            throw new InvalidArgumentException('El ID debe ser mayor a 0');
        }
    }

    public static function crearNombreUsuario(string $nombreUsuario): string
    {
        $nombreUsuario = $nombreUsuario
        |> trim(...)
        |> strtolower(...)
        |> (fn($v) => str_replace(' ', '', $v))
        |> (fn($v) => preg_replace('/[^a-z0-9]/', '', $v));

        match (true) {
            $nombreUsuario === '' =>
            throw new InvalidArgumentException('El nombre de usuario no puede estar vacio'),

            strlen($nombreUsuario) < self::MIN_LONGITUD_NOMBRE_USUARIO =>
            throw new InvalidArgumentException('El nombre de usuario debe tener al menos ' . self::MIN_LONGITUD_NOMBRE_USUARIO . ' caracteres'),

            strlen($nombreUsuario) > self::MAX_LONGITUD_NOMBRE_USUARIO =>
            throw new InvalidArgumentException('El nombre de usuario debe tener menos de ' . self::MAX_LONGITUD_NOMBRE_USUARIO . ' caracteres'),

            default => true,
        };

        return $nombreUsuario;
    }

    public function setUsername(string $nombreUsuario): void
    {
        $this->nombreUsuario = self::crearNombreUsuario($nombreUsuario);
    }

    public function getUsername(): string
    {
        return $this->nombreUsuario;
    }

    public static function crearClave(string $clave): string
    {
        match (true) {
            $clave === '' =>
            throw new InvalidArgumentException('La clave no puede estar vacia'),

            $clave !== trim($clave) =>
            throw new InvalidArgumentException('La clave no puede tener espacios al inicio o al final'),

            strlen($clave) < self::MIN_LONGITUD_CLAVE =>
            throw new InvalidArgumentException('La clave debe tener al menos ' . self::MIN_LONGITUD_CLAVE . ' caracteres'),

            !preg_match('/[A-Z]/', $clave) =>
            throw new InvalidArgumentException('La clave debe tener al menos una mayúscula'),

            !preg_match('/[a-z]/', $clave) =>
            throw new InvalidArgumentException('La clave debe tener al menos una minúscula'),

            !preg_match('/[0-9]/', $clave) =>
            throw new InvalidArgumentException('La clave debe tener al menos un número'),

            !preg_match('/[^\w]/', $clave) =>
            throw new InvalidArgumentException('La clave debe tener al menos un símbolo'),

            default => true,
        };

        return $clave;
    }

    public static function hashearClave(string $clave): string
    {
        $clave = password_hash($clave, PASSWORD_DEFAULT);

        return $clave;
    }

    public function setPassword(string $clave): void
    {
        $this->clave = self::crearClave($clave);
        $this->clave = self::hashearClave($this->clave);
    }

    public function cambiarClave(string $claveSinHash): void
    {
        $this->clave = self::hashearClave($claveSinHash);
    }

    public function getPassword(): string
    {
        return $this->clave;
    }

    public function setEmail(string $email): void
    {
        if (strlen($email) < self::MIN_LONGITUD_EMAIL || strlen($email) > self::MAX_LONGITUD_EMAIL) {
            throw new InvalidArgumentException('El email debe tener al menos ' . self::MIN_LONGITUD_EMAIL . ' caracteres');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('El email no es válido');
        }

        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
