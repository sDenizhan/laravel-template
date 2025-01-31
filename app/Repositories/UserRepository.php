<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers()
    {
        return User::with(['roles'])->paginate(10)->all();
    }

    public function findById($id)
    {
        $user = User::with(['roles'])->find($id);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        return $user;
    }

    public function update($id, $data)
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $user;
    }

    public function store($data)
    {
        return User::create($data);
    }
}
