<?php

use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

use function Pest\Laravel\postJson;

uses(TestCase::class, RefreshDatabase::class);

beforeAll(function () {
  dump('Testing User Model!');
});

// beforeEach(function () {
//   dump('Testing...');
// });

afterAll(function () {
  dump('Done Testing User Model!');
});

// afterEach(function () {
//   dump('Done Testing.');
// });

// it('can update a user', function () {
//   $user = User::factory()->create();
//   $response = $this->putJson('/api/users/' . $user->id, []);
// });

// it('can create a user', function () {
//   // $user = User::factory()->raw();
//   // $response = $this->postJson('/api/posts', $user);
//   // $response->assertStatus(201)->assertJson();
//   // $this->assertDatabaseHas('posts', $user);
//   $user = [
//     'name' => 'UserTest',
//     'email' => 'test222222222222@example.com',
//     'password' => '222222222',
//   ];
//   $response = $this->postJson('/api/users', $user);
//   $response->assertStatus(200)->assertJson([
//     'id' => 1,
//     'name' => $user['name'],
//     'email' => $user['email'],
//   ]);
//   $this->assertDatabaseHas('users', [
//     'id' => 1,
//     'name' => $user['name'],
//     'email' => $user['email'],
//   ]);
// });



// it('passes validation with valid data', function () {
//   $validator = Validator::make([
//     'name' => 'JohnDoe',
//     'email' => 'john@example.com',
//     'password' => 'password123',
//   ], (new UserCreateRequest())->rules());

//   $this->assertFalse($validator->fails());
// });

// it('fails validation if name has symbols', function () {
//   $validator = Validator::make(['name' => '%##%'], (new UserCreateRequest())->rules());
//   $this->assertTrue($validator->fails());
//   // $this->assertArrayHasKey('name', $validator->errors()->toArray());
//   $this->assertSame('The name field must only contain letters and numbers.', $validator->errors()->first('name'));
// });
// it ('fails validation if name has symbols', function () {
//   $validator = Validator::make(['name' => '%##%'], (new UserCreateRequest())->rules());
//   $this->assertTrue($validator->fails());
//   $this->assertArrayHasKey('name', $validator->errors()->toArray());
// });

// it('fails validation if name is too short', function () {
//   $validator = Validator::make(['name' => 'J'], (new UserCreateRequest())->rules());

//   $this->assertTrue($validator->fails());
//   $this->assertArrayHasKey('name', $validator->errors()->toArray());
// });

// it('fails validation if name is too long', function () {
//   $validator = Validator::make(['name' => str_repeat('a', 21)], (new UserCreateRequest())->rules());

//   $this->assertTrue($validator->fails());
//   $this->assertArrayHasKey('name', $validator->errors()->toArray());
// });

// it('fails validation if email is invalid', function () {
//   $validator = Validator::make(['email' => 'johngmail'], (new UserCreateRequest())->rules());
//   $this->assertTrue($validator->fails());
//   $this->assertArrayHasKey('email', $validator->errors()->toArray());
// });

// it('fails validation if email is already created', function () {
//   // Создаем пользователя с определенным email
//   $user = User::factory()->create([
//     'email' => 'user@example.com',
//   ]);

//   $validator = Validator::make(['email' => 'user@example.com'], (new UserCreateRequest())->rules());

//   $this->assertTrue($validator->fails());
//   $this->assertArrayHasKey('email', $validator->errors()->toArray());
// });



// it('fails validation if email is null', function () {
//   $validator = Validator::make(['email' => null], (new UserCreateRequest())->rules());
//   $this->assertTrue($validator->fails());
//   $this->assertArrayHasKey('email', $validator->errors()->toArray());
// });

// it('fails validation if password is too short', function () {
//   $validator = Validator::make(['password' => '123456'], (new UserCreateRequest())->rules());
//   $this->assertTrue($validator->fails());
//   $this->assertArrayHasKey('password', $validator->errors()->toArray());
// });

// it('fails validation if password is not string', function () {
//   $validator = Validator::make(['password' => 33333333333333333], (new UserCreateRequest())->rules());
//   $this->assertTrue($validator->fails());
//   $this->assertArrayHasKey('password', $validator->errors()->toArray());
// });