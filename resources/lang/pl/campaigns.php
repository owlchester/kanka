<?php

return [
    'create'                            => [
        'description'           => 'Utwórz nową kampanię',
        'helper'                => [
            'title'     => 'Witaj w :name',
            'welcome'   => <<<'TEXT'
Zanim przejdziesz dalej, musisz nadać swojej kampanii tytuł albo nazwać jakoś powstający świat. Jeżeli nie masz jeszcze dobrego pomysłu, nie martw się! Zawsze możesz zmienić go później, albo utworzyć nową kampanię.

Dziękujemy za wybór Kanki i witamy w naszej kwitnącej społeczności!
TEXT
,
        ],
        'success'               => 'Kampania utworzona.',
        'success_first_time'    => 'Twoja kampania została utworzona! Ponieważ to twój pierwszy raz, dodaliśmy od razu kilka elementów, które pomogą ci zacząć i być może podsuną pomysły, co robić dalej.',
        'title'                 => 'Nowa kampania',
    ],
    'destroy'                           => [
        'action'    => 'Usuń kampanię',
        'helper'    => 'Możesz usunąć wyłącznie kampanię, której jesteś jedynym uczestnikiem.',
        'success'   => 'Kampania usunięta.',
    ],
    'edit'                              => [
        'success'   => 'Zmieniono kampanię.',
        'title'     => 'Edycja kampanii :name',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'Osobowość nowych postaci jest domyślnie tajna.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nowe elementy są tajne',
    ],
    'errors'                            => [
        'access'        => 'Nie masz dostępu do tej kampanii.',
        'superboosted'  => 'Ta opcja dostępna jest tylko w kampaniach turbodoładowanych.',
        'unknown_id'    => 'Nieznana kampania.',
    ],
    'export'                            => [
        'errors'            => [
            'limit' => 'Przekraczasz limit jednego eksportu dziennie. Spróbuj ponownie jutro.',
        ],
        'helper'            => 'Eksportuj kampanię. Pojawi się zawiadomienie z odnośnikiem do pobrania materiałów.',
        'helper_secondary'  => 'Zostaną utworzone dwa pliki: jeden zawierający elementy w formacie JSON i drugi z powiązanymi obrazami. Uwaga, w wypadku dużych kampanii eksport obrazów może ulec awarii i można je odzyskać wyłącznie przy pomocy :api.',
        'helper_third'      => 'Pliki .json można otworzyć każdym edytorem tekstu. To zapisane w formacie tekstowym dane pobrane z bazy Kanki. Wyeksportowanych w ten sposób plików nie można ponownie zaimportować.',
        'success'           => 'Przygotowujemy eksport kampanii. Gdy plik zip będzie gotowy do pobrania, otrzymasz powiadomienie.',
        'title'             => 'Eksportowanie kampanii :nazwa',
    ],
    'fields'                            => [
        'boosted'                           => 'Doładowanie przez',
        'character_personality_visibility'  => 'Domyślna widoczność osobowości postaci',
        'connections'                       => 'Pokazuj domyślnie tabelę powiązań tego elementu (zamiast grafu relacji w kampaniach doładowanych)',
        'css'                               => 'CSS',
        'description'                       => 'Opis',
        'entity_count'                      => 'Liczba elementów',
        'entity_privacy'                    => 'Domyślna widoczność nowych elementów',
        'entry'                             => 'Opis kampanii',
        'excerpt'                           => 'Podsumowanie',
        'followers'                         => 'Obserwujący',
        'header_image'                      => 'Ilustracja okładkowa',
        'image'                             => 'Obraz',
        'locale'                            => 'Język kampanii',
        'name'                              => 'Nazwa',
        'nested'                            => 'Domyślnie pokazuj listy elementów w widoku hierarchii (jeżeli jest dostępny)',
        'open'                              => 'Otwarta na zgłoszenia',
        'post_collapsed'                    => 'Nowe komentarze do elementów są domyślnie zwynięte.',
        'public'                            => 'Widoczność kampanii',
        'public_campaign_filters'           => 'Filtry kampanii publicznych',
        'related_visibility'                => 'Widoczność powiązanych elementów',
        'rpg_system'                        => 'Systemy RPG',
        'superboosted'                      => 'Turbodoładowana przez',
        'system'                            => 'System',
        'theme'                             => 'Motyw',
        'visibility'                        => 'Widoczność',
    ],
    'following'                         => 'Obserwowanie',
    'helpers'                           => [
        'boost_required'                    => 'Ta opcja jest dostępna tylko w doładowanych kampaniach. Więcej informacji znajdziesz na stronie :settings.',
        'boost_required_multi'              => 'Ta opcja wymaga doładowania kampanii. Więcej informacji znajdziesz na stronie :settings',
        'boosted'                           => 'Odblokowano nowe opcje ponieważ kampania jest doładowana. Więcej informacji znajdziesz na stronie :settings.',
        'character_personality_visibility'  => 'Wybierz domyślą widoczność cech osobowości nowych postaci, tworzonych przez adminów.',
        'css'                               => 'Twórz własne style CSS do używania w kampanii. Uwaga - nadużywanie tej opcji może poskutkować usunięciem stworzonych stylów. Powtarzające się albo poważne wykroczenia mogą spowodować usunięcie kampanii.',
        'dashboard'                         => 'Dostosuj sposób wyświetlania widżetów na pulpicie kampanii wypełniając poniższe pola',
        'entity_count'                      => 'Wartość aktualizowana co sześć godzin.',
        'entity_privacy'                    => 'Wybierz domyślą dostępność nowych elementów, tworzonych przez adminów.',
        'excerpt'                           => 'Podsumowanie kampanii będzie wyświetlane na pulpicie, więc poświęć mu kilka zdań. Najlepiej, gdy jest krótkie i dobitne.',
        'header_image'                      => 'Obraz wyświetlany w tle nagłówka pulpitu kampanii',
        'hide_history'                      => 'Zaznacz, by ukryć historię edycji elementów kampanii przed nieposiadającymi statusu administratora.',
        'hide_members'                      => 'Zaznacz, by ukryć listę uczestników kampanii przed nieposiadającymi statusu administratora.',
        'locale'                            => 'Język, w którym piszesz kampanię. Służy do tworzenia zawartości oraz filtrowania kampanii publicznych.',
        'name'                              => 'Twoja kampania lub świat mogą się nazywać jakkolwiek, o ile nazwa ma przynamniej 4 litery lub cyfry.',
        'permissions_tab'                   => 'Poniższe opcje pozwalają kontrolować widoczność i dostępność nowych elementów.',
        'public_campaign_filters'           => 'Pomóż innym graczom znaleźć twoją kampanię wśród innych dostępnych publicznie, podając następujące informacje.',
        'public_no_visibility'              => 'Uwaga! Ta kampania jest publiczna, ale nie rola "publiczność" na razie niczego nie widzi. :fix',
        'related_visibility'                => 'Domyślna widoczność nowych elementów powiązanych z innym elementem (notek, relacji, zdolności itd.)',
        'system'                            => 'Jeżeli kampania jest dostępna publicznie, system podany jest na stronie :link.',
        'systems'                           => 'By nie zarzucać wszystkich użytkowników mnóstwem opcji, Kanka udostępnia niektóre możliwości tylko dla konkretnych systemów RPG (np. blok statystyk potworów do D&D 5 ed.). Jeżeli dodasz tu wspierany w ten sposób system, uzyskasz dostęp do takich treści.',
        'theme'                             => 'Ustaw inny motyw tej kampanii, niż zaznaczony w ogólnych preferencjach użytkownika.',
        'view_public'                       => 'By zobaczyć kampanię tak, jak obserwujący otwórz :link w trybie incognito.',
        'visibility'                        => 'Jeżeli kampania jest publiczna, każda osoba posiadająca odnośnik będzie mogła ją zobaczyć.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nowa kampania',
            ],
        ],
        'title'     => 'Kampania',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Zaproś',
            'copy'  => 'Skopiuj odnośnik do schowka',
            'link'  => 'Nowy odnośnik',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Stwórz zaproszenie',
                'send'      => 'Wyślij zaproszenie',
            ],
            'success'       => 'Wysłano zaproszenie.',
            'success_link'  => 'Stworzono odnośnik :link',
            'title'         => 'Zaproś kogoś do udziału w kampanii',
        ],
        'destroy'               => [
            'success'   => 'Usunięto zaproszenie.',
        ],
        'email'                 => [
            'link_text' => 'Dołącz do kampanii :name\'s',
            'subject'   => ':name zaprasza cię do udziału w kampanii \':campaign\' na platformie kanka.io! By przyjąć zaproszenie, użyj załączonego odnośnika.',
            'title'     => 'Zaproszenie od :name',
        ],
        'error'                 => [
            'already_member'    => 'Bierzesz już udział w tej kampanii.',
            'inactive_token'    => 'Ta przepustka jest już wykorzystana albo kampania została usunięta.',
            'invalid_token'     => 'Przepustka jest nieważna.',
            'login'             => 'Zaloguj się lub zarejestruj, by dołączyć do kampanii.',
        ],
        'fields'                => [
            'created'   => 'Wysłano',
            'email'     => 'Email',
            'role'      => 'Rola',
            'type'      => 'Rodzaj',
            'usage'     => 'Maksymalna liczba użyć',
        ],
        'helpers'               => [
            'email'     => 'Nasze emaile często uważane są za spam i może minąć kilka godzin, zanim trafią do adresata.',
            'validity'  => 'Liczba użytkowników, która może wykorzystać odnośnik zanim przestanie działać. Brak wpisu oznacza brak ograniczenia.',
        ],
        'placeholders'          => [
            'email' => 'Adres email osoby, którą chcesz zaprosić',
        ],
        'types'                 => [
            'email' => 'Email',
            'link'  => 'Odnośnik',
        ],
        'unlimited_validity'    => 'Nieograniczona',
        'usages'                => [
            'five'      => '5 użyć',
            'no_limit'  => 'Bez limitu',
            'once'      => '1 użycie',
            'ten'       => '10 użyć',
        ],
    ],
    'leave'                             => [
        'confirm'   => 'Czy na pewno chcesz opuścić kampanię :name? Utracisz do niej dostęp do czasu, gdy administrator kampanii zaprosi cię ponownie.',
        'error'     => 'Nie możesz opuścić kampanii.',
        'success'   => 'Opuszczasz kampanię.',
    ],
    'members'                           => [
        'actions'               => [
            'help'          => 'Pomoc',
            'remove'        => 'Usuń z kampanii',
            'switch'        => 'Przełącz',
            'switch-back'   => 'Powrót do profilu',
        ],
        'create'                => [
            'title' => 'Dodaj uczestnika kampanii',
        ],
        'edit'                  => [
            'title' => 'Edytuj uczestnika :name',
        ],
        'fields'                => [
            'joined'        => 'Dołączył(a)',
            'last_login'    => 'Ostatnie logowanie',
            'name'          => 'Użytkownik',
            'role'          => 'Rola',
            'roles'         => 'Role',
        ],
        'help'                  => 'W kampaniach może brać udział dowolnie dużo uczestników.',
        'helpers'               => [
            'admin' => 'Jako administrator, możesz zapraszać nowych graczy, usuwać nieaktywnych i zmieniać ich uprawnienia. By przetestować uprawnienia gracza, użyj funkcji Przełącz. Jej dokładny opis znajdziesz tutaj: :link.',
            'switch'=> 'Przełącz uczestnika',
        ],
        'impersonating'         => [
            'message'   => 'Oglądasz kampanię z perspektywy innego uczestnika. Niektóre funkcje mogą nie działać, ale reszta wygląda dokładnie tak, jak widzi ją ta osoba. By wrócić do własnego profilu użyj opcji Powrót do profilu, znajdującej się w miejscu opcji Wyloguj.',
            'title'     => 'Zalogowano jako :name',
        ],
        'invite'                => [
            'description'   => 'Możesz włączać znajomych do udziału w kampanii przekazując im odnośnik z zaproszeniem. Po zaakceptowaniu, zostaną oni dodani do kampanii w przydzielonej roli. Możesz też zapraszać graczy mailem.',
            'more'          => 'Możesz dodawać nowe role tutaj: :link.',
            'roles_page'    => 'lista ról',
            'title'         => 'Zaproszenia',
        ],
        'manage_roles'          => 'Zarządzaj rolami uczestników',
        'roles'                 => [
            'member'    => 'Uczestnik',
            'owner'     => 'Administrator',
            'player'    => 'Gracz',
            'public'    => 'Publiczność',
            'viewer'    => 'Obserwator',
        ],
        'switch_back_success'   => 'Powrócono do podstawowego profilu.',
        'title'                 => 'Uczestnicy kampanii :name',
        'updates'               => [
            'added'     => 'Uczestnikowi :user przyznano rolę :role.',
            'removed'   => 'Uczestnikowi :user odebrano rolę :role.',
        ],
        'your_role'             => 'Twoja rola: <i>:role</i>',
    ],
    'open_campaign'                     => [
        'helper'    => 'Publiczna kampania o statusie "Otwarta" pozwala graczom wysyłać prośby o dołączenie. Listę zgłoszeń znajdziesz na stronie :link.',
        'link'      => 'zgłoszenia do kampanii',
        'statuses'  => [
            'closed'    => 'Zamknięta',
            'open'      => 'Przyjmuje zgłoszenia',
        ],
        'title'     => 'Kampania otwarta',
    ],
    'options'                           => [],
    'panels'                            => [
        'boosted'   => 'Doładowana',
        'dashboard' => 'Pulpit',
        'permission'=> 'Uprawnienia',
        'setup'     => 'Konfiguracja',
        'sharing'   => 'Udostępnianie',
        'systems'   => 'System',
        'ui'        => 'Wygląd',
    ],
    'placeholders'                      => [
        'description'   => 'Krótkie podsumowanie kampanii',
        'locale'        => 'Język kampanii',
        'name'          => 'Tytuł tej kampanii',
        'system'        => 'D&D, Pathfinder, Fate, DSA',
    ],
    'privacy'                           => [
        'hidden'    => 'Ukryta',
        'private'   => 'Prywatna',
        'visible'   => 'Widoczna',
    ],
    'public'                            => [
        'helpers'   => [
            'introduction'  => 'Kampanie są domyślnie prywatne, ale można je upublicznić. Wówczas każdy zyska do nich dostęp za pomocą strony :public-campaigns, o ile w kampanii są jakieś elementy widoczne dla posiadaczy roli :public-role. A więc: wszyscy widzą publiczne kampanie, ale by mogli przeglądać ich elementy trzeba odpowiednio ustawić uprawnienia dla roli :public-role.',
        ],
    ],
    'roles'                             => [
        'actions'       => [
            'add'           => 'Dodaj rolę',
            'permissions'   => 'Zarządzaj uprawnieniami',
            'rename'        => 'Zmień nazwę',
            'save'          => 'Zapisz rolę',
        ],
        'admin_role'    => 'administrator',
        'create'        => [
            'success'   => 'Stworzono rolę.',
            'title'     => 'Stwórz nową rolę dla :name',
        ],
        'destroy'       => [
            'success'   => 'Usunięto rolę.',
        ],
        'edit'          => [
            'success'   => 'Zaktualizowano rolę.',
            'title'     => 'Edycja roli :name',
        ],
        'fields'        => [
            'name'          => 'Nazwa',
            'permissions'   => 'Uprawnienia',
            'type'          => 'Rodzaj',
            'users'         => 'Posiadacze',
        ],
        'helper'        => [
            '1' => 'Kampania może posiadać dowodnie dużo ról. "Administrator" posiada automatycznie dostęp do wszystkich elementów kampanii, ale inne role mogą być ograniczone tylko do części elementów (postaci, miejsc, itd.).',
            '2' => 'Uprawnienia rozmaitych elementów można dodatkowo modyfikować w zakładce "Uprawnienia". Pojawi się ona, kiedy w kampanii przybędzie ról lub członków.',
            '3' => 'Ustawieniami można zarządzać globalnie, zapewniając rolom uprawienia dostępu do całych kategorii elementów kampanii i ukrywając część z nich za pomocą opcji "Tajne", albo lokalnie, włączając ręcznie widoczność konkretnych elementów.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'Ustawiono uprawnienia roli Publiczność, ale kampania jest prywatna. Możesz to zmienić z pomocą zakładki Udostępnij w menu edycji kampanii.',
            'public'                => 'Roli Publiczność używa się, gdy ktoś ogląda publicznie dostępną kampanię. :more',
            'role_permissions'      => 'Zezwól roli :name na następujące działania na elementach',
        ],
        'members'       => 'Uczestnicy',
        'modals'        => [
            'details'   => [
                'button'    => 'Pomoc',
                'campaign'  => 'Uprawnienia w kampanii umożliwiają, co następuje.',
                'entities'  => 'Oto krótkie zestawienie uprawnień, które mogą otrzymać użytkownicy w danej roli.',
                'more'      => 'Dalsze instrukcje znajdziesz w filmie instruktażowym na YouTube',
                'title'     => 'Szczegóły uprawnień',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Tworzenie',
                'dashboard'     => 'Pulpit',
                'delete'        => 'Usuwanie',
                'edit'          => 'Edytowanie',
                'entity-note'   => 'Komentowanie',
                'gallery'       => 'Galeria',
                'manage'        => 'Zarządzaj',
                'members'       => 'Uczestnicy',
                'permission'    => 'Uprawnienia',
                'read'          => 'Oglądanie',
                'toggle'        => 'Zmień dla wszystkich',
            ],
            'helpers'   => [
                'add'           => 'Pozwala tworzyć elementy danego rodzaju. Automatycznie umożliwia również oglądanie i edycję stworzonych elementów, nawet jeżeli rola nie posiada do tego uprawnień.',
                'dashboard'     => 'Pozwala edytować pulpity i ich widżety.',
                'delete'        => 'Pozwala usuwać elementy danego rodzaju.',
                'edit'          => 'Pozwala modyfikować elementy danego rodzaju.',
                'entity_note'   => 'Pozwala uczestnikom nie posiadającym praw edycji dodawać komentarze do elementów kampanii.',
                'gallery'       => 'Pozwala zarządzać galerią w kampaniach turbodoładowanych.',
                'manage'        => 'Pozwala edytować kampanię jakby uczestnik był administratorem, ale nie daje uprawnień by ją usunąć.',
                'members'       => 'Pozwala zapraszać nowych uczestników kampanii.',
                'permission'    => 'Pozwala zarządzać uprawnieniami tych elementów danego typu, które uczestnik może też edytować.',
                'read'          => 'Pozwala widzieć wszystkie elementy danego typu, które nie są tajne.',
            ],
            'hint'      => 'Ta rola ma automatyczny dostęp do wszystkiego.',
        ],
        'placeholders'  => [
            'name'  => 'Nazwa roli',
        ],
        'show'          => [
            'title' => 'Rola w kampanii ":role"',
        ],
        'title'         => 'Role w kampanii :name',
        'types'         => [
            'owner'     => 'Administrator',
            'public'    => 'Publiczność',
            'standard'  => 'Stadardowy',
        ],
        'users'         => [
            'actions'   => [
                'add'       => 'Dodaj uczestnika',
                'remove'    => ':user z roli :role',
            ],
            'create'    => [
                'success'   => 'Uczestnikowi przypisano rolę.',
                'title'     => 'Przypisz uczestnikowi rolę :name',
            ],
            'destroy'   => [
                'success'   => 'Uczestnikowi odebrano rolę.',
            ],
            'fields'    => [
                'name'  => 'Nazwa',
            ],
        ],
    ],
    'settings'                          => [
        'actions'   => [
            'enable'    => 'Aktywny',
        ],
        'boosted'   => 'Opcja we wczesnym dostępie, na razie dostępna wyłącznie w :boosted.',
        'edit'      => [
            'success'   => 'Zaktualizowano ustawienia kampanii.',
        ],
        'errors'    => [
            'module-disabled'   => 'Ten moduł jest obecnie wyłączony w ustawieniach kampanii. :fix',
        ],
        'helper'    => 'Wszystkie moduły kampanii można w każdej chwili aktywować lub wyłączyć. Wyłączenie modułu powoduje ukrycie związanych z nim składników interfejsu oraz istniejących już elementów kampanii - ale nie zostaną usunięte. Możesz zawsze zmienić zdanie i włączyć je ponownie. Zmiana działa u wszystkich uczestników kampanii, nawet administratorów.',
        'helpers'   => [
            'abilities'     => 'Twórz zdolności specjalne, na przykład czary, moce czy techniki, i przypisuj je innym elementom.',
            'calendars'     => 'Wyposaż swój świat w systemy liczenia czasu.',
            'characters'    => 'Mieszkańcy tego świata.',
            'conversations' => 'Rozmowy które odbywają fikcyjne postaci albo prawdziwi uczestnicy kampanii. Ten moduł bywa niedoceniany.',
            'dice_rolls'    => 'Jeżeli używasz Kanki do prowadzenia kampanii, tu możesz zarządzać wykonywaniem rzutów kośćmi. Ten moduł bywa niedoceniany.',
            'events'        => 'Święta, festyny, katastrofy, urodziny i wojny.',
            'families'      => 'Klany lub rodziny, ich członkowie i wzajemne relacje.',
            'inventories'   => 'Zarządzaj wyposażeniem elementów.',
            'items'         => 'Uzbrojenie, pojazdy, artefakty, eliksiry.',
            'journals'      => 'Rozmaite spostrzeżenia spisane przez postaci oraz notatki MG.',
            'locations'     => 'Planety, wymiary, kontynenty, państwa, miasta, rzeki, świątynie, gospody.',
            'maps'          => 'Dodaj do kampanii mapę i oznacz położenie innych elementów z pomocą warstw i znaczników.',
            'menu_links'    => 'Zbiór własnych odnośników w dodatkowym menu.',
            'notes'         => 'Tajemnice, religie, historia, magia, rasy.',
            'organisations' => 'Kulty, oddziały wojskowe, frakcje polityczne, gildie.',
            'quests'        => 'Zadania, które realizuje drużyna, z opisem zaangażowanych miejsc i postaci.',
            'races'         => 'Jeżeli świecie żyje wiele ras, możesz opisać je tutaj.',
            'tags'          => 'Każdy element można oznaczyć z pomocą rozmaitych etykiet ułatwiających wyszukiwanie. Nawet etykiety mogą mieć własne etykiety.',
            'timelines'     => 'Dzieje świata wedle rozmaitych historii.',
        ],
        'title'     => 'Moduły Kampanii :name',
    ],
    'show'                              => [
        'actions'   => [
            'boost' => 'Doładuj kampanię',
            'edit'  => 'Edytuj kampanię',
            'leave' => 'Opuść kampanię',
        ],
        'menus'     => [
            'configuration'     => 'Konfiguracja',
            'overview'          => 'Ogólne',
            'user_management'   => 'Użytkownicy',
        ],
        'tabs'      => [
            'achievements'      => 'Osiągnięcia',
            'applications'      => 'Zgłoszenia',
            'campaign'          => 'Kampania',
            'default-images'    => 'Domyślne ikony',
            'export'            => 'Eksport',
            'information'       => 'Informacja',
            'members'           => 'Uczestnicy',
            'plugins'           => 'Dodatki',
            'recovery'          => 'Odzyskiwanie',
            'roles'             => 'Role',
            'settings'          => 'Moduły',
            'styles'            => 'Motywy',
        ],
        'title'     => 'Kampania :name',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Umieszczanie obrazów w edytorze tekstu możliwe jest tylko w :superboosted.',
                'title' => 'Zamieszczanie obrazów w galerii kampanii',
            ],
        ],
    ],
    'themes'                            => [
        'none'  => 'Brak (powrót do ustawień użytkownika)',
    ],
    'ui'                                => [
        'boosted'           => 'Doładowana',
        'collapsed'         => [
            'collapsed' => 'Zwinięte',
            'default'   => 'Domyślne',
        ],
        'connections'       => [
            'explorer'  => 'Wizualizacja powiązań (tylko w doładowanych kampaniach)',
            'list'      => 'Tabela powiązań',
        ],
        'entity_history'    => [
            'hidden'    => 'Widoczna tylko dla adminów',
            'visible'   => 'Widoczna dla uczestników',
        ],
        'fields'            => [
            'connections'       => 'Domyślny interfejs powiązań elementu',
            'entity_history'    => 'Historia edycji elementu',
            'entity_image'      => 'Ilustracja elementu',
            'family_toolip'     => 'Rodzina postaci',
            'member_list'       => 'Lista uczestników kampanii',
            'nested'            => 'Domyślny układ list',
            'post_collapsed'    => 'Domyślny sposób prezentowana komentarzy',
        ],
        'helpers'           => [
            'connections'       => 'Wybierz domyślny sposób wyświetlania powiązań po wejściu na odpowiednią podstronę elementu.',
            'other'             => 'Inne opcje wizualne kampanii',
            'post_collapsed'    => 'Wybierz sposób wyświetlania nowych komentarzy do elementów.',
            'tooltip'           => 'Wybierz informacje widoczne po najechaniu kursorem na nazwę elementu na liście',
        ],
        'members'           => [
            'hidden'    => 'Widoczne tylko dla adminów kampanii',
            'visible'   => 'Widoczne dla wszystkich uczestników',
        ],
        'nested'            => [
            'default'   => 'Domyślne',
            'nested'    => 'Widok hierarchii',
        ],
        'other'             => 'Inne',
    ],
    'visibilities'                      => [
        'private'   => 'Prywatna',
        'public'    => 'Publiczna',
        'review'    => 'Oczekuje na recenzję',
    ],
];
