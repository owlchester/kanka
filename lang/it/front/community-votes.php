<?php

return [
    'actions'       => [
        'return'    => 'Ritorna a tutti i voti della comunità.',
        'show'      => 'Mostra i risultati dei voti',
        'subscribe' => 'Abbonati a Kanka per votare',
        'vote'      => 'Vota',
    ],
    'description'   => 'Gli utenti che supportano Kanka contribuiscono all\'evoluzione dell\'applicazione partecipando alle frequenti votazioni della comunità.',
    'index'         => [
        'past'      => 'Voti della Comunità Chiusi',
        'voting'    => 'Voti della Comunità Attivi',
    ],
    'latest'        => [
        'title' => 'Voti Recenti',
    ],
    'show'          => [
        'restricted'    => 'I voti della Comunità sono disponibili solo per gli utenti che supportano Kanka.',
        'title'         => 'Voto della Comunità - :name',
        'vote_count'    => '{1} :number partecipante ha votato.|[2,*] :number partecipanti hanno votato.',
        'voted_lasted'  => 'La votazione è durata da :from GMT a :until GMT.',
        'voting_until'  => 'La votazione è aperta fino a :until GMT.',
    ],
    'title'         => 'Voti della Comunità',
];
