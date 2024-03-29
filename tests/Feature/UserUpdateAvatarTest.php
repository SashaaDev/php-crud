<?php

use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\FileRepository;
use App\Repository\UserRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Builder;

test('user update avatar', function ($findedUser, $userId, $awatingResponse) {
  $file = UploadedFile::fake()->image('file.png');
  // dd($file->getRealPath(), $file->getClientOriginalName());

  $user = Mockery::mock(User::class);
  $builder = Mockery::mock(Builder::class);
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('find')->andReturn($findedUser);
  $builder->shouldReceive('where')->andReturn(new User());
  $user->shouldReceive('update')->andReturn(true);
  $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));
  // dd($this->post('/api/users/1/avatar', ['avatar' => $file]));

  $response = $this->post('/api/users/1/avatar', ['avatars' => $file])->json();
  expect($response)->toBe($awatingResponse);
})->with('User updated avatar');
