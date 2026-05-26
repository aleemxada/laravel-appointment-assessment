<?php
namespace App\Domain\Models;

class Patient extends User
{
    public function getRole(): string { return 'patient'; }
}