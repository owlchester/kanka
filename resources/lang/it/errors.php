<?php

return [
    '403'       => [
        'body'  => 'Sembra che tu non abbia il permesso per accedere a questa pagina!',
        'title' => 'Permesso Negato',
    ],
    '404'       => [
        'body'  => 'Ci dispiace, la pagina che stavi cercando non può essere trovata.',
        'title' => 'Pagina non trovata',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Ops, sembra che qualcosa non abbia funzionato.',
            '2' => 'Un report con l\'errore riscontrato ci è  appena stato inviato ma ogni tanto ci può essere d\'aiuto sapere qualcosa in più su cosa stessi facendo.',
        ],
        'title' => 'Errore',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka è attualmente in manutenzione che normalmente significa che un c\'è aggiornamento in corso!',
            '2' => 'Ci dispiace per l\'inconveniente. Tutto tornerà alla normalità in pochi minuti.',
        ],
        'title' => 'Manutenzione',
    ],
    '503-form'  => [
        'body'  => 'Non possiamo salvare i tuoi dati correttamente, chè è normalmente causato da uno dei seguenti due fattori. Per favore apri Kanka in una :link se l\'app è in manutenzione, salva cortesemente i tuoi dati da qualche altra parte finché l\'app non è nuovamente utilizzabile e riprova.Se vieni avvisato da un "Controlla il tuo browser" può provare a salvare nuovamente.',
        'link'  => 'nuova finestra',
        'title' => 'È successo qualcosa di inaspettato.',
    ],
    'footer'    => 'Se necessiti di ulteriore assistenza per favore contattaci a hello@kanka.io oppure su :discord',
];
