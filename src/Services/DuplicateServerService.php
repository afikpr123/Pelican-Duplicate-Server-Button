<?php

namespace Dipsy\DuplicateServer\Services;

use App\Models\Server;
use App\Services\Servers\ServerCreationService;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DuplicateServerService
{
    public function duplicate(int $sourceServerId, int $allocationId, ?string $newName = null): int
    {
        $source = Server::query()->find($sourceServerId);

        if (!$source) {
            throw new RuntimeException('Source server was not found.');
        }

        $allocation = DB::table('allocations')->where('id', $allocationId)->first();

        if (!$allocation) {
            throw new RuntimeException('Allocation was not found.');
        }

        if (!empty($allocation->server_id)) {
            throw new RuntimeException('This allocation is already assigned to another server.');
        }

        if ((int) $allocation->node_id !== (int) $source->node_id) {
            throw new RuntimeException('The allocation must be on the same node as the source server.');
        }

        $environment = DB::table('server_variables')
            ->where('server_id', $source->id)
            ->join('egg_variables', 'server_variables.variable_id', '=', 'egg_variables.id')
            ->pluck('server_variables.variable_value', 'egg_variables.env_variable')
            ->toArray();

        $data = [
            'external_id' => null,
            'name' => $newName ?: ($source->name . ' Copy'),
            'description' => $source->description ?? '',
            'node_id' => $source->node_id,
            'owner_id' => $source->owner_id,
            'allocation_id' => $allocationId,
            'egg_id' => $source->egg_id,
            'startup' => $source->startup,
            'image' => $source->image,
            'database_limit' => $source->database_limit ?? 0,
            'allocation_limit' => $source->allocation_limit ?? 0,
            'backup_limit' => $source->backup_limit ?? 0,
            'memory' => $source->memory,
            'swap' => $source->swap,
            'disk' => $source->disk,
            'io' => $source->io,
            'cpu' => $source->cpu,
            'threads' => $source->threads,
            'oom_killer' => $source->oom_killer ?? false,
            'skip_scripts' => $source->skip_scripts ?? false,
            'environment' => $environment,
            'start_on_completion' => false,
        ];

        $newServer = app(ServerCreationService::class)->handle($data);


        return $newServer->id;
    }
}
