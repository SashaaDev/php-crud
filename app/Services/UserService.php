<?php

namespace App\Services;

use App\DTO\UserLoadAvatarDTO;
use App\DTO\UserUpdateAvatarDTO;
use App\DTO\UserUpdateDTO;
use App\DTO\UserCreateDTO;
use App\DTO\UserRegistrationDTO;
use App\Exceptions\ForbiddenException;
use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\FileRepository;
use App\Repository\UserRepository;

class UserService
{
  public const PART_PATH_AVATARS = 'avatars';


  public function __construct(
    private readonly UserRepository $userRepository,
    protected readonly FileRepository $fileRepository,
    private readonly AvatarRepository $avatarRepository,

    private readonly AuthWrapperService $authWrapperService
  ) {
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
   * @param UserUpdateAvatarDTO $userLoadAvatarDTO
   * @param string|int $id
   * 
   * @return array
   */
  public function loadAvatar(UserUpdateAvatarDTO $userLoadAvatarDTO, string|int $id): array
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
    return $this->userRepository->getOne($id);
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
    $user = $this->setAvatarUrl($fileName, $user);
    $this->userRepository->updateUserAvatar($fileName, $file);
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
    return $this->userRepository->updateAvatar($user, $user['id']);
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
   * @param UserRegistrationDTO|UserCreateDTO $credentials
   * 
   * @return array
   */
  public function createUser(UserCreateDTO $credentials): array
  {
    return $this->userRepository->create($credentials);
  }

  /**
   * @param array $data
   * @param string|int $id
   * 
   * @return array<string, string>
   */

  public function updateUser(UserUpdateDTO $credentials, string|int $id): array
  {
    if (auth()->user() === null) {
      throw new ForbiddenException('Forbidden.');
    }
    /** @var User $authUser */
    $authUser = $this->authWrapperService->user();
    //todo authWrapper

    if ($authUser->id != $id) {
      throw new ForbiddenException('Forbidden.');
    }
    $formattedCredentials=$this->formatDTOtoArray($credentials);
    return $this->userRepository->update($formattedCredentials, $id);

  }

  private function formatDTOtoArray(UserUpdateDTO $credentials): array
  {
   return  [
      'name' => $credentials->getName(),
      'email' => $credentials->getEmail(),
      'password' => $credentials->getPassword(),
   ];
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
        return $this->userRepository->updateAvatar($user, $id);
      }
    );
    return $this->userRepository->getOne($id);
  }
}
