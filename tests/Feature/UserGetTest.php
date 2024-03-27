<?php

use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Builder;

test('get user', function ($findedUser, array $awatingResponse) {
  $user = Mockery::mock(User::class);
  $builder = Mockery::mock(Builder::class);
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('find')->andReturn($findedUser);
  $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));
  $response = $this->get('/api/users/1')->json();
  expect($response)->toBe($awatingResponse);
})->with('User getted');

// test('can create a user', function ($createdUser, array $awatingResponse) {
//   $user = Mockery::mock(User::class);
//   $builder = Mockery::mock(Builder::class);
//   $user->shouldReceive('query')->andReturn($builder);
//   $builder->shouldReceive('create')->andReturn($createdUser);
//   $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));
//   $response = $this->post('/api/users', $createdUser->toArray())->json();
//   dd($createdUser->toArray());
//   expect($response)->toBe($awatingResponse);
// })->with('User created');
