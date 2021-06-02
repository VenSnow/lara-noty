<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelpTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function test_authUser()
    {
        $user = User::factory()->create();
        $response = $this->post(route('login'), [
            'name' => $user->name,
            'password' => 'test',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect('/');

    }

    public function test_notAuthUser()
    {
        $user = User::factory()->create();
        $response = $this->post(route('login'), [
            'name' => $user->name,
            'password' => 'asdasd',
        ]);
        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status', 'Неверный логин или пароль');
    }
}
