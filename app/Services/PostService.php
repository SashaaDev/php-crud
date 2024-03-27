<?php

namespace App\Services;

use App\DTO\PostCreateDTO;
use App\DTO\PostUpdateDTO;
use App\Repository\PostRepository;

class PostService
{
  /**
   * @var object
   */
  protected $postRepository;

  public function __construct(PostRepository $postRepository)
  {
    $this->postRepository = $postRepository;
  }

  /**
   * @param array $data
   * 
   * @return array
   */
  public function createPost(PostCreateDTO $credentials):array
  {
    return $this->postRepository->create($credentials->setCredentials());
  }

  /**
   * @return array
   */
  public function getAllPosts(): array
  {
    return $this->postRepository->getAll();
  }

  /**
   * @param string|int $id
   * 
   * @return array
   */
  public function getOnePost(string|int $id): array
  {
    return $this->postRepository->getOne($id);
  }

  /**
   * @param array $data
   * @param string|int $id
   * 
   * @return array
   */
  public function updatePost(PostUpdateDTO $credentials, string|int $id): array
  {
    return $this->postRepository->update($credentials, $id);
  }
  private function convertDTOtoDBFormat(PostCreateDTO $credentials): array
  {
    return [
      'title' => $credentials->getTitle(),
      'description' => $credentials->getDescription(),
    ];
  }

  /**
   * @param string|int $id
   * 
   * @return bool
   */
  public function deletePost(string|int $id): bool|null 
  {
    return $this->postRepository->delete($id);
  }
}
