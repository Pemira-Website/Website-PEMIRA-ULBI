<?php

namespace Tests\Unit;

use App\Filament\Pages\GenerateKodePage;
use Carbon\Carbon;
use Tests\TestCase;

class GenerateKodePageTest extends TestCase
{
    public function test_expiry_display_uses_wib_for_asia_jakarta_timezone(): void
    {
        config(['app.timezone' => 'Asia/Jakarta']);

        $expiresAt = Carbon::parse('2026-03-31 06:40:37', 'UTC');

        $this->assertSame('13:40:37 WIB', GenerateKodePage::formatExpiryForDisplay($expiresAt));
    }

    public function test_expiry_display_uses_current_app_timezone_label_for_non_wib_timezone(): void
    {
        config(['app.timezone' => 'UTC']);

        $expiresAt = Carbon::parse('2026-03-31 06:40:37', 'UTC');

        $this->assertSame('06:40:37 UTC', GenerateKodePage::formatExpiryForDisplay($expiresAt));
    }
}
