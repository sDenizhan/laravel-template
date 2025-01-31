<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Illuminate\Http\Client\Request;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request->validated());
        return new UserResource($user);


    }

    public function show($id)
    {
        try {
            $user = $this->userService->findById($id);
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'data' => []], 403);
        }
    }

    public function update($id, UpdateUserRequest $request)
    {
        try {
            $request->validated()['id'] = $id;
            $user = $this->userService->update($id, $request->validated());
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'data' => []], $e->getCode());
        }
    }

    public function destroy($id)
    {
        return response()->json(['status' => 'success', 'message' => '', 'data' => []]);
    }
}
