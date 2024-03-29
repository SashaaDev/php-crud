<?php

use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\FileRepository;
use App\Repository\UserRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Builder;

test('user update hash', function ($findedUser, $awatingResponse) {
  $user = Mockery::mock(User::class);
  $builder = Mockery::mock(Builder::class);
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('find')->andReturn(true);
  $builder->shouldReceive('where')->andReturn(new User());
  $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));

  $response = $this->get('/api/auth/send/UserTest1@gmail.com')->json();

  expect($response)->toBe($awatingResponse);
})->with('User updated hash');
