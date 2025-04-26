<?php

namespace App\Http\Services\Status;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\Status\Actions\FindStatusAction;
use App\Http\Services\Status\Actions\CreateStatusAction;
use App\Http\Services\Status\Actions\FindAllStatusAction;
use App\Models\Status;

class StatusService
{
    public function __construct(
        private CreateStatusAction $createStatus,
        private FindAllStatusAction $findAllStatus,
        private FindStatusAction $findStatus,
    )
    {}

    public function findAll(): Collection {
        return $this->findAllStatus->execute();
    }

    public function find(int $id): Status {
        return $this->findStatus->execute(id: $id);
    }

    public function create(array $data): Status
    {
        return $this->createStatus->execute(
            name: $data['name'],
        );
    }
}
