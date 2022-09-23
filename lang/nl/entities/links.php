<?php

return [
    'actions'       => [
        'add'   => 'Voeg een link toe',
    ],
    'create'        => [
        'success'   => 'Link :name toegevoegd aan :entity.',
        'title'     => 'Voeg een link toe aan :name',
    ],
    'destroy'       => [
        'success'   => 'Link :name verwijderd van :entity.',
    ],
    'fields'        => [
        'icon'      => 'Pictogram',
        'name'      => 'Naam',
        'position'  => 'Positie',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'icon'  => 'Je kunt het pictogram dat voor de link wordt weergegeven, aanpassen. Gebruik een van de gratis pictogrammen van :fontawesome of laat dit veld leeg als standaard.',
    ],
    'placeholders'  => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'Boosted campaigns kunnen links toevoegen aan entiteiten die naar externe websites verwijzen.',
        'title'     => 'Links voor :name',
    ],
    'update'        => [
        'success'   => 'Link :name bijgewerkt voor :entity',
        'title'     => 'Werk link bij voor :name',
    ],
];
