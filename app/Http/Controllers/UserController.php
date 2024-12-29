<?php

namespace App\Http\Controllers;

use App\Enum\RolesEnum;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        return Inertia::render('User/Index', [
            'users' => AuthUserResource::collection(User::all())->collection->toArray()
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Edit', [
            'user' => new AuthUserResource($user),
            'roles' =>Role::all(),
            'rolesLabels' => RolesEnum::labels()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
           'roles' => ['required', 'array'],
        ]);
        $user->syncRoles($data['roles']);

        return back()->with(['success' => 'Roles updated successfully']);
    }

}
