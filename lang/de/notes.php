<?php

return [
    'create'        => [
        'title' => 'Erstelle eine neue Notiz',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'untergeordnete Notiz',
    ],
    'helpers'       => [
        'nested_without'    => 'Anzeigen aller Notizen ohne übergeordnete Notiz. Klicken Sie auf eine Zeile, um die untergeordneten Notizen anzuzeigen.',
    ],
    'hints'         => [
        'is_pinned' => 'Bis zu 3 Notizen können angepinnt werden und werden dann auf dem Dashboard angezeigt.',
    ],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Wähle eine übergeordnete Notiz',
        'type'  => 'Religion, Spezies, Politisches System',
    ],
    'show'          => [],
];
