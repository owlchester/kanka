<?php

return [
    'age'               => [
        'description'   => 'Możesz połączyć postać z kalendarzem kampanii wchodząc w zakładkę Powiadomienia w menu postaci. Tam dodaj nowe powiadomienie i ustaw typ jako Narodziny albo Śmierć, by automatycznie obliczyć wiek postaci. Jeżeli dodasz obie daty, nie tylko zostaną wyświetlone, ale program obliczy też wiek postaci w chwili śmierci. Dodanie wyłącznie daty narodzin spowoduje wyświetlenie obecnego wieku, a wyłącznie daty śmierci - liczby lat, która od niej upłynęła.',
        'title'         => 'Wiek i śmierć postaci',
    ],
    'api-filters'       => [
        'description'   => 'W węźle końcowym API :name dostępne są następujące filtry',
        'title'         => 'Filtry API',
    ],
    'attributes'        => [
        'con'               => 'Kon',
        'description'       => 'By oznaczyć współczynniki postaci, które nie są tekstem, używaj cech. Możesz tworzyć odnośniki do postaci w cechach używając składni zaawansowanych wzmianek :mention. Możesz też wspominać inne cechy za pomocą składni :attribute.',
        'level'             => 'Poziom',
        'link'              => 'Opcje cech',
        'math'              => 'Możesz też bawić się obliczeniami. Na przykład :example pomnoży cechę :level przez cechę :con tego elementu. Jeżeli chcesz zaokrąglać w górę albo w dół, użyj :floor albo :ceil.',
        'name'              => 'Możesz stworzyć odnośnik do nazwy elementu za pomocą :name. Jeżeli istnieje cecha o tej nazwie, zostanie użyta w zastępstwie.',
        'pinned'            => 'Przypięcie cechy za pomocą ikony :icon spowoduje, że będzie się wyświetlać w głównym menu elementu, pod obrazkiem.',
        'private'           => 'Cechy tajne, używające ikony :icon będą widoczne tylko dla administratorów kampanii.',
        'random'            => 'Podczas tworzenia albo edycji szablonu cech, możesz ustawić cechę losową. Może wybierać z dwóch wartości rozdzielonych przez :dash, albo losową wartość z listy rozdzielonej z pomocą :comma. Losowa wartość cechy zostaje wybrana kiedy szablon zostaje przypisany do elementu albo gdy element jest zapisywany.',
        'random_examples'   => 'Na przykład, jeżeli chcesz wartości od 1 do 100, użyj :number. Jeżeli natomiast chcesz wartości wybranej z listy dostępnych opcji, użyj :list.',
        'title'             => 'Cechy',
    ],
    'dice'              => [
        'description'               => 'Możesz konfigurować podstawowe rzuty kośćmi po prostu pisząc "d20", "4d4+4", "d%" dla kości procentowej i "df" dla kostki fudge.',
        'description_attributes'    => 'Możesz też użyć cechy postaci za pomocą składni {character.attribute_name}. Na przykład pisząc {character.level}d6+{character.wisdom}.',
        'more'                      => 'Więcej opcji i przykładów znajduje się na stronie modułu rzucania kośćmi.',
        'title'                     => 'Rzuty kośćmi',
    ],
    'entity_templates'  => [
        'description'   => 'Kiedy tworzysz nowy element, nie musisz zaczynać od zera. Możesz zamiast tego ustawić inny istniejący element jako szablon - wystarczy że wejdziesz w jego wygląd szczegółowy i wybierzesz :link w menu akcji :actions, w prawym górnym rogu. Od tej pory szablon tego elementu będzie dostępny zaraz obok przycisku :new. Możesz ustawić wiele elementów danego typu w roli szablonów.',
        'link'          => 'Jak stworzyć szablon',
        'remove'        => 'By usunąć szablon elementu, wybierz akcję :remove, która zastępuje akcję :link opisaną wyżej.',
        'title'         => 'Szablony elementów',
    ],
    'filters'           => [
        'attributes'    => [
            'exclude'   => '!Poziom',
            'first'     => 'Możesz filtrować elementy ze względu na cechy, wpisując dokładną nazwę i wartość w odpowiednie pola wyszukiwania. Jeżeli nie wpiszesz wartości, wyszukane zostaną tylko elementy posiadające wpisaną cechę. Możesz wpisać :exclude by wyłączyć z wyszukiwania elementy posiadające cechę o nazwie Poziom.',
            'second'    => 'Filtr nie wyszukuje wyników obliczeń. Jeżeli cecha ma wartość :code, nie da się wyszukiwać takiej kalkulacji.',
        ],
        'clipboard'     => 'Kiedy ustawisz filtry, możesz skopiować ich wartość do schowka. Możesz ich wówczas użyć do filtrowania widżetów pulpitu albo tworząc skróty.',
        'description'   => 'Możesz zmniejszyć liczbę wyświetlanych elementów za pomocą filtrów. Pola tekstowe posiadają kilka opcji które pozwalają dodatkowo zawęzić filtrowanie.',
        'empty'         => 'Wpisując w treści zapytania :tag wyszukasz elementy, które mają to pole puste.',
        'ending_with'   => 'Umieszczając po tekście zapytania :tag możesz szukać wszystkiego, co posiada dokładnie taki tekst.',
        'multiple'      => 'Możesz łączyć opcje wyszukiwania używając :syntax, na przykład :example',
        'session'       => 'Filtry i zadane kolumny dla danej listy',
        'starting_with' => 'Umieszczając przed tekstem zapytania :tag możesz szukać wszystkiego, co nie posiada w takiego tekstu.',
        'title'         => 'Jak używać filtrów',
    ],
    'link'              => [
        'advanced'          => [
            'title' => 'Zaawansowane wzmianki',
        ],
        'anchor'            => 'Wzmianka zaawansowana może określać kotwicę HTML, do której odsyłać powinien odnośnik :example.',
        'attribute'         => [
            'description'   => 'Można również wzmiankować cechy elementu. Wspisz po prostu :code i trzy lub więcej liter, by wyświetlić pasujące do wzmianki cechy elementu.',
            'title'         => 'Cechy',
        ],
        'auto_update'       => 'Odnośniki do innych elementów aktualizują się automatycznie, kiedy zmienia się nazwa albo opis celu.',
        'description'       => 'Możesz z łatwością tworzyć odnośniki do innych elementów kampanii przy pomocy następującego zapisu.',
        'filtering'         => [
            'description'   => 'Łatwo jest filtrować, by znaleźć ten element, którego szukasz.',
            'exact'         => 'Wpisz :code by znaleźć element o tej właśnie nazwie.',
            'space'         => 'Wpisz :code by znaleźć elementy ze spacją w nazwie.',
            'title'         => 'Filtrowanie',
        ],
        'formatting'        => [
            'text'  => 'Lista dozwolonych tagów HTML i cech znajduje się na naszym :github.',
            'title' => 'Fromatowanie',
        ],
        'friendly_mentions' => 'By stworzyć odnośnik do innego elementu wpisz :code i kilka pierwszych znaków nazwy, by go wyszukać. Dzięki temu umieścisz :example w edytorze tekstu i utworzysz odnośnik do tego elementu podczas jego przeglądania.',
        'mention_helpers'   => 'Jeżeli w nazwie elementu jest spacja, zamiast niej użyj :example. Jeśli szukasz elementu o dokładnie takiej nazwie, wpisz :exact.',
        'mentions'          => 'Możesz tworzyć odnośniki do innych elementów wpisując :code i pierwsze kilka znaków nazwy, by je wyszukać. To umieści :example w edytorze. By zmienić wyświetlaną nazwę, wpisz :example_name. Jeżeli odnośnik ma prowadzić na podstronę elementu, użyj :example_page, jeżeli chcesz zalinkować zakładkę, użyj example :tab.',
        'mentions_field'    => 'Możesz wyświetlić w odnośniki pole z opisu elementu zamiast jego nazwy, używając :code.',
        'month'             => [
            'title' => 'Miesiące kalendarza',
        ],
        'months'            => 'Wpisz :code by dodać numer miesiąca z kalnedarza.',
        'options'           => 'Niektóre opcje: :options.',
        'overview'          => 'Można łatwo tworzyć odnośniki do elementów kampanii, wpisując :code i trzy lub więcej liter.',
        'title'             => 'Tworzenie odnośników i skrótów',
    ],
    'map'               => [
        'description'   => 'Dodanie do miejsca mapy uruchomi menu \'Mapa\' w widoku tego miejsca oraz bezpośredni odnośnik do tej mapy z menu miejsca. Oglądając mapę, uczestnicy kampanii z prawem do edycji mogą uruchomić \'Tryb Edycji\', który pozwala dodawać na mapę punkty. Te z kolei mogą być samymi podpisami albo prowadzić do istniejących elementów kampanii. Mają różne kształty i rozmiary.',
        'private'       => 'Administratorzy mogą utajniać mapy. Dzięki temu zwykli uczestnicy mogą oglądać miejsca i nie widzieć ich map.',
        'title'         => 'Mapy miejsc',
    ],
    'pins'              => [
        'description'   => 'Do opisu historii elementu można przypinać relacje i cechy. By to zrobić, wejdź w edycję relacji albo cechy i zaznacz pole "przypięte".',
        'title'         => 'Przypięcia',
    ],
    'public'            => 'Zobacz tutorial na Youtube dotyczący kampanii publicznych.',
    'title'             => 'Pomoc',
    'troubleshooting'   => [
        'description'       => 'Skierował cię na tę stronę członek zespołu Kanki. Wybierz kampanię z rozwijanego menu by stworzyć zgłoszenie, dzięki któremu ktoś od nas będzie mógł czasowo dołączyć do kampanii jako administrator.',
        'errors'            => [
            'token_exists'  => 'Dla :campaign istnieje już zgłoszenie',
        ],
        'save_btn'          => 'Stwórz zgłoszenie',
        'select_campaign'   => 'Wybierz kampanię',
        'subtitle'          => 'Przybądźcie z odsieczą!',
        'success'           => 'Skopuj następujące zgłoszenie i prześlij je do kogoś z zespołu Kanki',
        'title'             => 'Rozwiązywanie problemów',
    ],
    'widget-filters'    => [
        'description'   => 'Możesz filtrować elementy wyświetlane przez zmodyfikowany widżet tworząc listę pól dla elementów albo wartości. Na przykład możesz użyć :example by filtrować martwe postaci na liście BNów.',
        'link'          => 'filtry widżetów',
        'more'          => 'Możesz kopiować wartość z URL list elementów. Na przykład, możesz użyć filtra na liście postaci kampanii by określić, jakie postaci chcesz wyświetlać, a potem skopiować wartość pojawiającą się w adresie URL po :question.',
        'title'         => 'Filtry widżetów pulpitu',
    ],
];
