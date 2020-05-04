<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Changer au login Kanka',
            'update_email'      => 'Modifier l\'email',
            'update_password'   => 'Modifier le mot de passe',
        ],
        'description'       => 'Modification du compte',
        'email'             => 'Modification de l\'email',
        'email_success'     => 'Email modifié.',
        'password'          => 'Modification du mot de passe',
        'password_success'  => 'Mot de passe modifié.',
        'social'            => [
            'error'     => 'Tu utilises déjà le login Kanka pour ce compte.',
            'helper'    => 'Ton compte est géré par :provider. Tu peux changer au login Kanka en fournissant un login et un mot de passe.',
            'success'   => 'Ton compte utilise d\'orénavant le login Kanka.',
            'title'     => 'Social à Kanka',
        ],
        'title'             => 'Compte',
    ],
    'api'           => [
        'description'           => 'Modifier les options d\'API',
        'experimental'          => 'Bienvenus aux API de Kanka! Ces fonctionalités sont encore experimental mais assez stable que tu puisses intéragire avec les APIs. Créé un jeton personnel pour utiliser dans tes requêtes API, ou un jeton client pour permettre à ton app d\'accéder à tes données.',
        'help'                  => 'Kanka va prochainement mettre à disposition une API.',
        'link'                  => 'Lire la documentation',
        'request_permission'    => 'Nous construisons en ce moment des API RESTful pour que des applications tièrces communiquent avec Kanka. Cependant nous limitons actuellement le nombre d\'utilisateurs qui peuvent intéragire avec nos API, du moins jusqu\'à ce que la qualité de nos APIs soit assez bonne. Si tu veux accéder aux API et construire des applications qui communiquent avec Kanka, prends contact avec nous et nous te donneront les infos dont tu as besoin!',
        'title'                 => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Lier',
            'remove'    => 'Retirer',
        ],
        'benefits'  => 'Kanka supporte quelques intégrations avec d\'autres services. D\'autres services seront ajoutés dans le futur.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Une erreur est survenue lors de liage de Discord avec le compte Kanka.',
            ],
            'success'   => [
                'add'       => 'Compte Discord lié.',
                'remove'    => 'Compte Discord délié.',
            ],
            'text'      => 'Accès aux rôles automatique.',
        ],
        'title'     => 'Ingération d\'app',
    ],
    'boost'         => [
        'benefits'      => [
            'first'     => 'Pour assurer une évolution continue de Kanka, certaines fonctionnalités de l\'application sont débloquées lorsqu\'une campagne est boostée. Les boosts sont débloqués grâce a un abonnement. Une campagne peut être boostée par n\'importe qui, du moment que le compte a accès à la campagne en question. Une campagne reste boostée tant que le compte a un :subscription actif. Si une campagne n\'est plus boostée, les informations ne sont pas perdues mais deviennent simplement invisible jusqu\'à ce que la campagne sois à nouveau boostée..',
            'header'    => 'Image d\'en-tête pour entité.',
            'more'      => 'En savoir plus sur toutes les fonctionalités.',
            'second'    => 'Booster une campagne débloques les bénéfices suivants:',
            'theme'     => 'Thème de campagne et style personnalisé.',
            'tooltip'   => 'Infobulles personnalisés pour les entités.',
            'upload'    => 'Taille de fichier uploadé plus grand pour tous les membres de la campagne.',
        ],
        'buttons'       => [
            'boost' => 'Boost',
        ],
        'campaigns'     => 'Campagnes boostées :count / :max',
        'exceptions'    => [
            'already_boosted'   => 'La campagne :name est déjà boostée.',
            'exhausted_boosts'  => 'Tu n\'as plus de boost disponnible. Retire un boost d\'une campagne avant de pouvoir l\'attribuer à une autre.',
        ],
        'success'       => [
            'boost' => 'Campagne :name boostée.',
            'delete'=> 'Boost retiré de :name.',
        ],
        'title'         => 'Boost',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Télécharger PDF',
            'view_all'  => 'Tout voir',
        ],
        'fields'    => [
            'amount'    => 'Montant',
            'date'      => 'Date',
            'invoice'   => 'Facture',
            'status'    => 'Status',
        ],
        'header'    => 'Liste des 24 dernières factures qui peuvent être téléchargées.',
        'status'    => [
            'paid'      => 'Payé',
            'pending'   => 'En attente',
        ],
        'title'     => 'Factures',
    ],
    'layout'        => [
        'description'   => 'Modifier les options de mise en page',
        'success'       => 'Options de mise en page modifiées.',
        'title'         => 'Mise en page',
    ],
    'menu'          => [
        'account'               => 'Compte',
        'api'                   => 'API',
        'apps'                  => 'Apps',
        'billing'               => 'Méthode de paiement',
        'boost'                 => 'Boost',
        'invoices'              => 'Factures',
        'layout'                => 'Mise en Page',
        'other'                 => 'Autre',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Options de paiement',
        'personal_settings'     => 'Paramètres Personnels',
        'profile'               => 'Profil',
        'subscription'          => 'Abonnement',
        'subscription_status'   => 'Status d\'abonnement',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Lier le compte',
            'view'  => 'Visiter Kanka sur Patreon',
        ],
        'benefits'          => 'Nous supporter sur :patreon active plein de :features pour toi et tes campagnes, et nous permet de dédié plus de temps à travailler sur Kanka.',
        'benefits_features' => 'fonctionalités sympas',
        'deprecated'        => 'Fonction obsolète - si tu souhaites supporter Kanka, fais-le avec un abonnement. La liaison Patreon est toujours active pour nos Patrons qui ont lié leur compte avant le changement d\'abonnement.',
        'description'       => 'Synchronisation avec Patreon',
        'errors'            => [
            'invalid_token' => 'Token invalid! Patreon n\'a pas validé la requête.',
            'missing_code'  => 'Code manquant! Patreon n\'a pas envoyé de code d\'authentification pour ton compte.',
            'no_pledge'     => 'Pas de pledge! Patreon a identifié ton compte, mais ne croit pas que tu nous supportes.',
        ],
        'link'              => 'Si tu supportes Kanka sur Patreon, tu peux utiliser le bouton pour lier ton compte. Cela te donnera accès a des bonus sympas!',
        'linked'            => 'Merci pour ton support sur Patreon! Ton comptes est d\'orénavant lié.',
        'pledge'            => 'Pledge: :name',
        'remove'            => [
            'button'    => 'Délier le compte Patreon',
            'text'      => 'Délier le compte Patreon de Kanka supprime les bonus, le nom du Hall of Fame, les boosters de campagne et d\'autres fonctionnalités liées au supporter de Kanka. Aucun contenu boosté ne sera perdu (par exemple les en-têtes d\'entité). Lors du réabonnement, toutes les données seront à nouveau visibles, y compris la possibilité de booster des campagnes précédemment boostées.',
            'title'     => 'Délier le compte Patreon de Kanka',
        ],
        'success'           => 'Merci pour ton support sur Patreon!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Ton pledge est inséré manuellement par nous, du coups ça peut prendre quelques jours pour être actualisé. Si ça reste faux longtemps, n\'hésites pas à nous contacter.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Mettre à jour le profil',
        ],
        'avatar'    => 'Image de profil',
        'success'   => 'Mise à jour effectuée.',
        'title'     => 'Profil personnel',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Annuler l\'abonnement',
            'subscribe'         => 'Abonner',
            'update_currency'   => 'Changer la devise',
        ],
        'benefits'              => 'En nous soutenant, tu peux débloquer de nouvelles fonctionnalités: et nous aider a investir plus de temps dans l\'amélioration de Kanka. Aucune information concernant ta carte de crédit n\'est stockée ou ne transite par nos serveurs. Nous utilisons :stripe pour gérer toutes les factures.',
        'billing'               => [
            'helper'    => 'Les informations de paiement sont gérées et sauvegardées de manière sécurisée à travers :stripe. Cette méthode de paiement sera utilisée pour tous les abonnements.',
            'saved'     => 'Méthode de paiement',
            'title'     => 'Modifier la méthode de paiement',
        ],
        'cancel'                => [
            'text'  => 'Désolé de te voir partir! L\'annulation de ton abonnement le gardera actif jusqu\'au la fin du mois payé, après quoi tu perdras les bonus de ta campagne et les autres avantages liés au soutien de Kanka. N\'hésite pas à remplir le formulaire suivant pour nous informer de ce que nous pouvons faire mieux, ou de ce qui a conduit à ta décision.',
        ],
        'cancelled'             => 'L\'abonnement a été annulé. Un nouvel abonnement peut être fait dès que celui-ci arrive à terme.',
        'change'                => [
            'text'  => 'Abonnement pour le tier :tier, facturé mensuellement pour :amount.',
            'title' => 'Changement d\'abonnement',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Changer la devise de facturation',
        ],
        'errors'                => [
            'callback'      => 'Notre gestionnaire de paiement nous a remonté une erreur. Prière de ressayer et nous contacter si le problème persiste.',
            'subscribed'    => 'Erreur lors de la gestion de l\'abonnement. Stripe nous a fourni l\'erreur suivante.',
        ],
        'fields'                => [
            'active_since'      => 'Actif depuis',
            'active_until'      => 'Active jusqu\'à',
            'billed_monthly'    => 'Facturé mensuellement',
            'currency'          => 'Devise',
            'payment_method'    => 'Méthode de paiement',
            'plan'              => 'Abonnement actuel',
            'reason'            => 'Raison',
        ],
        'manage_subscription'   => 'Gérer l\'abonnement',
        'payment_method'        => [
            'actions'   => [
                'add_new'   => 'Ajouter une méthode de paiement',
                'change'    => 'Modifier la méthode de paiement',
                'save'      => 'Enregister la méthode de paiement',
            ],
            'add_one'   => 'Aucune méthode de paiement actuellement saisie.',
            'card'      => 'Carte',
            'card_name' => 'Nom sur la carte',
            'ending'    => 'Se terminant par',
            'helper'    => 'Cette carte sera utilisée pour les abonnements.',
            'new_card'  => 'Ajouter une méthode de paiement',
            'saved'     => ':brand se terminant par :last4',
        ],
        'placeholders'          => [
            'reason'    => '(optionnelle) dis-nous pourquoi tu ne souhaites plus être abonné à Kanka. Manquait-il une fonctionnalité? Ta situation financière a-t-elle changé?',
        ],
        'sub_status'            => 'Information d\'abonnement',
        'subscription'          => [
            'actions'   => [
                'downgrading'   => 'Prière de nous contacter pour un déclassement',
                'rollback'      => 'Changer à Kobold',
                'subscribe'     => 'Changer à :tier mensuel',
            ],
        ],
        'success'               => [
            'callback'      => 'Ton abonnement est réussis! Ton compte sera mis à jour dès que notre gestionnaire de paiement nous informe des changement (cela peut prendre quelques minutes).',
            'cancel'        => 'Ton abonnement est annulé. Il sera toujours actif jusqu\'à la fin de la période actuel.',
            'currency'      => 'Devise préférée sauvegardée.',
            'subscribed'    => 'Ton abonnement est réussis! N\'oublie pas de t\'abonner à la newsletter Community Vote pour être averti lorsqu\'un vote sera ouvert. Tu peux modifier tes paramètres de newsletter sur ta page de profil.',
        ],
        'tiers'                 => 'Niveaux d\'abonnements',
        'upgrade_downgrade'     => [
            'button'    => 'Information sur l\'upgrade/downgrade',
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'L\'abonnement actuel reste actif jusqu\'à la fin du cycle de paiement, après quoi le nouvel abonnement sera mis en place.',
                ],
                'title'     => 'Lors du passage à un niveau inférieur',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'La méthode de paiement sera facturée immédiatement et les nouvelles fonctionnalités seront accessibles.',
                    'prorate'   => 'Lors du changement de Owlbear à Elemental, seulement la différence sera facturée.',
                ],
                'title'     => 'Lors du passage à un niveau supérieur',
            ],
        ],
        'warnings'              => [
            'patreon'   => 'Ce compte est actuellement lié à Patreon. Prière de délié le compte dans les paramètres :patreon avant de pouvoir s\'abonner à Kanka.',
        ],
    ],
];
