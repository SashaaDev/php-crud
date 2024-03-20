<?php

namespace App\Services;

use App\DTO\UserRegistrationDTO;
use App\DTO\UserLoginDTO;
use App\Exceptions\ConflictExceptions;
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

/**
 * [Description AuthService]
 */
class AuthService
{
  public function __construct(
    private readonly AuthWrapperService $authWrapperService,
    private readonly HashWrapperService $hashWrapperService,
    private readonly UserRepository $userRepository
  ) {
  }

  /**
   * @param UserLoginDTO $credentials
   * 
   * @return array
   */
  public function loginAuth(UserLoginDTO $credentials)
  {
    if (!$token = $this->authWrapperService->attempt($credentials->setCredentials())) {
      throw new UnauthorizedException('Unauthorized');
    }
    // dd($token);
    return $this->respondWithToken($token);
  }

  /**
   * @param UserRegistrationDTO $credentials
   * 
   * @return array
   */
  public function registrationUser(UserRegistrationDTO $credentials): array
  {

    $user = $this->userRepository->getUserByEmail($credentials->getEmail());
    if ($user) {
      if ($this->isUserHasInviteHash($user, $user['id']) && $user['name'] === 'user') {
        return $this->userRepository->update($credentials->setCredentials(), $user['id']);
      }
      throw new ConflictExceptions('User already exists.');
    }
    return $this->userRepository->create($credentials->setCredentials());
  }

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

  /**
   * @param array $user
   * 
   * @return bool
   */
  protected function isUserHashExists(array $user): bool
  {
    return $user['hash'] !== null;
  }

  /**
   * @param array $user
   * @param string $key
   * 
   * @return bool
   */
  private function isUserHasInviteHash(array $user, ?string $key): bool
  {

    return $this->isUserHashExists($user) && $this->isUserInviteHashValid($user['hash'], $key);
  }

  /**
   * @param string|null $userHash
   * @param string $key
   * 
   * @return bool
   */
  public function isUserInviteHashValid(?string $userHash, string $key): bool
  {
    // dd($this->decryptHashUser($userHash, $key));
    return $this->decryptHashUser($userHash, $key) ? true : false;
  }

  /**
   * @param string|null $hash
   * @param string $key
   * 
   * @return bool
   */
  public function decryptHashUser(?string $hash, string $key): bool
  {
    return $this->hashWrapperService->hashDecrypt($hash, $key);
  }

  /**
   * @param array $user
   * 
   * @return array<string, string>
   */
  public function hashUpdate(array $user): array
  {
    // dd(gettype($user));
    $hash = $this->hashWrapperService->hashUpdate($user);
    $user['hash'] = $hash;
    return $this->userRepository->update($user, $user['id']);
  }


  /**
   * @param mixed $token
   * 
   * @return array
   */
  protected function respondWithToken($token): array
  {
    return [
      'access_token' => $token,
      'token_type' => 'bearer',
      /** @phpstan-ignore-next-line */
      'expires_in' => auth()->factory()->getTTL() * 60
    ];
  }
}
