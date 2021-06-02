<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index_guest_ok()
    {
        $response = $this->get(route('login'));
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function test_index_user_fail()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)->get(route('login'));
        $response->assertRedirect(route('dashboard_index'));
    }

    public function test_login_guest_ok()
    {
        $user = User::factory()->create();

//        $hasUser = $user ? true : false;

//        $this->assertTrue($user);

        $this->actingAs($user);

        $this->assertAuthenticated();

    }

}
