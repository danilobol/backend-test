<?php

namespace App\Repositories\Institution;


use App\Models\Institution;
use App\Repositories\Contracts\IInstitutionRepository;

/**
 * Class UserRepository.
 */
class InstitutionRepository implements IInstitutionRepository
{
    public function createInstitution(string $name){
        return Institution::create([
            'name'              => $name
        ]);
    }

    public function getInstitution(int $institutionId){
        return Institution::query()->where('id','=', $institutionId)->first();
    }

    public function getAllInstitutions(){
        return Institution::query()->get();
    }
}
