<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LibraryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_requires_valid_credentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrong',
        ]);

        $response->assertStatus(422);
    }

    public function test_unauthenticated_user_cannot_access_books(): void
    {
        $this->getJson('/api/books')->assertStatus(401);
    }
}
