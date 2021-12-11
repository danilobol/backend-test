<?php

namespace App\Repositories\Contracts;

interface IInstitutionRepository {
    public function createInstitution(string $name);
    public function getInstitution(int $institutionId);
    public function getAllInstitutions();
}
