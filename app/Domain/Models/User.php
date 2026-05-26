<?php
namespace App\Domain\Models;

abstract class User
{
    public function __construct(
        protected readonly int $id,
        protected readonly string $name,
        protected readonly string $email,
    ) {}

    abstract public function getRole(): string;

    public function getId(): int   { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
}