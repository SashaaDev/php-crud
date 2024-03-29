<?php

use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Builder;

test('delete user', function ($findedUser, array $awatingResponse) {
  $user = Mockery::mock(User::class);
  $builder = Mockery::mock(Builder::class);
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('find')->andReturn($findedUser);
  $builder->shouldReceive('where')->andReturn($builder); 
  $builder->shouldReceive('update')->andReturn(true); 
  $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));
  $response = $this->patch('/api/users/1/avatar')->json(); 
  expect($response)->toBe($awatingResponse);
})->with('User deleted avatar');
