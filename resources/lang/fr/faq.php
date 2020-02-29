<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
La meilleure façon d'expliquer les modèles d'attributs est d'utiliser un exemple. Imaginons que ton monde a beaucoup de lieux, et que pour chacun, tu veux des attributs personnalisés pour "Population", Climat" et "Niveau de criminalité".

Il est très facile de faire ça manuellement, mais cela peut devenir fastidieux, sans compter les oublis lorsque que la liste d'attributs devient longue. C’est la que les modèles d'attributs peuvent venir à la rescousse.

Tu peux créer un modèle d'attribut avec les attributs de ton choix (dans notre cas, Population, Climat et Niveau de criminalité), et ensuite appliquer ce modèle à tes lieux. Cela créera les attributs sur le lieu, et tout ce que tu as à faire est d’ajouter les valeurs. Tu n'as donc plus besoin de te souvenir de tous les attributs.
TEXT
,
        'question'  => 'Que sont les Modèles d\'Attributs?',
    ],
    'backup'                => [
        'answer'    => <<<'TEXT'
Les données d'une campagne peuvent être exportées une fois par jour dans un fichier ZIP. Dans l'application, cliques sur "Campagne" sur la gauche puis "Export" dans le sous-menu. Cette action va créer un export disponible pendant 30 minutes.

Il n'est pas possible d'uploadé cet export dans Kanka. Cette fonctionnalité est seulement pour ceux qui souhaitent cesser d’utiliser Kanka tout en conservant leurs données.
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
        'answer'    => 'Kanka a été créé avec un nombre d\'entités prédéfinies qui interagissent les unes avec les autres. Autoriser des types d\'entités personnalisées nécessiterait de complètement changer l\'application et d’aller à l’encontre de l\'objectif de simplifier l\'organisation. De plus, Kanka est flexible avec des Étiquettes qui peuvent représenter la plupart des scénarios et type d\'entités personnalisées.',
        'question'  => 'Puis-je crérer mes propres types d\'entités?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Accèdes au tableau de bord de ta campagne et cliques sur "Campagne" dans le menu de gauche. Un bouton de campagne "Supprimer" apparaîtra si tu es le seul administrateur de la campagne. La suppression d\'une campagne est une action permanente qui supprimera toutes les données stockées sur nos serveurs, y compris les images.',
        'question'  => 'Comment supprimer une campagne?',
    ],
    'entity-notes'          => [
        'answer'    => 'Chaque entité a une section "Note d\'entité" qui peut contenir des informations cachées des autres membres de la campagne. Il est aussi possible de permettre à des membres de gérer les notes d\'entité sans leur donner le droit de modifier l\'entité.',
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
Oui ! Nous pensons que votre situation financière ne doit pas avoir d'impact sur votre plaisir de jouer à des jeux de rôles ou à créer votre propre univers, et donc l'application sera toujours gratuite. Merci à nos généreux Patrons sur :patreon, grâce à qui nous sommes capables de couvrir nos frais de serveurs mensuels et de vous offrir une application sans publicité !

Cependant, nous soutenir sur Patreon permet d'augmenter la taille maximale des images à uploader, d'apparaitre dans le "Hall of Fame Patreon", d'avoir des icones plus sympas, de voter sur les tickets a prioritiser, et bien plus!
TEXT
,
        'question'  => 'Est-ce que l\'application restera gratuite ?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Les Dieux sont des personnage, et les religions sont des organisations dans Kanka. Pour rapidement trouver les dieux, nous recommandons aussi d\'utiliser des étiquettes.',
        'question'  => 'Où crérer les Dieux et religions?',
    ],
    'help'                  => [
        'answer'    => 'Premièrement, merci de vouloir donner un coup de main! Nous sommes toujours ravis d\'accueillir des personnes motivées pour aider avec les traductions, tester les nouvelles fonctionnalités, ou aider les nouveaux utilisateurs. Rejoins-nous simplement sur :discord. Nous apprécions aussi chacun de nos Patrons sur :patreon si tu veux nous soutenir et avoir accès à quelques bonus.',
        'question'  => 'Je veux aider! Que puis-je faire?',
    ],
    'map'                   => [
        'answer'    => <<<'TEXT'
Chaque lieu peut contenir une carte (png, jpg ou svg) qui elle-même contient des "endroits" qui sont placés sur la carte avec une icône de certaine taille, forme, et couleur, et ces endroits peuvent être liés à des entités ou un texte.

Les fichiers SVG venant de :azgaar et :watabou sont pleinement compatibles avex Kanka. Attention cependant, les images générées par d'autres outils sont comprimées de tel sorte à ce qu'elles soient incompatibles avec l'application. Une solution consiste à ouvrir les images dans Inkscape ou Photoshop et simplement réenregistrer les images SVG avant de les uploader.
TEXT
,
        'question'  => 'Puis-je uploader des cartes sur Kanka?',
    ],
    'mobile'                => [
        'answer'    => <<<'TEXT'
Il n'y a actuellement pas d'application mobile pour Kanka, mais la majorité des fonctionnalités marchent sur un browser mobile. Une des limites est l'outil de mention qui ne fonctionne pas dans l'éditeur de texte. Si le soutien :patreon le permet, j'espère un jour pouvoir construire et maintenir une application mobile.

TEXT
,
        'question'  => 'Qu\'en est-t-il d\'une application mobile?',
    ],
    'multiworld'            => [
        'answer'    => 'Non! Tu peux créer autant de campagnes que tu souhaites dans l\'application. Une campagne peut être un univers, un monde, un thème, ou quoi que ce soit d’autre. Quand tu as plusieurs campagnes, tu peux facilement passer d\'une campagne à l\'autre.',
        'question'  => 'Puis-je avoir plusieurs campagnes?',
    ],
    'permissions'           => [
        'answer'    => 'Absolument, c\'est ce pourquoi nous avons créé Kanka! Vous pouvez inviter n’importe qui à votre campagne, et leur donner des rôles et des permissions. Nous avons créé un système extrêmement flexible (vous pouvez à la fois utiliser des optionsde permission et de restriction) pour couvrir toutes les situations possibles.',
        'question'  => 'Puis-je sélectionner les informations que mes joueurs peuvent voir?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Les plans long termes pour Kanka sont de construire une app flexible pour les auteurs et maîtres de jeu qui soit indépendante du système de jeu, avec du contenu communautaire pour tout ce qui est spécifique au système de jeu. Un objectif sur le long terme est de construire des mécanismes entre Kanka et des applications de jeux virtuels pour que ceux-ci puissent accéder aux données de Kanka.

Concernant le second point, la plupart des projets de type ‘hobby’ finissent en burnout pour le créateur. Le :patreon a été mis en place avec l'objectif de me dédier à Kanka sans sacrifier la stabilité financière de ma famille. Ce projet est aussi open source et peut être continué et amélioré par la communauté si quelque chose devait m'arriver. Le contenu de chaque campagne peut être exporté une fois par jour par l’admin d'une campagne en cas de doute sur la sécurité des données à long terme.
TEXT
,
        'question'  => 'Quelles sont les objectifs long terme?',
    ],
    'public-campaigns'      => [
        'answer'    => 'La page des :public-campaigns affiche toutes les campagnes publiques.',
        'question'  => 'Comment utiliser Kanka?',
    ],
    'sections'              => [
        'community'     => 'Communauté',
        'general'       => 'Général',
        'other'         => 'Autre',
        'permissions'   => 'Permission',
        'pricing'       => 'Prix',
        'worldbuilding' => 'Worldbuilding',
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
