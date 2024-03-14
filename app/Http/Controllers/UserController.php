<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetOneUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Exception;

use function Laravel\Prompts\password;

class UserController extends Controller
{
  public function __construct(public readonly UserService $userService)
  {
  }

  public function getAll(): array
  {
    return $this->userService->getAllUsers();
  }

  public function getOne(string|int $id)
  {
    return $this->userService->getOneUser($id);
  }

  public function create(CreateUserRequest $request): array
  {
    return $this->userService->createUser($request->all());
  }

  public function update(UpdateUserRequest $request, string|int $id): array
  {
    return $this->userService->updateUser($request->all(), $id);
  }

  public function deleteOne(string|int $id)
  {
    return $this->userService->deleteUser($id);
  }

  public function deleteAll()
  {
    return $this->userService->deleteAllUsers();
  }
}
