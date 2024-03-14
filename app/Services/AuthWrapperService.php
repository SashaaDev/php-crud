<?php

namespace App\Services;

class AuthWrapperService
{

  public function attempt(array $credentials)
  {
    return auth()->attempt($credentials);
  }
}
