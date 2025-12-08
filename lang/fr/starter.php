<?php

return [
    'campaign'      => [
        'name'  => 'Monde de :user',
    ],
    'character1'    => [
        'fears'     => 'James a peur du bruit et des explosions.',
        'history'   => 'Ceci est un exemple de personnage.',
        'race'      => 'Humain',
        'sex'       => 'Mâle',
        'title'     => 'Chasseur Gris',
        'traits'    => 'Tourne toujours la vérité à son avantage.',
    ],
    'character2'    => [
        'fears'     => 'Créer la plus grande explosion possible.',
        'history'   => 'Ceci est un exemple de personnage.',
        'race'      => 'Gnome',
        'sex'       => 'Femelle',
        'title'     => 'Reine des Explosions',
        'traits'    => 'Besoin d\'autre chose? Cette section est là pour ça!',
    ],
    'kingdom1'      => [
        'description'   => 'Ceci est un exemple de localité.',
        'history'       => '(exemple) Le royaume de Genory fut fondé par la tribu des Genoriens durant le 5ème sciècle.',
        'name'          => 'Genory',
        'type'          => 'Royaume',
    ],
    'kingdom2'      => [
        'description'   => '(exemple) Ulyss est la capitale du royaume de Genory.',
        'history'       => '(exemple) Ulyss est la capitale du royaume de Genory.',
        'name'          => 'Ulyss',
        'type'          => 'Capitale',
    ],
    'name'          => ':name (exemple)',
    'note1'         => [
        'entry'         => <<<'TEXT'
Bienvenue sur Kanka! Ta première campagne a été créée et nous avons inclus quelques exemples d'entités pour t'inspirer que tu peux supprimer.

Tu voudras probablement commencer par ajouter tes propres entités. Choisis une catégorie sur le menu à gauche pour commencer. Les catégories dont tu n'as pas besoin peuvent être désactivées dans la configuration de la campagne (modules). Désactiver une catégorie la retire du menu.

Voici quelques conseils pour t'aider à commencer:
- Tu peux écrire @nom dans la description d'une entité pour lier vers d'autres entités. Le lien sera automatiquement mis à jour en cas de modifications de l'entité mentionnée.
- Tu peux configurer ton profil pour changer de thème ou le nombre d'entités affichées par page. L'accès à la configuration du profil se fait en cliquant en haut à droite.
- Tu peux définir des permissions sur des types d'entités ainsi que sur les entités individuellement.
- Il y a des tutoriels sur :youtube. Les tutoriels couvrent la thématique des attributs ou comment partager la campagne avec tes amis. La :faq peut aussi t'être utile.

Autres:
- Trouve de l'inspiration sur comment utiliser Kanka dans les :public.
- Si tu as des questions, suggestions ou simplement envie de discuter, rejoins-nous sur :discord.
- Tu adore l'app et veux soutenir son évolution? Kanka offre des :subscriptions.
TEXT
,
        'name'          => 'Note de bienvenue',
        'subscriptions' => 'Abonnements',
    ],
];
