<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OauthClientFeatureTest extends TestCase
{
    use RefreshDatabase;

    const REGISTER_URI = 'api/register';

    private array $registerPayload = [
        'userName' => 'pepitoPompin',
        'firstName' => 'Pepe',
        'lastName' => 'Pompin',
        'email' => 'pepitoPompin@email.com',
        'password' => 'password.d123',
    ];


    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_register_oauth_client_should_returns_201()
    {
        $response = $this->postJson(self::REGISTER_URI, $this->registerPayload);

        $response->assertStatus(201);
        $response->assertJson([]);
    }

    public function test_register_oauth_client_with_invalid_request_should_returns_400()
    {
        $payload = [
            'firstName' => '',
            'lastName' => 'Pepe',
            'email' => 'testingMail@mail.com',
            'password' => 'short',
        ];

        $response = $this->postJson(self::REGISTER_URI, $payload);
        $response->assertStatus(400);
        $response->assertJson([
            'error' => [
                'userName' => ['The userName is required.'],
                'firstName' => ['The firstName is required.'],
                'password' => ['The password has to be 8 chars min.'],
            ]
        ]);
    }

}
