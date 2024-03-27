<?php

namespace App\Services;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthWrapperService
{

  /**
   * @param array $credentials
   * 
   * @return mixed
   */
  public function attempt(array $credentials): mixed
  {
    return auth()->attempt($credentials);
  }
  public function user(): Authenticatable|null
  {
    return auth()->user();
  }
}
