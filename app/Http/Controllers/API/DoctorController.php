<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function get(Request $request)
    {
        $valid = \Validator::make($request->all(), [
            'role' => 'required',
        ]);

        if ($valid->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request!'], 200);
        }

        $validated = (object) $valid->validated();

        $doctors = \App\Models\User::role($validated->role)->get();

        $data = [];
        foreach ($doctors as $user) {
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
