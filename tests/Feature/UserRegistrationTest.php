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


test('user registered', function ($createdUser, array $awaitingResponse) {
  $user = Mockery::mock(User::class);
  $builder = Mockery::mock(Builder::class);
  // $createdUser['hash'] = Hash::make($createdUser['hash']);
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('where')->andReturn($builder);
  $builder->shouldReceive('first')->andReturn(null);
  $builder->shouldReceive('create')->andReturn($createdUser);
  $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));
  // dd($this->put('/api/auth/registration', [
  //   "name" => "userName1",
  //   "email" => "UserTest1@gmail.com",
  //   "password" => "123456789"
  // ]));
  $response = $this->put('/api/auth/registration', [
    "name" => "userName1",
    "email" => "UserTest1@gmail.com",
    "password" => "123456789"
  ])->json();
  expect($response)->toBe($awaitingResponse);
})->with('User registered');
