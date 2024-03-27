<?php

namespace App\Services;

use App\Repository\AuthRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class HashWrapperService
{
  public function hashDecrypt(?string $hash, string $key): bool
  {
    return Hash::check($key, $hash);
  }
  public function hashUpdate(array $user): string
  {
    return Hash::make($user['id']);
  }
  public function bcryptHashCreate(string $neededHash): string {
    return Hash::createBcryptDriver()->make($neededHash);
  }
}
