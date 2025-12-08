<?php

return [
    'actions'           => [
        'add'               => 'Ajouter',
        'copy_from'         => 'Copier depuis',
        'copy_inventory'    => 'Copier l\'inventaire',
        'generate'          => 'Générer',
    ],
    'copy'              => [
        'helper'    => 'Copie l\'inventaire complet d\'une entité à :name.',
    ],
    'create'            => [
        'helper'        => 'Ajouter un objet à l\'inventaire de :name. Il peut éventuellement être lié à un objet existant de la campagne.',
        'success'       => 'Objet :item ajouté à :entity.',
        'success_bulk'  => '{0} Aucun objet ajouté à :entity.|{1} :count objet ajouté à :entity.|[2,*] :count objets ajoutés à :entity.',
        'title'         => 'Ajouter à l\'inventaire',
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
        'item_amount'           => 'Nombre d\'objets',
        'match_all'             => 'Avec toutes les étiquettes',
        'name'                  => 'Nom',
        'position'              => 'Position',
        'qty'                   => 'Qté',
        'replace'               => 'Remplacer l\'inventaire',
    ],
    'generate'          => [
        'helper'    => 'Générer un inventaire pour :name basé sur des objets de la campagne.',
        'title'     => 'Générer un inventaire',
    ],
    'helpers'           => [
        'amount'                => 'Nombre d\'objets',
        'copy_entity_entry_v2'  => 'Affiche l\'entrée de l\'objet au lieu de la description personnalisée.',
        'description'           => 'Ajouter une description personnalisée à l\'objet',
        'is_equipped'           => 'Marquer cet objet comme étant équipé.',
        'name'                  => 'Donner un nom à l\'objet. Un nom est requis si aucun objet n\'est sélectionné',
        'replace'               => 'Remplacer l\'inventaire actuel avec les nouveaux éléments générés.',
    ],
    'placeholders'      => [
        'amount'        => 'Un nombre',
        'description'   => 'Usé, abimé, atténué',
        'name'          => 'Requis si aucun object n\'est sélectionné',
        'position'      => 'Equipé, Sac-à-dos, Entrepôt, Banque',
    ],
    'show'              => [
        'helper'    => 'Les entités peuvent avoir des objets attachés pour créer un inventaire.',
        'title'     => 'Inventaire de :name',
        'unsorted'  => 'Autre',
    ],
    'tooltips'          => [
        'equipped'  => 'Cet objet est équipé',
    ],
    'tutorials'         => [
        'all'       => 'Suis ce que :name possède, garde ou vend en ajoutant des objets à cet inventaire',
        'character' => 'Garder la trace de ce que :name possède ou a à vendre en ajoutant des objets à l\'inventaire.',
        'location'  => 'Garder la trace de ce que :name a à vendre ou à piller en ajoutant des objets à l\'inventaire.',
        'other'     => 'Garder la trace de ce que :name possède en ajoutant des objets à l\'inventaire.',
    ],
    'update'            => [
        'success'   => 'Objet :item modifié pour :entity.',
        'title'     => 'Modifier un objet sur :name',
    ],
];
