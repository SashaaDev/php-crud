<?php

use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;


test('can create a user', function ($createdUser, array $awaitingResponse) {
  $user = Mockery::mock(User::class);
  $builder = Mockery::mock(Builder::class);
  $user->shouldReceive('query')->andReturn($builder);
  $builder->shouldReceive('create')->andReturn($createdUser);
  $this->app->instance(UserRepository::class, new UserRepository($user, app(AvatarRepository::class)));
  $response = $this->post('/api/users', $createdUser->toArray())->json();
  // dd($response,$awaitingResponse);
  expect($response)->toBe($awaitingResponse);
})->with('User created');

