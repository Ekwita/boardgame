<?php

namespace Tests\Feature;

use App\Models\Player;
use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_index(): void
    {
        Player::factory()->count(15)->create();

        $resposne = $this->get(route('playerslist'));

        $resposne->assertStatus(200);
        $resposne->assertViewIs('player.playerslist');
    }

    public function test_newPlayer(): void
    {
        $data = [
            'player_name' => 'RandomName'
        ];

        $response = $this->post(route('newPlayer'), $data);

        $this->assertDatabaseHas('players', $data);
        $response->assertStatus(302);
    }

    public function test_show(): void
    {
        Player::factory()->count(1)->create();

        $testPlayer = Player::first();

        $response = $this->get(route('playershow', [$testPlayer->player_name]));

        $response->assertViewIs('player.playerstatistic');
        // dd($testPlayer->player_name);
        dd($response);
        $response->assertViewHas($testPlayer->player_name);
    }
}
