<?php

namespace Core\Entities;

use InvalidArgumentException;
use Core\Enum\Estado;

class Proveedor
{
    const MAX_LONGITUD_NOMBRE = 50;
    const MAX_LONGITUD_TELEFONO = 15;
    const MIN_LONGITUD_NOMBRE = 3;
    const MIN_LONGITUD_TELEFONO = 9;
    const MAX_LONGITUD_RUC = 11;

    public function __construct(
        public readonly int $id,
        private string $nombre,
        private ?string $telefono,
        private int $ruc,
        private Estado $estado,
    ) {
        if ($id <= 0) {
            throw new InvalidArgumentException('El ID debe ser mayor a 0');
        }

        $this->setNombre($nombre);
        $this->setTelefono($telefono);
        $this->setRuc($ruc);
        $this->setEstado($estado);
    }

    public function setNombre(string $nombre): void
    {
        $nombre = $nombre
        |> trim(...)
        |> (fn($v) => preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 .]/u', '', $v));

        match (true) {
            $nombre === '' =>
            throw new InvalidArgumentException('El nombre no puede estar vacio'),

            strlen($nombre) < self::MIN_LONGITUD_NOMBRE =>
            throw new InvalidArgumentException('El nombre debe tener al menos ' . self::MIN_LONGITUD_NOMBRE . ' caracteres'),

            strlen($nombre) > self::MAX_LONGITUD_NOMBRE =>
            throw new InvalidArgumentException('El nombre debe tener menos de ' . self::MAX_LONGITUD_NOMBRE . ' caracteres'),

            default => true,
        };

        $this->nombre = $nombre;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setTelefono(?string $telefono): void
    {
        if ($telefono === null || trim($telefono) === '') {
            $this->telefono = null;
            return;
        }

        $telefono = $telefono
        |> trim(...)
        |> (fn($v) => preg_replace('/[^0-9+\- ]/', '', $v));

        if (strlen($telefono) > self::MAX_LONGITUD_TELEFONO) {
            throw new InvalidArgumentException('El telefono debe tener menos de ' . self::MAX_LONGITUD_TELEFONO . ' caracteres');
        }

        if (strlen($telefono) < self::MIN_LONGITUD_TELEFONO) {
            throw new InvalidArgumentException('El telefono debe tener al menos ' . self::MIN_LONGITUD_TELEFONO . ' caracteres');
        }

        $this->telefono = $telefono;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setRuc(int $ruc): void
    {
        if ($ruc == '') {
            throw new InvalidArgumentException('El RUC no puede estar vacio');
        }

        if (strlen((string) $ruc) != self::MAX_LONGITUD_RUC) {
            throw new InvalidArgumentException('El RUC debe tener ' . self::MAX_LONGITUD_RUC . ' caracteres');
        }

        $this->ruc = $ruc;
    }

    public function getRuc(): int
    {
        return $this->ruc;
    }

    public function setEstado(Estado $estado): void
    {
        $this->estado = $estado;
    }

    public function getEstado(): Estado
    {
        return $this->estado;
    }
}
/*
    if (is_int($estado)) {
            $estado = Estado::tryFrom($estado)
                ?? throw new InvalidArgumentException('El estado no es válido');
        }*/