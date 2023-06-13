<?php

namespace App\Domain\Auth\Repositories;


use App\Domain\Auth\DTO\UserCreateData;
use App\Domain\Auth\DTO\UserUpdateData;
use App\Domain\Auth\Models\User;
use App\Domain\Auth\Repositories\Sorts\UserPhotoCountSort;
use App\Domain\Support\Repositories\BaseRepository;
use Spatie\QueryBuilder\AllowedSort;

class UserRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    public function allowedSorts()
    {
        return [
            AllowedSort::field('created_at', $this->model->getTable() . '.created_at'),
            AllowedSort::custom('photo.count', new UserPhotoCountSort)
        ];
    }

    public function create(UserCreateData $userData)
    {
        return $this->model->newQuery()->create([
            'first_name' => $userData->getFirstName(),
            'last_name'  => $userData->getLastName(),
            'email'      => $userData->getEmail(),
            'password'   => $userData->getPassword(),
            'role_id'    => $userData->getClientRoleId()
        ]);
    }

    public function update($id, UserUpdateData $userData)
    {
        $data = [
            'first_name'    => $userData->getFirstName(),
            'last_name'     => $userData->getLastName(),
            'email'         => $userData->getEmail(),
            'password'      => $userData->getPassword(),
        ];
        return $this->model->find($id)
            ->update($data);
    }
}
