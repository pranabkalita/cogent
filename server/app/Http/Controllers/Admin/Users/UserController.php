<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Users\UserResource;
use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Services\Admin\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware(['role:super_admin|admin']);
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->allUsers();

        return UserResource::collection($users);
    }

    public function store(CreateUserRequest $request)
    {
        // TODO: Validate (Send new email verification)
        $user = $this->userService->createUser($request->only([
            'name', 'email', 'role'
        ]));

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        // TODO: Validate (Send new email verification)
        $user = $this->userService->updateUser($id, $request->only([
            'name', 'email', 'role'
        ]));

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(int $id)
    {
        $this->userService->deleteUser($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
