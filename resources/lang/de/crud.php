<?php

return [
    'actions'                   => [
        'actions'           => 'Aktionen',
        'apply'             => 'Übernehmen',
        'back'              => 'Zurück',
        'bulk_templates'    => 'Attributvorlage anwenden',
        'copy'              => 'Kopieren',
        'copy_mention'      => 'Kopie [] erwähnen',
        'copy_to_campaign'  => 'Kopiere zu Kampagne',
        'explore_view'      => 'Verschachtelte Ansicht',
        'export'            => 'Exportieren',
        'find_out_more'     => 'Mehr erfahren',
        'go_to'             => 'Gehe zu :name',
        'json-export'       => 'Export (json)',
        'manage_links'      => 'Links verwalten',
        'more'              => 'Mehr Aktionen',
        'move'              => 'Verschieben',
        'new'               => 'Neu',
        'new_post'          => 'Neue Objektnotiz',
        'next'              => 'Weiter',
        'print'             => 'Drucken',
        'private'           => 'Privat',
        'public'            => 'Öffentlich',
        'reset'             => 'Zurücksetzen',
        'transform'         => 'Umwandeln',
    ],
    'add'                       => 'Hinzufügen',
    'alerts'                    => [
        'copy_attribute'    => 'Die Erwähnung des Attributs wurde in Ihre Zwischenablage kopiert.',
        'copy_mention'      => 'Die erweiterte Erwähnung dieses Objekts wurde in Ihre Zwischenablage kopiert.',
    ],
    'boosted'                   => 'geboostet',
    'boosted_campaigns'         => 'geboostete Kampagne',
    'bulk'                      => [
        'actions'       => [
            'edit'  => 'Bearbeitung vieler Objekte',
        ],
        'age'           => [
            'helper'    => 'Sie können + und - vor der Nummer verwenden, um das Alter dynamisch zu aktualisieren.',
        ],
        'delete'        => [
            'title'     => 'Mehrere Objekte löschen',
            'warning'   => 'Möchten Sie die ausgewählten Objekte wirklich löschen?',
        ],
        'edit'          => [
            'tagging'   => 'Aktion für Tags',
            'tags'      => [
                'add'       => 'Hinzufügen',
                'remove'    => 'Entfernen',
            ],
            'title'     => 'Mehrere Objekte bearbeiten',
        ],
        'errors'        => [
            'admin'     => 'Nur Kampagnenadmins können den "Privat" Status eines Objektes ändern.',
            'general'   => 'Bei der Verarbeitung Ihrer Aktion ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut und kontaktieren Sie uns, wenn das Problem weiterhin besteht. Fehlermeldung: :hint.',
        ],
        'permissions'   => [
            'fields'    => [
                'override'  => 'Überschreiben',
            ],
            'helpers'   => [
                'override'  => 'Wenn ausgewählt, werden die Berechtigungen der ausgewählten Objekte mit diesen überschrieben. Wenn das Kontrollkästchen deaktiviert ist, werden die ausgewählten Berechtigungen zu den vorhandenen Berechtigungen hinzugefügt.',
            ],
            'title'     => 'Ändert die Berechtigungen für mehrere Objekte',
        ],
        'success'       => [
            'copy_to_campaign'  => '{1} :count der in :campaign kopierten Objekte. | [2, *] :count  der in :campaign kopierten Objekte.',
            'editing'           => '{1} :count objekt wurde aktualisiert. | [2, *] :count objekte wurden aktualisiert.',
            'permissions'       => '{1} Berechtigungen für :count Objekt geändert.|Berechtigungen für :count Objekte geändert.',
            'private'           => '{1} :count Objekt ist jetzt privat.|:count Objekte sind jetzt privat.',
            'public'            => '{1} :count Objekt ist jetzt sichtbar.|:count Objekte sind jetzt sichtbar.',
            'templates'         => '{1} Auf :count Objekt wurde eine Vorlage angewendet. | [2, *] auf :count Objekt wurde eine Vorlage angewendet.',
        ],
    ],
    'bulk_templates'            => [
        'bulk_title'    => 'Wenden Sie eine Vorlage auf mehrere Objekte an',
    ],
    'cancel'                    => 'Abbrechen',
    'click_modal'               => [
        'close'     => 'Schließen',
        'confirm'   => 'Bestätigen',
        'title'     => 'Bestätige deine Aktion',
    ],
    'copy_to_campaign'          => [
        'bulk_title'    => 'Kopieren Sie Objekte in eine andere Kampagne',
        'panel'         => 'Kopieren',
        'title'         => 'Kopiere :name in eine andere Kampagne',
    ],
    'create'                    => 'Erstellen',
    'datagrid'                  => [
        'empty' => 'Nichts zu sehen bisher.',
    ],
    'delete_modal'              => [
        'close'             => 'Schließen',
        'delete'            => 'Löschen',
        'description'       => 'Bist du sicher das du :tag entfernen möchtest?',
        'description_final' => 'Möchten Sie :tag wirklich entfernen? Diese Aktion kann nicht rückgängig gemacht werden.',
        'mirrored'          => 'Entferne gespiegelte Beziehung.',
        'title'             => 'Löschen bestätigen',
    ],
    'destroy_many'              => [
        'success'   => ':count Objekt gelöscht|:count Objekte gelöscht',
    ],
    'edit'                      => 'Bearbeiten',
    'errors'                    => [
        'boosted'                       => 'Diese Funktion ist nur für geboostete Kampagnen verfügbar.',
        'boosted_campaigns'             => 'Diese Funktion ist nur für :boosted verfügbar',
        'node_must_not_be_a_descendant' => 'Ungültiges Objekt (Kategorie, Ort): es würde ein Nachkomme von sich selbst sein.',
        'unavailable_feature'           => 'nicht verfügbare Eigenschaft',
    ],
    'events'                    => [
        'hint'  => 'Kalenderereignisse, die mit diesem Objekt verknüpft sind, werden hier dargestellt.',
    ],
    'export'                    => 'Exportieren',
    'fields'                    => [
        'ability'               => 'Fähigkeit',
        'attribute_template'    => 'Attributsvorlage',
        'calendar'              => 'Kalender',
        'calendar_date'         => 'Kalenderdatum',
        'character'             => 'Charakter',
        'closed'                => 'geschlossen',
        'colour'                => 'Farbe',
        'copy_abilities'        => 'Kopiere Fähigkeiten',
        'copy_attributes'       => 'Kopiere Attribute',
        'copy_inventory'        => 'Kopiere Inventar',
        'copy_links'            => 'Kopiere Objekt Links',
        'copy_notes'            => 'Kopiere Objektnotizen',
        'creator'               => 'Ersteller',
        'dice_roll'             => 'Würfelwürf',
        'entity'                => 'Objekt',
        'entity_type'           => 'Objekttyp',
        'entry'                 => 'Eintrag',
        'event'                 => 'Ereignis',
        'excerpt'               => 'Auszug',
        'family'                => 'Familie',
        'files'                 => 'Dateien',
        'gallery_header'        => 'Galerie-Header',
        'gallery_image'         => 'Galerie Bild',
        'has_entity_files'      => 'Hat Objektdateien',
        'has_entity_notes'      => 'Hat Objektnotizen',
        'has_image'             => 'hat ein Bild',
        'header_image'          => 'Kopfzeilenbild',
        'image'                 => 'Bild',
        'is_closed'             => 'Die Konversation wird geschlossen und es werden keine neuen Nachrichten mehr akzeptiert.',
        'is_private'            => 'Privat',
        'is_private_v2'         => 'Zeigen Sie dies nur Mitgliedern der Kampagne :admin-role',
        'is_star'               => 'Angepinnt',
        'item'                  => 'Gegenstand',
        'journal'               => 'Tagebuch',
        'location'              => 'Ort',
        'locations'             => ':first in :second',
        'map'                   => 'Karte',
        'name'                  => 'Name',
        'organisation'          => 'Organisation',
        'position'              => 'Position',
        'privacy'               => 'Privat',
        'race'                  => 'Spezies',
        'tag'                   => 'Tag',
        'tags'                  => 'Tags',
        'timeline'              => 'Zeitstrahl',
        'tooltip'               => 'Kurzinfo',
        'type'                  => 'Typ',
        'visibility'            => 'Sichtbarkeit',
    ],
    'files'                     => [
        'actions'   => [
            'drop'      => 'Klicken zum Hinzufügen oder Datei hierher ziehen (Drag & Drop).',
            'manage'    => 'Verwalte Objektdateien',
        ],
        'errors'    => [
            'max'       => 'Du hast die maximale Anzahl (:max) von Dateien in diesem Objekt erreicht.',
            'no_files'  => 'Keine Dateien.',
        ],
        'files'     => 'Hochgeladene Dateien',
        'hints'     => [
            'limit'         => 'In jedem Objekt kann eine maximale Anzahl von :max Dateien hochgeladen werden.',
            'limitations'   => 'Unterstütze Formate: jpg, png, gif, und pdf. Max. Dateigröße: :size',
        ],
        'title'     => 'Objektdateien für :name',
    ],
    'filter'                    => 'Filter',
    'filters'                   => [
        'all'                       => 'Filter um alle Unterobjekte zu sehen',
        'clear'                     => 'Filter zurücksetzen',
        'copy_helper'               => 'Verwenden Sie die kopierten Filter in Ihrer Zwischenablage als Werte für Filter in Dashboard-Widgets und Quicklinks.',
        'copy_helper_no_filters'    => 'Definieren Sie zuerst einige Filter, um sie in Ihre Zwischenablage kopieren zu können.',
        'copy_to_clipboard'         => 'Kopiere Filter in die Zwischenablage',
        'direct'                    => 'Filter um nur direkte Unterobjekte zu sehen',
        'filtered'                  => 'Zeige :count von :total :entity.',
        'hide'                      => 'Verstecken',
        'mobile'                    => [
            'clear' => 'Löschen',
            'copy'  => 'Clipboard',
        ],
        'options'                   => [
            'exclude'   => 'Ausschließen',
            'include'   => 'Einschließen',
            'none'      => 'keine',
        ],
        'show'                      => 'Zeigen',
        'sorting'                   => [
            'asc'       => ':field Aufsteigend',
            'desc'      => ':field absteigend',
            'helper'    => 'Steuern Sie, in welcher Reihenfolge die Ergebnisse angezeigt werden.',
        ],
        'title'                     => 'Filter',
    ],
    'fix-this-issue'            => 'Beheben Sie dieses Problem',
    'forms'                     => [
        'actions'       => [
            'calendar'  => 'Füge Datum hinzu',
        ],
        'copy_options'  => 'Kopiere Optionen',
    ],
    'helpers'                   => [
        'copy_options'  => 'Kopieren Sie die folgenden verwandten Elemente aus der Quelle in das neue Objekt.',
    ],
    'hidden'                    => 'Versteckt',
    'hints'                     => [
        'attribute_template'    => 'Wende eine Attributsvorlage direkt beim erstellen des Objektes an.',
        'calendar_date'         => 'Ein Datum erlaubt es, Listen einfach zu filtern und pflegt ein Ereignis im ausgewählten Kalender.',
        'gallery_header'        => 'Wenn das Objekt keine Kopfzeile hat, zeigen Sie stattdessen ein Bild aus der Kampagnengalerie an.',
        'gallery_image'         => 'Wenn das Objekt kein Bild hat, wird  ein Bild aus der Kampagnengalerie angezeigt.',
        'header_image'          => 'Dieses Bild wird über dem Objekt platziert. Verwenden Sie ein breites Bild, um optimale Ergebnisse zu erzielen.',
        'image_limitations'     => 'Unterstützte Formate: :formats. Maximale Dateigröße: :size.',
        'image_patreon'         => 'Erhöhe das Limit indem du uns bei Patreon unterstützt.',
        'is_private'            => 'Vor \'Zuschauern\' verbergen',
        'is_star'               => 'Angepinnte Objekte erscheinen im Objektmenü.',
        'tooltip'               => 'Ersetzen Sie die automatisch generierte Kurzinfo durch den folgenden Inhalt.',
        'visibility'            => 'Wenn die Sichtbarkeit auf Admin festgelegt wird, können dies nur Mitglieder in der Rolle Admin sehen. Wird es auf "Selbst" gesetzt, kannst es nur du sehen.',
    ],
    'history'                   => [
        'created'       => 'Erstellt von <strong>:name</strong> <span data-toggle="tooltip" title=":realdate">:date</span>',
        'created_date'  => 'Erstelle <span data-toggle="tooltip" title=":realdate">:date</span>',
        'unknown'       => 'Unbekannt',
        'updated'       => 'Zuletzt aktualisiert von <strong>:name</strong> <span data-toggle="tooltip" title=":realdate">:date</span>',
        'updated_date'  => 'Letzte Änderung <span data-toggle = "tooltip" title = ": realdate">: Datum </ span>',
        'view'          => 'Zeige Objektprotokoll',
    ],
    'image'                     => [
        'error' => 'Wir konnten das von dir angeforderte Bild nicht laden. Es könnte sein, dass die Website nicht erlaubt, Bilder herunterzuladen (typisch für Squarespace und DeviantArt) oder dass der Link nicht mehr gültig ist.',
    ],
    'is_not_private'            => 'Dieses Objekt ist derzeit nicht auf privat eingestellt.',
    'is_private'                => 'Dieses Objekt ist privat und nicht von Zuschauern einsehbar.',
    'legacy'                    => 'Erbe',
    'linking_help'              => 'Wie kann ich zu anderen Objekten verlinken?',
    'manage'                    => 'Verwalten',
    'move'                      => [
        'description'   => 'Verschiebe diese Objekt an einen anderen Ort',
        'errors'        => [
            'permission'        => 'Du hast keine Berechtigung, Objekte diesen Typs in dieser Kampagne zu erstellen.',
            'same_campaign'     => 'Du musst eine andere Kampagne auswählen, in welche du das Objekt verschieben willst.',
            'unknown_campaign'  => 'Unbekannte Kampagne.',
        ],
        'fields'        => [
            'campaign'  => 'Neue Kampagne',
            'copy'      => 'Erstelle Kopie',
            'target'    => 'Neuer Typ',
        ],
        'hints'         => [
            'campaign'  => 'Du kannst auch versuchen, dieses Objekt in eine andere Kampagne zu verschieben.',
            'copy'      => 'Wähle diese Option, wenn du eine Kopie in der neuen Kampagne erstellen willst.',
            'target'    => 'Bitte beachte, das einige Daten verloren gehen können, wenn ein Objekt von einem Typ zu einem anderen verschoben wird.',
        ],
        'panels'        => [
            'change'    => 'Objekttyp ändern',
            'move'      => 'Verschiebe in eine andere Kampagne',
        ],
        'success'       => 'Objekt \':name\' verschoben',
        'success_copy'  => 'Objekt \':name\' kopiert',
        'title'         => 'Verschiebe :name an einen anderen Ort',
    ],
    'navigation'                => [
        'cancel'    => 'Abbrechen',
        'or_cancel' => 'oder :cancel',
    ],
    'new_entity'                => [
        'error' => 'Bitte überprüfe deine Eingabe.',
        'fields'=> [
            'name'  => 'Name',
        ],
        'title' => 'Neues Objekt',
    ],
    'or_cancel'                 => 'oder <a href=":url">abbrechen</a>',
    'panels'                    => [
        'appearance'            => 'Aussehen',
        'attribute_template'    => 'Attributsvorlage',
        'calendar_date'         => 'Datum',
        'entry'                 => 'Eintrag',
        'general_information'   => 'Allgemeine Informationen',
        'move'                  => 'Verschieben',
        'system'                => 'System',
    ],
    'permissions'               => [
        'action'            => 'Aktion',
        'actions'           => [
            'bulk'          => [
                'add'       => 'Hinzufügen',
                'deny'      => 'verweigern',
                'ignore'    => 'Ignorieren',
                'remove'    => 'Entfernen',
            ],
            'bulk_entity'   => [
                'allow'     => 'erlauben',
                'deny'      => 'verweigern',
                'inherit'   => 'Erben',
            ],
            'delete'        => 'Löschen',
            'edit'          => 'Bearbeiten',
            'entity_note'   => 'Objektnotizen',
            'read'          => 'Lesen',
            'toggle'        => 'Umschalten',
        ],
        'allowed'           => 'Erlaubt',
        'fields'            => [
            'member'    => 'Mitglied',
            'role'      => 'Rolle',
        ],
        'helper'            => 'Benutze dieses Interface um die Berechtigungen von Nutzern und Rollen mit diesem Objekt  fein zu justieren.',
        'helpers'           => [
            'entity_note'   => 'Ermöglichen Sie Benutzern das Erstellen von Objektnotizen für dieses Objekt. Ohne diese Berechtigung können sie weiterhin Objekt Notizen sehen, die auf Sichtbarkeit Alle eingestellt sind.',
            'setup'         => 'Verwenden Sie diese Schnittstelle, um zu optimieren, wie Rollen und Benutzer mit diesem Objekt interagieren können. :allow ermöglicht dem Benutzer oder der Rolle, diese Aktion auszuführen. :deny wird ihnen diese Handlung verweigern. :inherit verwendet die Berechtigung des Benutzers oder der Hauptrolle. Ein Benutzer, der auf :allow eingestellt ist, kann die Aktion ausführen, auch wenn seine Rolle auf :deny eingestellt ist.',
        ],
        'inherited'         => 'Für diese Rolle ist die Berechtigung für diesen Objekttyp bereits festgelegt.',
        'inherited_by'      => 'Dieser Benutzer ist Teil der Rolle \':role\', die diese Berechtigungen für diesen Objekttyp erteilt.',
        'success'           => 'Berechtigungen gespeichert.',
        'title'             => 'Berechtigungen',
        'too_many_members'  => 'Diese Kampagne hat zu viele Mitglieder (> 10), um in dieser Benutzeroberfläche angezeigt zu werden. Verwenden Sie die Schaltfläche Berechtigung in der Objektansicht, um die Berechtigungen im Detail zu steuern.',
    ],
    'placeholders'              => [
        'ability'       => 'Wähle eine Fähigkeit',
        'calendar'      => 'Wähle einen Kalender',
        'character'     => 'Wähle einen Character',
        'entity'        => 'Objekt',
        'event'         => 'Wähle ein Ereignis',
        'family'        => 'Wähle eine Familie',
        'gallery_image' => 'Wählen Sie ein Bild aus der Kampagnengalerie',
        'image_url'     => 'Du kannst ein Bild auch von einer URL hochladen',
        'item'          => 'Wähle einen Gegenstand',
        'journal'       => 'Wähle ein Logbuch',
        'location'      => 'Wähle einen Ort',
        'map'           => 'Wähle eine Karte',
        'note'          => 'wähle eine Notiz',
        'organisation'  => 'Wähle eine Organisation',
        'quest'         => 'Wähle eine Quest',
        'race'          => 'Wähle eine Spezies',
        'tag'           => 'Wähle ein Tag',
        'timeline'      => 'Wähle einen Zeitstrahl',
    ],
    'relations'                 => [
        'actions'   => [
            'add'   => 'Füge eine Beziehung hinzu',
        ],
        'fields'    => [
            'location'  => 'Ort',
            'name'      => 'Name',
            'relation'  => 'Beziehung',
        ],
        'hint'      => 'Beziehungen zwischen Objekten können erstellt werden, um deren Verbindung darzustellen.',
    ],
    'remove'                    => 'Löschen',
    'rename'                    => 'Umbenennen',
    'save'                      => 'Speichern',
    'save_and_close'            => 'Speichern und schließen',
    'save_and_copy'             => 'Speichern und kopieren',
    'save_and_new'              => 'Speichern und neu',
    'save_and_update'           => 'Speichern und aktualisieren',
    'save_and_view'             => 'Speichern und ansehen',
    'search'                    => 'Suchen',
    'select'                    => 'Auswählen',
    'superboosted_campaigns'    => 'Superboost Kampagne',
    'tabs'                      => [
        'abilities'     => 'Fähigkeiten',
        'assets'        => 'Anhänge',
        'attributes'    => 'Attribute',
        'boost'         => 'Boost',
        'calendars'     => 'Kalender',
        'connections'   => 'Beziehungen',
        'default'       => 'Standard',
        'events'        => 'Ereignisse',
        'inventory'     => 'Inventar',
        'links'         => 'Links',
        'map-points'    => 'Kartenmarker',
        'mentions'      => 'Erwähnungen',
        'menu'          => 'Menü',
        'notes'         => 'Notizen',
        'permissions'   => 'Berechtigungen',
        'profile'       => 'Profil',
        'quests'        => 'Abenteuer',
        'relations'     => 'Beziehungen',
        'reminders'     => 'Erinnerungen',
        'story'         => 'Geschichte',
        'timelines'     => 'Zeitstrahlen',
        'tooltip'       => 'Kurztip',
    ],
    'update'                    => 'Bearbeiten',
    'users'                     => [
        'unknown'   => 'Unbekannt',
    ],
    'view'                      => 'Ansehen',
    'visibilities'              => [
        'admin'         => 'Admin',
        'admin-self'    => 'Selbst & Admin',
        'all'           => 'Jeder',
        'members'       => 'Mitglieder',
        'self'          => 'Selbst',
    ],
];
