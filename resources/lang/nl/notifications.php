<?php

return [
    'campaign'          => [
        'application'   => [
            'approved'  => 'Je aanvraag voor de campaign :campaign is goedgekeurd.',
            'new'       => 'Nieuwe aanvraag voor :campaign.',
            'rejected'  => 'Je aanvraag voor de :campaign campaign is afgewezen. Reden opgegeven: :reason',
        ],
        'asset_export'  => 'Er is een export van campaign assets beschikbaar. De link is beschikbaar voor :time minuten.',
        'boost'         => [
            'add'           => 'Campaign :campaign wordt ge-boost door :user.',
            'remove'        => ':user boost niet langer de campaign :campaign.',
            'superboost'    => 'Campaign :campaign wordt ge-superboost door :user',
        ],
        'export'        => 'Een export van een campaign is beschikbaar. De link is beschikbaar voor :time minutes.',
        'export_error'  => 'Er is een fout opgetreden bij het exporteren van je campaign. Neem contact met ons op als dit probleem zich blijft voordoen.',
        'join'          => ':user heeft zich aangesloten bij de campaign :campaign.',
        'leave'         => ':user heeft de campaign :campaign verlaten.',
        'role'          => [
            'add'       => 'Je bent toegevoegd aan de :role rol in de :campaign campaign.',
            'remove'    => 'Je bent verwijderd van de :role rol in de :campaign campaign.',
        ],
    ],
    'header'            => 'Je hebt :count notificaties',
    'index'             => [
        'title' => 'Notificaties',
    ],
    'no_notifications'  => 'Er zijn momenteel geen notificaties.',
    'subscriptions'     => [
        'charge_fail'   => 'Er is een fout opgetreden bij het verwerken van uw betaling. Wacht even terwijl we het opnieuw proberen. Als er niets verandert, neem dan contact met ons op.',
        'deleted'       => 'Uw abonnement op Kanka is geannuleerd na te veel mislukte pogingen om uw kaart op te laden. Ga naar uw abonnementsinstellingen en probeer uw betalingsgegevens bij te werken.',
        'ended'         => 'Je abonnement op Kanka is beëindigd. Je campaign boosts en Discord rollen zijn verwijderd. We hopen je snel weer te zien!',
        'failed'        => 'We konden uw betalingsgegevens niet in rekening brengen. Werk ze bij in uw betalingsmethode-instellingen.',
        'started'       => 'Je abonnement op Kanka is begonnen.',
    ],
];
