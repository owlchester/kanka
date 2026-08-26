<?php

return [
    'actions'           => [
        'import'    => 'Załaduj wyeksportowane',
    ],
    'csv'               => [
        'continue'          => 'Kontynuuj',
        'fields_helper'     => 'Wybierz kolumnę przypisaną każdemu aktywnemu polu elementu.',
        'no_preview'        => 'Brak danych podglądu',
        'preview'           => 'Podgląd',
        'select_module'     => 'Wybór kategorii',
        'select_one'        => 'Wybierz jedną',
        'selected_tags'     => 'Wybrane etykiety',
        'set_column'        => 'Ustaw kolumnę',
        'set_fields'        => 'Ustaw pole',
        'submit'            => 'Przekarz import CSV',
        'traits'            => 'Właściwości postaci',
        'traits_helper'     => 'Możesz dodawać właściowości postaciom: wybrany nagłówek posłuży za właściwość, a odpowiedni rząd za jej wartość.',
        'type_helper'       => 'Wybierz kategorię, do której chcesz zaimportować nowe elementy.',
        'validation_error'  => 'Należy wypełnić przynajmniej 1 kolumnę',
    ],
    'description_v2'    => 'Importuje do tej kampanii elementy, komentarze, cechy, galerie i inne wyeksportowane dane albo nowe elementy z pliku CSV. Import odbywa się w tle i może zająć nieco czasu. Po jedgo zakończeniu administratorzy otrzymają powiadomienie.',
    'fields'            => [
        'file_v2'   => 'Plik CSV albo wyeksportowany plik ZIP',
        'updated'   => 'Ostatnio zmienione',
    ],
    'form'              => 'Załaduj z',
    'limitation_v2'     => 'Można użyć tylko plików csv i zip. Max :size.',
    'progress'          => [
        'uploading' => 'Ładowanie',
    ],
    'status'            => [
        'failed'        => 'Niepowodzenie',
        'finished'      => 'Zakończono',
        'invalid'       => 'Niewłaściwe dane',
        'processing'    => 'Przetwarzanie',
        'queued'        => 'W kolejce',
        'ready'         => 'Gotowe do mapowania',
        'running'       => 'W toku',
        'validating'    => 'Weryfikacja',
    ],
    'subscription'      => [
        'pitch' => 'Przywróć kopię bezpieczeństwa kampanii albo wprowadź eksport z innej kampanii. Dostępne dla planów :wyvern i :elemental.',
    ],
    'title'             => 'Import',
];
