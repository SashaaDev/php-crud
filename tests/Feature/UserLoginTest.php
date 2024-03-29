<?php

use App\Models\User;
use App\Repository\AuthRepository;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use App\Services\AuthService;
use App\Services\AuthWrapperService;
use App\Services\HashWrapperService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;


use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Hash;


test('user login', function ($createdUser, array $awaitingResponse) {
  $createdUser['hash'] = Hash::make($createdUser['hash']);
  $loggedUser = new User($createdUser);
  $user = Mockery::mock(User::class);
  $builder = Mockery::mock(Builder::class);
  $authWrapper = Mockery::mock(AuthWrapperService::class);
  $authWrapper->shouldReceive('attempt')->andReturn('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzExNzAwMDExLCJleHAiOjE3MTE3MDM2MTEsIm5iZiI6MTcxMTcwMDAxMSwianRpIjoiQlRqNlFKUVVTN3J0YXZ0WSIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.1ltU_aZEXk-niLwBcOAhgIMTz8h0jZgdK9CIXlcirPY');
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('where')->andReturn($builder);
  $builder->shouldReceive('first')->andReturn(collect($createdUser), $loggedUser);
  
  $user->shouldReceive('makeVisible')->andReturn($loggedUser);

  $this->app->instance(UserRepository::class, new UserRepository(
    $user,
    app(AvatarRepository::class)
  ));
  $this->app->instance(AuthWrapperService::class, $authWrapper);
  $response = $this->post('/api/auth/login', $loggedUser->toArray())->json();

  expect($response)->toBe($awaitingResponse);
})->with('User logged in');
