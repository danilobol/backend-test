<?php

namespace App\Services\Contracts;

interface IInstitutionService {
    public function createInstitution(string $name);
    public function getInstitution(int $institutionId);
    public function getAllInstitutions();
}
