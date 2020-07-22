<?php

return [
    'description'   => 'Quelques aides disponnibles dans Kanka',
    'dice'          => [
        'description'               => 'Example de jet de dés: "d20", "4d4+4", "d%" pour un pourcent et "df" pour un jet Fudge.',
        'description_attributes'    => 'Il est aussi possible d\'accéder aux paramètres d\'un personnage en utilisant la syntax {character.nom_d_attribut}. Par example, {character.niveau}d6+{character.force}.',
        'more'                      => 'D\'autres options sont expliquées sur le site du plugin.',
        'title'                     => 'Jets de dés',
    ],
    'filters'       => [
        'description'   => 'Utilises les filtres pour limiter le nombre de résultats. Les champs de texte supportent plusieurs fonctionalités pour plus de granularité.',
        'empty'         => 'Le code :tag: dans un champs cherche pour toutes les entités ou ce champs est vide.',
        'ending_with'   => 'En placant un :tag à la fin du text, seuls les résultats avec exactement ce term seront affichés.',
        'session'       => 'Les filtres et colonnes ordonnées sont enregistrés dans ta session. Du moment que tu restes connecté, il n\'est pas nécessaire de les redéfinir sur chaque page.',
        'starting_with' => 'En placant un :tag au début du text, seuls les résultats ne contenant pas ce text seront affichés.',
        'title'         => 'Comment utiliser les filtres',
    ],
    'link'          => [
        'auto_update'       => 'Les liens vers d\'autres entités seront automatiquement mis à jour lorsque le nom ou la description de l\'entitée cible est modifié.',
        'description'       => 'Un lien vers une entité peut être facilement inséré en utilisant \'@\' dans le text. \'#\' peut être utilisé pour avoir une liste de mois depuis les calendriers de la campagne.',
        'formatting'        => [
            'text'  => 'La liste des balises et attributs HTML autorisés peut être consultée sur notre :github.',
            'title' => 'Mise en page',
        ],
        'friendly_mentions' => 'Lier vers d\'autres entités avec :code et les premiers charactères d\'une entité pour la rechercher. Cela injectera :example dans l\'editeur de text et affichera un lien vers l\'entité lors de la lecture.',
        'limitations'       => 'Malheureusement, à cause de limitation technique, ces raccourcits ne sont pas disponnible sur Android.',
        'mentions'          => 'Créer des liens vers d\'autres entités en saisissant :code suivit du nom d\'une entité pour la chercher. Cela injectera :example dans l\'editeur. Le nom affiché peut être controllé avec :example_name. Le lien vers une sous-page peut être controllé avec :example_page. Le lien vers un onglet peut être controllé avec :example_tab.',
        'months'            => 'Saisis :code pour avoid une liste de mois des calendriers de la campagne.',
        'title'             => 'Liens vers d\'autres éléments et raccourcis',
    ],
    'map'           => [
        'description'   => 'Uploader une carte à un lieu active le menu "Carte" sur un lieu, ainsi qu\'un lien vers la carte depuis la liste des lieux de la campagne. Les utilisateurs avec les droits de modification d\'une carte peuvent activer le mode \'Edition\' en visionnant la carte. Ceci permet d\'ajouter des Points sur la carte. Ceux-ci peuvent lier vers une entité existante ou être un text.',
        'private'       => 'Les membres du rôle Admin de la campagne peuvent rendre les cartes privées. Cela permet à un utilisateur de voir un lieu touot en guardant la carte secrète.',
        'title'         => 'Carte de lieux',
    ],
    'public'        => 'Une vidéo sur Youtube explique comment fonctionne les campagnes publiques.',
    'title'         => 'Aides',
];
