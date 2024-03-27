<?php

use App\Models\Post;
use App\Http\Requests\CreateUserRequest;
use App\Repository\PostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

test('update post', function () {
  $post = Mockery::mock(Post::class);
  $builder = Mockery::mock(Builder::class);
  $findedPost = new Post(); 
  // $findedPost->id = 1;
  // $findedPost->title = 'title';
  // $findedPost->description = 'description';
  // $findedPost->created_at = '2022-01-01T00:00:00.000000Z';
  // $findedPost->updated_at = '2022-01-01T00:00:00.000000Z';
  $findedPost->fill([
    'id' => 1,
    'title' => 'title',
    'description' => 'description',
    'created_at' => '2022-01-01T00:00:00.000000Z',
    'updated_at' => '2022-01-01T00:00:00.000000Z',
  ]);
  $post->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('find')->andReturn($findedPost);
  $post->shouldReceive('update')->andReturn(true);
  $this->app->instance(PostRepository::class, new PostRepository($post));
  $response = $this->put('/api/posts/1', [
    'title' => 'title', 
    'description' => 'description'
    ])->json();
  expect($response)->toBe([
    'title' => 'title',
    'description' => 'description',
    // 'created_at' => '2022-01-01T00:00:00.000000Z',
    // 'updated_at' => '2022-01-01T00:00:00.000000Z',
    // 'id' => 1,
  ]);

});