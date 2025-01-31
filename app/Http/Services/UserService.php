<?php
namespace App\Http\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function findById($id)
    {
        if ( !auth()->user()->hasPermissionTo('view-user') ) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->userRepository->findById($id);
    }

    public function update($id, $data)
    {
        if ( !auth()->user()->hasPermissionTo('edit-user') ) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->userRepository->update($id, $data);
    }

    public function delete($id)
    {
        if ( !auth()->user()->hasPermissionTo('delete-user') ) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->userRepository->delete($id);
    }


    public function store($data)
    {
        if ( !auth()->user()->hasPermissionTo('create-user') ) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->userRepository->store($data);
    }
}
