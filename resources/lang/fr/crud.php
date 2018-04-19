<?php

return [
    'actions'       => [
        'back'  => 'Retour',
        'copy'  => 'Copier',
        'move'  => 'Déplacer',
        'new'   => 'Nouveau',
    ],
    'add'           => 'Ajouter',
    'attributes'    => [
        'actions'       => [
            'add'               => 'Ajouter un attribut',
            'apply_template'    => 'Appliquer un modèle d\'attribut',
            'manage'            => 'Gérer',
        ],
        'create'        => [
            'description'   => 'Créer un nouvel attribut',
            'success'       => 'Attribut :name ajouté à :entity.',
            'title'         => 'Nouvel attribut pour :name',
        ],
        'destroy'       => [
            'success'   => 'Attribut :name supprimé de :entity.',
        ],
        'edit'          => [
            'description'   => 'Modifier un attribut existant',
            'success'       => 'Attribut :name modifié pour :entity.',
            'title'         => 'Modifier l\'attribut pour :name',
        ],
        'fields'        => [
            'attribute' => 'Attribut',
            'template'  => 'Modèle',
            'value'     => 'Valeur',
        ],
        'index'         => [
            'success'   => 'Attributs modifiés pour :entity.',
            'title'     => 'Attributs pour :name',
        ],
        'placeholders'  => [
            'attribute' => 'Nombre de quêtes, niveau de difficulté, initiative, population',
            'template'  => 'Sélectionner un modèle',
            'value'     => 'Valeur de l\'attribut',
        ],
        'template'      => [
            'success'   => 'Modèle d\'attribut :name appliqué pour :entity.',
            'title'     => 'Appliquer un modèle d\'attribut pour :name',
        ],
    ],
    'cancel'        => 'Annuler',
    'clear_filters' => 'Effacer les filtres',
    'click_modal'   => [
        'close'     => 'Fermer',
        'confirm'   => 'Confirmer',
        'title'     => 'Confirme ton action',
    ],
    'create'        => 'Créer',
    'delete_modal'  => [
        'close'         => 'Fermer',
        'delete'        => 'Supprimer',
        'description'   => 'Est-tu sûr de vouloir supprimer :tag?',
        'title'         => 'Confirmation la suppression',
    ],
    'destroy_many'  => [
        'success'   => ':count élément supprimé.|:count éléments supprimés.',
    ],
    'edit'          => 'Modifier',
    'fields'        => [
        'character'     => 'Personnage',
        'description'   => 'Description',
        'entity'        => 'Entité',
        'entry'         => 'Entrée',
        'event'         => 'Evénement',
        'history'       => 'Histoire',
        'image'         => 'Image',
        'is_private'    => 'Privé',
        'location'      => 'Lieu',
    ],
    'filter'        => 'Filtre',
    'filters'       => 'Filtres',
    'hidden'        => 'Caché',
    'hints'         => [
        'is_private'    => 'Cacher des membres de type non-Admin',
    ],
    'image'         => [
        'error' => 'Impossible de récupérer l\'image demandée. Il est possible que le site web ne nous permet pas de télécharger des images (cela arrive par example avec squarespace et DeviantArt), ou le lien n\'est plus valide.',
    ],
    'is_private'    => 'Cet élément est privé et pas visible.',
    'linking_help'  => 'Comment lier vers d\'autres éléments?',
    'manage'        => 'Gérer',
    'move'          => [
        'description'   => 'Déplacer cet élément à un nouveau endroit',
        'fields'        => [
            'target'    => 'Nouveau type',
        ],
        'hints'         => [
            'target'    => 'Attention! Certaines informations peuvent être perdues lors du déplacement d\'un élément.',
        ],
        'success'       => 'Elément :name déplacé.',
        'title'         => 'Déplacer :name autre part',
    ],
    'new_entity'    => [
        'error' => 'Vérifier les valeures.',
        'fields'=> [
            'name'  => 'Nom',
        ],
        'title' => 'Nouvel élément',
    ],
    'or_cancel'     => 'ou <a href=":url">annuler</a>',
    'panels'        => [
        'appearance'            => 'Apparance',
        'description'           => 'Description',
        'general_information'   => 'Information Generale',
        'history'               => 'Histoire',
        'move'                  => 'Déplacer',
    ],
    'permissions'   => [
        'action'    => 'Action',
        'actions'   => [
            'delete'    => 'Supprimer',
            'edit'      => 'Modifier',
            'read'      => 'Lire',
        ],
        'allowed'   => 'Permis',
        'fields'    => [
            'member'    => 'Membre',
            'role'      => 'Rôle',
        ],
        'helper'    => 'Utilisez cette interface pour affiner les utilisateurs et les rôles pouvant interagir avec cette entité.',
        'success'   => 'Permissions enregistrées.',
        'title'     => 'Permissions',
    ],
    'placeholders'  => [
        'character' => 'Choix du personnage',
        'event'     => 'Choix de l\'événement',
        'image_url' => 'Ou depuis une URL',
        'location'  => 'Choix du lieu',
    ],
    'relations'     => [
        'actions'   => [
            'add'   => 'Ajouter une relation',
        ],
        'fields'    => [
            'location'  => 'Lieu',
            'name'      => 'Nom',
            'relation'  => 'Relation',
        ],
    ],
    'remove'        => 'Supprimer',
    'save'          => 'Enregistrer',
    'save_and_new'  => 'Enregistrer et Nouveau',
    'search'        => 'Rechercher',
    'select'        => 'Sélection',
    'tabs'          => [
        'attributes'    => 'Attributs',
        'permissions'   => 'Permissions',
        'relations'     => 'Relations',
    ],
    'update'        => 'Modifier',
    'view'          => 'Voir',
];
