<?php

namespace App\Repository;

use App\DTO\UserCreateDTO;
use App\DTO\UserRegistrationDTO;
use App\DTO\UserUpdateAvatarDTO;
use App\DTO\UserUpdateDTO;
use App\Exceptions\NotFoundException;
use App\Http\Requests\UserAvatarUpdateRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * [Description UserRepository]
 */
class UserRepository extends DataBaseRepository
{
  public const PAG_PAGE_SIZE = 10;

  public function __construct(
    private Model $model,
    private readonly AvatarRepository $avatarRepository
  ) {
  }

  /**
   * @return array
   */
  public function getAll(): array
  {
    // return $this->model->query()->paginate(self::PAG_PAGE_SIZE)->toArray();
    /** @var Collection $allUsers */
    $allUsers = $this->model->query()->paginate(self::PAG_PAGE_SIZE);
    return $allUsers->toArray();
  }

  /**
   * @param string|int $id
   * 
   * @return array
   */
  public function getOne(string|int $id): array
  {
    $user = $this->findUser($id);
    return $user;
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
  public const MODEL = 'model';

  /**
   * @param array $data
   * 
   * @return array<string, string>
   */
  public function create(UserCreateDTO $credentials): array
  {
    $user = $this->model->query()->create([
      'email' => $credentials->getEmail(),
    ]);

    return $user->toArray();
  }
  public function register(UserRegistrationDTO $credentials): array
  {
    $user = $this->model->query()->create([
      'name' => $credentials->getName(),
      'email' => $credentials->getEmail(),
      'password' => $credentials->getPassword(),
    ]);
    return $user->toArray();
  }
  /**
   * @param array $data
   * @param int|string $id
   * 
   * @return array<string, string>
   */
  public function update(array|UserUpdateDTO|UserRegistrationDTO $credentials, int|string $id): array
  {
    $this->findUser($id);


    $this->model->query()->where('id', $id)->update(
      [
        'name' => $credentials->getName(),
        'email' => $credentials->getEmail(),
        'password' => $credentials->getPassword(),
        'hash' => null,
      ]
    );
    return $this->findUser($id);
  }

  /**
   * @param array $user
   * @param int|string $id
   * 
   * @return array
   */
  public function updateAvatar(array $user, int|string $id): array
  {
    $this->findUser($id);
    $this->model->query()->where('id', $id)->update([
      'avatar' => $user['avatar'],
    ]);
    return $this->findUser($id);
  }

  /**
   * @param array $user
   * @param int|string $id
   * 
   * @return array
   */
  public function updateHash(array $user, int|string $id): array
  {
    $this->findUser($id);
    $this->model->query()->where('id', $id)->update([
      'hash' => $user['hash'],
    ]);
    return $this->findUser($id);
  }

  /**
   * @param string|int $id
   * 
   * @return bool
   */
  public function delete(string|int $id): bool
  {
    $this->findUser($id);
    $this->model->query()->delete();
    return true;
  }

  /**
   * @param string|int $id
   * 
   * @return array
   */
  public function findUser(string|int $id): array
  {
    $user = $this->model->query()->find($id);

    if (!$user) {
      throw new NotFoundException('There is no such user.');
    }
    return $user->toArray();
  }

  /**
   * @return bool
   */
  public function deleteAll(): bool
  {
    $user = $this->model->query()->count();
    if ($user) {
      $this->model->query()->truncate();
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
    $user = $this->model->query()->where('email', $email)->first();
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
