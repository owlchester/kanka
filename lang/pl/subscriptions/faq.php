<?php

return [
    'cancellation'  => [
        'answer'    => 'Oczywiście! Stosowną opcję znajdziesz na stronie obecnej subskrypcji. Po anulowaniu zachowasz dostęp do wszystkich korzyści do rozpoczęcia nowego okresu rozliczeniowego. Pamiętaj, że subskrypcja przez PayPal ustaje automatycznie po opłaconym okresie, ponieważ firma nie pozwala na automatyczne odnowienie.',
        'question'  => 'Czy mogę anulować subskrypcję w każdej chwili?',
    ],
    'cost'          => [
        'answer'    => 'Kanka posiada trzy poziomy subskrypcji, nazwane od potworów z D&D: Owlbear, Wyvern i Elemental. Cena zależy od wybranej waluty (USD, EUR albo BRL). Jeżeli wybierzesz plan roczny, uzyskasz dwa darmowe miesiące w stosunku do rozliczenia miesięcznego.',
        'question'  => 'Ile kosztuje subskrybcja?',
    ],
    'data'          => [
        'answer'    => 'Nie martw się, nigdy nie usuwamy danych po zakończeniu subskrypcji. Kampanie premium wracają po prostu do formy podstawowej i dodatkowe opcje przestają być dostępne. Jeżeli wznowisz subskrypcję, natychmiast odzyskasz dostęp do funkcji premium w takiej postaci, w jakiej je zostawiłeś.',
        'question'  => 'Co stanie się z moimi danymi po anulowaniu subskrybcji?',
    ],
    'discount'      => [
        'answer'    => 'Tak! Nagrodą za subskrypcję roczną są dwa darmowe miesiące w stosunku do opłaty miesięcznej. W ten sposób dziękujemy za dłuższe zobowiązanie wobec Kanki.',
        'question'  => 'Czy subskrypcja roczna zwiera zniżkę?',
    ],
    'downgrade'     => [
        'answer'    => 'Możesz zmienić poziom subskrypcji w każdej chwili. Jeśli ją zwiększasz, zapłacisz w bieżącym okresie tylko różnicę między obecnym i przyszłym planem. Podczas redukcji nowy, niższy poziom zacznie obowiązywać od początku kolejnego okresu rozliczeniowego - do tej chwili nie stracisz obecnych korzyści.',
        'question'  => 'Jak zwiększyć/zmniejszyć poziom subskrybcji?',
    ],
    'fail'          => [
        'answer'    => 'Jeżeli nie uda się pobrać płatności, zostaniesz powiadomiony mailem i podejmiemy jeszcze trzy próby obciążenia karty kredytowej. Jeżeli również zakończą się niepowodzeniem, subskrypcja zostanie zawieszona. Problem można zwykle łatwo rozwiązać, aktualizując informacje dotyczące :billing za pomocą poprawnych danych.',
        'question'  => 'Co, jeśli płatność się nie uda?',
    ],
    'methods'       => [
        'answer'    => 'Przyjmujemy karty kredytowe oraz płatność przez PayPal w dolarach, euro i realach brazylijskich. Traktujemy bezpieczeństwo danych z najwyższą powagą, więc wszystkie dane kart kredytowych przechowuje nasz zaufany partner obsługujący płatności, :stripe.',
        'question'  => 'Jakie przyjmujecie metody płatności?',
    ],
    'refund'        => [
        'answer'    => 'Tak! W wypadku subskrypcji rocznej oferujemy 14-dniowy okres próbny, w czasie którego można uzyskać zwrot kosztów. Nie musisz podawać powodu. Wystarczy, że napiszesz maila na adres :email prosząc o zwrot pieniędzy, i wszystkim się zajmiemy.',
        'question'  => 'Czy zwracacie pieniądze?',
    ],
    'renewal'       => [
        'answer'    => 'Tak, jeśli używasz do subskrypcji karty kredytowej, po zakończeniu każdego okresu rozliczeniowego automatycznie obciążymy ją tą samą kwotą. Inaczej jest w wypadku subskrypcji przez PayPal: nie odnawia się automatycznie i po każdym okresie należy ją odnowić ręcznie.',
        'question'  => 'Czy podczas odnawiania subskrypcji płatność będzie automatyczna?',
    ],
    'security'      => [
        'answer'    => 'Bezpieczeństwo danych to nasz priorytet. Korzystamy z usług :stripe, firmy zapewniającej najwyższe standardy bezpieczeństwa płatności zgodne z PCI. Zarządza i przechowuje wszystkie dane użytkowników w sposób zgodny z wymaganiami RODO. Żadne dane nie trafiają na nasze serwery.',
        'question'  => 'Czy moje informacje finansowe są bezpieczne?',
    ],
    'sharing'       => [
        'answer'    => 'Oczywiście! Opcje premium kampanii aktywowane dzięki subskrypcji są dostępne dla wszystkich uczestników - nawet jeżeli sami nie subskrybują Kanki. Dzięki temu możecie dzielić się kosztami tworzenia światów.',
        'question'  => 'Czy mogę dzielić z kimś konto/subskrypcję?',
    ],
    'title'         => 'Popularne pytania',
    'trial'         => [
        'answer'    => 'Kanka nie posiada wprawie darmowej wersji próbnej, ale oferuje za darmo liczne narzędzia do tworzenia światów i zarządzania kampanią. Gdy przestaną ci wystarczać, subskrypcja pozwoli ci korzystać z opcji premium, w tym zwiększonego limitu plików, braku reklam i dodatkowych funkcji światotwórczych.',
        'question'  => 'Czy macie darmową wersję próbną?',
    ],
    'update'        => [
        'answer'    => 'Aktualizacja danych do płatności jest prosta: wejdź na stronę :billing w ustawieniach konta. Tam możesz zmienić metodę płatności, zaktualizować dane karty albo zmienić adres rozliczenia.',
        'question'  => 'Jak zaktualizować dane do płatności?',
    ],
];
