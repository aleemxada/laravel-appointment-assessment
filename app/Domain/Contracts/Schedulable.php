<?php
namespace App\Domain\Contracts;

interface Schedulable
{
    public function getAvailableSlots(): array;
}