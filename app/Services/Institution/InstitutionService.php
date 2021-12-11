<?php

namespace App\Services\Institution;


use App\Repositories\Contracts\IInstitutionRepository;
use App\Services\Contracts\IInstitutionService;

class InstitutionService implements IInstitutionService
{
    protected $institutionRepository;

    public function __construct(IInstitutionRepository $institutionRepository)
    {
        $this->institutionRepository = $institutionRepository;
    }

    public function createInstitution(string $name){
        return $this->institutionRepository->createInstitution($name);
    }

    public function getInstitution(int $institutionId){
        return $this->institutionRepository->getInstitution($institutionId);
    }

    public function getAllInstitutions(){
        return $this->institutionRepository->getAllInstitutions();
    }
}
