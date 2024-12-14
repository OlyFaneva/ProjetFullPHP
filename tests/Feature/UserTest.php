<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_successful()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $payload = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // Act
        $response = $this->postJson('/api/login', $payload);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'message',
        ]);
    }

    public function test_login_failure()
    {
        // Arrange
        $payload = [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ];

        // Act
        $response = $this->postJson('/api/login', $payload);

        // Assert
        $response->assertStatus(200); // Adjust to your error status code if different
        $response->assertJson([
            'message' => 'Wrong credentials',
        ]);
    }

    public function test_registration_successful()
    {
        // Arrange
        $payload = [
            'email' => 'test@example.com',
            'password' => 'password123',
            'name' => 'John Doe',
        ];

        // Act
        $response = $this->postJson('/api/registration', $payload);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'message' => "you're connected",
        ]);
    }

    public function test_registration_validation_failure()
    {
        // Arrange
        $payload = [
            'email' => '',
            'password' => '',
            'name' => '',
        ];

        // Act
        $response = $this->postJson('/api/registration', $payload);

        // Assert
        $response->assertStatus(422); // Change this to match your validation error status
        $response->assertJsonStructure([
            'message',
        ]);
    }
}
