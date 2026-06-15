<?php

namespace Dipsy\DuplicateServer\Filament\Admin\Pages;

use Dipsy\DuplicateServer\Services\DuplicateServerService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class DuplicateServer extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'tabler-copy';
    protected static ?string $navigationLabel = 'Duplicate Server';
    protected static ?string $title = 'Duplicate Server';
    protected static ?string $slug = 'duplicate-server';
    protected string $view = 'duplicate-server::filament.admin.pages.duplicate-server';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('source_server_id')
                ->label('Source Server')
                ->searchable()
                ->required()
                ->options(fn () => DB::table('servers')
                    ->orderBy('name')
                    ->limit(500)
                    ->pluck('name', 'id')
                    ->toArray())
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
    if (!$state) {
        $set('new_name', null);
        return;
    }

    $name = DB::table('servers')->where('id', $state)->value('name');

    if ($name) {
        $set('new_name', $name . ' Copy');
    }
}),

            Select::make('allocation_id')
                ->label('Free Allocation')
                ->helperText('Must be a free allocation on the same node as the source server.')
                ->searchable()
                ->required()
                ->options(function (callable $get) {
                    $sourceServerId = $get('source_server_id');
                    if (!$sourceServerId) {
                        return [];
                    }

                    $source = DB::table('servers')->where('id', $sourceServerId)->first();
                    if (!$source) {
                        return [];
                    }

                    return DB::table('allocations')
                        ->whereNull('server_id')
                        ->where('node_id', $source->node_id)
                        ->orderBy('ip')
                        ->orderBy('port')
                        ->limit(500)
                        ->get()
                        ->mapWithKeys(fn ($allocation) => [
                              $allocation->id => $allocation->ip . ':' . $allocation->port,
                        ])
                        ->toArray();
                }),

            TextInput::make('new_name')
                ->label('New Server Name')
                ->placeholder('Leave empty to use: Source Name Copy')
                ->maxLength(191),
        ];
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function duplicate(): void
    {
        $state = $this->form->getState();

        try {
            $newServerId = app(DuplicateServerService::class)->duplicate(
                (int) $state['source_server_id'],
                (int) $state['allocation_id'],
                $state['new_name'] ?: null,
            );

            Notification::make()
                ->title('Server duplicated')
                ->body('New server ID: ' . $newServerId)
                ->success()
                ->send();

            $this->form->fill();
        } catch (\Throwable $exception) {
            Notification::make()
                ->title('Duplicate failed')
                ->body($exception->getMessage())
                ->danger()
                ->send();
        }
    }
}
