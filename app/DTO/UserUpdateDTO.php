<?php

namespace App\DTO;

class UserUpdateDTO
{
  // private ?string $name;
  // private ?string $email;
  // private ?string $password;

  public function __construct(
    private string $name,
    private string $email,
    private string $password,
    // private readonly string $hash
  ) {
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    // $this->hash = $hash;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }
  // public function getHash(): ?string
  // {
  //   return $this->hash;
  // }
}
