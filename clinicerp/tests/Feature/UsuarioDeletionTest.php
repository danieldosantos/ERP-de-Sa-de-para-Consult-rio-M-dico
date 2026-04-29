<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_usuario_also_deletes_linked_user(): void
    {
        $adminUser = User::factory()->create();
        Usuario::factory()->create([
            'user_id' => $adminUser->id,
            'email' => $adminUser->email,
            'is_admin' => true,
        ]);

        $targetUser = User::factory()->create();
        $targetUsuario = Usuario::factory()->create([
            'user_id' => $targetUser->id,
            'email' => $targetUser->email,
            'is_admin' => false,
        ]);

        $this->actingAs($adminUser)
            ->delete(route('usuarios.destroy', $targetUsuario))
            ->assertRedirect(route('usuarios.index'));

        $this->assertDatabaseMissing('usuarios', ['id' => $targetUsuario->id]);
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }
}
