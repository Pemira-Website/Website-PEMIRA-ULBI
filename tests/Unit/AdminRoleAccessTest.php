<?php

namespace Tests\Unit;

use App\Filament\Pages\GenerateKodePage;
use App\Filament\Resources\PaslonResource;
use App\Filament\Resources\PemilihResource;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_only_access_generate_kode_page(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]));

        $this->assertTrue(GenerateKodePage::canAccess());
        $this->assertFalse(PaslonResource::canAccess());
        $this->assertFalse(PemilihResource::canAccess());
        $this->assertFalse(UserResource::canAccess());
    }

    public function test_super_admin_can_access_all_admin_features(): void
    {
        $this->actingAs(User::factory()->superAdmin()->create());

        $this->assertTrue(GenerateKodePage::canAccess());
        $this->assertTrue(PaslonResource::canAccess());
        $this->assertTrue(PemilihResource::canAccess());
        $this->assertTrue(UserResource::canAccess());
    }
}
