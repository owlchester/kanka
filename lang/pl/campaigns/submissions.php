<?php

return [
    'actions'       => [
        'accept'        => 'Akceptuj',
        'applications'  => 'Zgłoszenie :status',
        'change'        => 'Zmień',
        'reject'        => 'Odrzuć',
    ],
    'apply'         => [
        'apply'         => 'Zgłoszenie',
        'help'          => 'Tak kampania jest otwarta dla nowych graczy. Możesz się do niej zgłosić wypełniając formularz. Kiedy administratorzy kampanii rozpatrzą zgłoszenie, otrzymasz powiadomienie',
        'remove_text'   => 'twoje zgłoszenie',
        'success'       => [
            'apply' => 'Zapisano zgłoszenie. Możesz je zmienić albo usunąć w dowolnej chwili. Otrzymasz powiadomienie, gdy administratorzy kampanii rozpatrzą prośbę.',
            'remove'=> 'Usunięto twoje zgłoszenie',
            'update'=> 'Zmieniono zgłoszenie. Możesz je zmienić albo usunąć w dowolnej chwili. Otrzymasz powiadomienie, gdy administratorzy kampanii rozpatrzą prośbę.',
        ],
        'title'         => 'Dołącz do :name',
    ],
    'errors'        => [
        'not_open'  => 'Ta kampania nie przyjmuje zgłoszeń od potencjalnych członków. Możesz to zmienić w ustawieniach.',
    ],
    'fields'        => [
        'application'   => 'Zgłoszenie',
        'approval'      => 'Powód akceptacji',
        'reason'        => 'Powód przyjęcia/odrzucenia',
        'rejection'     => 'Powód odrzucenia',
    ],
    'helpers'       => [
        'filter-helper'         => 'Kampania otwarta na zgłoszenia!',
        'modal'                 => 'Do kampanii publicznej, którą otwarto na zgłoszenia, mogą się zgłaszać nowi uczestnicy.',
        'no_applications'       => 'W tej kampanii nie ma oczekujących zgłoszeń. Nowi uczestnicy mogą zgłaszać się, wchodząc na pulpit kampanii i klikając na :button.',
        'no_applications_title' => 'Brak zgłoszeń',
        'not_open'              => 'Kampania nie przyjmuje zgłoszeń.',
        'open_not_public'       => 'Kampanię otwarto na zgłoszenia, ale nie jest publiczna, więc nikt nie może się zgłosić. Zmień ten stan rzeczy edytując ustawienia kampanii.',
        'reason'                => 'Jeśli podasz, kandydat otrzyma tę informację.',
        'role'                  => 'Jeśli przyjmiesz kandydata, otrzyma tę rolę.',
    ],
    'open'          => [
        'closed'    => 'Kampania jest zamknięta',
        'open'      => 'Kampania jest otwarta',
        'title'     => 'Kampania otwarta',
    ],
    'placeholders'  => [
        'note'      => 'Napisz zgłoszenie, by dołączyć do kampanii',
        'reason'    => 'Powód',
    ],
    'public'        => [
        'private'   => 'Kampania jest prywatna',
        'public'    => 'Kampania jest publiczna',
        'title'     => 'Kampania publiczna',
    ],
    'statuses'      => [
        'closed'    => 'Zamknięta',
        'open'      => 'Otwarta',
    ],
    'toggle'        => [
        'closed'    => 'Zamknięta na zgłoszenia',
        'label'     => 'Status',
        'open'      => 'Otwarta na zgłoszenia',
        'success'   => 'Zmieniono status kampanii.',
        'title'     => 'Status zgłoszenia',
    ],
    'update'        => [
        'approve'   => 'Wybierz rolę, którą otrzymają uczestnicy dodawani do kampanii.',
        'approved'  => 'Zatwierdzono zgłoszenie.',
        'reject'    => 'Jeżeli chcesz, możesz wytłumaczyć dlaczego zgłoszenie zostało odrzucone.',
        'rejected'  => 'Odrzucono zgłoszenie.',
    ],
];
