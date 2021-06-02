<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function test_login_page()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function test_user_login()
    {
        $user = User::factory()->create();
        $response = $this->post(route('login'), [
            'name' => $user->name,
            'password' => 'test',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect('/');

    }

    public function test_login_user_with_invalid_data()
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

    public function test_user_logout()
    {
        $user = User::factory()->create();
        $this->post(route('login'), [
            'name' => $user->name,
            'password' => 'test',
        ]);
        $this->assertAuthenticated();
        $response = $this->get(route('logout'));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_see_registration_page()
    {
        $response = $this->get(route('register'));
        $response->assertOk();
    }

    public function test_auth_user_can_not_see_registration_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $response = $this->get(route('register'));
        $response->assertRedirect(route('dashboard_index'));
    }

    public function test_user_registration()
    {
        $user = User::factory()->make();
        $response = $this->post(route('register'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmed' => $user->password,
        ]);
        $response->assertRedirect(route('dashboard_index'));
    }

}
