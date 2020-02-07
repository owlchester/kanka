<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
La meilleure façon d'expliquer les modèles d'attributs est d'utiliser un exemple. Imaginons que ton monde a beaucoup de lieux, et que pour chacun, tu veux les attributs personnalité pour "Population", Climat" et "Niveau de criminalité".

Il est très facile de faire cela manuellement sur chaque lieux, mais cela peut devenir fastidieux, sans compter les oublis dès que la liste d'attributs devient longue. Là est la force des modèles d'attributs.

Tu peux créer un modèle d'attributs avec les attributs de ton choix (dans notre cas, Population, Climat et Niveau de criminalité), et ensuite appliquer ce modèle à tes lieux. Cela créera les attributs sur le lieu, et tout ce que tu as à faire est de remplir les valeurs. Ainsi tu n'as plus besoin de te souvenir de tous les attributs.
TEXT
,
        'question'  => 'Que sont les Modèles d\'Attributs?',
    ],
    'backup'                => [
        'answer'    => <<<'TEXT'
Les données d'une campagne peuvent être exportées une fois par jour dans un fichier ZIP. Dans l'application, cliques sur "Campagne" sur la gauche puis "Export" dans le sous-menu. Cette action va crérer un export disponnible pendant 30 minutes.

Il n'est pas possible d'uploadé cet export dans Kanka. Cette fonctionalité est seulement pour ceux qui souhaitent quitter Kanka tout en conservant leurs données.
TEXT
,
        'question'  => 'Puis-je faire un backup ou un export de ma campagne?',
    ],
    'bugs'                  => [
        'answer'    => 'Rejoins simplement le server :discord et écrit un rapport dans le canal #error-and-bugs.',
        'question'  => 'Comment signaler un problème?',
    ],
    'conversations'         => [
        'answer'    => 'Des conversations peuvent être établiées entre des Personnages ou entre les membres d\'une campagne. Si par example tu souhaites documenter une conversation importante entre des NPCs et les joueurs, tu peux le faire en utilisant ce module. Celui-ci peut aussi être utilisé pour des campagnes de type "play-by-post".',
        'question'  => 'Que sont les Conversations?',
    ],
    'custom'                => [
        'answer'    => 'Kanka a été créé avec un nombre de types d\'entités prédéfinis qui interagissent les uns avec les autres. Autoriser des types d\'entités personnalisés nécessiterait de complètement changer le coeur de l\'application et de contrecarrer l\'objectif d\'un outil avec des types prédéfinis qui aide les gens à ne pas perdre du temps sur l\'organisation. De plus, Kanka est flexible avec des Etiquettes qui peuvent représenter la plupart des scénarios de type d\'entité personnalisés.',
        'question'  => 'Puis-je crérer mes propres types d\'entités?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Accèdes au tableau de bord de ta campagne et cliques sur "Campagne" dans le menu de gauche. Un bouton de campagne "Supprimer" apparaîtra si tu es le seul administrateur de la campagne. La suppression d\'une campagne est une action permanente qui supprimera toutes les données stockées sur nos serveurs, y compris les images.',
        'question'  => 'Comment supprimer une campagne?',
    ],
    'entity-notes'          => [
        'answer'    => 'Chaque entité a une section "Note d\'entité" qui peuvent contenir des informations cachées des autres membres de la campagne. Il est aussi possible de permettre des membres de gérer les notes d\'entité sans leur donner les droits de modifié l\'entité.',
        'question'  => 'Comment gérer des informations privées?',
    ],
    'fields'                => [
        'answer'    => 'Réponse',
        'category'  => 'Question',
        'locale'    => 'Langue',
        'order'     => 'Ordre',
        'question'  => 'Question',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Oui ! Nous pensons que votre situation financière ne doit pas avoir d'impacte sur votre plaisir de jouer à des jeux de rôles ou à créer votre propres univers, et donc l'application sera toujours gratuite. Merci à nos généreux Patrons sur Patreon, nous sommes capable de couvrir nos frais de serveurs mensuels et de vous offrir une application sans publicité!

Cependant, nous supporter sur Patreon te permet d'augmenter la taille maximal des images à uploader, d'apparaitre dans le "Hall of Fame Patreon", d'avoir des icons plus sympas, de voter sur les tickets a prioritiser, et bien plus!
TEXT
,
        'question'  => 'Est-ce que l\'application restera gratuite ?',
    ],
    'help'                  => [
        'answer'    => 'Premièrement, merci de vouloir donner un coups de main! Nous sommes toujours ravis d\'accueilir des personnes motivées pour aider avec les traductions, tester les nouvelles fonctionalités, ou qui veulent aider les nouveaux utilisateurs. Rejoins-nous simplement sur le Discord. Nous apprécions aussi chacun de nos Patrons sur Patreon si tu veux nous soutenir et avoir accès à quelques avantages.',
        'question'  => 'Je veux aider! Que puis-je faire?',
    ],
    'map'                   => [
        'answer'    => <<<'TEXT'
Chaque lieu peut contenir une carte (png, jpg ou svg) qui elle-même contient des "points" qui sont placés sur la carte avec une taille, forme, icône et couleur, et ces points peuvent être lié à des entités ou un simple text.

Les fichiers SVG venant de :azgaar et :watabou sont pleinement compatibles avex Kanka. Attention cependant, les images générées par d'autres outils sont comprimés de tel à ce qu'ils sont incompatibles avec l'application. Une solution consiste à ouvrir les images dans Inkscape ou Photoshop et simplement réenregister les images SVG avant de les téléverser sur un lieu.
TEXT
,
        'question'  => 'Puis-je uploadé des cartes sur Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'Il n\'y a actuellement pas d\'application mobile pour Kanka, mais la majorité des fonctions fonctionnent sur un browser mobile. Une limitation est l\'outil de mention ne fonctionnant pas dans l\'éditeur de text. Si le support Patreon le permet, j\'espère un jour pouvoir payer quelqu\'un pour construire et maintenir une application mobile.',
        'question'  => 'Qu\'en est-t-il d\'une application mobile?',
    ],
    'multiworld'            => [
        'answer'    => 'Non! Tu peux créer autant de campagne que tu souhaites dans l\'application. Une campagne peut être un univers, un monde, un thème, ou ce que tu veux. Dès que tu as plusieurs campagnes, tu peux facilement passer d\'une campagne à l\'autre.',
        'question'  => 'J\'ai plusieurs campagnes dans des univers différents. Ai-je besoin d\'un compte différent pour chaque campagne?',
    ],
    'permissions'           => [
        'answer'    => 'Absolument, c\'est ce pourquoi nous avons fait Kanka! Vous pouvez inviter tous les joueurs à votre campagne, et leurs donner des rôles et des permissions. Nous avons réalisé un système extrêmement flexible (vous pouvez à la fois utiliser des options de configuration de permission et de restriction) pour couvrir toutes les situations possibles dont vous pourriez avoir besoin.',
        'question'  => 'Je veux utiliser Kanka pour concevoir mon propre univers JDR, mais je souhaiterais que mes joueurs puissent avoir accès à certains éléments et modifier leurs personnages. Est-ce possible ?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Les plans long terms pour Kanka sont de construire une app flexible pour les autheurs et maîtres de jeu qui est indépendant d'un système de jeu, avec du contenu communautaire pour tout ce qui est spéficique à un système de jeu. Un objectif plus long term est de construire des méchanisme entre Kanka et des applications de jeu virtual pour que ceux-ci accèdent aux données de Kanka.

Concernant le second point, la plupart des projets hobby finissent en burnout pour le créateur. Le Patreon est mise en place avec l'objectif de me permettre de réduire mon temps de travail, pour que je puisse dédier plus de temps à Kanka sans sacrifier la stabilité financière de ma famille. Ce project est aussi open source et peut être continué et amélioré par la communauté si quelque chose devait m'arriver. Le contenu de chaque campagne peut être exporté une fois par jour pas un admin d'une campagne en cas de doute sur la sécurité des données à long term.
TEXT
,
        'question'  => 'Quelles sont les objectifs long terms? Que ce passe-t-il si Ilestis ne souhaite plus travailler sur Kanka?',
    ],
    'public-campaigns'      => [
        'answer'    => 'La page des :public-campaigns affiche toutes les campagnes publiques.',
        'question'  => 'Comment utilisent les gens Kanka?',
    ],
    'sections'              => [
        'community'     => 'Communauté',
        'general'       => 'Général',
        'other'         => 'Autre',
        'permissions'   => 'Permission',
        'pricing'       => 'Prix',
    ],
    'show'                  => [
        'return'    => 'Retour à la FAQ',
        'timestamp' => 'Dernière mise à jour :date',
        'title'     => 'FAQ :name',
    ],
    'user-switch'           => [
        'answer'    => 'Les permissions peuvent rapidement devenir compliqué, surtout au sein de grande campagne. En tant qu\'administateur d\'une campagne, naviguer vers la page affichant les membres d\'une campagne permet de cliquer sur le bouton "Usurper". Cela permet d\'afficher la campagne tel que visible par le compte usurpé avec les permissions de celui-ci.',
        'question'  => 'Les permissions de ma campagne sont définies, comment les tester?',
    ],
    'visibility'            => [
        'answer'    => 'Seules les personnes que tu invites à ta campagne peuvent voir et interagir avec celle-ci. Tes données sont privées et toujours sous ton contrôle.',
        'question'  => 'Tout le monde peut-il voir ma campagne?',
    ],
];
