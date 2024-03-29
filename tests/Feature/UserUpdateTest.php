<?php

use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use App\Services\AuthWrapperService;
use Illuminate\Database\Eloquent\Builder;

test('update user', function ($findedUser, array $awatingResponse) {
  $user = Mockery::mock(User::class);
  $loggedUser = new User($findedUser);
  $builder = Mockery::mock(Builder::class);
  $authWrapper = Mockery::mock(AuthWrapperService::class);
  $authWrapper->shouldReceive('attempt')->andReturn('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzExNzE5OTY2LCJleHAiOjE3MTE3MjM1NjYsIm5iZiI6MTcxMTcxOTk2NiwianRpIjoieFhmWVpkaHZTemVEajg3cCIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.R10s_K90h9qRfLexjxzwKiWtNAOjq_D0ymXs7Og58Jo');
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('where')->andReturn($findedUser);
  $user->shouldReceive('update')->andReturn(true);
  // $builder
  $user->shouldReceive('makeVisible')->andReturn($findedUser);
  $this->app->instance(AuthWrapperService::class, $authWrapper);
  $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));
  $response = $this->put('/api/users/1', [
    'name' => 'name',
    'email' => 'email@gmail.com',
    'password' => 'password',
  ])->json();
  // dd($response);
  expect($response)->toBe($awatingResponse);
})->with('User updated');
