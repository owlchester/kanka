<?php

return [
    'age'               => [
        'description'   => 'Sie können einen Charakter mit einem Kalender der Kampagne verknüpfen, indem Sie einen Charakter anzeigen und zur Registerkarte Erinnerungen wechseln. Fügen Sie von dort aus eine neue Erinnerung hinzu und setzen Sie den Typ auf Geburt oder Tod, um das Alter des Charakters automatisch zu berechnen. Wenn sowohl Geburt als auch Tod vorliegen, werden beide Daten und das Todesalter angezeigt. Wenn nur die Geburt eingestellt ist, werden das Datum und das aktuelle Alter angezeigt. Wenn nur der Tod festgelegt ist, werden das Datum und die Jahre seit dem Tod angezeigt.',
        'title'         => 'Charakteralter und Tod',
    ],
    'api-filters'       => [
        'description'   => 'Die folgenden Filter sind für den API-Endpunkt :name verfügbar.',
        'title'         => 'API Filters',
    ],
    'attributes'        => [
        'con'               => 'Kon',
        'description'       => 'Verwenden Sie Attribute, um Werte darzustellen, die an ein Objekt angehängt sind, die keine Texte sind. Sie können Objekte in Attributen mithilfe der erweiterten Erwähnungssyntax referenzieren :mention. Sie können auch auf andere Attribute verweisen, indem Sie die :attribute syntax verwenden.',
        'level'             => 'Stufe',
        'link'              => 'Attributoptionen',
        'math'              => 'Sie können auch mit einigen grundlegenden mathematischen Optionen kreativ werden. Beispiel :example multipliziert die Attribute :level und :con dieses Objektes. Wenn Sie auf- oder abrunden möchten, können Sie Folgendes verwenden :floor oder :ceil',
        'name'              => 'Sie können auf den Namen des Objektes verweisen mit :name. Wenn ein Attribut mit diesem Namen vorhanden ist, wird stattdessen das Attribut verwendet.',
        'pinned'            => 'Wenn Sie ein Attribut mit dem :icon Symbol fixieren, wird es im Menü des Objekts unter dem Bild angezeigt.',
        'private'           => 'Private Attribute, die das :icon verwenden, sind nur für Kampagnenadministratoren sichtbar.',
        'random'            => 'Beim Erstellen oder Bearbeiten einer Attributvorlage können Sie zufällige Attribute festlegen. Dies kann entweder ein Zufallswert zwischen zwei durch :dash getrennten Zahlen oder ein Zufallswert aus einer durch :comma getrennten Werteliste sein. Der Wert für das Attribut wird bestimmt, wenn die Vorlage auf ein Objekt angewendet wird oder wenn ein Objekt gespeichert wird.',
        'random_examples'   => 'Wenn Sie beispielsweise eine Zahl zwischen 1 und 100 möchten, verwenden Sie :number. Wenn Sie einen Wert aus einer Liste von Optionen wünschen, verwenden Sie :list.',
        'title'             => 'Attribute',
    ],
    'dice'              => [
        'description'               => 'Allgemeine Würfelwürfe sind möglich, wenn du "d20", "4d4+4", "d%" (Prozentwürfe) oder "df" (FUDGE-würfe) schreibst.',
        'description_attributes'    => 'Es ist auch möglich ein Charakterattribut zu verwenden mittels {character.attribute_name} Syntac. Zum Beispiel, {character.level}d6+{character.wisdom}.',
        'more'                      => 'Mehr Optionen sind verfügbar und werden auf der Würfelwurf-Plugin Seite erklärt.',
        'title'                     => 'Würfelwürfe',
    ],
    'entity_templates'  => [
        'description'   => 'Wenn Sie ein neues Objekt erstellen, können Sie es basierend auf einer Vorlage erstellen, anstatt von einem leeren Formular aus zu beginnen. Um ein Objekt als Vorlage festzulegen, klicken Sie auf :link in der Schaltfläche Aktionen :action oben rechts. Beim Anzeigen einer Liste von Objekten stehen Vorlagen dieses Objekttyps neben der Schaltfläche :new  zur Verfügung. Sie können für jeden Objekttyp mehrere Vorlagen haben.',
        'link'          => 'So legen Sie Vorlagen fest',
        'remove'        => 'Um ein Objekt als Vorlage zu entfernen, klicken Sie auf die Aktion :remove, die die oben beschriebene Aktion :link ersetzt.',
        'title'         => 'Objekttemplates',
    ],
    'filters'           => [
        'attributes'    => [
            'exclude'   => '!Level',
            'first'     => 'Sie können Objekte basierend auf ihren Attributen filtern. Die Suchfelder sind exakte Übereinstimmungen sowohl für den Namen als auch für den Wert. Wenn das Wertfeld leer gelassen wird, sucht es nach Objekten, die ein Attribut mit genau diesem Namen haben. Sie können :exclude eingeben, um Objekte mit einem Attribut namens Level auszuschließen.',
            'second'    => 'Der Filter wertet keine Attributberechnungen aus. Wenn ein Attribut den Wert :code hat, ist die Suche nach dem Ergebnis dieser Berechnung nicht möglich.',
        ],
        'clipboard'     => 'Wenn Filter aktiv sind, wird die Schaltfläche in die Zwischenablage kopieren aktiv. Dadurch werden die Filter in Ihre Zwischenablage kopiert und Sie können sie für Dashboard-Widget-Filter oder für Quicklink-Filter verwenden.',
        'description'   => 'Sie können Filter verwenden, um die Anzahl der in Listen angezeigten Ergebnisse zu begrenzen. Textfelder unterstützen verschiedene Optionen, um detaillierter zu steuern, was herausgefiltert wird.',
        'empty'         => 'Schreibt man :tag in ein Feld wird in allen Objekten, bei denen dieses Feld leer ist gesucht.',
        'ending_with'   => 'Durch Platzieren eines :tag am Ende Ihres Textes können Sie nach jedem Objekt mit genau diesem Text im Feld suchen.',
        'multiple'      => 'Sie können Suchoptionen für Textfelder kombinieren, indem Sie Folgendes schreiben: :syntax. Zum Beispiel :example.',
        'session'       => 'Filter und geordnete Spalten, die für eine Objektliste festgelegt wurden, werden in Ihrer Sitzung gespeichert. Solange Sie verbunden bleiben, müssen Sie sie nicht auf jeder Seite neu festlegen.',
        'starting_with' => 'Durch Platzieren eines :tag vor Ihrem Text können Sie nach Objekten suchen, die den Text in diesem Feld nicht enthalten.',
        'title'         => 'Verwendung von Filtern',
    ],
    'link'              => [
        'advanced'          => [
            'title' => 'Erweiterte Erwähnungen',
        ],
        'anchor'            => 'Die erweiterte Erwähnung kann auch den HTML-Anker angeben, auf den der Link zeigen soll, indem :example verwendet wird.',
        'attribute'         => [
            'description'   => 'Auch das Referenzieren von Attributen dieses Objekts ist möglich. Geben Sie einfach :code und drei oder mehr Buchstaben ein, um übereinstimmende Attribute für dieses Objekt anzuzeigen.',
            'title'         => 'Attribute',
        ],
        'auto_update'       => 'Links zu ändern Objekten werden automatisch aktualisiert, wenn der Name des Ziels oder die Beschreibung sich geändert hat.',
        'description'       => 'Mit einem "@" kannst du ganz einfach Links zu anderen Einträgen setzen. Ein "#" zeigt dir stattdessen eine Namensliste mit Monaten aus deinen Kalendern an.',
        'filtering'         => [
            'description'   => 'Das Filtern nach genau dem Objekt, nach derm Sie suchen, ist einfach.',
            'exact'         => 'Geben Sie :code ein, um ein Objekt zu finden, das genau diesen Namen hat.',
            'space'         => 'Geben Sie :code ein, um ein Objekt mit einem Leerzeichen im Namen zu finden.',
            'title'         => 'Filtern',
        ],
        'formatting'        => [
            'text'  => 'Die Liste der zulässigen HTML-Tags und -Attribute finden Sie auf unserem :github.',
            'title' => 'Formatierung',
        ],
        'friendly_mentions' => 'Verknüpfen Sie andere Objekte, indem Sie Folgendes eingeben :code und die ersten Zeichen eines Objekts, um danach zu suchen. Dadurch wird :example in den Texteditor eingefügt und beim Anzeigen dieses Objekts als Link zum Objekt verlinkt.',
        'mention_helpers'   => 'Wenn Ihr Objektname ein Leerzeichen enthält, verwenden Sie :example anstelle von Leerzeichen. Wenn Sie nach einem Objekt mit genau diesem Namen suchen möchten, geben Sie Folgendes ein :exact.',
        'mentions'          => 'Verknüpfen Sie andere Objekte, indem Sie Folgendes eingeben :code und die ersten Zeichen eines Objekts, um danach zu suchen. Dies wird eingefügt :example im Texteditor. Um den Namen des angezeigten Objekts anzupassen, können Sie Folgendes eingeben: :example_name. Verwenden Sie zum Festlegen der Unterseite des Objekts :example_page. Verwenden Sie zum Festlegen der Registerkarte des Objekts :example_tab.',
        'mentions_field'    => 'Sie können auch ein Feld aus dem Objekt anstelle seines Namens im Link mit :code anzeigen.',
        'month'             => [
            'title' => 'Kalendermonate',
        ],
        'months'            => 'Geben Sie :code ein, um eine Liste der Monate aus Ihrem Kalendern abzurufen.',
        'options'           => 'Ein paar Optionen sind :options',
        'overview'          => 'Verknüpfen Sie einfach mit bestehenden Objekten der Kampagne, indem Sie :code und drei oder mehr Buchstaben eingeben.',
        'title'             => 'Andere Objekte verlinken',
    ],
    'map'               => [
        'description'   => 'Wenn Sie eine Karte an einen Ort hochladen, wird das Menü "Karte" auf der Ansichtsseite des Standorts und ein direkter Link zur Karte von der Standortseite der Kampagne aktiviert. In der Kartenansicht können Benutzer, die den Standort bearbeiten können, den Bearbeitungsmodus aktivieren, mit dem sie Kartenpunkte auf der Karte platzieren können. Diese können mit einem vorhandenen Objekt verknüpft sein oder ein Etikett sein und verschiedene Formen und Größen haben.',
        'private'       => 'Mitglieder in der Administratorrolle der Kampagne können eine Karte privat machen. Auf diese Weise können Benutzer einen Standort anzeigen, Administratoren können die Karte jedoch geheim halten.',
        'title'         => 'Standortkarten',
    ],
    'pins'              => [
        'description'   => 'Objekte können rechts neben ihrer Story-Ansicht Beziehungen und Attribute haben. Um ein Element anzuheften, bearbeiten Sie die Beziehung oder die Attribute und legen Sie den angehefteten Wert für diese fest.',
        'title'         => 'Objekt Pins',
    ],
    'public'            => 'Sie die Tutorial Videos über öffentliche Kampagnen auf Youtube an.',
    'title'             => 'Hilfe',
    'troubleshooting'   => [
        'description'       => 'Ein Mitglied von Kankas Team hat Sie auf diese Seite geschickt. Wählen Sie eine Kampagne aus der Dropdown-Liste aus, um ein Token zu generieren, damit wir Ihrer Kampagne vorübergehend als Administrator beitreten können.',
        'errors'            => [
            'token_exists'  => 'Es besteht bereits ein Token für :campaign.',
        ],
        'save_btn'          => 'Token erstellen',
        'select_campaign'   => 'Kampagne auswählen',
        'subtitle'          => 'Bitte senden Sie Hilfe!',
        'success'           => 'Bitte kopieren Sie den folgenden Token und senden Sie ihn an jemanden aus Kankas Team.',
        'title'             => 'Troubleshooting',
    ],
    'widget-filters'    => [
        'description'   => 'Sie können Objekte filtern, die im kürzlich geänderten Widget angezeigt werden, indem Sie eine Liste der Felder der Objekte und der Werte bereitstellen. Zum Beispiel können Sie :example verwenden, um nach toten Charakteren des NPC-Typs zu filtern.',
        'link'          => 'Widget Filter',
        'more'          => 'Sie können Werte von der URL in Objektlisten kopieren. Wenn Sie beispielsweise die Zeichen der Kampagne anzeigen, filtern Sie nach der Art der Zeichen, die Sie anzeigen möchten, und kopieren Sie die Werte nach der :question in die URL.',
        'title'         => 'Dashboard Widget Filter',
    ],
];
