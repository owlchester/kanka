<?php

return [
    'actions'       => [
        'return'        => 'Ritorna a tutti i prompt',
        'send'          => 'Partecipa',
        'show_ongoing'  => 'Visualizza Evento & Partecipa',
        'show_past'     => 'Visualizza Evento & Vincitori',
        'update'        => 'Aggiorna la consegna',
        'view'          => 'Visualizza la consegna',
    ],
    'description'   => 'Organizziamo frequentemente prompt di worldbuilding per la nostra comunità, con i nostri preferiti in mostra.',
    'fields'        => [
        'comment'       => 'Commenta',
        'entity_link'   => 'Link all\'entità',
        'honorable'     => 'Menzione d\'onore',
        'jury'          => 'Giuria ospite :user',
        'rank'          => 'Rango',
        'submitter'     => 'Autore',
    ],
    'index'         => [
        'ongoing'   => 'Prompt in corso',
        'past'      => 'Prompt passati',
    ],
    'participate'   => [
        'description'   => 'Ti senti ispirato da questa prompt? Crea un\'entità in una delle tue campagne pubbliche e inviaci il link all\'entità nel modulo sottostante. Puoi modificare o cancellare la tua consegna in qualsiasi momento.',
        'login'         => 'Accedi al tuo account per partecipare al prompt.',
        'participated'  => 'Hai già inviato la tua consegna al prompt. Puoi modificarla o rimuoverla.',
        'success'       => [
            'modified'  => 'I cambiamenti alla tua consegna sono stati salvati.',
            'removed'   => 'La tua consegna è stata rimossa.',
            'submit'    => 'La tua consegna è stata inviata. Puoi modificarla o rimuoverla in qualsiasi momento.',
        ],
        'title'         => 'Partecipa in un prompt di worldbuilding',
    ],
    'placeholders'  => [
        'comment'       => 'Commento relativo alla tua consegna (facoltativo)',
        'entity_link'   => 'Copia-incolla qui il link all\'entità',
    ],
    'results'       => [
        'description'       => 'La nostra giuria ha selezionato i seguenti lavori come vincitori per questo prompt.',
        'scheduled'         => 'Il prompt inizierà il :start.',
        'title'             => 'Vincitori del Prompt',
        'waiting_results'   => 'Il concorso del prompt è terminato! La giuria dell\'evento esaminerà i lavori inviati e, non appena saranno selezionati i vincitori, questi verranno visualizzati qui.',
    ],
    'show'          => [
        'participants'  => '{1} :number consegna inviata.|[2,*] :number consegne inviate.',
        'title'         => 'Evento :name',
    ],
    'title'         => 'Prompt di Worldbuilding',
];
