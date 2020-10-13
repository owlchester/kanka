<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Zu Kanka Login wechseln',
            'update_email'      => 'Email aktualisieren',
            'update_password'   => 'Passwort aktualisieren',
        ],
        'description'       => 'Deinen Account aktualisieren',
        'email'             => 'Email ändern',
        'email_success'     => 'Email aktualisiert.',
        'password'          => 'Passwort ändern',
        'password_success'  => 'Passwort aktualisiert.',
        'social'            => [
            'error'     => 'Du benutzt bereits das Kanka Login für dieses Konto.',
            'helper'    => 'Dein Konto ist momentan von :provider. Du kannst aufhören dieses zu benutzen und auf ein Standard Kanka Login wechseln, indem du ein Kennwort setzt.',
            'success'   => 'Dein Konto benutzt jetzt das Kanka Login.',
            'title'     => 'Social Konto',
        ],
        'title'             => 'Account',
    ],
    'api'           => [
        'description'           => 'Aktualisiere deine API Einstellungen',
        'experimental'          => 'Willkommen zur API von Kanka! Diese Features sind noch experimentell, aber sollten stabil genug sein, um mit API zu kommunizieren. Erstelle ein persönliches Access Token, welches in deinem API Request genutzt wird, oder nutze das Client Token wenn du möchtest, dass deine App Zugriff auf Nutzerdaten hat.',
        'help'                  => 'Kanka wird bald eine RESTful API zur Verfügung stellen, so dass Drittanbieter-Apps mit Kanka kommunizieren können. Details, wie du deine API Keys verwaltest, wirst du bald hier finden.',
        'link'                  => 'Lies die API Dokumentation',
        'request_permission'    => 'Wir bauen zurzeit eine mächtige RESTful API, so das Drittanbieter-Apps sich zu Kanka verbinden können. Allerdings limitieren wir aktuell noch die Anzahl der Nutzer, die die API nutzen können, solange wir noch daran arbeiten. Wenn du Zugriff auf die API haben möchtest und coole Apps bauen möchtest, die mit Kanka kommunizieren, bitte kontaktiere uns und wir senden dir die Informationen, die du brauchst.',
        'title'                 => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Verbinden',
            'remove'    => 'Entfernen',
        ],
        'benefits'  => 'Kanka bietet einige Integrationsmöglichkeiten für Dienste von Drittanbietern. Weitere Integrationen von Drittanbietern sind für die Zukunft geplant.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Beim Verknüpfen Ihres Discord-Kontos mit Kanka ist ein Fehler aufgetreten. Bitte versuche es erneut.',
            ],
            'success'   => [
                'add'       => 'Ihr Discord-Konto wurde verknüpft.',
                'remove'    => 'Ihr Discord-Konto wurde nicht verbunden.',
            ],
            'text'      => 'Greifen Sie automatisch auf Ihre Abonnementrollen zu.',
        ],
        'title'     => 'App Integration',
    ],
    'boost'         => [
        'benefits'      => [
            'first'     => 'Um weitere Fortschritte bei Kanka zu erzielen, werden einige Kampagnenfunktionen durch Boosten einer Kampagne freigeschaltet. Boosts werden durch Abonnements freigeschaltet. Jeder, der eine Kampagne anzeigen kann, kann sie verbessern, sodass der DM nicht immer die Rechnung bezahlen muss. Eine Kampagne bleibt verstärkt, solange ein Benutzer die Kampagne verstärkt und Kanka weiterhin unterstützt. Wenn eine Kampagne nicht mehr verstärkt wird, gehen keine Daten verloren, sondern werden nur ausgeblendet, bis die Kampagne erneut erhöht wird.',
            'header'    => 'Objekt Header Bilder.',
            'images'    => 'Benutzerdefinitierte Standardobjektbilder.',
            'more'      => 'Erfahren Sie mehr über alle Funktionen.',
            'second'    => 'Das Boosten einer Kampagne bietet die folgenden Vorteile:',
            'theme'     => 'Leitmotiv auf Kampagnenebene und benutzerdefiniertes Design.',
            'third'     => 'Um eine Kampagne zu boosten, rufen Sie die Seite der Kampagne auf und klicken Sie auf die Schaltfläche ":boost_button" über der Schaltfläche ":edit_button".',
            'tooltip'   => 'Benutzerdefinierte Kurzinfo für Objekt.',
            'upload'    => 'Erhöhte Upload-Größe für jedes Mitglied in der Kampagne.',
        ],
        'buttons'       => [
            'boost' => 'Boost',
        ],
        'campaigns'     => 'Geboostete Kampagne :count / :max',
        'exceptions'    => [
            'already_boosted'   => 'Kampagne :name ist bereits geboostet',
            'exhausted_boosts'  => 'Sie haben keine Boosts mehr zu geben. Entfernen Sie Ihren Boost aus einer Kampagne, bevor Sie ihn einer anderen geben.',
        ],
        'success'       => [
            'boost' => 'Kampagne :name geboostet',
            'delete'=> 'Entferne den boost von :name',
        ],
        'title'         => 'Boost',
    ],
    'countries'     => [
        'austria'       => 'Österreich',
        'belgium'       => 'Belgien',
        'france'        => 'Frankreich',
        'germany'       => 'Deutschland',
        'italy'         => 'Italien',
        'netherlands'   => 'Niederlande',
        'spain'         => 'Spanien',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'PDF herunterladen',
            'view_all'  => 'Alle anzeigen',
        ],
        'empty'     => 'keine Rechnungen',
        'fields'    => [
            'amount'    => 'Menge',
            'date'      => 'Datum',
            'invoice'   => 'Rechnung',
            'status'    => 'Status',
        ],
        'header'    => 'Unten finden Sie eine Liste Ihrer letzten 24 Rechnungen, die heruntergeladen werden können.',
        'status'    => [
            'paid'      => 'Bezahlt',
            'pending'   => 'steht aus',
        ],
        'title'     => 'Rechnungen',
    ],
    'layout'        => [
        'description'   => 'Aktualisiere deine Layout Optionen',
        'success'       => 'Layout Optionen aktualisiert.',
        'title'         => 'Layout',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Marktplatzname',
        ],
        'helper'    => 'Standardmäßig wird Ihr Benutzername auf dem :marketplace angezeigt. Sie können diesen Wert mit diesem Feld überschreiben.',
        'title'     => 'Marktplatz Einstellungen',
        'update'    => 'Marktplatz Einstellungen gespeichert',
    ],
    'menu'          => [
        'account'               => 'Account',
        'api'                   => 'API',
        'apps'                  => 'Apps',
        'billing'               => 'Zahlungsmethode',
        'boost'                 => 'Boost',
        'invoices'              => 'Rechnungen',
        'layout'                => 'Layout',
        'marketplace'           => 'Marktplatz',
        'other'                 => 'Andere',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Zahlungsmöglichkeiten',
        'personal_settings'     => 'Persönliche Einstellungen',
        'profile'               => 'Profil',
        'subscription'          => 'Abonnement',
        'subscription_status'   => 'Abonnement Status',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Account verlinken',
            'view'  => 'Besuche Kanka auf Patreon',
        ],
        'benefits'          => 'Eure Unterstützung auf Patreon erlaubt es euch größere Bilder hochzuladen, hilft uns die Serverkosten zu begleichen und mehr Arbeitszeit in Kanka zu stecken.',
        'benefits_features' => 'erstaunliche Eigenschaften',
        'deprecated'        => 'Veraltete Funktion - Wenn Sie Kanka unterstützen möchten, tun Sie dies bitte mit einem :subscription. Die Patreon-Verknüpfung ist weiterhin für unsere Benutzer aktiv, die ihr Konto vor dem Umzug von Patreon verknüpft haben.',
        'description'       => 'Synchronisierung mit Patreon',
        'errors'            => [
            'invalid_token' => 'Ungültiger Token! Patreon konnte die Anfrage nicht validieren.',
            'missing_code'  => 'Fehlender Code! Patreon hat keinen Code zurück geschickt, um deinen Account zu verifizieren.',
            'no_pledge'     => 'Kein Pledge! Patreon hat deinen Account verifiziert, aber konnte keinen aktiven Pledge feststellen.',
        ],
        'link'              => 'Benutze diesen Button, wenn du aktuell Kanka auf Patreon unterstützt. Das gibt dir Zugriff auf einige tolle Extras.',
        'linked'            => 'Danke, dass du Kanka auf Patreon unterstützt! Dein Account wurde verlinkt.',
        'pledge'            => 'Pledge :name',
        'remove'            => [
            'button'    => 'Trennen Sie die Verknüpfung Ihres Patreon-Kontos',
            'success'   => 'Ihr Patreon-Konto wurde getrennt.',
            'text'      => 'Wenn Sie die Verknüpfung Ihres Patreon-Kontos mit Kanka aufheben, werden Ihre Boni, Ihr Name in der Hall of Fame, Kampagnen-Boosts und andere Funktionen im Zusammenhang mit der Unterstützung von Kanka entfernt. Keiner Ihrer verstärkten Inhalte geht verloren (z. B. Objekt header). Wenn Sie sich erneut anmelden, haben Sie Zugriff auf alle Ihre vorherigen Daten, einschließlich der Möglichkeit, Ihre zuvor verstärkten Kampagnen zu verbessern.',
            'title'     => 'Trennen Sie Ihr Patreon-Konto von Kanka',
        ],
        'success'           => 'Danke, dass du Kanka auf Patreon unterstützt.',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Euer Patreon Tier wird manuell von uns gesetzt. Daher kann es sein, dass es bis zu ein paar Tagen dauert bis es korrekt hinterlegt wird. Wenn es länger falsch ist, kontaktiert uns bitte.',
    ],
    'profile'       => [
        'actions'       => [
            'update_profile'    => 'Aktualisiere dein Profil',
        ],
        'avatar'        => 'Profilbild',
        'description'   => 'Aktualisiere dein Profil',
        'success'       => 'Profil aktualisiert.',
        'title'         => 'Persönliches Profil',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Abonnement beenden',
            'subscribe'         => 'Abonnieren',
            'update_currency'   => 'Speichern Sie die bevorzugte Währung',
        ],
        'benefits'              => 'Wenn Sie uns unterstützen, können Sie einige neue :features freischalten und uns helfen  mehr Zeit in die Verbesserung von Kanka zu investieren. Es werden keine Kreditkarteninformationen gespeichert oder über unsere Server übertragen. Wir verwenden :stripe, um alle Abrechnungen abzuwickeln.',
        'billing'               => [
            'helper'    => 'Ihre Zahlungsinformationen werden sicher verarbeitet und gespeichert durch :stripe. Diese Zahlungsmethode wird für alle Ihre Abonnements verwendet.',
            'saved'     => 'Gespeicherte Zahlungsmethode',
            'title'     => 'Zahlungsmethode ändern',
        ],
        'cancel'                => [
            'text'  => 'Es tut uns leid dich gehen zu sehen! Wenn Sie Ihr Abonnement kündigen, bleibt es bis zu Ihrem nächsten Abrechnungszyklus aktiv. Danach verlieren Sie Ihre Kampagnen-Boosts und andere Vorteile im Zusammenhang mit der Unterstützung von Kanka. Füllen Sie das folgende Formular aus, um uns mitzuteilen, was wir besser machen können oder was zu Ihrer Entscheidung geführt hat.',
        ],
        'cancelled'             => 'Ihr Abonnement wurde gekündigt. Sie können ein Abonnement verlängern, sobald Ihr aktuelles Abonnement endet.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Sie abonnieren die :tier Stufe , die monatlich in Rechnung gestellt wird für :amount.',
                'yearly'    => 'Sie abonnieren die :tier Stufe, die jährlich in Rechnung gestellt wird für :amount.',
            ],
            'title' => 'Abonnementstufe ändern',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Ändern Sie Ihre bevorzugte Rechnungswährung',
        ],
        'errors'                => [
            'callback'      => 'Unser Zahlungsanbieter hat einen Fehler gemeldet. Bitte versuchen Sie es erneut oder kontaktieren Sie uns, wenn das Problem weiterhin besteht.',
            'subscribed'    => 'Ihr Abonnement konnte nicht verarbeitet werden. Stripe lieferte den folgenden Hinweis.',
        ],
        'fields'                => [
            'active_since'      => 'aktiv seit',
            'active_until'      => 'aktiv bis',
            'billed_monthly'    => 'Monatlich abgerechnet',
            'billing'           => 'Abrechnung',
            'currency'          => 'Abrechnungswährung',
            'payment_method'    => 'Zahlungsmethode',
            'plan'              => 'Derzeitiger Plan',
            'reason'            => 'Ursache',
        ],
        'helpers'               => [
            'alternatives'          => 'Bezahlen Sie Ihr Abonnement mit :method. Diese Zahlungsmethode wird am Ende Ihres Abonnements nicht automatisch verlängert. :method ist nur in Euro verfügbar.',
            'alternatives_warning'  => 'Ein Upgrade Ihres Abonnements mit dieser Methode ist nicht möglich. Bitte erstellen Sie ein neues Abonnement, wenn Ihr aktuelles Abonnement endet.',
            'alternatives_yearly'   => 'Aufgrund der Einschränkungen bei wiederkehrenden Zahlungen ist die :method nur für Jahresabonnements verfügbar',
        ],
        'manage_subscription'   => 'Abonnement verwalten',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Füge eine neue Zahlungsmethode hinzu',
                'change'            => 'Zahlungsmethode ändern',
                'save'              => 'Zahlungsmethode speichern',
                'show_alternatives' => 'alternative Zahlungsoptionen',
            ],
            'add_one'       => 'Sie haben derzeit keine Zahlungsmethode gespeichert.',
            'alternatives'  => 'Sie können diese alternativen Zahlungsoptionen abonnieren. Diese Aktion belastet Ihr Konto einmal und erneuert Ihr Abonnement nicht jeden Monat automatisch.',
            'card'          => 'Karte',
            'card_name'     => 'Name auf der Karte',
            'country'       => 'Land des Wohnsitzes',
            'ending'        => 'gültig bis',
            'helper'        => 'Diese Karte wird für alle Ihre Abonnements verwendet.',
            'new_card'      => 'Fügen sie eine neue Zahlungsmethode hinzu',
            'saved'         => ':brand endet mit :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Sagen Sie uns optional, warum Sie Kanka nicht mehr unterstützen. Fehlt eine Funktion? Hat sich Ihre finanzielle Situation geändert?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount monatlich abgerechnet',
            'cost_yearly'   => ':currency :amount jährlich abgerechnet',
        ],
        'sub_status'            => 'Abonnementinformationen',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Bitte kontaktieren Sie uns für ein Downgrade',
                'rollback'          => 'Wechseln Sie zu Kobold',
                'subscribe'         => 'Wechseln Sie zu :tier monatlich',
                'subscribe_annual'  => 'Wechseln Sie zu :tier jährlich',
            ],
        ],
        'success'               => [
            'alternative'   => 'Ihre Zahlung wurde registriert. Sie erhalten eine Benachrichtigung, sobald diese verarbeitet wurde und Ihr Abonnement aktiv ist.',
            'callback'      => 'Ihr Abonnement war erfolgreich. Ihr Konto wird aktualisiert, sobald unsere Zahlung uns über die Änderung informiert (dies kann einige Minuten dauern).',
            'cancel'        => 'Ihr Abonnement wurde gekündigt. Es bleibt bis zum Ende Ihres aktuellen Abrechnungszeitraums aktiv.',
            'currency'      => 'Ihre bevorzugte Währungseinstellung wurde aktualisiert.',
            'subscribed'    => 'Ihr Abonnement war erfolgreich. Vergessen Sie nicht, den Community Vote-Newsletter zu abonnieren, um benachrichtigt zu werden, wenn eine Abstimmung live geht. Sie können Ihre Newsletter-Einstellungen auf Ihrer Profilseite ändern.',
        ],
        'tiers'                 => 'Abonnementstufen',
        'trial_period'          => 'Für Jahresabonnements gilt eine Stornierungsfrist von 14 Tagen. Kontaktieren Sie uns unter :email, wenn Sie Ihr Jahresabonnement kündigen und eine Rückerstattung erhalten möchten.',
        'upgrade_downgrade'     => [
            'button'    => 'Upgrade- und Downgrade-Informationen',
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'Ihre aktuelle Stufe bleibt bis zum Ende Ihres aktuellen Abrechnungszyklus aktiv. Danach werden Sie auf Ihre neue Stufe herabgestuft.',
                ],
                'title'     => 'Beim Downgrade auf eine niedrigere Stufe',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Ihre Zahlungsmethode wird sofort in Rechnung gestellt und Sie haben Zugriff auf Ihre neue Stufe.',
                    'prorate'   => 'Beim Upgrade von Owlbear auf Elemental wird Ihnen nur die Differenz zu Ihrer neuen Stufe in Rechnung gestellt.',
                ],
                'title'     => 'Beim Upgrade auf eine höhere Stufe',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Wir konnten Ihre Kreditkarte nicht belasten. Bitte aktualisieren Sie Ihre Kreditkarteninformationen. Wir werden versuchen, sie in den nächsten Tagen erneut zu belasten. Wenn es erneut fehlschlägt, wird Ihr Abonnement gekündigt.',
            'patreon'       => 'Ihr Konto ist derzeit mit Patreon verknüpft. Bitte trennen Sie die Verknüpfung Ihres Kontos in Ihren :patreon-Einstellungen, bevor Sie zu einem Kanka-Abonnement wechseln.',
        ],
    ],
];
