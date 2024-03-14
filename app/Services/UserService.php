<?php

namespace App\Services;

use App\Exceptions\ForbiddenException;
use App\Repository\UserRepository;
use Exception;

class UserService
{
  protected $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function getAllUsers(): array
  {
    return $this->userRepository->getAll();
  }

  public function getOneUser(string|int $id): array
  {
    return $this->userRepository->getOne($id);
  }

  public function createUser(array $data): array
  {
    return $this->userRepository->create($data);
  }

  public function updateUser(array $data, string|int $id)
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

  public function deleteUser(string|int $id)
  {
    return $this->userRepository->delete($id);
  }

  public function deleteAllUsers()
  {
    return $this->userRepository->deleteAll();
  }
}
