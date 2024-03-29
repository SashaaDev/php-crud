<?php

namespace App\Services;

use App\DTO\UserRegistrationDTO;
use App\DTO\UserLoginDTO;
use App\Exceptions\ConflictExceptions;
use App\Exceptions\ForbiddenException;
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
  public function loginAuth(UserLoginDTO $credentials): array
  {
    $user = $this->userRepository->getUserByEmail($credentials->getEmail());
    if ($user) {
      $this->checkHash($user);
      $password = $this->userRepository->getPassword($user['email']);
      // dd($password);
      if ($password === null) {
        throw new ConflictExceptions('There is no password in the database.');
      }
      return $this->authenticateUser($credentials);
    }
    throw new NotFoundException('There is no such user.');
  }

  /**
   * @param array $user
   * 
   * @return void
   */
  public function checkHash(array $user): void
  {
    if ($this->isUserHasInviteHash($user, $user['id'])) {
      throw new ForbiddenException('You need to complete the registration process.');
    }
  }

  /**
   * @param UserLoginDTO $credentials
   * 
   * @return array
   */
  public function authenticateUser(UserLoginDTO $credentials): array
  {
    // dd($credentials->getPassword());
    $token = $this->authWrapperService->attempt($credentials->setCredentials());
    if (!$token) {
      throw new UnauthorizedException('Unauthorized.');
    }
    // dd($token);
    return $this->respondWithToken($token);
  }

  /**
   * @param string $email
   * 
   * @return void
   */
  public function getPasswordOrThrowIfNotFound(string $email): void
  {
    $password = $this->userRepository->getPassword($email);
    if ($password === null) {
      throw new ConflictExceptions('This user don`t have a hash.');
    }
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
      if ($this->isUserHasInviteHash($user, $user['id'])) {

        $credentials->setPassword($this->hashWrapperService->bcryptHashCreate($credentials->getPassword()));
        return $this->userRepository->update($credentials, $user['id']);
      }
      $this->getPasswordOrThrowIfNotFound($user['email']);
      throw new ConflictExceptions('User already exists.');
    }
    return $this->userRepository->register($credentials);
  }
  // public function registrationUser(UserRegistrationDTO $credentials): array
  // {
  //   $user = $this->userRepository->getUserByEmail($credentials->getEmail());
  //   if ($user) {
  //     if ($this->isUserHasInviteHash($user, $user['id']) && $user['name'] === 'user') {

  //       $credentials->setPassword($this->hashWrapperService->bcryptHashCreate($credentials->getPassword()));
  //       return $this->userRepository->update($credentials, $user['id']);
  //     }
  //     throw new ConflictExceptions('User already exists.');
  //   }
  //   return $this->userRepository->register($credentials);
  // }

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
    // dd($userHash, $key);
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
    return $this->userRepository->updateHash($user, $user['id']);
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
