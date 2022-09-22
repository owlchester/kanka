<?php

return [
    'actions'   => [
        'status'    => 'Status: :status',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'Die Kampagne ist derzeit privat.',
            'public'    => 'Die Kampagne ist derzeit öffentlich.',
        ],
        'description'   => 'Lege die Berechtigungen für die öffentliche Rolle fest, um die folgenden Objekte der Kampagne anzuzeigen. Ein Benutzer ist automatisch in der öffentlichen Rolle, wenn er die Kampagne anzeigt, aber kein Mitglied ist.',
        'test'          => 'Um die Berechtigungen der öffentlichen Rolle zu testen, öffne die URL der Kampagne in einem Inkognito-Fenster.',
    ],
    'show'      => [
        'title' => ':role Berechtigungen - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Mitglieder der Rolle :role können keine :action :entities mehr ausführen',
        'enabled'   => 'Mitglieder der Rolle :role können jetzt :action :entities',
    ],
];
