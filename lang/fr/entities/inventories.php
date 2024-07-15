<?php

return [
    'actions'           => [
        'add'               => 'Ajouter un objet',
        'copy_from'         => 'Copier depuis',
        'copy_inventory'    => 'Copier l\'inventaire',
    ],
    'copy'              => [
        'title' => 'Copier l\'inventaire vers :name',
    ],
    'create'            => [
        'success'       => 'Objet :item ajouté à :entity.',
        'success_bulk'  => '{0} Aucun objet ajouté à :entity.|{1} :count objet ajouté à :entity.|[2,*] :count objets ajoutés à :entity.',
        'title'         => 'Ajouter un objet à :name',
    ],
    'default_position'  => 'Non organisé',
    'destroy'           => [
        'success'           => 'Objet :item retiré de :entity.',
        'success_position'  => 'Les éléments de :position ont été retirés de :entity.',
    ],
    'fields'            => [
        'amount'                => 'Quantité',
        'copy_entity_entry_v2'  => 'Utiliser l\'entrée de l\'objet',
        'description'           => 'Description',
        'is_equipped'           => 'Equipé',
        'name'                  => 'Nom',
        'position'              => 'Position',
        'qty'                   => 'Qté',
    ],
    'helpers'           => [
        'amount'                => 'Nombre d\'objets',
        'copy_entity_entry_v2'  => 'Affiche l\'entrée de l\'objet au lieu de la description personnalisée.',
        'description'           => 'Ajouter une description personnalisée à l\'objet',
        'is_equipped'           => 'Marquer cet objet comme étant équipé.',
        'name'                  => 'Donner un nom à l\'objet. Un nom est requis si aucun objet n\'est sélectionné',
    ],
    'placeholders'      => [
        'amount'        => 'Un nombre',
        'description'   => 'Usé, abimé, atténué',
        'name'          => 'Requis si aucun object n\'est sélectionné',
        'position'      => 'Equipé, Sac-à-dos, Entrepôt, Banque',
    ],
    'show'              => [
        'helper'    => 'Les entités peuvent avoir des objets attachés pour créer un inventaire.',
        'title'     => 'Inventaire de l\'entité :name',
        'unsorted'  => 'Autre',
    ],
    'tooltips'          => [
        'equipped'  => 'Cet objet est équipé',
    ],
    'tutorial'          => 'Garder la trace de ce qu\'une entité possède en ajoutant des objets à son inventaire.',
    'update'            => [
        'success'   => 'Objet :item modifié pour :entity.',
        'title'     => 'Modifier un objet sur :name',
    ],
];
