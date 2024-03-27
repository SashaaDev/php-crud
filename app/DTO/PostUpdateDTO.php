<?php

namespace App\DTO;

class PostUpdateDTO
{
  public function __construct(
    private readonly string $title,
    private readonly string $description,
  ) {
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function getDescription(): string
  {
    return $this->description;
  }

  public function setCredentials(): array
  {
    return ([
      'title' => $this->title,
      'description' => $this->description
    ]);
  }
}
