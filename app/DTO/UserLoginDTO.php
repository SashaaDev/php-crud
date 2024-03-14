<?php

namespace App\DTO;

class UserLoginDTO
{
  public function __construct(
    private readonly string $email,
    private readonly string $password
  ) {
  }
  public function getEmail(): string
  {
    return $this->email;
  }
  public function getPassword(): string
  {
    return $this->password;
  }
  public function setCredentials(): array
  {
    return [
      'email' => $this->email,
      'password' => $this->password
    ];
  }
}
