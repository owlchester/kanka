<?php

return [
    'actions'   => [
        'status'    => 'Status: :status',
    ],
    'create'    => [
        'helper'    => 'Erstelle eine neue Rolle für die Kampagne.',
    ],
    'overview'  => [
        'limited'   => ':amount der :total erstellter Rollen.',
        'title'     => 'verfügbare Rollen',
        'unlimited' => ':amount der erstellten unbegrenzten Rollen.',
    ],
    'public'    => [],
    'show'      => [
        'title' => ':role Berechtigungen - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Mitglieder der Rolle :role können keine :action :entities mehr ausführen',
        'enabled'   => 'Mitglieder der Rolle :role können jetzt :action :entities',
    ],
    'warnings'  => [
        'adding-to-admin'   => 'Mitglieder der Rolle :name haben Zugriff auf alles in der Kampagne und können nicht von anderen Mitgliedern der Rolle entfernt werden . Nach :amount Minuten können nur sie sich aus der Rolle entfernen.',
    ],
];
