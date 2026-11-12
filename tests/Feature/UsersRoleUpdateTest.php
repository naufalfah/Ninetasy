<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersRoleUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_a_users_role_without_resubmitting_other_fields(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'admin',
        ]);
    }

    public function test_admin_cannot_assign_an_unknown_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'role' => 'unknown',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'user',
        ]);
    }
}
