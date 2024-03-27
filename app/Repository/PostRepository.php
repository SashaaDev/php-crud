<?php

namespace App\Repository;

use App\DTO\PostUpdateDTO;
use App\Exceptions\NotFoundException;
use App\Models\Post;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class PostRepository
{
  public function __construct(
    private readonly Post $model
  ) {
  }

  /**
   * @return array
   */
  public function getAll(): array
  {
    return $this->model->all()->toArray();
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
  public function update(PostUpdateDTO $credentials, string|int $id): array
  {
    $post = $this->model->query()->find($id);
    if (!$post) {
      throw new NotFoundException('There is no such post.');
    }
    $post->update([
      'title' => $credentials->getTitle(),
      'description' => $credentials->getDescription(),
    ]);
    return $post->toArray();
  }

  /**
   * @param string|int $id
   * 
   * @return void
   */
  public function delete(string|int $id): bool
  {
    $post = Post::find($id);
    !$post ? throw new NotFoundException('There is no such post.') :
      $post->delete();
    return true;
  }
}
