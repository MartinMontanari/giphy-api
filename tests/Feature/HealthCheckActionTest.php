<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthCheckActionTest extends TestCase
{
    use RefreshDatabase;

    const HEALTH_URI = 'api/health';

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    public function test_the_health_check_returns_healthy(): void
    {
        $response = $this->get(self::HEALTH_URI);

        $response->assertStatus(200);
        $response->assertJson(["status" => "Healthy", "message" => "API is up and running!"]);
    }
}
