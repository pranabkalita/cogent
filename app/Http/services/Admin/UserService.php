<?php

namespace App\Http\Services\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class UserService
{
    public function allUsers(): Collection
    {
        return User::notSuperAdmins()->get();
    }

    public function createUser(array $data): User
    {
        $role = Role::findOrFail($data['role']);

        $data['password'] = User::USER_DEFAULT_PASSWORD;

        $user = User::create($data);
        $user->assignRole($role);

        return $user;
    }

    public function getUserById(int $id): User
    {
        $user = User::with('roles')->where('id', $id)->first();

        if (!$user) {
            abort(404, 'Not found !');
        }

        return $user;
    }

    public function updateUser(int $id, array $data)
    {
        if (Arr::exists($data, 'role')) {
            $role = Role::where('id', $data['role'])->first();

            if (!$role) {
                abort(404, 'Invalid Role !');
            }
        }

        $user = $this->getUserById($id);
        $user->update($data);

        if ($role) {
            $user->roles()->detach();
            $user->assignRole($role);
        }

        return $user;
    }

    public function deleteUser(int $id): void
    {
        $user = $this->getUserById($id);
        if ($user->hasRole('super_admin')) {
            abort(403, 'Can not delete !');
        }

        $user->delete();
    }
}
