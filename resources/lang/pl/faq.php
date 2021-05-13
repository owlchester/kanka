<?php

return [
    'account-deletion'      => [
        'account_settings'  => 'Ustawienia konta',
        'answer'            => 'Aby usunąć konto, przejdź na stronę :account i przewiń na dół, do sekcji usuwania. W ten sposób usuniesz zarówno konto, jak wszystkie kampanie których jesteś jedynym uczestnikiem.',
        'question'          => 'Jak mogę usunąć konto?',
    ],
    'app_backup'            => [
        'answer'    => 'Tworzymy dwie kopie zapasowe dziennie, żeby nie doszło do utraty danych. Na tym serwerze są nasze własne kampanie, nie zamierzamy ryzykować!',
        'question'  => 'Jak często Kanka archiwizuje dane?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Najlepiej wytłumaczyć działanie szablonów cech na przykładzie. Dajmy na to, w twoim świecie jest wiele Miejsc, i dla większości z nich chcesz zanotować konkretne Cechy - na przykład "Populację", "Klimat" i "Poziom przestępczości".

Możesz dodawać te pozycje ręcznie do każdego miejsca, ale o męczące i czasem zdarzy ci się zapomnieć o "Poziomie przestępczości". I tu przydają się szablony cech.

Możesz stworzyć szablon zawierający dowolne cechy (Populację, Klimat, Poziom przestępczości i tak dalej) i dodawać go potem do kolejnych miejsc. Dzięki temu zadane cechy pojawią się w odpowiedniej zakładce. A tobie zostanie tylko zmienić ich wartości, zamiast dodawać je ręcznie za każdym razem.
TEXT
,
        'question'  => 'Co to są te "Szablony cech"?',
    ],
    'backup'                => [
        'answer'    => 'Raz dziennie możesz wyeksportować dane ze swojej kampanii jako plik ZIP. W tym celu kliknij w menu po lewej stronie na pozycję "Kampania", a potem wybierz opcję "Eksportuj". Stworzony w ten sposób plik możesz pobrać przez 30 minut. Takich danych nie można załadować z powrotem do Kanki, więc pobieraj je dla własnego spokoju ducha albo jeżeli planujesz zrezygnować z używania naszego narzędzia.',
        'question'  => 'Jak mogę stworzyć kopię zapasową albo wyeksportować kampanię?',
    ],
    'bugs'                  => [
        'answer'    => 'Po prostu dołącz do naszego serwera :discord i zgłoś błąd na kanale #error-and-bugs',
        'question'  => 'Jak zgłaszać błędy?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka na to nie pozwala. Jeżeli prowadzisz wiele drużyn w tym samym świecie możesz jednak dodać wszystkich graczy do tej samej kampanii, a potem dzielić im dostęp za pomocą systemu misji, etykiet i uprawnień.',
        'question'  => 'Czy mogę synchronizować elementy pomiędzy kilkoma kampaniami?',
    ],
    'conversations'         => [
        'answer'    => 'Konwersacje służą do prowadzenia rozmów między postaciami albo między uczestnikami kampanii. Możesz użyć tej opcji by zarchiwizować ważną rozmowę między drużyną a BNem, albo jeżeli prowadzisz grę zdalnie, przez maile.',
        'question'  => 'Czym są Konwersacje?',
    ],
    'custom'                => [
        'answer'    => 'Kanka posiada zdefiniowany zestaw elementów, które wchodzą ze sobą w konkretne interakcje. Dopuszczenie rodzajów tworzonych przez użytkowników wymagałoby napisania aplikacji od nowa i stałoby w sprzeczności z naszym głównym celem - chcemy pomagać ludziom w tworzeniu światów, a nie zmuszać ich do główkowania, jak je katalogować. Możesz z łatwością odróżniać od siebie własne kategorie elementów dzięki systemowi etykiet.',
        'question'  => 'Czy mogę tworzyć własne rodzaje elementów?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Wejdź na pulpit kampanii i kliknij "Kampania" w menu po lewej stronie. Jeżeli jesteś jedynym użytkownikiem kampanii, pojawi się guzik "Usuń". Usunięcie kampanii to akcja nieodwracalna, która wymaże z naszych serwerów wszystko, łącznie z obrazami.',
        'question'  => 'Jak usunąć kampanię?',
    ],
    'discord'               => [
        'answer'    => 'By połączyć Kankę z profilem na :discord należy najpierw kliknąć na awatar w prawym górnym rogu aplikacji, a następnie wybrać opcję Profil. Tam przejdź na podstronę :apps i wybierz Połącz.',
        'question'  => 'Jak połączyć konto Kanki z moim profilem Discord?',
    ],
    'early-access'          => [
        'answer'    => 'Wczesny dostęp to sposób, w jaki nagradzamy naszych wspaniałych subskrybentów. Otrzymują oni możliwość korzystania z najnowszych modułów na 30 dni przed pozostałymi użytkownikami.',
        'question'  => 'Czym jest "wczesny dostęp"?',
    ],
    'entity-notes'          => [
        'answer'    => 'Każdy element ma zakładkę "Komentarze", gdzie można zapisywać niewielkie fragmenty tekstu, widoczne wyłącznie dla ciebie (przydaje się przy kilku prowadzących), tylko dla administratorów, albo dla wszystkich. Możesz też pozwolić graczom dodawać i edytować takie notki, nie zapewniając im przy tym możliwości edycji całych elementów.',
        'question'  => 'Jak ukrywać w Kance tylko część informacji?',
    ],
    'fields'                => [
        'answer'    => 'Odpowiedź',
        'category'  => 'Kategoria',
        'locale'    => 'Język',
        'order'     => 'Kolejność',
        'question'  => 'Pytanie',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Tak! Uważamy szczerze, że nasza sytuacja finansowa nie powinna wpływać na radość z gry w RPG i wymyślania światów, więc Kanka zawsze będzie za darmo. Ale jeżeli chcesz przyczynić się rozwoju aplikacji, wesprzeć nas i głosować na funkcjonalności, które najbardziej ci się przydadzą, możesz wybrać płatną subskrypcję. 

Oprócz głosowania nad kierunkiem, w którym rozwijać się będzie Kanka, wspierając nas otrzymujesz też :boosters, możesz zamieszczać zamieszczać więcej plików, twoje imię trafia do galerii sław, dostajesz ładniejsze domyślne ikony i nie tylko!
TEXT
,
        'question'  => 'Czy aplikacja zawsze będzie darmowa?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Polecamy tworzyć bogów jako Postaci, a religie jako Organizacje. Aby szybciej odszukać bóstwa na liście, możesz dać im odpowiednie etykiety.',
        'question'  => 'Jak tworzyć bogów i religie?',
    ],
    'help'                  => [
        'answer'    => 'Po pierwsze, bardzo dziękujemy za chęć pomocy! Zawsze szukamy ludzi gotowych pomóc przy tłumaczeniu, testowaniu funkcjonalności i wprowadzaniu nowych użytkowników. Zachęcamy też do promowania Kanki w miejscach, o których nawet nie pomyśleliśmy. Najlepiej, jeżeli dołączysz do serwera :discord, gdzie działa kanał dla osób które nam pomagają.',
        'question'  => 'Jak mogę pomóc?',
    ],
    'map'                   => [
        'answer'    => 'Moduł Map pozwala dodawać obrazy w formacie PNG, JPG i SGV. Mapy mogą mieć wiele warstw i można nanosić na nie oznaczenia o różnych kształtach i rozmiarach, wiążąc je z innymi elementami kampanii.',
        'question'  => 'Czy do Kanki mogę dodawać mapy?',
    ],
    'mobile'                => [
        'answer'    => 'Obecnie Kanka nie posiada dedykowanej aplikacji mobilnej, ale większość opcji działa bez problemu na urządzeniach mobilnych. Mamy nadzieję, że subskrypcje pozwolą nam kiedyś zlecić komuś wykonanie takiej aplikacji, ale to raczej nie zdarzy się w bliskiej przyszłości.',
        'question'  => 'Czy istnieje wersja mobilna? Czy jest w planach?',
    ],
    'monsters'              => [
        'answer'    => 'Polecamy używać modułu Rasy by dodawać ludy, gatunki, potwory i wszelkie żywe istoty nie będące postaciami.',
        'question'  => 'Jak tworzyć potwory?',
    ],
    'multiworld'            => [
        'answer'    => 'Możesz brać udział w dowolnej liczbie kampanii, w tym w kampaniach własnego autorstwa. By zmienić kampanię albo dodać nową otwórz pulpit - klikając nazwę kampanii w lewym górnym rogu otworzysz menu zarządzania kampaniami.',
        'question'  => 'Czy mogę mieć więcej niż jedną kampanię?',
    ],
    'nested'                => [
        'answer'    => 'Jeżeli wolisz używać domyślnie widoku hierarchii elementów, zamiast ich list, przejdź do Profilu i wybierz opcję Układ. Tam możesz zaznaczyć Widok hierarchii. Opcja działa wyłącznie dla twojego konta, a nie wszystkich uczestników kampanii.',
        'question'  => 'Czy mogę ustawić wyświetlanie hierarchii jako domyślne?',
    ],
    'organise_play'         => [
        'answer'    => 'Możesz łatwo organizować sesje dla swojej grupy dzięki naszemu partnerowi, :lfgm. Jeżeli zsynchronizujesz kampanię w Kance z kampanią w LFGM, dostępne terminy będą się wyświetlały na pulpicie.',
        'question'  => 'Jak zarządzać terminami prowadzenia sesji?',
    ],
    'permissions'           => [
        'answer'    => 'Oczywiście, właśnie po to stworzyliśmy Kankę! Kiedy zaprosisz graczy do kampanii, możesz nadawać im role i uprawnienia. Stworzyliśmy bardzo elastyczny system (który pozwala zarządzać uprawnieniami globalnie i lokalnie), który łatwo dostosować do dowolnej sytuacji i potrzeb.',
        'question'  => 'Czy mogę jakoś ograniczyć liczbę informacji, do których mają dostęp moi gracze?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Naszym planem długoterminowym jest stworzyć wszechstronną aplikację do budowania światów i zarządzana kampaniami, która jest systemowo niezależna i którą zarządza społeczność dzięki "Szablonom Społeczności". Chcemy też integrować naszą Kankę z innymi narzędziami, na przykład aplikacjami do gry zdalnej.

Sami używamy Kanki, więc nie zamierzamy jej porzucać ani zaprzestawać rozwoju. Ale, tak na wszelki wypadek, cały projekt ma charakter open source i może być rozwijany gdyby coś się z nami stało.
TEXT
,
        'question'  => 'Jakie macie plany na dalszą przyszłość?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Możesz przeglądać stronę :public-campaigns by zobaczyć kampanie stworzone przez innych użytkowaników.',
        'question'  => 'Jak inni używają Kanki?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Podstawowa Kanka nie pozwala zmieniać nazw modułów, przez wzgląd na poprawność stylistyczną zwłaszcza w językach posiadających rodzaje gramatyczne. W kampaniach doładowanych można jednak modyfikować nazwy wyświetlane w menu po lewej stronie używając skryptów CSS.',
        'question'  => 'Czy mogę zmieniać nazwy modułów? Na przykład Rodziny na Klany, albo Organizacje na Frakcje?',
    ],
    'sections'              => [
        'community'     => 'Społeczność',
        'general'       => 'Ogólne',
        'other'         => 'Inne',
        'permissions'   => 'Uprawnienia',
        'pricing'       => 'Opłaty',
        'worldbuilding' => 'Tworzenie światów',
    ],
    'show'                  => [
        'return'    => 'Powrót do FAQ',
        'timestamp' => 'Ostatnia aktualizacja: :date',
        'title'     => 'FAQ :name',
    ],
    'unboost'               => [
        'answer'    => 'Usunięcie doładowania nie usuwa żadnych danych, które dodano podczas doładowania, po prostu je ukrywa. Jeżeli ponownie doładujesz kampanię, wszystkie opcje staną się znów dostępne w postaci, jaką miały przed usunięciem doładowania.',
        'question'  => 'Co dzieje się z kampanią, która przestaje być doładowana?',
    ],
    'user-switch'           => [
        'answer'    => 'Uprawnienia, zwłaszcza w większych kampaniach, mogą być dość skomplikowane. Jako administrator możesz zawsze wejść na stronę użytkownika kampanii i nacisnąć opcję "Przełącz", która znajduje się obok nazwisk uczestników nie posiadających statusu admina. Logujesz się wówczas jako ten użytkownik i widzisz kampanię tak, jak on. W ten sposób najłatwiej sprawdzić, czy uprawnienia działają poprawnie.',
        'question'  => 'No to mam już uprawnienia kampanii, jak je teraz przetestować?',
    ],
    'visibility'            => [
        'answer'    => 'Tylko osoby, które otrzymały od ciebie zaproszenie do kampanii widzą twoje dzieło. Wszystkie dane są prywatne i masz nad nimi pełną kontrolę. Jeżeli chcesz, możesz nadać kampanii status publiczny, który pozwala ją przeglądać niezarejestrowanym użytkownikom.',
        'question'  => 'Czy inni widzą mój świat?',
    ],
];
