<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'Désactiver les plugins',
            'enable'    => 'Activer les plugins',
            'update'    => 'Mettre à jour les plugins',
        ],
        'changelog'         => 'Changements',
        'disable'           => 'Désactiver le plugin',
        'enable'            => 'Activer le plugin',
        'find-plugins'      => 'Trouver des plugins',
        'import'            => 'Importer',
        'update'            => 'Mettre à jour le plugin',
        'update_available'  => 'Mise à jour disponible!',
    ],
    'bulks'         => [
        'delete'    => '{1} :count plugin retiré.|[2,*] :count plugins retirés.',
        'disable'   => '{1} :count plugin désactivé.|[2,*] :count plugins désactivés.',
        'enable'    => '{1} :count plugin activé.|[2,*] :count plugins activés.',
        'update'    => '{1} :count plugin mis à jour.|[2,*] :count plugins mis à jour.',
    ],
    'destroy'       => [
        'success'   => 'Le plugin :plugin a été retiré.',
    ],
    'disabled'      => [
        'success'   => 'Le plugin :plugin a été désactivé.',
    ],
    'empty_list'    => 'La campagne n\'a actuellement aucun plugin. Visiter la bibliothèque de plugins pour ajouter des plugins à la campagne, et revenir ici pour les activer.',
    'enabled'       => [
        'success'   => 'Le plugin :plugin a été activé.',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Plugin invalide.',
    ],
    'fields'        => [
        'name'      => 'Nom du plugin',
        'obsolete'  => 'Ce plugin a été marqué comme étant obsolète par l\'équipe de Kanka, indiquant qu\'il ne fonctionne plus comme prévu originalement par le/la créateur-rice.',
        'status'    => 'Status',
        'type'      => 'Type de plugin',
    ],
    'import'        => [
        'button'                => 'Importer',
        'created'               => 'Les entités suivantes ont été créées:',
        'fields'                => [
            'only_new'  => 'Seulement les nouvelles entités',
            'private'   => 'Entités privées',
        ],
        'helper'                => ':count entités du plugin :plugin seront importées. Si ce plugin a déjà été importé dans le passé, les changements fait aux entités déjà importées peuvent être perdus.',
        'no_new_entities'       => 'Il n\'y a pas de nouvelles entités à importer.',
        'option_only_import'    => 'Seulement importer les nouvelles entités, et ignorer les entités déjà précédemment importées.',
        'option_private'        => 'Importer toutes les entités comme privées.',
        'success'               => '{1} Importé :count entité du plugin :plugin.|[2,*] Importé :count entités du plugin :plugin.',
        'title'                 => 'Importer :plugin',
        'updated'               => 'Les entités suivantes ont été modifiées:',
    ],
    'info'          => [
        'helper'        => 'Dès qu\'un plugin a une nouvelle version, tu peux mettre à jour le plugin à la version la plus récente.',
        'title'         => 'Mises à jour du plugin :plugin',
        'updates'       => 'Mises à jour',
        'versions'      => 'Versions',
        'your_version'  => 'Ta version',
    ],
    'pitch'         => 'Installes et gères les plugins du :marketplace.',
    'status'        => [
        'always'    => 'Ce type de plugin est toujours actif, sauf s\'il est supprimé.',
        'disabled'  => 'Désactivé',
        'enabled'   => 'Activé',
    ],
    'templates'     => [
        'name'  => ':name de :user',
    ],
    'title'         => 'Plugins de la campagne :name',
    'types'         => [
        'attribute' => 'Modèle d\'attributs',
        'pack'      => 'Content Pack',
        'theme'     => 'Thème',
    ],
    'update'        => [
        'success'   => 'Le plugin :plugin a été mis à jour.',
    ],
];
