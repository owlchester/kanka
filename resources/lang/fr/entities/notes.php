<?php

return [
    'actions'       => [
        'add'   => 'Ajouter une note',
    ],
    'create'        => [
        'description'   => 'Créer une nouvelle note',
        'success'       => 'Note \':name\' ajoutée à :entity.',
        'title'         => 'Nouvelle Note pour :name',
    ],
    'destroy'       => [
        'success'   => 'La note \':name\' a été retirée.',
    ],
    'edit'          => [
        'description'   => 'Modifier une note existante',
        'success'       => 'La note \':name\' pour :entity a été modifiée.',
        'title'         => 'Modifier la note pour :name',
    ],
    'fields'        => [
        'creator'   => 'Créé par',
        'entry'     => 'Entrée',
        'name'      => 'Nom',
    ],
    'hint'          => 'Les informations qui n\'entrent pas vraiment dans les champs pré-définis ou qui doivent être privées peuvent être ajoutées en tant que Note.',
    'index'         => [
        'title' => 'Notes pour :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la note, observation ou remarque',
    ],
    'show'          => [
        'title' => 'Note d\'entité :name pour :entity',
    ],
];
