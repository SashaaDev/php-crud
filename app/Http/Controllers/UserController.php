<?php

namespace App\Http\Controllers;

use App\DTO\UserCreateDTO;
use App\DTO\UserUpdateAvatarDTO;
use App\DTO\UserUpdateDTO;
use App\Exceptions\ForbiddenException;
use App\Http\Requests\UserAvatarUpdateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Services\PostService;
use App\DTO\UserLoadAvatarDTO;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetOneUserRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UserUpdateRequest;
use Exception;
use Illuminate\Http\JsonResponse;

use function Laravel\Prompts\password;
class UserController extends Controller
{
  public const PART_PATH_AVATARS = 'avatars';
  // protected $avatarService;
  public function __construct(public readonly UserService $userService, 
  public readonly PostService $postService)
  {
    // $this->avatarService = $avatarService;
  }


  /**
   * @return JsonResponse
   */
  public function getAll(): JsonResponse
  {
    return response()->json($this->userService->getAllUsers());
  }


  /**
   * @param string|int $id
   * 
   * @return JsonResponse
   */
  public function getOne(string|int $id): JsonResponse
  {
    return response()->json($this->userService->getOneUser($id));
  }

  /**
   * @param UserAvatarUpdateRequest $updateAvatarRequest
   * @param string|int $id
   * 
   * @return JsonResponse
   */
  public function uploadAvatar(UserAvatarUpdateRequest $updateAvatarRequest, string|int $id): JsonResponse
  {
    $userUpdateAvatarDTO = new UserUpdateAvatarDTO(
      name: $updateAvatarRequest->file(self::PART_PATH_AVATARS)->getClientOriginalName(),
      path: $updateAvatarRequest->file(self::PART_PATH_AVATARS)->getRealPath(), 
      extension:$updateAvatarRequest->file(self::PART_PATH_AVATARS)->getClientOriginalExtension()
    );

    return response()->json($this->userService->loadAvatar($userUpdateAvatarDTO, $id));
  }

  /**
   * @param string|int $id
   * 
   * @return JsonResponse
   */
  public function getAvatar(string|int $id): JsonResponse
  {
    return response()->json([
      'avatar' => $this->userService->getAvatarPath($id)
    ]);
  }

  /**
   * @param UserCreateRequest $request
   * 
   * @return JsonResponse
   */
  public function create(UserCreateRequest $createUserRequest): JsonResponse
  {
    $credentials = new UserCreateDTO(
      email: $createUserRequest->get('email'),
    );
    return response()->json($this->userService->createUser($credentials));
  }


  /**
   * @param UserUpdateRequest $request
   * @param string|int $id
   * 
   * @return JsonResponse
   */
  public function update(UserUpdateRequest $updateUserRequest, string|int $id): JsonResponse
  {
    $credentials = new UserUpdateDTO(
      name: $updateUserRequest->get('name'),
      email: $updateUserRequest->get('email'),
      password: $updateUserRequest->get('password'),
      // hash: $updateUserRequest->get('hash'),
    );

    return response()->json($this->userService->updateUser($credentials, $id));
  }

  /**
   * @param string|int $id
   * 
   * @return bool|null
   */
  public function deleteOne(string|int $id): bool|null
  {
    return $this->userService->deleteUser($id);
  }

  /**
   * @return bool
   */
  public function deleteAll(): bool|null
  {
    return $this->userService->deleteAllUsers();
  }

  /**
   * @param string|int $id
   * 
   * @return JsonResponse
   */
  public function deleteAvatar(string|int $id): JsonResponse
  {
    return response()->json($this->userService->deleteUserAvatar($id));
  }
}
