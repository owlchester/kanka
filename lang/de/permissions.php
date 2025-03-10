<?php

return [
    'helpers'   => [
        'delete'    => 'Erlaubnis zum Löschen dieses Elements',
        'edit'      => 'Erlaubnis, dieses Element zu bearbeiten',
        'view'      => 'Erlaubnis zur Ansicht dieses Elements',
    ],
    'members'   => [
        'inherited' => ':member kann dies bereits tun, indem es Teil der :role-Rolle ist.',
    ],
    'roles'     => [
        'inherited' => 'Die :role-Rolle kann dies bereits für das gesamte :module-Modul tun.',
    ],
];
