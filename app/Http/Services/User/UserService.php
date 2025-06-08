<?php

declare(strict_types=1);

namespace App\Http\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\User\Actions\FindUserAction;
use App\Http\Services\User\Actions\CreateUserAction;
use App\Http\Services\User\Actions\DeleteUserAction;
use App\Http\Services\User\Actions\DestroyUserAction;
use App\Http\Services\User\Actions\FindAllUserAction;
use App\Http\Services\User\Actions\UpdateUserAction;
use Illuminate\Http\Request;

class UserService
{
    public function __construct(
        private CreateUserAction $createUser,
        private FindAllUserAction $findAllUser,
        private FindUserAction $findUser,
        private UpdateUserAction $updateUser,
        private DeleteUserAction $deleteUser,
        private DestroyUserAction $destroyUser,
    ) {
    }

    public function findAll(Request $request): Collection
    {
        return $this->findAllUser->execute($request);
    }

    public function find(int $id): User
    {
        return $this->findUser->execute(id: $id);
    }

    public function create(array $data): User
    {
        return $this->createUser->execute(
            firstname: $data['first_name'],
            lastname: $data['last_name'],
            email: $data['email'],
            role: $data['role'],
            password: $data['password'],
        );
    }

    public function update(int $id, array $data): User
    {
        return $this->updateUser->execute(
            id: $id,
            firstname: $data['first_name'],
            lastname: $data['last_name'],
            email: $data['email'],
            role: $data['role'],
        );
    }

    public function delete(int $id): void
    {
        $this->deleteUser->execute(id: $id);
    }

    public function destroy(int $id): void
    {
        $this->destroyUser->execute(id: $id);
    }
}
