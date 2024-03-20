<?php

namespace App\Repository;

use App\Exceptions\NotFoundException;
use App\Models\User;
use Exception;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Js;

/**
 * [Description UserRepository]
 */
class UserRepository extends DataBaseRepository
{
  public const PAG_PAGE_SIZE = 10;

  protected $dispatcher;
  protected $avatarRepository;
  public function __construct(AvatarRepository $avatarRepository, Dispatcher $dispatcher)
  {
    $this->dispatcher = $dispatcher;
    $this->avatarRepository = $avatarRepository;
  }

  /**
   * @return array
   */
  public function getAll(): array
  {
    $users = User::paginate(self::PAG_PAGE_SIZE);
    return $users->toArray();
  }

  /**
   * @param string|int $id
   * 
   * @return array
   */
  public function getOne(string|int $id): array
  {
    $user = $this->findUser($id);
    $user->all();
    return $user->toArray();
  }
  /**
   * @param string|int $id
   * 
   * @return string|null
   */
  public function getAvatar(string|int $id): ?string
  {
    $user = $this->getOne($id);
    return $user['avatar'];
  }

  /**
   * @param array $data
   * 
   * @return array<string, string>
   */
  public function create(array $data): array
  {
    $user = User::create($data);
    return $user->toArray();
  }

  /**
   * @param array $data
   * @param int|string $id
   * 
   * @return array<string, string>
   */
  public function update(array $data, int|string $id): array
  {
    $user = $this->findUser($id);
    $user->update($data);

    return $user->toArray();
  }

  /**
   * @param string|int $id
   * 
   * @return bool
   */
  public function delete(string|int $id): bool
  {
    $user = $this->findUser($id);
    $user->delete();
    return true;
  }

  /**
   * @param string|int $id
   * 
   * @return User|null
   */
  public function findUser(string|int $id): ?User
  {
    $user = User::find($id);
    if (!$user) {
      throw new NotFoundException('There is no such user.');
    }
    return $user;
  }

  /**
   * @return bool
   */
  public function deleteAll(): bool
  {
    $user = User::count();
    if ($user) {
      User::truncate();
    }
    return true;
  }

  /**
   * @param string $email
   * 
   * @return array
   */
  public function getUserByEmail(string $email): array
  {
    $user = User::query()->where('email', $email)->first();
    return $user ? $user->toArray() : [];
  }

  /**
   * @param string $fileName
   * @param string $file
   * 
   * @return void
   */
  public function updateUserAvatar(string $fileName, string $file): void
  {
    $this->avatarRepository->setAvatar($fileName, $file);
  }
}
