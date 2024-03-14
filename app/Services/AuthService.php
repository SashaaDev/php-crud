<?php

namespace App\Services;

use App\DTO\UserRegistrationDTO;
use App\DTO\UserLoginDTO;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\AppUserRequest;
use App\Models\User;
use App\Repository\AuthRepository;
use App\Repository\UserRepository;
use Dotenv\Util\Str;
use Exception;
use Hamcrest\Core\HasToString;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AuthService
{
  public function __construct(
    private readonly AuthRepository $authRepository,
    private readonly AuthWrapperService $authWrapperService,
    private readonly HashWrapperService $hashWrapperService,
    private readonly UserRepository $userRepository
  ) {
  }

  //login
  public function loginAuth(UserLoginDTO $credentials)
  {
    if (!$token = $this->authWrapperService->attempt($credentials->setCredentials())) {
      throw new UnauthorizedException('Unauthorized');
    }
    return $this->respondWithToken($token);
  }

  //registartion

  /**
   * @param UserRegistrationDTO $credentials
   * 
   * @return array
   */
  public function registrationUser(UserRegistrationDTO $credentials): array
  {
    // dd(1);
    $user = $this->userRepository->getUserByEmail($credentials->getEmail());
    if ($user) {
      if ($this->isUserHasInviteHash($user, $user['id'])) {
        return $this->userRepository->update($credentials->setCredentials(), $user['id']);
      }
      // throw new Exception('User already exist', 409);
    }
    if (!$user) {
      return $this->userRepository->create($credentials->setCredentials());
    }
  }

  //email Check
  /**
   * @param string $email
   * 
   * @return array
   */
  public function emailInviteCheck(string $email): array
  {
    $user = $this->userRepository->getUserByEmail($email);
    if (!$user) {
      throw new NotFoundException('There is no such user.');
    }
    return $this->hashUpdate($user);
  }

  //checking user hash 
  protected function isUserHashExists(array $user): bool
  {
    return $user['hash'] !== null;
  }

  private function isUserHasInviteHash(array $user, string $key): bool
  {
    return $this->isUserHashExists($user) && $this->isUserInviteHashValid($user['hash'], $key);
  }

  //validating hash
  public function isUserInviteHashValid(?string $userHash, string $key): bool
  {
    return $this->decryptHashUser($userHash, $key) ? true : false;
  }

  //decrypt
  public function decryptHashUser(?string $hash, string $key): bool
  {
    return $this->hashWrapperService->hashDecrypt($hash, $key);
  }

  //send hash
  public function hashUpdate(array $user): array
  {
    $hash = $this->hashWrapperService->hashUpdate($user);
    $user['hash'] = $hash;
    return $this->userRepository->update($user, $user['id'])->toArray();
  }

  //login check
  protected function respondWithToken($token): array
  {
    return [
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60
    ];
  }
}
