<?php

// namespace App\DTO;

// class UserCreateDTO
// {
//   public function __construct(
//     private readonly ?string $name = null,
//     private readonly string $email,
//     private readonly string $password
//   ) {
//     $this->name = $name ?? 'user';
//   }

//   public function getName(): string
//   {
//     return $this->name;
//   }

//   public function getEmail(): string
//   {
//     return $this->email;
//   }

//   public function getPassword(): string
//   {
//     return $this->password;
//   }
//   public function setCredentials(): array
//   {
//     return ([
//       'name' => $this->name,
//       'email' => $this->email,
//       'password' => $this->password,
//     ]);
//   }
// }

namespace App\DTO;

class UserCreateDTO
{
  public function __construct(
    private ?string $email = null,
  ) {
    $this->email = $email;
  }

  // public function getName(): string
  // {
  //   return $this->name;
  // }

  public function getEmail(): string
  {
    return $this->email;
  }

  // public function getPassword(): string
  // {
  //   return $this->password;
  // }

  public function setCredentials(): array
  {
    return [
      // 'name' => $this->getName(),
      'email' => $this->getEmail(),
      // 'password' => $this->getPassword(),
    ];
  }
}
