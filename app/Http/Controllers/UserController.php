<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(User $user)
    {
        return $user->UserResource();
    }

    public function create(Request $request)
    {
        if (User::where('nit', $request->nit)->exists()) {
            return response()->json(['message' => 'NIT already exists']);
        }

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'NIT already exists']);
        }


        //Code here
        $user = User::create($request->all());
        //Code here

        return $user->UserResource();
    }

    public function update(Request $request, User $user)
    {
        if (User::where('email', $request->email)->where('id','<>',$user->id)->exists()) {
            return response()->json(['message' => 'Email already exists']);
        }

        if (User::where('nit', $request->nit)->where('id','<>',$user->id)->exists()) {
            return response()->json(['message' => 'NIT already exists']);
        }

        //Code here
        $user->update($request->all());
        //Code here
        return response()->json($user->refresh());
    }

    public function delete(User $user)
    {
        //Code here
        $user->delete($user);
        //Code here
        return response()->json(['message' => 'User deleted']);
    }
}
