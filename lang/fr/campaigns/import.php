<?php

return [
    'actions'           => [
        'import'    => 'Envoyer l\'export',
    ],
    'csv'               => [
        'continue'          => 'Continuer',
        'fields_helper'     => 'Sélectionne une colonne à assigner à chacun des champs de l\'entrée.',
        'no_preview'        => 'Aucune donnée d\'aperçu disponible',
        'preview'           => 'Aperçu',
        'select_module'     => 'Sélection de catégorie',
        'select_one'        => 'Sélectionner',
        'selected_tags'     => 'Tags sélectionnés',
        'set_column'        => 'Définir la colonne',
        'set_fields'        => 'Définir les champs',
        'submit'            => 'Soumettre l\'import CSV',
        'traits'            => 'Traits de personnage',
        'traits_helper'     => 'Tu peux ajouter des traits aux personnages. L\'en-tête sélectionné sera utilisé comme nom du trait, et la valeur correspondante comme valeur du trait.',
        'type_helper'       => 'Sélectionne la catégorie dans laquelle tu veux importer les nouvelles entrées.',
        'validation_error'  => 'Au moins 1 colonne doit être entièrement remplie',
    ],
    'description_v2'    => 'Importe des entrées, articles, propriétés, galeries et autres données depuis un export de campagne ou de nouvelles entrées depuis un fichier .CSV dans cette campagne. L\'import s\'exécute en arrière-plan et peut prendre du temps. Toi et les autres administrateurs serez notifiés quand il sera terminé.',
    'fields'            => [
        'file_v2'   => 'Fichier CSV ou fichier ZIP d\'export',
        'updated'   => 'Dernière modification',
    ],
    'form'              => 'Formulaire d\'upload',
    'limitation_v2'     => 'Seuls les fichiers zip et csv sont acceptés. Max :size.',
    'progress'          => [
        'uploading' => 'Téléchargement',
    ],
    'status'            => [
        'failed'        => 'Echoué',
        'finished'      => 'Terminé',
        'invalid'       => 'Données invalides',
        'processing'    => 'En cours de traitement',
        'queued'        => 'Programmé',
        'ready'         => 'Prêt pour le mapping',
        'running'       => 'En cours',
        'validating'    => 'Validation en cours',
    ],
    'title'             => 'Import',
];
