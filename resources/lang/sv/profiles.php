<?php

return [
    'avatar'        => [
        'success'   => 'Avatar uppdaterad.',
    ],
    'description'   => 'Uppdatera dina profiluppgifter',
    'edit'          => [
        'success'   => 'Profil uppdaterad',
    ],
    'editors'       => [
        'summernote'    => 'Summernote',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Epost',
        'last_login_share'          => 'Della när jag senast loggade in med andra kampanjmedlemmar',
        'name'                      => 'Namn',
        'new_password'              => 'Nytt Lösenord',
        'new_password_confirmation' => 'Nytt Lösenord Bekräftelse',
        'newsletter'                => 'Jag önskar att ibland bli kontaktad via mail.',
        'password'                  => 'Nuvarande lösenord',
        'settings'                  => 'Inställningar',
        'theme'                     => 'Tema',
    ],
    'newsletter'    => [
        'links'     => [
            'community-vote'    => 'Community Röstning',
            'news'              => 'Nyheter',
        ],
        'settings'  => [
            'news'          => 'Nyheter - bli underrättad när det finns :news.',
            'newsletter'    => 'Nyhetsbrev - få Kankas nyhetsbrev.',
            'votes'         => 'Community Röstningar - bli underrättad så fort en ny :vote är tillgänglig',
        ],
        'title'     => 'Nyhetsbrev',
    ],
    'password'      => [
        'success'   => 'Lösenord uppdaterat',
    ],
    'placeholders'  => [
        'email'                     => 'Din e-postadress',
        'name'                      => 'Ditt visningsnamn',
        'new_password'              => 'Ditt nya lösenord',
        'new_password_confirmation' => 'Bekräfta ditt nya lösenord',
        'password'                  => 'Ditt nuvarande lösenord för att bekräfta ändringar',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Ta bort mitt konto',
            'title'     => 'Ta bort ditt konto',
            'warning'   => 'Genom att ta bort ditt konto kommer all din data att gå förlorad. Är du säker?',
        ],
        'password'  => [
            'title' => 'Ändra ditt lösenord',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Avancerade Omnämningar',
            'date_format'           => 'Datum Formatering',
            'default_nested'        => 'Hierarkiska Vyer som Standard',
            'editor'                => 'Text Redigerare',
            'new_entity_workflow'   => 'Ny Entitet Arbetsflöde',
            'pagination'            => 'Element per sida',
        ],
        'helpers'   => [
            'editor'    => 'Standard redigeraren (TinyMCE 4) är gammal men fungerar bra på dartor, men fungerar inte alls på mobil. Summernote är en nyare redigerare som funkar på alla enheter men vi testar den fortfarande.',
        ],
        'hints'     => [
            'advanced_mentions'     => 'Om aktiverad, omnämnanden kommer alltid renderas som [entitet:123] när en entitet redigeras.',
            'default_nested'        => 'Aktivera detta alternativ om du vill ha listor Hierarkiska som standard (när det är tillgängligt).',
            'new_entity_workflow'   => 'När en ny entitet skapas så är standard arbetsflödet att gå till listan över entiteter. Du kan ändra detta till att visa den nyligen skapade entiteten istället.',
        ],
        'success'   => 'Inställningar ändrade.',
    ],
    'theme'         => [
        'success'   => 'Tema ändrat.',
        'themes'    => [
            'dark'      => 'Mörk',
            'default'   => 'Standard',
            'future'    => 'Framtid',
            'midnight'  => 'Midnattsblå',
        ],
    ],
    'title'         => 'Uppdatera din profil',
    'workflows'     => [
        'created'   => 'Gå till skapad entitet',
        'default'   => 'Lista över entiteter',
    ],
];
