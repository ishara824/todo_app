<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserStoryThreeDeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        //$login_api = $this->postJson('api/login', ['email' => 'user2@user.com', 'password' => '12345678']);

        //$token = $login_api->json('data.data.token');
        //$token = $login_api->json('data.data.token');

        $response = $this
            ->postJson('api/delete/todo',['item_id' => '6'])
            ->withHeaders(['Authorization' => 'Bearer '.'61|yNGlWML9QilM1unjsDOlojDJLXc1lvp0na1r4XL3'])
            ->assertStatus(200);

    }
}
