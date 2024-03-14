<?php

namespace App\Repository;

use App\Models\Post;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;

class PostRepository
{
  public function getAll()
  {
    return Post::all();
  }

  public function getOne($id)
  {
    $post = Post::find($id);
    if (!$post) {
      throw new Exception('Немає такого поста.');
    } else {
      $post->all();
      return Post::find($id);
    }
  }

  public function create(array $data)
  {
    return Post::create($data);
    // $id = Arr::get($data,'id');
  }

  public function update(array $data, $id)
  {
    $post = Post::find($id);
    if (!$post) {
      throw new Exception('Немає такого поста.');
    }
    $post->update($data);
    return Post::find($id);
  }

  public function delete($id)
  {
    $post = Post::find($id);
    if (!$post)
      return false;
    else
      $post->delete();
    return true;
  }
}
