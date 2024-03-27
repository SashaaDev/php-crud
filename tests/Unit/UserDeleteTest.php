<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

// Test('passes validation if user can be deleted', function () {
//   $user = User::factory()->create();
//   $response = $this->deleteJson("/api/users/{$user->id}");
//   // $response = $this->deleteJson('/api/users/' . $user->id);
//   $response->assertStatus(200);
//   $this->assertDatabaseMissing('users',['id'=> $user->id]);
//   $this->assertCount(0, User::all());
// });
it('user can be deleted', function () {
  $user = User::factory()->create();
  $response = $this->deleteJson("/api/users/{$user->id}");
  $response->assertStatus(200);
  $this->assertDatabaseMissing('users',['id'=> $user->id]);
  $this->assertCount(0, User::all());
});