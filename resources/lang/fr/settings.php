<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Changer au login Kanka',
            'update_email'      => 'Modifier l\'email',
            'update_password'   => 'Modifier le mot de passe',
        ],
        'email'             => 'Modification de l\'email',
        'email_success'     => 'Email modifié.',
        'password'          => 'Modification du mot de passe',
        'password_success'  => 'Mot de passe modifié.',
        'social'            => [
            'error'     => 'Tu utilises déjà le login Kanka pour ce compte.',
            'helper'    => 'Ton compte est géré par :provider. Tu peux changer au login Kanka en fournissant un login et un mot de passe.',
            'success'   => 'Ton compte utilise dorénavant le login Kanka.',
            'title'     => 'Social à Kanka',
        ],
        'title'             => 'Compte',
    ],
    'api'           => [
        'helper'    => 'Bienvenue à l\'API de Kanka. Les personal access token permettent d\'accéder aux données d\'un utilisateur lors des requêtes à l\'API.',
        'link'      => 'Lire la documentation',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Lier',
            'remove'    => 'Retirer',
        ],
        'benefits'  => 'Kanka supporte quelques intégrations avec d\'autres services. D\'autres services seront ajoutés dans le futur.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Une erreur est survenue lors du liage de Discord avec le compte Kanka.',
            ],
            'success'   => [
                'add'       => 'Compte Discord lié.',
                'remove'    => 'Compte Discord délié.',
            ],
            'text'      => 'Accès aux rôles automatique.',
        ],
        'title'     => 'Intégration d\'app',
    ],
    'boost'         => [
        'benefits'      => [
            'campaign_gallery'  => 'Une galerie d\'image pour télécharger des images réutilisables dans toute la campagne.',
            'entity_files'      => 'Télécharger jusqu\'à 10 fichiers par entité.',
            'entity_logs'       => 'Historique complet des changements sur une entité.',
            'first'             => 'Pour assurer une évolution continue de Kanka, certaines fonctionnalités de l\'application sont débloquées lorsqu\'une campagne est boostée. Les boosts sont débloqués grâce a un abonnement. Une campagne peut être boostée par n\'importe qui, du moment que le compte a accès à la campagne en question. Une campagne reste boostée tant que le compte a un :subscription actif. Si une campagne n\'est plus boostée, les informations ne sont pas perdues mais deviennent simplement invisibles jusqu\'à ce que la campagne soit à nouveau boostée.',
            'header'            => 'Image d\'en-tête pour entité.',
            'headers'           => [
                'boosted'       => 'Avantages d\'une campagne boostée',
                'superboosted'  => 'Avantages d\'une campagne superboostée',
            ],
            'helpers'           => [
                'boosted'       => 'Booster une campagne assign un booster à la campagne.',
                'superboosted'  => 'Superbooster une campagne assign un total de trois boosters à la campagne.',
            ],
            'images'            => 'Images d\'entité par défaut personnalisées.',
            'more'              => [
                'boosted'       => 'Toutes les fonctionnalités pour les campagnes boostées',
                'superboosted'  => 'Toutes les fonctionnalités pour les campagnes superboostées',
            ],
            'recovery'          => 'Récupérer des entités supprimées pendant :amount jours.',
            'superboost'        => 'Superbooster une campagne utilise 3 boosts et permet d\'autres fonctionnalités en plus de celles débloquées par les campagnes boostées.',
            'theme'             => 'Thème de campagne et style personnalisé.',
            'third'             => 'Pour booster une campagne, aller sur la page de la campagne et cliquer sur le bouton ":boost_button" situé au dessus du bouton ":edit_button".',
            'tooltip'           => 'Infobulles personnalisées pour les entités.',
            'upload'            => 'Taille des fichiers uploadés plus grande pour tous les membres de la campagne.',
        ],
        'buttons'       => [
            'boost'         => 'Boost',
            'superboost'    => 'Superboost',
            'tooltips'      => [
                'boost'         => 'Booster une campagne utilise :amount boosts.',
                'superboost'    => 'Superbooster une campagne utilise :amount boosts.',
            ],
        ],
        'campaigns'     => 'Campagnes boostées :count / :max',
        'exceptions'    => [
            'already_boosted'       => 'La campagne :name est déjà boostée.',
            'exhausted_boosts'      => 'Tu n\'as plus de boost disponnible. Retire un boost d\'une campagne avant de pouvoir l\'attribuer à une autre.',
            'exhausted_superboosts' => 'Tu n\'as plus de boosts. Tu as besoin de 3 boosts pour superbooster une campagne.',
        ],
        'success'       => [
            'boost'         => 'La campagne :name est boostée.',
            'delete'        => 'Boost retiré de :name.',
            'superboost'    => 'La campagne :name est superboostée.',
        ],
        'title'         => 'Boost',
        'unboost'       => [
            'description'   => 'Es-tu sûr de vouloir arrêter de booster la campagne :tag?',
            'title'         => 'Débooster une campagne',
        ],
    ],
    'countries'     => [
        'austria'       => 'Autriche',
        'belgium'       => 'Belgique',
        'france'        => 'France',
        'germany'       => 'Allemagne',
        'italy'         => 'Italie',
        'netherlands'   => 'Pays-Bas',
        'spain'         => 'Espagne',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Télécharger PDF',
            'view_all'  => 'Tout voir',
        ],
        'empty'     => 'Aucune facture',
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
        'success'   => 'Options de mise en page modifiées.',
        'title'     => 'Mise en page',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Nom sur le marketplace',
        ],
        'helper'    => 'Par défaut, le nom d\'utilisateur est affiché sur le :marketplace. Le nom affiché peut être modifié avec ce champs.',
        'title'     => 'Paramètres du Marketplace',
        'update'    => 'Paramètres du marketplace sauvegardés.',
    ],
    'menu'          => [
        'account'               => 'Compte',
        'api'                   => 'API',
        'apps'                  => 'Apps',
        'billing'               => 'Méthode de paiement',
        'boost'                 => 'Boost',
        'invoices'              => 'Factures',
        'layout'                => 'Mise en Page',
        'marketplace'           => 'Marketplace',
        'other'                 => 'Autre',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Options de paiement',
        'personal_settings'     => 'Paramètres Personnels',
        'profile'               => 'Profil',
        'settings'              => 'Paramètres',
        'subscription'          => 'Abonnement',
        'subscription_status'   => 'Status d\'abonnement',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Lier le compte',
            'view'  => 'Visiter Kanka sur Patreon',
        ],
        'benefits'          => 'Nous supporter sur :patreon active plein de :features pour toi et tes campagnes, et nous permet de dédier plus de temps à travailler sur Kanka.',
        'benefits_features' => 'fonctionnalités sympas',
        'deprecated'        => 'Fonction obsolète - si tu souhaites supporter Kanka, fais-le avec un abonnement. La liaison Patreon est toujours active pour nos Patrons qui ont lié leur compte avant le changement d\'abonnement.',
        'description'       => 'Synchronisation avec Patreon',
        'linked'            => 'Merci pour ton support sur Patreon! Ton compte est dorénavant lié.',
        'pledge'            => 'Pledge: :name',
        'remove'            => [
            'button'    => 'Délier le compte Patreon',
            'success'   => 'Ton compte Patreon a été délié.',
            'text'      => 'Délier le compte Patreon de Kanka supprime les bonus, le nom du Hall of Fame, les boosters de campagne et d\'autres fonctionnalités liées au supporter de Kanka. Aucun contenu boosté ne sera perdu (par exemple les en-têtes d\'entité). Lors du réabonnement, toutes les données seront à nouveau visibles, y compris la possibilité de booster des campagnes précédemment boostées.',
            'title'     => 'Délier le compte Patreon de Kanka',
        ],
        'success'           => 'Merci pour ton support sur Patreon!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Ton pledge est inséré manuellement par nous, du coup ça peut prendre quelques jours pour être actualisé. Si ça prend longtemps, n\'hésite pas à nous contacter.',
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
        'benefits'              => 'En nous soutenant, tu peux débloquer de nouvelles fonctionnalités et nous aider à investir plus de temps dans l\'amélioration de Kanka. Aucune information concernant ta carte de crédit n\'est stockée ou ne transite par nos serveurs. Nous utilisons :stripe pour gérer toutes les factures.',
        'billing'               => [
            'helper'    => 'Les informations de paiement sont gérées et sauvegardées de manière sécurisée à travers :stripe. Cette méthode de paiement sera utilisée pour tous les abonnements.',
            'saved'     => 'Méthode de paiement',
            'title'     => 'Modifier la méthode de paiement',
        ],
        'cancel'                => [
            'text'  => 'Désolé de te voir partir! L\'annulation de ton abonnement le gardera actif jusqu\'au la fin du mois payé, après quoi tu perdras les bonus de ta campagne et les autres avantages liés au soutien de Kanka. N\'hésite pas à remplir le formulaire suivant pour nous informer de ce que nous pouvons améliorer, ou ce qui a conduit à ta décision.',
        ],
        'cancelled'             => 'L\'abonnement a été annulé. Un nouvel abonnement peut être fait dès que celui-ci arrive à terme.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Abonnement au niveau :tier, facturé mensuellement pour :amount.',
                'yearly'    => 'Abonnement au niveau :tier, facturé annuellement pour :amount.',
            ],
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
            'callback'      => 'Notre gestionnaire de paiement nous a remonté une erreur. Prière de réessayer et nous contacter si le problème persiste.',
            'subscribed'    => 'Erreur lors de la gestion de l\'abonnement. Stripe nous a fourni l\'erreur suivante.',
        ],
        'fields'                => [
            'active_since'      => 'Actif depuis',
            'active_until'      => 'Active jusqu\'à',
            'billing'           => 'Facturation',
            'currency'          => 'Devise',
            'payment_method'    => 'Méthode de paiement',
            'plan'              => 'Abonnement actuel',
            'reason'            => 'Raison',
        ],
        'helpers'               => [
            'alternatives'          => 'Payez votre abonnement en utilisant :method. Ce mode de paiement ne sera pas renouvelé automatiquement à la fin de votre abonnement. :method n\'est disponible qu\'en Euros.',
            'alternatives_warning'  => 'La mise à niveau de l\'abonnement lors de l\'utilisation de cette méthode n\'est pas possible. Veuillez créer un nouvel abonnement à la fin de votre abonnement actuel.',
            'alternatives_yearly'   => 'En raison des restrictions entourant les paiements récurrents, :method n\'est disponible que pour les abonnements annuels',
        ],
        'manage_subscription'   => 'Gérer l\'abonnement',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Ajouter une méthode de paiement',
                'change'            => 'Modifier la méthode de paiement',
                'save'              => 'Enregister la méthode de paiement',
                'show_alternatives' => 'Autres méthodes de paiement',
            ],
            'add_one'       => 'Aucune méthode de paiement actuellement saisie.',
            'alternatives'  => 'Un abonnement peut être souscrit avec ces méthodes de paiement. Cette action ne générera qu\'une seule facture et ne renouvellera pas automatiquement l\'abonnement chaque mois.',
            'card'          => 'Carte',
            'card_name'     => 'Nom sur la carte',
            'country'       => 'Pays de résidence',
            'ending'        => 'Se terminant par',
            'helper'        => 'Cette carte sera utilisée pour les abonnements.',
            'new_card'      => 'Ajouter une méthode de paiement',
            'saved'         => ':brand se terminant par :last4',
        ],
        'placeholders'          => [
            'reason'    => '(optionnelle) dis-nous pourquoi tu ne souhaites plus être abonné à Kanka. Manquait-il une fonctionnalité? Ta situation financière a-t-elle changé?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount facturé mensuellement',
            'cost_yearly'   => ':currency :amount facturé annuellement',
        ],
        'sub_status'            => 'Information d\'abonnement',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Prière de nous contacter pour un déclassement',
                'rollback'          => 'Changer à Kobold',
                'subscribe'         => 'Changer à :tier mensuel',
                'subscribe_annual'  => 'Changer à :tier annuel',
            ],
        ],
        'success'               => [
            'alternative'   => 'Le paiement a été enregistré. Une notification sera générée dès le paiement traité et l\'abonnement activé.',
            'callback'      => 'Ton abonnement est réussi! Ton compte sera mis à jour dès que notre gestionnaire de paiement nous informera des changements (cela peut prendre quelques minutes).',
            'cancel'        => 'Ton abonnement est annulé. Il sera toujours actif jusqu\'à la fin de la période actuelle.',
            'currency'      => 'Devise préférée sauvegardée.',
            'subscribed'    => 'Ton abonnement est réussi! N\'oublie pas de t\'abonner à la newsletter Community Vote pour être averti lorsqu\'un vote sera ouvert. Tu peux modifier tes paramètres de newsletter sur ta page de profil.',
        ],
        'tiers'                 => 'Niveaux d\'abonnements',
        'trial_period'          => 'Les abonnements annuels ont une période d\'annulation de 14 jours. Nous contacter à :email pour annuler un abonnement et recevoir un remboursement.',
        'upgrade_downgrade'     => [
            'button'    => 'Information sur l\'upgrade/downgrade',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Tes bonus restent activés jusqu\'à la fin de la période de paiement.',
                    'boosts'    => 'La même chose se passe pour les campagnes boostées. Les fonctionnalités boostées deviennent invisibles mais les données ne sont pas supprimé lorsqu\'une campagne n\'est plus boostée.',
                    'kobold'    => 'Pour annuler ton abonnement, change au tier Kobold.',
                ],
                'title'     => 'Lors de l\'annulation d\'un abonnement',
            ],
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
            'incomplete'    => 'Nous n\'avons pas pu débiter la carte de crédit. Vérifier les informations de la carte et mettre à jour si nécessaire. Nous essayerons à nouveau durant les prochains jours. Si ça échoue de nouveau, l\'abonnement sera annulé.',
            'patreon'       => 'Ce compte est actuellement lié à Patreon. Prière de délier le compte dans les paramètres :patreon avant de pouvoir s\'abonner à Kanka.',
        ],
    ],
];
