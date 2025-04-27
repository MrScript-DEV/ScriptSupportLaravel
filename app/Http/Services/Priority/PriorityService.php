<?php

namespace App\Http\Services\Priority;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\Priority\Actions\FindPriorityAction;
use App\Http\Services\Priority\Actions\CreatePriorityAction;
use App\Http\Services\Priority\Actions\DeletePriorityAction;
use App\Http\Services\Priority\Actions\UpdatePriorityAction;
use App\Http\Services\Priority\Actions\FindAllPriorityAction;
use App\Models\Priority;

class PriorityService {
    public function __construct(
        private CreatePriorityAction $createPriority,
        private FindAllPriorityAction $findAllPriority,
        private FindPriorityAction $findPriority,
        private UpdatePriorityAction $updatePriority,
        private DeletePriorityAction $deletePriority,
    )
    {}

    public function findAll():Collection {
        return $this->findAllPriority->execute();
    }

    public function find(int $id): Priority {
        return $this->findPriority->execute(id: $id);
    }

    public function create(array $data): Priority
    {
        return $this->createPriority->execute(
            name: $data['name'],
            level: $data['level'],
        );
    }

    public function update(int $id, array $data): Priority
    {
        return $this->updatePriority->execute(
            id: $id,
            name: $data['name'],
            level: $data['level'],
        );
    }

    public function delete(int $id): void
    {
       $this->deletePriority->execute(id: $id);
    }
}
