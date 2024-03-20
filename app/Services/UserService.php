<?php

namespace App\Services;

use App\DTO\UserLoadAvatarDTO;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\UpdateAvatarRequest;
use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\FileRepository;
use App\Repository\UserRepository;
use Exception;
use Faker\Provider\Image;
use Illuminate\Support\Facades\Storage;

class UserService
{
  public const PART_PATH_AVATARS = 'avatars';
  /**
   * @var object
   */
  protected $userRepository, $fileRepository, $avatarRepository;

  public function __construct(
    UserRepository $userRepository,
    FileRepository $fileRepository,
    AvatarRepository $avatarRepository
  ) {
    $this->userRepository = $userRepository;
    $this->fileRepository = $fileRepository;
    $this->avatarRepository = $avatarRepository;
  }

  /**
   * @return array<string, string>
   */
  public function getAllUsers(): array
  {
    return $this->userRepository->getAll();
  }

  /**
   * @param string|int $id
   * 
   * @return array<string, string>
   */
  public function getOneUser(string|int $id): array
  {
    return $this->userRepository->getOne($id);
  }

  /**
   * @param UserLoadAvatarDTO $userLoadAvatarDTO
   * @param string|int $id
   * 
   * @return array
   */
  public function loadAvatar(UserLoadAvatarDTO $userLoadAvatarDTO, string|int $id): array
  {
    $this->userRepository->makeTransaction(function () use ($userLoadAvatarDTO, $id) {
      $user = $this->userRepository->getOne($id);
      $extension = $userLoadAvatarDTO->getExtension();
      $file = $this->getFileContent($userLoadAvatarDTO->getPath());
      if ($user['avatar']) {
        $this->deleteAvatar($user);
      }
      return $this->updateAvatarData($file, $extension, $user);
    });
    return
      $this->userRepository->getOne($id);
  }

  /**
   * @param string $path
   * 
   * @return string
   */
  protected function getFileContent(string $path): string
  {
    return file_get_contents($path);
  }
  /**
   * @param array $user
   * 
   * @return bool
   */
  public function deleteAvatar(array $user): bool
  {
    $fileName = $user['avatar'];
    if ($fileName !== null) {
      $this->avatarRepository->deleteAvatar($fileName);
    }
    return true;
  }


  /**
   * @param bool|string $file
   * @param string $extension
   * @param array $user
   * 
   * @return array
   */
  public function updateAvatarData(bool|string $file, string $extension, array $user): array
  {
    $fileName = $this->avatarRepository->setRandomName($extension);
    $this->userRepository->updateUserAvatar($fileName, $file);
    $user = $this->setAvatarUrl($fileName, $user);
    return $user;
  }

  /**
   * @param string|null $fileName
   * @param array $user
   * 
   * @return array
   */
  public function setAvatarUrl(?string $fileName, array $user): array
  {
    $fileurl = (self::PART_PATH_AVATARS) . '/' . $fileName;
    $user['avatar'] = $fileurl;
    return $this->userRepository->update($user, $user['id']);
  }

  /**
   * @param string|int $id
   * 
   * @return string|null
   */
  public function getAvatarPath(string|int $id): ?string
  {
    return $this->userRepository->getAvatar($id);
  }
  /**
   * @param array $data
   * 
   * @return array<string, string>
   */
  public function createUser(array $data): array
  {
    return $this->userRepository->create($data);
  }

  /**
   * @param array $data
   * @param string|int $id
   * 
   * @return array<string, string>
   */

  public function updateUser(array $data, string|int $id): array
  {
    if (auth()->user() === null) {
      throw new ForbiddenException('Forbidden.');
    }
    $authUser = auth()->user();
    if ($authUser->id != $id) {
      throw new ForbiddenException('Forbidden.');
    }
    return $this->userRepository->update($data, $id);
  }

  /**
   * @param string|int $id
   * 
   * @return bool|null
   */
  public function deleteUser(string|int $id): bool|null
  {
    return $this->userRepository->delete($id);
  }

  /**
   * @return bool
   */
  public function deleteAllUsers(): bool|null
  {
    return $this->userRepository->deleteAll();
  }

  /**
   * @param string|int $id
   * 
   * @return array
   */
  public function deleteUserAvatar(string|int $id): array
  {
    $this->userRepository->makeTransaction(
      function () use ($id) {
        $user = $this->userRepository->getOne($id);
        $this->deleteAvatar($user);
        $user['avatar'] = null;
        return $this->userRepository->update($user, $id);
      }
    );
    return $this->userRepository->getOne($id);
  }
}
