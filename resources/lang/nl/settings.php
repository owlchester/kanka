<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Schakel over naar Kanka Login',
            'update_email'      => 'Werk e-mail bij',
            'update_password'   => 'Vernieuw wachtwoord',
        ],
        'email'             => 'E-mailadres wijzigen',
        'email_success'     => 'E-mail bijgwerkt.',
        'password'          => 'Wijzig wachtwoord',
        'password_success'  => 'Wachtwoord bijgewerkt.',
        'social'            => [
            'error'     => 'Je gebruikt de Kanka-login al voor dit account.',
            'helper'    => 'Je account wordt momenteel beheerd door :provider. Je kunt stoppen met het gebruik en overschakelen naar de standaard Kanka-login door een wachtwoord in te stellen.',
            'success'   => 'Je account gebruikt nu de Kanka-login.',
            'title'     => 'Sociaal voor Kanka',
        ],
        'title'             => 'Account',
    ],
    'api'           => [
        'title' => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Verbind',
            'remove'    => 'Verwijder',
        ],
        'benefits'  => 'Kanka biedt enkele integratie met services van derden. Voor de toekomst zijn er meer integraties van derden gepland.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Er is een fout opgetreden bij het koppelen van je Discord-account aan Kanka. Probeer het a.u.b. opnieuw.',
            ],
            'success'   => [
                'add'       => 'Je Discord account is gekoppeld.',
                'remove'    => 'Je Discord account is ontkoppeld.',
            ],
            'text'      => 'Krijg automatisch toegang tot je abonnement rollen.',
        ],
        'title'     => 'App Integratie',
    ],
    'boost'         => [
        'benefits'  => [
            'campaign_gallery'  => 'Een campaign galerij om afbeeldingen te uploaden die je via de campaign kunt hergebruiken.',
            'entity_files'      => 'Upload tot wel 10 bestanden per entiteit.',
            'entity_logs'       => 'Volledige entiteit logboeken van wat er bij elke update op een entiteit is gewijzigd.',
            'header'            => 'Entiteit header afbeeldingen.',
            'images'            => 'Aangepaste standaard entiteit afbeeldingen.',
            'more'              => 'Lees meer over alle functies.',
        ],
        'buttons'   => [
            'boost'         => 'Boost',
            'superboost'    => 'Superboost',
        ],
    ],
    'countries'     => [
        'austria'       => 'Oostenrijk',
        'belgium'       => 'België',
        'france'        => 'Frankrijk',
        'germany'       => 'Duitsland',
        'italy'         => 'Italië',
        'netherlands'   => 'Nederland',
        'spain'         => 'Spanje',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Download PDF',
            'view_all'  => 'Bekijk alle',
        ],
        'fields'    => [
            'date'      => 'Datum',
            'status'    => 'Status',
        ],
    ],
    'menu'          => [
        'account'               => 'Account',
        'api'                   => 'API',
        'apps'                  => 'Apps',
        'boost'                 => 'Boost',
        'layout'                => 'Lay-out',
        'marketplace'           => 'Marktplaats',
        'other'                 => 'Andere',
        'patreon'               => 'Patreon',
        'personal_settings'     => 'Persoonlijke Instellingen',
        'profile'               => 'Profiel',
        'subscription'          => 'Abbonement',
        'subscription_status'   => 'Abbonement Status',
    ],
    'profile'       => [
        'avatar'    => 'Profiel Foto',
    ],
    'subscription'  => [
        'actions'           => [
            'subscribe' => 'Abboneer',
        ],
        'currencies'        => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'fields'            => [
            'reason'    => 'Reden',
        ],
        'upgrade_downgrade' => [
            'downgrade' => [
                'title' => 'Bij het downgraden naar een lager niveau',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Uw betalingsmethode wordt onmiddellijk gefactureerd en u krijgt toegang tot uw nieuwe niveau.',
                    'prorate'   => 'Bij het upgraden van Owlbear naar Elemental, wordt alleen het verschil met je nieuwe niveau in rekening gebracht.',
                ],
                'title'     => 'Bij het upgraden naar een hoger niveau',
            ],
        ],
        'warnings'          => [
            'incomplete'    => 'We konden uw creditcard niet belasten. Werk uw creditcardgegevens bij en we zullen proberen deze de komende dagen opnieuw in rekening te brengen. Als het opnieuw mislukt, wordt uw abonnement opgezegd.',
            'patreon'       => 'Uw account is momenteel gekoppeld aan Patreon. Ontkoppel uw account in uw: patreon-instellingen voordat u overschakelt naar een Kanka-abonnement.',
        ],
    ],
];
