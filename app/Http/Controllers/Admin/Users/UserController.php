<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


// TODO: Separate Service
// TODO: Response using resource
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super_admin|admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Collection
    {
        return User::notSuperAdmins()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): User
    {
        // TODO: Validate (Send new email verification, confirm password)
        $role = Role::findOrFail($request->role);

        $user = User::create($request->only(['name', 'email', 'password']));
        $user->assignRole($role);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user): User
    {
        // TODO: Validate (Send new email verification, confirm password)
        // TODO: Validate other fields empty use existing
        $user->update($request->only(['name', 'email', 'password']));

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // TODO: Implement Soft Delete
        return $user->delete();
    }
}
