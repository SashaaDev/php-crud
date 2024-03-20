<?php

namespace App\DTO;

class UserLoadAvatarDTO
{
  public function __construct(
    private readonly string $name,
    private readonly string $path,
    private readonly string $extension,
  ) {
  }
  public function getName(): string
  {
    return $this->name;
  }
  public function getPath(): string
  {
    return $this->path;
  }
  public function getExtension(): string
  {
    return $this->extension;
  }
}
