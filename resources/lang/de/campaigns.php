<?php

return [
    'create'                => [
        'description'           => 'Erstelle eine neue Kampagne',
        'helper'                => [
            'first' => 'Danke, dass du unsere App ausprobierst! Bevor es losgehen kann, brauchen wir nur eine Kleinigkeit von dir, deinen <b>Kampagnennamen</b>. Das ist der Name deiner Welt, der sie von anderen unterscheidet, also muss er einzigartig sein. Wenn du noch keinen geeigneten Namen hast, mach dir keine Sorgen, du kannst ihn <b>jederzeit ändern</b>, oder weitere Kampagnen erstellen.',
            'second'=> 'Aber genug Geplauder! Was soll es sein?',
            'title' => 'Willkommen bei :name!',
        ],
        'success'               => 'Kampagne erstellt.',
        'success_first_time'    => 'Deine Kampagne wurde erstellt! Da es deine erste Kampagne ist, haben wir ein paar Dinge für dich erstellt, die dir helfen sollen, loszulegen und hoffentlich ein bisschen Inspiration liefern, was du alles machen kannst.',
        'title'                 => 'Neue Kampagne erstellen',
    ],
    'destroy'               => [
        'success'   => 'Kampagne gelöscht',
    ],
    'edit'                  => [
        'description'   => 'Bearbeite deine Kampagne',
        'success'       => 'Kampagne aktualisiert',
        'title'         => 'Kampagne :campaign bearbeiten',
    ],
    'entity_visibilities'   => [
        'private'   => 'Neue Objekte sind privat',
    ],
    'errors'                => [
        'access'        => 'Du hast keinen Zugang zu dieser Kampagne.',
        'unknown_id'    => 'Unbekannte Kampagne.',
    ],
    'export'                => [
        'description'   => 'Exportiere die Kampagne.',
        'errors'        => [
            'limit' => 'Du hast dein Limit von einem Export pro Tag erreicht. Bitte versuche es morgen wieder.',
        ],
        'helper'        => 'Exportiere deine Kampagne. Eine Benachrichtigung mit dem Downloadlink wir dir bereit gestellt.',
        'success'       => 'Der Export deiner Kampagne wird vorbereitet. Du erhältst eine Nachricht in Kanka sobald dein Download bereit steht.',
        'title'         => 'Kampagne :name Export',
    ],
    'fields'                => [
        'description'       => 'Beschreibung',
        'entity_visibility' => 'Objektsichtbarkeit',
        'image'             => 'Bild',
        'locale'            => 'Schauplatz',
        'name'              => 'Name',
        'visibility'        => 'Sichtbarkeit',
    ],
    'helpers'               => [
        'entity_visibility' => 'Wenn du ein neues Objekt erstellst, wird es automatisch auf "Privat" gesetzt.',
        'locale'            => 'Die Sprache, in der deine Kampagne geschrieben ist. Dies wird genutzt, um Inhalte zu erstellen und öffentliche Kampagnen zu gruppieren.',
        'name'              => 'Deine Kampagne/Welt kann einen beliebigen Namen haben, solange dieser mindestens 4 Buchstaben oder Zahlen enthält.',
        'visibility'        => 'Eine Kampagne öffentlich machen bedeutet, dass jeder mit einem Link dazu sie sehen kann.',
    ],
    'index'                 => [
        'actions'       => [
            'new'   => [
                'description'   => 'Neue Kampagne erstellen',
                'title'         => 'Neue Kampagne',
            ],
        ],
        'add'           => 'Neue Kampagne',
        'description'   => 'Verwalte deine Kampagnen',
        'list'          => 'Deine Kampagnen',
        'select'        => 'Wähle eine Kampagne',
        'title'         => 'Kampagnen',
    ],
    'invites'               => [
        'actions'       => [
            'add'   => 'Einladung',
            'link'  => 'Neuer Link',
        ],
        'create'        => [
            'button'        => 'Einladen',
            'description'   => 'Lade einen Freund zu deiner Kampagne ein',
            'link'          => 'Link erstellt: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Einladung verschickt.',
            'title'         => 'Lade jemanden zu deiner Kampagne ein',
        ],
        'destroy'       => [
            'success'   => 'Einladung entfernt.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Trete :name\'s Kampagne bei</a>',
            'subject'   => ':name hat dich eingeladen, seiner Kampagne \':campaign\' auf kanka.io beizutreten! Nutze den folgenden Link, um die Einladung anzunehmen.',
            'title'     => 'Einladung von :name',
        ],
        'error'         => [
            'already_member'    => 'Du bist bereits Mitglied dieser Kampagne',
            'inactive_token'    => 'Dieses Token wurde bereits genutzt oder die Kampagne existiert nicht mehr.',
            'invalid_token'     => 'Dieser Token ist nicht mehr gültig.',
            'login'             => 'Bitte logge dich ein oder registriere dich, um der Kampagne beizutreten.',
        ],
        'fields'        => [
            'created'   => 'Senden',
            'email'     => 'Email',
            'role'      => 'Rolle',
            'type'      => 'Typ',
            'validity'  => 'Gültigkeit',
        ],
        'helpers'       => [
            'validity'  => 'Wie viele Nutzer können diesen Link benutzen, bevor er ausläuft.',
        ],
        'placeholders'  => [
            'email' => 'Email Adresse der Person, die du zu der Kampagne einladen möchtest',
        ],
        'types'         => [
            'email' => 'Email',
            'link'  => 'Link',
        ],
    ],
    'leave'                 => [
        'confirm'   => 'Bist du sicher, dass du die Kampagne :name verlassen möchtest? Du hast danach keinen Zugang mehr, außer ein Besitzer der Kampagne lädt dich erneut ein.',
        'error'     => 'Kann die Kampagne nicht verlassen.',
        'success'   => 'Du hast die Kampagne verlassen.',
    ],
    'members'               => [
        'create'        => [
            'title' => 'Füge ein Mitglied zu deiner Kampagne hinzu.',
        ],
        'description'   => 'Verwalte die Mitglieder deiner Kampagne',
        'edit'          => [
            'description'   => 'Bearbeite ein Mitglied deiner Kampagne',
            'title'         => 'Bearbeite Mitglied :name',
        ],
        'fields'        => [
            'joined'    => 'Beigetreten',
            'name'      => 'Nutzer',
            'role'      => 'Rolle',
            'roles'     => 'Rollen',
        ],
        'help'          => 'Es gibt kein Limit der Anzahl der Mitglieder einer Kampagne und als ein Admin kannst du Mitglieder entfernen, die nicht mehr aktiv sind.',
        'invite'        => [
            'description'   => 'Du kannst deine Freunde zu deiner Kampagne einladen, in dem du ihre Email Adresse eingibst. Wenn sie die Einladung annehmen, werden sie als \'Zuschauer\' hinzugefügt. Du kannst die Einladung auch jederzeit abbrechen.',
            'title'         => 'Einladen',
        ],
        'roles'         => [
            'member'    => 'Mitglied',
            'owner'     => 'Besitzer',
            'viewer'    => 'Zuschauer',
        ],
        'title'         => 'Kampagne :name Mitglieder',
        'your_role'     => 'Du bist ein <i>:role</i>',
    ],
    'placeholders'          => [
        'description'   => 'Eine kurze Zusammenfassung deiner Kampagne',
        'locale'        => 'Sprachcode',
        'name'          => 'Dein Kampagnenname',
    ],
    'roles'                 => [
        'actions'       => [
            'add'   => 'Rolle hinzufügen',
        ],
        'create'        => [
            'success'   => 'Rolle erstellt.',
            'title'     => 'Erstelle eine neue Rolle für :name',
        ],
        'description'   => 'Verwalte die Rollen deiner Kampagne',
        'destroy'       => [
            'success'   => 'Rolle entfernt.',
        ],
        'edit'          => [
            'success'   => 'Rolle aktualisiert.',
            'title'     => 'Rolle :name bearbeiten',
        ],
        'fields'        => [
            'name'          => 'Name',
            'permissions'   => 'Berechtigungen',
            'type'          => 'Typ',
            'users'         => 'Nutzer',
        ],
        'helper'        => [
            '1' => 'Eine Kampagne kann so viele Rollen haben, wie du willst. Die "Admin" Rolle hat automatisch Zugriff auf alles in einer Kampagne, aber jede andere Rolle kann spezielle Berechtigungen auf unterschiedliche Typen von Objekten (Charaktere, Orte, etc.) haben.',
            '2' => 'Objekte können feiner abgestimmte Berechtigungen haben, die du im "Berechtigungen" Tab des Objekts einstellen kannst. Dieser Tab erscheint, wenn du mehrere Rollen in deiner Kampagne hast.',
            '3' => 'Man kann entweder ein "opt-out" System verwenden, in dem Rollen lesenden Zugriff auf alle Objekte bekommen und mit der "Privat" Checkbox bestimmte Objekte ausgeblendet werden. Oder man gibt Rollen wenige Berechtigungen und setzt jedes Objekt explizit auf sichtbar.',
        ],
        'hints'         => [
            'role_permissions'  => 'Erlaube der Rolle \':name\' die folgenden Aktionen auf allen Objekten.',
        ],
        'members'       => 'Mitglieder',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Erstellen',
                'delete'        => 'Entfernen',
                'edit'          => 'Bearbeiten',
                'permission'    => 'Verwalte Berechtigungen',
                'read'          => 'Anschauen',
            ],
            'hint'      => 'Diese Rolle hat automatisch Zugriff auf alles.',
        ],
        'placeholders'  => [
            'name'  => 'Name der Rolle',
        ],
        'show'          => [
            'description'   => 'Mitglieder und Berechtigungen einer Rolle',
            'title'         => 'Rolle \':role\' für Kampagne \':campaign\'',
        ],
        'title'         => 'Kampagne :name Rollen',
        'types'         => [
            'owner'     => 'Besitzer',
            'public'    => 'Öffentlich',
            'standard'  => 'Standard',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Hinzufügen',
            ],
            'create'    => [
                'success'   => 'Benutzer zu Rolle hinzugefügt.',
                'title'     => 'Füge ein Mitglied zur Rolle :name hinzu',
            ],
            'destroy'   => [
                'success'   => 'Benutzer aus Rolle entfernt',
            ],
            'fields'    => [
                'name'  => 'Name',
            ],
        ],
    ],
    'settings'              => [
        'description'   => 'Aktiviere oder deaktiviere Module für diese Kampagne.',
        'edit'          => [
            'success'   => 'Kampagnen Einstellungen aktualisiert.',
        ],
        'helper'        => 'Du kannst einfach Elemente von deiner Kampagne abschalten, die dann versteckt werden. Wenn du bereits Objekte in dieser Kategorie angelegt hast, werden diese nicht gelöscht, nur versteckt.',
        'helpers'       => [
            'calendars'     => 'Der Ort, um die Kalender deiner Welt zu erstellen.',
            'tags'    => 'Jedes Objekt kann eine Kategorie habe. Kategorien können zu anderen Kategorien gehören und Objekte können nach Kategorie gefiltert werden.',
            'characters'    => 'Die Leute, die deine Welt bevölkern.',
            'conversations' => 'Fiktive Gespräche zwischen Charakteren oder zwischen Kampagnennutzern.',
            'dice_rolls'    => 'Für die, die Kanka für RPG Kampagnen benutzen, eine Möglichkeit Würfelwürfe zu verwalten.',
            'events'        => 'Feiertage, Festlichkeiten, Katastrophen, Geburtstage, Kriege.',
            'families'      => 'Klans oder Familien, deren Beziehungen und deren Mitglieder.',
            'items'         => 'Waffen, Fahrzeuge, Reliquien, Tränke.',
            'journals'      => 'Beobachtungen von Spielern oder Spielvorbereitungen vom Spielleiter.',
            'locations'     => 'Planeten, Ebenen, Kontinente, Flüsse, Staaten, Siedlungen, Tempel, Tavernen.',
            'menu_links'    => 'Selbsterstellte Menü Links in der Seitenleiste.',
            'notes'         => 'Sagen, Religionen, Geschichte, Magie, Rassen.',
            'organisations' => 'Kulte, Militäreinheiten, Fraktionen, Gilden.',
            'quests'        => 'Um Aufgaben mit Charakteren und Ort zu verfolgen.',
            'races'         => 'Wenn deine Kampagne mehr als eine Rasse hat, hier kannst du den Überblick behalten.',
        ],
        'title'         => 'Kampagne :name Module',
    ],
    'show'                  => [
        'actions'       => [
            'leave' => 'Kampagne verlassen',
        ],
        'description'   => 'Eine detaillierte Ansicht der Kampagne',
        'tabs'          => [
            'export'        => 'Export',
            'information'   => 'Informationen',
            'members'       => 'Mitglieder',
            'menu'          => 'Menü',
            'roles'         => 'Rollen',
            'settings'      => 'Einstellungen',
        ],
        'title'         => 'Kampagne :name',
    ],
    'visibilities'          => [
        'private'   => 'Privat',
        'public'    => 'Öffentlich',
        'review'    => 'Wartet auf Überprüfung',
    ],
];
