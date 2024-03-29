<?php

use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Builder;

test('delete all user', function ($findedUser, int $awatingResponse) {
  $user = Mockery::mock(User::class);
  $builder = Mockery::mock(Builder::class);
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('truncate')->andReturn(true);
  $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));
  $response = $this->delete('/api/users')->json();
  expect($response)->toBe($awatingResponse);
})->with('User deleted');
