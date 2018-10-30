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
    'footer'    => 'Se necessiti di ulteriore assistenza per favore contattaci a hello@kanka.io oppure su :discord',
];
