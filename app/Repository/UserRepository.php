<?php

namespace App\Repository;

use App\Exceptions\NotFoundException;
use App\Models\User;
use Exception;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Illuminate\Support\Js;

class UserRepository
{
  public const PAG_PAGE_SIZE = 10;
  //user
  public function getAll(): array
  {
    $users = User::paginate(self::PAG_PAGE_SIZE);
    return $users->toArray();
  }

  public function getOne(string|int $id): array
  {
    $user = User::find($id);
    !$user ? throw new NotFoundException('There is no such user.') : $user->all();
    return $user->toArray();
  }

  public function create(array $data): array
  {
    $user = User::create($data);
    return $user->toArray();
  }

  public function update(array $data, int|string $id)
  {
    $user = User::find($id);
    if (!$user) {
      throw new NotFoundException('There is no such user.');
    }
    $user->update($data);
    return $user->toArray() ;
  }

  public function delete(string| int $id): void
  {
    $user = User::find($id);
    !$user ? throw new NotFoundException('There is no such user.') :
      $user->delete();
  }

  public function deleteAll(): void
  {
    $user = User::count();
    if ($user) {
      User::truncate();
    }
  }

  //auth 
  public function getUserByEmail(string $email): array
  {
    $user = User::query()->where('email', $email)->first();
    return $user ? $user->toArray() : [];
  }
}
