<?php

namespace App\Services;

use App\Repository\PostRepository;

class PostService
{
  protected $postRepository;

  public function __construct(PostRepository $postRepository)
  {
    $this->postRepository = $postRepository;
  }

  public function createPost(array $data)
  {
    return $this->postRepository->create($data);
  }

  public function getAllPosts()
  {
    return $this->postRepository->getAll();
  }

  public function getOnePost($id)
  {
    return $this->postRepository->getOne($id);
  }

  public function updatePost(array $data, $id)
  {
    return $this->postRepository->update($data, $id);
  }

  public function deletePost($id)
  {
    return $this->postRepository->delete($id);
  }
}
