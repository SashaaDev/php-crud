<?php

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenException;
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
use App\Http\Requests\UpdateUserRequest;
use Exception;
use Illuminate\Http\JsonResponse;

use function Laravel\Prompts\password;
class UserController extends Controller
{
  public const PART_PATH_AVATARS = 'avatars';
  // protected $avatarService;
  public function __construct(public readonly UserService $userService, public readonly PostService $postService)
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
   * @param UpdateAvatarRequest $updateAvatarRequest
   * @param string|int $id
   * 
   * @return JsonResponse
   */
  public function uploadAvatar(UpdateAvatarRequest $updateAvatarRequest, string|int $id): JsonResponse
  {
    $userLoadAvatarDTO = new UserLoadAvatarDTO(
      name: $updateAvatarRequest->file(self::PART_PATH_AVATARS)->getClientOriginalName(),
      path: $updateAvatarRequest->file(self::PART_PATH_AVATARS)->getRealPath(), 
      extension:$updateAvatarRequest->file(self::PART_PATH_AVATARS)->getClientOriginalExtension()
    );

    return response()->json($this->userService->loadAvatar($userLoadAvatarDTO, $id));
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
   * @param CreateUserRequest $request
   * 
   * @return JsonResponse
   */
  public function create(CreateUserRequest $request): JsonResponse
  {
    return response()->json($this->userService->createUser($request->all()));
  }


  /**
   * @param UpdateUserRequest $request
   * @param string|int $id
   * 
   * @return JsonResponse
   */
  public function update(UpdateUserRequest $request, string|int $id): JsonResponse
  {
    return response()->json($this->userService->updateUser($request->all(), $id));
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
