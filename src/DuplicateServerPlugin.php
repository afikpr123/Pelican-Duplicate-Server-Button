<?php

namespace Dipsy\DuplicateServer;

use Filament\Contracts\Plugin;
use Filament\Panel;

class DuplicateServerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'duplicate-server';
    }

    public function register(Panel $panel): void
    {
        if ($panel->getId() !== 'admin') {
            return;
        }

        $panel->discoverPages(
            plugin_path($this->getId(), 'src/Filament/Admin/Pages'),
            'Dipsy\\DuplicateServer\\Filament\\Admin\\Pages'
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }
}