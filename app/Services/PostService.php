<?php

namespace App\Services;

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
  public function createPost(array $data):array
  {
    return $this->postRepository->create($data);
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
  public function updatePost(array $data, string|int $id): array
  {
    return $this->postRepository->update($data, $id);
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
