<?php

return [
    'actions'       => [
        'return'        => 'Terug naar alle evenementen',
        'send'          => 'Deelnemen',
        'show_ongoing'  => 'Bekijk Evenement & Deelnemen',
        'show_past'     => 'Bekijk Evenement & Winnaars',
        'update'        => 'Update inzending',
        'view'          => 'Bekijk inzending',
    ],
    'description'   => 'We houden regelmatig worldbuilding evenementen voor onze community met onze favoriete inzendingen.',
    'fields'        => [
        'comment'       => 'Reactie',
        'entity_link'   => 'Link naar de entiteit',
        'rank'          => 'Rank',
        'submitter'     => 'Inzender',
    ],
    'index'         => [
        'ongoing'   => 'Lopende evenementen',
        'past'      => 'Afgelopen evenementen',
    ],
    'participate'   => [
        'description'   => 'Voel je je geïnspireerd door dit evenement? Maak een entiteit in een van je openbare campaigns en stuur ons de link naar de entiteit in het onderstaande formulier. Je kunt je inzending op elk moment wijzigen of verwijderen.',
        'login'         => 'Log in op je account om deel te nemen aan het evenement.',
        'participated'  => 'Je hebt al een inzending voor dit evenement verzonden. Je kunt het bewerken of verwijderen.',
        'success'       => [
            'modified'  => 'Wijzigingen in je inzending zijn opgeslagen.',
            'removed'   => 'Je inzending is verwijderd.',
            'submit'    => 'Je inzending is verzonden. Je kunt deze op elk moment bewerken of verwijderen.',
        ],
        'title'         => 'Deelnemen aan het evenement',
    ],
    'placeholders'  => [
        'comment'       => 'Opmerking over je inzending (optioneel)',
        'entity_link'   => 'Kopieer en plak hier de link naar de entiteit',
    ],
    'results'       => [
        'description'       => 'Onze jury koos de volgende inzendingen als winnaars voor het evenement.',
        'title'             => 'Evenement Winnaars',
        'waiting_results'   => 'Het evenement is voorbij! De evenement jury bekijkt de inzendingen en zodra de winnaars zijn geselecteerd, worden ze hier weergegeven.',
    ],
    'show'          => [
        'participants'  => '{1} :number inzending verzonden.|[2,*] :number inzendingen verzonden.',
        'title'         => 'Evenement :name',
    ],
    'title'         => 'Evenementen',
];
