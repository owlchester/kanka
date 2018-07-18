<?php

return [
    'actions'       => [
        'back'      => 'Retour',
        'copy'      => 'Copier',
        'export'    => 'Export',
        'more'      => 'Autres Actions',
        'move'      => 'Déplacer',
        'new'       => 'Nouveau',
        'private'   => 'Privé',
        'public'    => 'Publique',
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
    'bulk'          => [
        'errors'    => [
            'admin' => 'Seulement les membres administrateur de la campagne peuvent changer le status des entités.',
        ],
        'success'   => [
            'private'   => ':count entité est maintenant privée.|:count entitées sont maintenant privées.',
            'public'    => ':count entité est maintenant visible.|:count entitées sont maintenant visibles.',
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
    'errors'        => [
        'node_must_not_be_a_descendant' => 'Node invalide (catégorie, lieu parent): l\'entité serait un descendant de lui-même.',
    ],
    'events'        => [
        'hint'  => 'Les événements de calendrier peuvent être associé à cette entité et être affiché ici.',
    ],
    'export'        => 'Export',
    'fields'        => [
        'attribute_template'    => 'Modèle d\'attribut',
        'character'             => 'Personnage',
        'creator'               => 'Créateur',
        'description'           => 'Description',
        'dice_roll'             => 'Jet de dés',
        'entity'                => 'Entité',
        'entry'                 => 'Entrée',
        'event'                 => 'Evénement',
        'family'                => 'Famille',
        'history'               => 'Histoire',
        'image'                 => 'Image',
        'is_private'            => 'Privé',
        'location'              => 'Lieu',
        'name'                  => 'Nom',
        'organisation'          => 'Organisation',
        'section'               => 'Catégorie',
    ],
    'filter'        => 'Filtre',
    'filters'       => 'Filtres',
    'hidden'        => 'Caché',
    'hints'         => [
        'attribute_template'    => 'Appliquer un modèl d\'attribut lors de la création de cette entité.',
        'is_private'            => 'Cacher des membres de type non-Admin',
    ],
    'history'       => [
        'created'   => 'Créé par <strong>:name</strong> <span data-toggle="tooltip" title=":realdate">:date</span>',
        'unknown'   => 'Inconnu',
        'updated'   => 'Dernière modification par <strong>:name</strong> <span data-toggle="tooltip" title=":realdate">:date</span>',
    ],
    'image'         => [
        'error' => 'Impossible de récupérer l\'image demandée. Il est possible que le site web ne nous permet pas de télécharger des images (cela arrive par example avec squarespace et DeviantArt), ou le lien n\'est plus valide.',
    ],
    'is_private'    => 'Cet élément est privé et pas visible.',
    'linking_help'  => 'Comment lier vers d\'autres éléments?',
    'manage'        => 'Gérer',
    'move'          => [
        'description'   => 'Déplacer cet élément à un nouveau endroit',
        'errors'        => [
            'permission'        => 'Droits insuffisants pour créer une entité de ce type dans la campagne sélectionnée.',
            'same_campaign'     => 'Une autre campagne doit être sélectionnée pour y déplacer l\'entité.',
            'unknown_campaign'  => 'Campagne inconnue.',
        ],
        'fields'        => [
            'campaign'  => 'Nouvelle campagne',
            'target'    => 'Nouveau type',
        ],
        'hints'         => [
            'campaign'  => 'Il est aussi possible de déplacer cette entité vers une autre campagne.',
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
    'notes'         => [
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
        'hint'          => 'Des informations qui n\'entrent pas vraiment dans les champs pré-définis ou qui doivent être privés peuvent être ajoutée en tant que Note.',
        'index'         => [
            'title' => 'Notes pour :name',
        ],
        'placeholders'  => [
            'name'  => 'Nom de la note, observation ou remarque',
        ],
    ],
    'or_cancel'     => 'ou <a href=":url">annuler</a>',
    'panels'        => [
        'appearance'            => 'Apparence',
        'attribute_template'    => 'Modèle d\'attribut',
        'description'           => 'Description',
        'general_information'   => 'Information Generale',
        'history'               => 'Histoire',
        'move'                  => 'Déplacer',
        'system'                => 'Système',
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
        'helper'    => 'En utilisant cette interface, il est possible d\'affiner les permissions des membres et rôles de la campagne pouvant interagir avec cette entité.',
        'success'   => 'Permissions enregistrées.',
        'title'     => 'Permissions',
    ],
    'placeholders'  => [
        'character'     => 'Choix du personnage',
        'entity'        => 'Entité',
        'event'         => 'Choix de l\'événement',
        'family'        => 'Choix de la famille',
        'image_url'     => 'Ou depuis une URL',
        'location'      => 'Choix du lieu',
        'organisation'  => 'Choix d\'une organisation',
        'section'       => 'Choix d\'une catégorie',
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
        'hint'      => 'Des relations entre les entités peuvent être définies pour représenter leur connexion.',
    ],
    'remove'        => 'Supprimer',
    'save'          => 'Enregistrer',
    'save_and_new'  => 'Enregistrer et Nouveau',
    'search'        => 'Rechercher',
    'select'        => 'Sélection',
    'tabs'          => [
        'attributes'    => 'Attributs',
        'events'        => 'Événements',
        'notes'         => 'Notes',
        'permissions'   => 'Permissions',
        'relations'     => 'Relations',
    ],
    'update'        => 'Modifier',
    'view'          => 'Voir',
];
