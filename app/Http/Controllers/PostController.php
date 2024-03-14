<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;

class PostController extends Controller
{

  public function __construct(public readonly PostService $postService)
  {
  }

  public function getAll()
  {
    return response()->json($this->postService->getAllPosts());
  }

  public function getOne($id)
  {
    return response()->json($this->postService->getOnePost($id));
  }

  public function create(Request $request)
  {
    return $this->postService->createPost($request->all());
  }

  public function update(Request $request, $id)
  {
    return $this->postService->updatePost($request->all(), $id);
  }

  public function delete($id)
  {
    $result = $this->postService->deletePost($id);
    if (!$result) {
      return response()->json(['message' => 'Немає такого поста'], 404);
    } else {
      return response()->json(['message' => 'Видалення поста успішне'], 200);
    }
  }
}
