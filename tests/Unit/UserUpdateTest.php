<?php

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\AuthWrapperService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

// uses(TestCase::class);

uses(TestCase::class, LazilyRefreshDatabase::class);

// test('passes validation if user has been updated"', function() {
//   // $user = User::factory()->create();
//   $validator = Validator::make([
//     'name'=>'UserJohn',
//     'email'=>'john@gmail.com',
//     'password' =>'123456789',
//   ], (new UpdateUserRequest())->rules());
//   $this->assertFalse($validator->fails());
// });

// it('user can be updated', function () {
//   $user = User::factory()->create();
//   $updatedUser = [
//     'name' => 'UserJohn',
//     'email' => 'john@gmail.com',
//     'password' => '123456789',
//   ];
//   $authWrappService = Mockery::mock(AuthWrapperService::class);
//   $authWrappService->shouldReceive('user')->andReturn();
//   $response = $this->putJson('/api/users/'.$user->id, $updatedUser);
//   $response->assertStatus(200);
  // $this->assertDatabaseHas('users', [
  //   'id' => $user->id,
  //   'name' => $updatedUser['name'],
  //   'email' => $updatedUser['email'],
  //   // 'password' => $updatedUser['password'],
  // ]);
// });