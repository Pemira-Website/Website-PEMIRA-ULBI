<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function mount(): void
    {
        if (auth()->user() instanceof User && auth()->user()->isAdmin()) {
            $this->redirect(GenerateKodePage::getUrl());
        }
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user() instanceof User && auth()->user()->isSuperAdmin();
    }
}
