<?php

namespace App\Http\Controllers;

use App\DTO\PostCreateDTO;
use App\DTO\PostUpdateDTO;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

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
  public function create(PostCreateRequest $postCreateRequest): JsonResponse
  {
    $credentials = new PostCreateDTO(
      title: $postCreateRequest->get('title'),
      description :  $postCreateRequest->get('description'),
    );
    return response()->json($this->postService->createPost($credentials));
  }

  /**
   * @param Request $request
   * @param string|int $id
   * 
   * @return array
   */
  public function update(PostUpdateRequest $postUpdateRequest, string|int $id):JsonResponse
  {
    $credentials = new PostUpdateDTO(
      title: $postUpdateRequest->get('title'),
      description:$postUpdateRequest->get('description'),
    );
    return response()->json($this->postService->updatePost($credentials, $id));
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
