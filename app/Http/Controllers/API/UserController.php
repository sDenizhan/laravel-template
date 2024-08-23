<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(),
                'slug_role' => Str::of($user->getRoleNames()->first())->slug()->replace('-', ''),
            ];
        }

        return response()->json(['status' => 'success', 'message' => '', 'data' => $data]);
    }
}
