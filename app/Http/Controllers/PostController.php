<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;

class PostController extends Controller
{

  public function __construct(public readonly PostService $postService)
  {
  }

  /**
   * @return array
   */
  public function getAll(): array
  {
    return $this->postService->getAllPosts();
  }

  /**
   * @param string|int $id
   * 
   * @return array
   */
  public function getOne(string|int $id): array
  {
    return $this->postService->getOnePost($id);
  }

  /**
   * @param Request $request
   * 
   * @return array
   */
  public function create(Request $request): array
  {
    return $this->postService->createPost($request->all());
  }

  /**
   * @param Request $request
   * @param string|int $id
   * 
   * @return array
   */
  public function update(Request $request, string|int $id):array
  {
    return $this->postService->updatePost($request->all(), $id);
  }

  /**
   * @param string|int $id
   * 
   * @return bool
   */
  public function delete(string|int $id): bool|null
  {
    return $this->postService->deletePost($id);
  }
}
