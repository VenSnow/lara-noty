<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Host;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{

    public function test_guest_user_can_not_see_projects_index_page()
    {
        $response = $this->get(route('projects.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_not_see_projects_show_page()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $host = Host::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->get(route('projects.show', $project->id));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_not_see_projects_create_page()
    {
        $response = $this->get(route('projects.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_user_can_not_see_projects_edit_page()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $host = Host::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->get(route('projects.edit', $project->id));
        $response->assertRedirect(route('login'));
    }

    public function test_auth_user_can_see_projects_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $response = $this->get(route('projects.index'));
        $response->assertOk();
    }

    public function test_auth_user_can_see_projects_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $response = $this->get(route('projects.create'));
        $response->assertOk();
    }

    public function test_auth_user_can_see_own_projects_show_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $host = Host::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->get(route('projects.show', $project->id));
        $response->assertOk();
    }

    public function test_auth_user_can_not_see_another_projects_show_page()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $userOwner->id]);
        $host = Host::factory()->create(['user_id' => $userOwner->id]);
        $project = Project::factory()->create([
            'user_id' => $userOwner,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->get(route('projects.show', $project->id));
        $response->assertStatus(404);
    }

    public function test_auth_user_can_store_projects()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $host = Host::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->make([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->post(route('projects.store'), [
            'name' => $project->name,
            'domain' => $project->domain,
            'client_id' => $client->id,
            'domain_end' => $project->domain_end,
            'host_id' => $host->id,
            'host_end' => $project->host_end,
            'ftp_login' => $project->ftp_login,
            'ftp_password' => $project->ftp_password,
            'db_login' => $project->db_login,
            'db_password' => $project->db_password,
            'comment' => $project->comment,
        ]);
        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('success', 'Проект успешно добавлен');
    }

    public function test_auth_user_can_not_store_projects_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $host = Host::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->post(route('projects.store'), [
            'name' => 'a',
            'domain' => 'b',
            'client_id' => $client->id,
            'domain_end' => 'asdasd',
            'host_id' => $host->id,
            'host_end' => $project->host_end,
            'ftp_login' => $project->ftp_login,
            'ftp_password' => $project->ftp_password,
            'db_login' => $project->db_login,
            'db_password' => $project->db_password,
            'comment' => $project->comment,
        ]);
        $response->assertRedirect(route('dashboard_index'));
    }

    public function test_auth_user_redirect_to_projects_show_when_visit_own_projects_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $host = Host::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->get(route('projects.edit', $project->id));
        $response->assertRedirect(route('projects.show', $project->id));
    }

    public function test_auth_user_can_not_see_projects_edit_of_another_user()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $userOwner->id]);
        $host = Host::factory()->create(['user_id' => $userOwner->id]);
        $project = Project::factory()->create([
            'user_id' => $userOwner,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->get(route('projects.edit', $project->id));
        $response->assertStatus(404);
    }

    public function test_auth_user_can_update_own_projects()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $host = Host::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->patch(route('projects.update', $project->id), [
            'name' => 'New Some Name',
            'domain' => 'New Some Domain',
            'client_id' => $client->id,
            'domain_end' => $project->domain_end,
            'host_id' => $host->id,
            'host_end' => $project->host_end,
            'ftp_login' => $project->ftp_login,
            'ftp_password' => $project->ftp_password,
            'db_login' => $project->db_login,
            'db_password' => $project->db_password,
            'comment' => $project->comment,
        ]);
        $response->assertRedirect(route('projects.show', $project->id));
        $response->assertSessionHas('success', 'Проект успешно изменён');
    }

    public function test_auth_user_can_not_update_another_projects()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $userOwner->id]);
        $host = Host::factory()->create(['user_id' => $userOwner->id]);
        $project = Project::factory()->create([
            'user_id' => $userOwner,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->patch(route('projects.update', $project->id), [
            'name' => 'New Some Name',
            'domain' => 'New Some Domain',
            'client_id' => $client->id,
            'domain_end' => $project->domain_end,
            'host_id' => $host->id,
            'host_end' => $project->host_end,
            'ftp_login' => $project->ftp_login,
            'ftp_password' => $project->ftp_password,
            'db_login' => $project->db_login,
            'db_password' => $project->db_password,
            'comment' => $project->comment,
        ]);
        $response->assertStatus(404);
    }

    public function test_auth_user_can_delete_own_projects()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $host = Host::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->delete(route('projects.destroy', $project->id));
        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('success', 'Проект успешно удалён');
    }

    public function test_auth_user_can_not_delete_another_projects()
    {
        $userOwner = User::factory()->create();
        $userAnother = User::factory()->create();
        $this->actingAs($userAnother);
        $this->assertAuthenticated();
        $client = Client::factory()->create(['user_id' => $userOwner->id]);
        $host = Host::factory()->create(['user_id' => $userOwner->id]);
        $project = Project::factory()->create([
            'user_id' => $userOwner,
            'client_id' => $client->id,
            'host_id' => $host->id
        ]);
        $response = $this->delete(route('projects.destroy', $project->id));
        $response->assertStatus(404);
    }

}
