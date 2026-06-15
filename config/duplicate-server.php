<?php

return [
    // Server columns copied from the source server into the clone.
    // The service only copies columns that actually exist in your database.
    'server_columns' => [
        'external_id',
        'name',
        'description',
        'owner_id',
        'node_id',
        'nest_id',
        'egg_id',
        'startup',
        'skip_scripts',
        'image',
        'database_limit',
        'allocation_limit',
        'backup_limit',
        'memory',
        'swap',
        'disk',
        'io',
        'cpu',
        'threads',
        'oom_disabled',
    ],

    // Tables copied by server_id after the new server is created.
    // The service checks if each table exists before copying.
    'copy_related_tables' => [
        'server_variables',
        'server_mounts',
    ],

    // Keep false for first test. File copy depends on your Wings/node layout.
    'enable_file_copy' => false,
];
