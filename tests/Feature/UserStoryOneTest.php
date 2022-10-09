<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserStoryOneTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->postJson('api/register', ['first_name' => 'Mr.Test', 'last_name' => 'Bernard', 'email' => 'bernard@user.com', 'phone_number' => '1234567890', 'password' => '12345678', 'confirm_password' => '12345678']);

        $response->assertStatus(200);
    }
}
