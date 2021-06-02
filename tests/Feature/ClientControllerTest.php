<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_user_can_not_see_clients_index_page()
    {
        $response = $this->get(route('clients.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_not_see_clients_show_page()
    {
        $client = Client::factory()->create();
        $response = $this->get(route('clients.show', $client->id));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_not_see_clients_create_page()
    {
        $response = $this->get(route('clients.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_auth_user_can_see_clients_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('clients.index'));
        $response->assertStatus(200);
    }

    public function test_auth_user_can_see_clients_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('clients.create'));
        $response->assertOk();
    }

    public function test_auth_user_can_see_own_clients_show_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $client = Client::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('clients.show', $client->id));
        $response->assertOk();
    }

    public function test_auth_user_can_not_see_another_clients_show_page()
    {
        $userOwner = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $userOwner->id]);
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $response = $this->get(route('clients.show', $client->id));
        $response->assertStatus(404);
    }

    public function test_auth_user_can_store_own_clients()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $client = Client::factory()->make(['user_id' => $user->id]);
        $response = $this->post(route('clients.store'), [
            'user_id' => $user->id,
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
            'email' => $client->email,
            'phone' => $client->phone,
            'comment' => $client->comment,
        ]);
        $response->assertRedirect(route('clients.index'));
        $response->assertSessionHas('success', 'Клиент успешно добавлен');
    }

    public function test_auth_user_can_not_store_own_clients_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $client = Client::factory()->make(['user_id' => $user->id]);
        $response = $this->post(route('clients.store'), [
            'user_id' => $user->id,
            'first_name' => '',
            'last_name' => 'a',
            'email' => 'asdasd',
            'phone' => '123',
            'comment' => $client->comment,
        ]);
        $response->assertRedirect(route('dashboard_index'));
    }

    public function test_auth_user_redirect_to_clients_show_when_visit_own_clients_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $client = Client::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('clients.edit', $client->id));
        $response->assertRedirect(route('clients.show', $client->id));
    }

    public function test_auth_user_can_not_see_clients_edit_of_another_user()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $client = Client::factory()->create(['user_id' => $userOwner->id]);
        $response = $this->get(route('clients.edit', $client->id));
        $response->assertStatus(404);
    }

    public function test_auth_user_can_update_own_clients()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);
        $response = $this->patch(route('clients.update', $client->id), [
            'first_name' => 'another name',
            'last_name' => 'another last name',
            'email' => $client->email,
            'phone' => $client->phone,
            'comment' => $client->comment,
        ]);
        $response->assertRedirect(route('clients.show', $client->id));
        $response->assertSessionHas('success', 'Клиент успешно изменён');
    }

    public function test_auth_user_can_not_update_another_clients()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $userOwner->id]);
        $this->actingAs($userAnother);
        $response = $this->patch(route('clients.update', $client->id), [
            'first_name' => 'another name',
            'last_name' => 'another last name',
            'email' => $client->email,
            'phone' => $client->phone,
            'comment' => $client->comment,
        ]);
        $response->assertStatus(404);
    }

    public function test_auth_user_can_delete_own_clients()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);
        $response = $this->delete(route('clients.destroy', $client->id));
        $response->assertRedirect(route('dashboard_index'));
        $response->assertSessionHas('success', 'Клиент успешно удалён');
    }

    public function test_auth_user_can_not_delete_another_clients()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $userOwner->id]);
        $this->actingAs($userAnother);
        $response = $this->delete(route('clients.destroy', $client->id));
        $response->assertStatus(404);
    }

}
