<?php

return [
    'actions'       => [
        'mode-map'      => 'Outil de visualisation des relations',
        'mode-table'    => 'Table des relations et connexions',
    ],
    'bulk'          => [
        'delete'    => '{1} :count relation supprimée.|[2,*] :count relations supprimées.',
        'success'   => [
            'editing'           => '{1} :count relation modifiée.|[2,*] :count relations modifiées.',
            'editing_partial'   => '{1} :count/:total relation modifiée.|[2,*] :count/:total relations modifiées.',
        ],
    ],
    'connections'   => [
        'map_point'         => 'Point de carte',
        'mention'           => 'Mention',
        'quest_element'     => 'Élément de quête',
        'timeline_element'  => 'Élément de timeline',
    ],
    'create'        => [
        'new_title' => 'Nouvelle relation',
        'success'   => 'Relation :target ajoutée pour :entity.',
        'title'     => 'Nouvelle relation pour :name',
    ],
    'destroy'       => [
        'success'   => 'Relation :target supprimée pour :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Attitude',
        'connection'        => 'Connexion',
        'is_star'           => 'Epinglé',
        'owner'             => 'Source',
        'relation'          => 'Relation',
        'target'            => 'Cible',
        'target_relation'   => 'Relation de la cible',
        'two_way'           => 'Créer une relation miroir',
    ],
    'helper'        => 'Définir des relations entre entités avec leurs description, attitude et visibilité. Les relations peuvent aussi être épinglées sur le menu de l\'entité.',
    'helpers'       => [
        'no_relations'  => 'Cette entité n\'a actuellement aucune relation vers d\'autres entités de la campagne.',
        'popup'         => 'Les entités de la campagne peuvent être lié entre elles en utilisant des relations. Celles-ci peuvent avoir une description, une évaluation de relation, un control de visibilité, et plus.',
    ],
    'hints'         => [
        'attitude'          => 'Ce champ optionnel peut être utilisé pour définir l\'ordre ascendant dans lequel s\'affichent les relations.',
        'mirrored'          => [
            'text'  => 'Cette relation est liée avec :link.',
            'title' => 'Lié',
        ],
        'target_relation'   => 'La description de la relation sur la cible. Laisser vide pour utiliser la même relation pour la cible.',
        'two_way'           => 'Sélectionne pour créer une copie de la relation sur la cible.',
    ],
    'index'         => [
        'add'   => 'Nouvelle relation',
        'title' => 'Relations',
    ],
    'options'       => [
        'mentions'  => 'Relations + liés + mentions',
        'related'   => 'Relations + liés',
        'relations' => 'Relations',
        'show'      => 'Afficher',
    ],
    'panels'        => [
        'related'   => 'Liés',
    ],
    'placeholders'  => [
        'attitude'  => 'de -100 à 100, 100 étant très positif.',
        'relation'  => 'Nature de la relation',
        'target'    => 'Choix d\'un élément',
    ],
    'show'          => [
        'title' => 'Relations de :name',
    ],
    'teaser'        => 'Les campagnes boostées ont accès à l\'explorateur de relation. Cliquer pour en savoir plus sur les campagnes boostées.',
    'types'         => [
        'family_member'         => 'Membre de famille',
        'organisation_member'   => 'Membre d\'organisation',
    ],
    'update'        => [
        'success'   => 'Relation :target modifiée pour :entity.',
        'title'     => 'Modifier la relation de :name',
    ],
];
