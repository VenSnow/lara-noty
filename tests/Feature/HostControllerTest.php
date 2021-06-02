<?php

namespace Tests\Feature;

use App\Models\Host;
use App\Models\User;
use Tests\TestCase;

class HostControllerTest extends TestCase
{

    public function test_guest_user_can_not_see_hosts_index_page()
    {
        $response = $this->get(route('hosts.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_not_see_hosts_show_page()
    {
        $user = User::factory()->create();
        $host = Host::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('hosts.show', $host->id));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_not_see_hosts_create_page()
    {
        $response = $this->get(route('hosts.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_not_see_hosts_edit_page()
    {
        $user = User::factory()->create();
        $host = Host::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('hosts.edit', $host->id));
        $response->assertRedirect(route('login'));
    }

    public function test_auth_user_can_see_hosts_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $response = $this->get(route('hosts.index'));
        $response->assertOk();
    }

    public function test_auth_user_can_see_hosts_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $response = $this->get(route('hosts.create'));
        $response->assertOk();
    }

    public function test_auth_user_can_see_own_hosts_show_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $host = Host::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('hosts.show', $host->id));
        $response->assertOk();
    }

    public function test_auth_user_can_not_see_another_hosts_show_page()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $this->assertAuthenticated();
        $host = Host::factory()->create(['user_id' => $userOwner->id]);
        $response = $this->get(route('hosts.show', $host->id));
        $response->assertStatus(404);
    }

    public function test_auth_user_can_store_hosts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $host = Host::factory()->make(['user_id' => $user->id]);
        $response = $this->post(route('hosts.store'), [
            'name' => $host->name,
            'address' => $host->address,
            'host_login' => $host->host_login,
            'host_password' => $host->host_password,
            'comment' => $host->comment,
        ]);
        $response->assertRedirect(route('hosts.index'));
        $response->assertSessionHas('success', 'Хост успешно добавлен');
    }

    public function test_auth_user_can_not_store_hosts_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $host = Host::factory()->make(['user_id' => $user->id]);
        $response = $this->post(route('hosts.store'), [
            'user_id' => $host->user_id,
            'name' => 'a',
            'address' => 'b',
            'host_login' => 'c',
            'host_password' => 'd',
            'comment' => $host->comment,
        ]);
        $response->assertRedirect(route('dashboard_index'));
    }

    public function test_auth_user_redirect_to_hosts_show_when_visit_own_hosts_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $host = Host::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('hosts.edit', $host->id));
        $response->assertRedirect(route('hosts.show', $host->id));
    }

    public function test_auth_user_can_not_see_hosts_edit_of_another_user()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $this->assertAuthenticated();
        $host = Host::factory()->create(['user_id' => $userOwner->id]);
        $response = $this->get(route('hosts.edit', $host->id));
        $response->assertStatus(404);
    }

    public function test_auth_user_can_update_own_hosts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $host = Host::factory()->create(['user_id' => $user->id]);
        $response = $this->patch(route('hosts.update', $host->id), [
            'name' => 'New Name',
            'address' => 'New Address',
            'host_login' => $host->host_login,
            'host_password' => $host->host_password,
            'comment' => $host->comment,
        ]);
        $response->assertRedirect(route('hosts.show', $host->id));
        $response->assertSessionHas('success', 'Хост успешно изменён');
    }

    public function test_auth_user_can_not_update_another_hosts()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $host = Host::factory()->create(['user_id' => $userOwner->id]);
        $this->actingAs($userAnother);
        $this->assertAuthenticated();
        $response = $this->patch(route('hosts.update', $host->id), [
            'name' => 'New Name',
            'address' => 'New Address',
            'host_login' => $host->host_login,
            'host_password' => $host->host_password,
            'comment' => $host->comment,
        ]);
        $response->assertStatus(404);
    }

    public function test_auth_user_can_delete_own_hosts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $host = Host::factory()->create(['user_id' => $user->id]);
        $response = $this->delete(route('hosts.destroy', $host->id));
        $response->assertRedirect(route('hosts.index'));
        $response->assertSessionHas('success', 'Хост успешно удалён');
    }

    public function test_auth_user_can_not_delete_another_hosts()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $this->assertAuthenticated();
        $host = Host::factory()->create(['user_id' => $userOwner->id]);
        $response = $this->delete(route('hosts.destroy', $host->id));
        $response->assertStatus(404);
    }

}
