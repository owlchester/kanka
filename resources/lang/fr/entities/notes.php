<?php

return [
    'actions'       => [
        'add'       => 'Ajouter une note',
        'add_user'  => 'Ajouter un membre',
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
        'is_pinned' => 'Épinglé',
        'name'      => 'Nom',
        'position'  => 'Position épinglée',
    ],
    'hint'          => 'Les informations qui n\'entrent pas vraiment dans les champs pré-définis ou qui doivent être privées peuvent être ajoutées en tant que Note.',
    'hints'         => [
        'is_pinned' => 'Les notes d\'entités épinglées sont affichées sous le text d\'une entité. Le champ position épinglé permet de contrôler dans quel ordre les notes sont affichées.',
    ],
    'index'         => [
        'title' => 'Notes pour :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la note, observation ou remarque',
    ],
    'show'          => [
        'advanced'  => 'Permissions Avancées',
        'title'     => 'Note d\'entité :name pour :entity',
    ],
];
