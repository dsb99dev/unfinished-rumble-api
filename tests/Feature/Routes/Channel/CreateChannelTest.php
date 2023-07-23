<?php

namespace Tests\Feature\Routes\Channel;

use Tests\TestCase;
use App\Models\User;
use App\Models\Channel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateChannelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_guest_cannot_create_a_channel(): void
    {
        $attributes = [
            'url' => 'https://rumble.com/c/tateconfidential'
        ];

        $response = $this->post('api/channels', $attributes);

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function a_user_cannot_create_a_channel(): void
    {
        $user = User::factory()->create();

        $attributes = [
            'url' => 'https://rumble.com/c/tateconfidential'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode($user->email . ':' . 'Abc123000!'),
        ])->post('/api/channels', $attributes);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function an_admin_can_create_a_channel_with_a_valid_url(): void
    {
        $user = User::factory()->create([
            'is_admin' => true
        ]);

        $attributes = [
            'url' => 'https://rumble.com/c/tateconfidential'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode($user->email . ':' . 'Abc123000!'),
        ])->post('/api/channels', $attributes);

        $response->assertCreated();
    }
}