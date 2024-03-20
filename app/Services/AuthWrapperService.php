<?php

namespace App\Services;

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
}
