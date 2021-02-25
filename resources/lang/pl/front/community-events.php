<?php

return [
    'actions'       => [
        'return'        => 'Powrót do listy wydarzeń',
        'send'          => 'Dołącz',
        'show_ongoing'  => 'Zobacz wydarzenia i dołącz',
        'show_past'     => 'Zobacz wydarzenie i zwycięzców',
        'update'        => 'Aktualizuj zgłoszenie',
        'view'          => 'Zobacz zgłoszenie',
    ],
    'description'   => 'Regularnie organizujemy dla naszej społeczności wydarzenia światotwórcze, nagradzając zgłoszenia które najbardziej nam się spodobały.',
    'fields'        => [
        'comment'       => 'Komentarz',
        'entity_link'   => 'Odnośnik do elementu',
        'rank'          => 'Ranga',
        'submitter'     => 'Zgłaszający',
    ],
    'index'         => [
        'ongoing'   => 'Aktualne wydarzenia',
        'past'      => 'Minione wydarzenia',
    ],
    'participate'   => [
        'description'   => 'Inspiruje cię to wydarzenie? Stwórz element w swojej publicznej kampanii i wklej odnośnik poniżej. Możesz w każdej chwili zmienić albo usunąć zgłoszenie.',
        'login'         => 'Zaloguj się i dołącz do wydarzenia.',
        'participated'  => 'Masz już wysłane zgłoszenie do tego wydarzenia. Możesz je edytować lub usunąć.',
        'success'       => [
            'modified'  => 'Zapisano zmiany w zgłoszeniu.',
            'removed'   => 'Usunięto zgłoszenie.',
            'submit'    => 'Wysłano zgłoszenie. Możesz je w każdej chwili zmienić lub usunąć.',
        ],
        'title'         => 'Weź udział w wydarzeniu',
    ],
    'placeholders'  => [
        'comment'       => 'Komentarz dotyczący zgłoszenia (opcjonalny)',
        'entity_link'   => 'Wklej tu odnośnik do elementu kampanii',
    ],
    'results'       => [
        'description'       => 'Nasze jury zdecydowało się wyróżnić następujące zgłoszenia do tego wydarzenia.',
        'title'             => 'Zwycięzcy wydarzenia',
        'waiting_results'   => 'Wydarzenie zakończone! Jury oceni teraz zgłoszenia i wyłoni zwycięzców, którzy zostaną ogłoszeniu tutaj.',
    ],
    'show'          => [
        'participants'  => '{1} :number zgłoszenie.|[2,3,4] :number zgłoszenia.|[5,*] :number zgłoszeń.',
        'title'         => 'Wydarzenie :name',
    ],
    'title'         => 'Wydarzenia',
];
