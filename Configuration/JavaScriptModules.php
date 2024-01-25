<?php

$extensionKey = 'site_setup';

return [
    'dependencies' => [
        'backend',
    ],
    'tags' => [
        'backend.form',
    ],
    'imports' => [
        '@creifenscheid/' . str_replace('_', '-', $extensionKey) . '/' => 'EXT:' . $extensionKey . '/Resources/Public/JavaScript/',
    ],
];
