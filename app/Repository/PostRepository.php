<?php

namespace App\Repository;

use App\Exceptions\NotFoundException;
use App\Models\Post;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;

class PostRepository
{
  /**
   * @return array
   */
  public function getAll(): array
  {
    return Post::all()->toArray();
  }

  /**
   * @param string|int $id
   * 
   * @return array
   */
  public function getOne(string|int $id): array
  {
    $post = Post::find($id);
    if (!$post) {
      throw new Exception('Немає такого поста.');
    } else {
      $post->all();
      return Post::find($id)->toArray();
    }
  }


  /**
   * @param array $data
   * 
   * @return array<string, string>
   */
  public function create(array $data): array
  {
    return Post::create($data)->toArray();
    // $id = Arr::get($data,'id');
  }

  /**
   * @param array $data
   * @param string|int $id
   * 
   * @return array
   */
  public function update(array $data, string|int $id): array
  {
    $post = Post::find($id);
    if (!$post) {
      throw new NotFoundException('There is no such post.');
    }
    $post->update($data);
    return Post::find($id)->toArray();
  }

  /**
   * @param string|int $id
   * 
   * @return void
   */
  public function delete(string|int $id): void
  {
    $post = Post::find($id);
    !$post ? throw new NotFoundException('There is no such post.') :
      $post->delete();
  }
}
