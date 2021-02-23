<?php

return [
    'age'           => [
        'description'   => 'Możesz połączyć postać z kalendarzem kampanii wchodząc w zakładkę Powiadomienia w menu postaci. Tam dodaj nowe powiadomienie i ustaw typ jako Narodziny albo Śmierć, by automatycznie obliczyć wiek postaci. Jeżeli dodasz obie daty, nie tylko zostaną wyświetlone, ale program obliczy też wiek postaci w chwili śmierci. Dodanie wyłącznie daty narodzin spowoduje wyświetlenie obecnego wieku, a wyłącznie daty śmierci - liczby lat, która od niej upłynęła.',
        'title'         => 'Wiek i śmierć postaci',
    ],
    'attributes'    => [
        'con'           => 'Kon',
        'description'   => 'By oznaczyć współczynniki postaci, które nie są tekstem, używaj cech. Możesz tworzyć odnośniki do postaci w cechach używając składni zaawansowanych wzmianek :mention. Możesz też wspominać inne cechy za pomocą składni :attribute.',
        'level'         => 'Poziom',
        'link'          => 'Opcje cech',
        'math'          => 'Możesz też bawić się obliczeniami. Na przykład :example pomnoży cechę :level przez cechę :com dla tego elementu. Jeżeli chcesz zaokrąglać w górę albo w dół, użyj :floor albo :ceil.',
        'pinned'        => 'Przypięcie cechy za pomocą ikony :icon spowoduje, że będzie się wyświetlać w głównym menu elementu, pod obrazkiem.',
        'private'       => 'Cechy tajne, używające ikony :icon będą widoczne tylko dla administratorów kampanii.',
        'title'         => 'Cechy',
    ],
    'dice'          => [
        'description'               => 'Możesz konfigurować podstawowe rzuty kośćmi po prostu pisząc "d20", "4d4+4", "d%" dla kości procentowej i "df" dla kostki fudge.',
        'description_attributes'    => 'Możesz też użyć cechy postaci za pomocą składni {character.nazwa_cechy}. Na przykład pisząc {character.poziom}d6+{character.mądrość}.',
        'more'                      => 'Więcej opcji i przykładów znajduje się na stronie modułu rzucania kośćmi.',
        'title'                     => 'Rzuty kośćmi',
    ],
    'filters'       => [
        'description'   => 'Możesz zmniejszyć liczbę wyświetlanych elementów za pomocą filtrów. Pola tekstowe posiadają kilka opcji które pozwalają dodatkowo zawęzić filtrowanie.',
        'empty'         => 'Wpisując w treści zapytania :tag wyszukasz elementy, które mają to pole puste.',
        'ending_with'   => 'Umieszczając po tekście zapytania :tag możesz szukać wszystkiego, co posiada dokładnie taki tekst.',
        'multiple'      => 'Możesz łączyć opcje wyszukiwania używając :syntax, na przykład :example',
        'session'       => 'Filtry i zadane kolumny dla danej listy',
        'starting_with' => 'Umieszczając przed tekstem zapytania :tag możesz szukać wszystkiego, co nie posiada w takiego tekstu.',
        'title'         => 'Jak używać filtrów',
    ],
    'link'          => [
        'attributes'        => 'Możesz stworzyć odnośnik do cechy elementy pisząc :code. Funkcja działa wyłącznie z już istniejącymi cechami tego elementu.',
        'auto_update'       => 'Odnośniki do innych elementów aktualizują się automatycznie, kiedy zmienia się nazwa albo opis celu.',
        'description'       => 'Możesz z łatwością tworzyć odnośniki do innych elementów kampanii przy pomocy następującego skrótu.',
        'formatting'        => [
            'text'  => 'Lista dozwolonych tagów HTML i cech znajduje się na naszym :github.',
            'title' => 'Fromatowanie',
        ],
        'friendly_mentions' => 'By stworzyć odnośnik do innego elementu wpisz :code i kilka pierwszych znaków nazwy, by go wyszukać. Dzięki temu umieścisz :example w edytorze tekstu i utworzysz odnośnik do tego elementu podczas jego przeglądania.',
        'limitations'       => 'Pamiętaj że ze względu na ograniczenia techniczne takie skróty nie działają na urządzeniach mobilnych jeżeli nie używasz edytora Summernote. Możesz zmienić edytor wchodząc w Ustawienia > Układ.',
        'mentions'          => 'Możesz tworzyć odnośniki do innych elementów wpisując :code i pierwsze kilka znaków nazwy, by je wyszukać. To umieści :example w edytorze teksty. By zmienić wyświetlaną nazwę, wpisz :example_name. Jeżeli odnośnik ma prowadzić na podstronę elementu, użyj :example_page, jeżeli chcesz zalinkować zakładkę, użyj example:tab.',
        'months'            => 'Wpisz :code by otrzymać listę miesięcy z twoich kalendarzy.',
        'title'             => 'Tworzenie odnośników i skrótów',
    ],
    'map'           => [
        'description'   => 'Dodanie do miejsca mapy uruchomi menu \'Mapa\' w widoku tego miejsca oraz bezpośredni odnośnik do tej mapy z menu miejsca. Oglądając mapę, uczestnicy kampanii z prawem do edycji mogą uruchomić \'Tryb Edycji\', który pozwala dodawać Punkty Mapy. Te z kolei mogą być samymi podpisami albo prowadzić do istniejących elementów kampanii. Mają też różne kształty i rozmiary.',
        'private'       => 'Administratorzy mogą utajniać mapy. Dzięki temu zwykli uczestnicy mogą oglądać miejsca i nie widzieć ich map.',
        'title'         => 'Mapy miejsc',
    ],
    'public'        => 'Zobacz tutorial na Youtube dotyczący kampanii publicznych.',
    'title'         => 'Pomoc',
];
