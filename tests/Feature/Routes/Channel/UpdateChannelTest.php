<?php

namespace Tests\Feature\Routes\Channel;

use Tests\TestCase;
use App\Models\User;
use App\Models\Channel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateChannelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_guest_cannot_update_a_channel(): void
    {
        $channel = Channel::factory()->create();

        $attributes = [
            'name' => 'A channel name'
        ];
        
        $response = $this->patch('api/channels/' . $channel->id, $attributes);

        $response->assertUnauthorized();
    }
}