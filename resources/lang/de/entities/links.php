<?php

return [
    'actions'       => [
        'add'   => 'Link hinzufügen',
    ],
    'create'        => [
        'success'   => 'Link :name hinzugefügt zu :entity.',
        'title'     => 'Fügen Sie einen Link hinzu zu :name',
    ],
    'destroy'       => [
        'success'   => 'Link :name entfernt von :entity.',
    ],
    'fields'        => [
        'icon'      => 'Symbol',
        'name'      => 'Name',
        'position'  => 'Position',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'goto'      => 'gehe zu :name',
        'icon'      => 'Sie können das für den Link angezeigte Symbol anpassen. Verwenden Sie eines der kostenlosen Symbole von :fontawesome oder lassen Sie dieses Feld für die Standardeinstellung leer.',
        'leaving'   => 'Sie verlassen Kanka und wechseln zu einer anderen Domain. Die Seite, die Sie verlassen, wurde von einem Benutzer bereitgestellt und wird von unserer Website nicht überprüft.',
        'url'       => 'Die URL, zu der Sie gehen, lautet :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'Durch geboostete Kampagnen können Links zu Objekten hinzufügen, die auf externe Websites verweisen.',
        'title'     => 'Links für :name',
    ],
    'unboosted'     => [
        'text'  => 'Das Hinzufügen von Links zu externen Ressourcen, die direkt im Objekt angezeigt werden, ist :boosted-campaigns vorbehalten.',
        'title' => 'Boosted Kampagnenfunktion',
    ],
    'update'        => [
        'success'   => 'Link :name aktualisiert für :entity.',
        'title'     => 'Link aktualisieren für :name',
    ],
];
