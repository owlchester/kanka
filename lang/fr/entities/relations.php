<?php

return [
    'actions'           => [
        'mode-map'      => 'Outil de visualisation des relations',
        'mode-table'    => 'Table des relations et relation',
    ],
    'bulk'              => [
        'delete'    => '{1} :count relation supprimée.|[2,*] :count relations supprimées.',
        'fields'    => [
            'delete_mirrored'   => 'Supprimer la relation liée',
            'unmirror'          => 'Délier la relation',
            'update_mirrored'   => 'Actualiser la relation liée',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Aussi supprimer les relations liées.',
            'unmirror'          => 'Délier les relations liées.',
            'update_mirrored'   => 'Actualiser les relations liées.',
        ],
        'success'   => [
            'editing'           => '{1} :count relation modifiée.|[2,*] :count relations modifiées.',
            'editing_partial'   => '{1} :count/:total relation modifiée.|[2,*] :count/:total relations modifiées.',
        ],
    ],
    'call-to-action'    => 'Explorer visuellement les relations d\'une entrée et la manière dont elle est connectée au reste de la campagne.',
    'connections'       => [
        'map_point'         => 'Point de carte',
        'mention'           => 'Mention',
        'quest_element'     => 'Élément de quête',
        'timeline_element'  => 'Élément de timeline',
    ],
    'create'            => [
        'helper'        => 'Créer un lien entre :name et une ou plusieurs entrées.',
        'new_title'     => 'Nouvelle relation',
        'success_bulk'  => '{1} Ajout de :count relation à :entity.|[2,*] Ajout de :count relations à :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'Cette relation est dupliquée sur l\'entrée cible. Sélectionner cette option pour aussi supprimer la relation symétrique.',
        'option'    => 'Supprimer la relation miroir',
    ],
    'destroy'           => [
        'mirrored'  => 'Ceci supprimera aussi la relation liée et est permanent.',
        'success'   => 'Relation :target supprimée pour :entity.',
    ],
    'fields'            => [
        'attitude'          => 'Attitude',
        'is_pinned'         => 'Épinglé',
        'link'              => 'Lien réciproque',
        'mirror_relation'   => 'Rôle réciproque',
        'owner'             => 'Source',
        'role'              => 'Rôle',
        'target'            => 'Cible',
        'targets'           => 'Cibles',
        'two_way'           => 'Créer une relation miroir',
        'unmirror'          => 'Délier cette relation de la relation miroir.',
    ],
    'filters'           => [
        'connection'    => 'Relation de la relation',
        'name'          => 'Cible de la relation',
    ],
    'helper'            => 'Définir des relations entre entrées avec leurs description, attitude et visibilité. Les relations peuvent aussi être épinglées sur le menu de l\'entrée.',
    'helpers'           => [
        'description'       => 'Détailler la nature du lien entre les deux entrées.',
        'link'              => 'Créer une relation correspondante sur les cibles.',
        'mirror_relation'   => 'Comment la cible voit cette entrée (laisser vide pour copier ci-dessus).',
        'no_relations'      => 'Cette entrée n\'a actuellement aucune relation vers d\'autres entrées de la campagne.',
    ],
    'hints'             => [
        'attitude'  => 'Ce champ optionnel peut être utilisé pour définir l\'ordre ascendant dans lequel s\'affichent les relations.',
        'two_way'   => 'Sélectionne pour créer une copie de la relation sur la cible.',
    ],
    'index'             => [
        'title' => 'Relations',
    ],
    'linked'            => [
        'break'             => 'Rompre le lien',
        'helper'            => 'Cette relation est synchronisée avec :link',
        'label'             => 'Relation liée',
        'unmirror-helper'   => 'Convertir en relation indépendante ne supprimera rien.',
    ],
    'options'           => [
        'mentions'          => 'Défaut + liés + mentions',
        'only_relations'    => 'Seule les relations directes',
        'related'           => 'Défaut + liés',
        'relations'         => 'Défaut',
        'show'              => 'Afficher',
    ],
    'panels'            => [
        'related'   => 'Éléments liés',
    ],
    'placeholders'      => [
        'attitude'  => 'de -100 à 100, 100 étant très positif.',
        'role'      => 'Rival, Meilleur ami, Frère/Sœur',
    ],
    'show'              => [
        'title' => 'Relations de :name',
    ],
    'types'             => [
        'family_member'         => 'Membre de famille',
        'organisation_member'   => 'Membre d\'organisation',
    ],
    'update'            => [
        'success'   => 'Relation :target modifiée pour :entity.',
        'title'     => 'Modifier la relation de :name',
    ],
];
