<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Die beste Art Attributvorlagen zu erklären, ist mit einem Beispiel. Stellen wir uns, dass deine Welt eine Menge Orte hat. Für viele dieser Orte möchtest du eigene Attribute wie "Bewohnerzahl", "Klima" und "Kriminalitätsgrad" haben.

Nun kannst du diese Attribute in jedem Ort einzeln hinzufügen, das wird aber schnell mühsam und manchmal vergisst man das Attribut "Kriminalitätsgrad" zu hinterlegen. Hier kommen die Attributvorlagen zum Einsatz.

Du kannst eine Attributvorlage mit deinen Attributen "Bewohnerzahl", "Klima" und "Kriminalitätsgrad" füllen und später diese Vorlage bei deinen Orten benutzen. Das wird die Attribute der Vorlage automatisch in dem Ort hinterlegen und du musst nur noch die Werte der Attribute füllen!
TEXT
,
        'question'  => 'Attributvorlagen, was sind die?',
    ],
    'conversations'         => [
        'answer'    => 'Unterhaltungen können als Gespräche zwischen Charakteren oder zwischen Kampagnenmitgliedern eingerichtet werden. Wenn du zum Beispiel ein wichtiges Gespräch zwischen NSCs und SCs dokumentieren möchtest, kannst du dies mit diesem Modul tun. Sie können auch für Play-by-Post-Kampagnen verwendet werden.',
        'question'  => 'Was sind "Unterhaltungen"?',
    ],
    'entity-notes'          => [
        'answer'    => 'Alle Objekte verfügen über den Reiter "Objekt-Notizen", bei der es sich um kleine Textausschnitte handelt, die nur für Sie sichtbar (vor allem  sinnvoll, wenn mehrere SLs an der Kampagne arbeiten), nur für Mitglieder der Administratorrolle oder für alle sichtbar sind. Du kannst deinen Spielern auch die Erlaubnis erteilen, Objekt-Notizen zu Objekten zu erstellen und zu bearbeiten, ohne dass sie ein ganzes Objekt bearbeiten müssen.',
        'question'  => 'Wie geht Kanka mit Informationen um, die nicht für jeden zugänglich sind?',
    ],
    'fields'                => [
        'answer'    => 'Antwort',
        'category'  => 'Kategorie',
        'locale'    => 'Sprache',
        'order'     => 'Reihenfolge',
        'question'  => 'Frage',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Ja! Wir glauben, dass unsere finanzielle Situation keinen Einfluss auf euer Vergnügen beim Rollenspiel oder beim Welten bauen haben sollte, weswegen wir die App immer kostenfrei halten werden. Dank unserer großzügigen Patrone auf :patreon, ist es uns möglich die monatlichen Serverkosten zu bezahlen und die Plattform werbefrei zu halten!

Uns auf Patreon zu unterstützen ermöglicht es euch allerdings das Upload Limit von Dateien zu erhöhen, euer Name kommt auf die Patreon Wall of Fame, ihr bekommt schönere Standard Icons, könnt abstimmen was bei der Weiterentwicklung prioritisiert werden soll und mehr!
TEXT
,
        'question'  => 'Wird die App kostenfrei bleiben?',
    ],
    'help'                  => [
        'answer'    => 'Als Erstes: Danke, dass du helfen möchtest! Wir sind immer an Leuten interessiert, die uns bei Übersetzungen unterstützen, neue Funktionen testen oder die neuen Usern helfen können. Wir lieben es auch wenn Leute Kanka weiterempfehlen, um neue User an Orten zu erreichen an die wir nicht gedacht haben. Am besten ist es, wenn du auf :discord zu uns stößt, wo es einen Kanal für\'s Aushelfen gibt. Wir lieben auch unsere Patrone auf Patreon, wenn du uns unterstützen möchtest und ein paar Extras bekommen möchtest!',
        'question'  => 'Ich möchte helfen! Was kann ich tun?',
    ],
    'map'                   => [
        'answer'    => <<<'TEXT'
Jeder Ort kann eine Karte (PNG, JPG oder SVG) enthalten, die selbst "Kartenpunkte" enthält, die mit Kontrolle über Größe, Form, Symbol und Farbe sowie als Links zu Elementen oder einfachen Beschriftungen platziert werden können.

SVG-Dateien von Azgaars :azgaar und watabous :watabou sind kompatibel mit Kanka. Einige andere Programme komprimieren die generierten SVG-Dateien, was sie inkompatibel zu Kanka macht. Um diese Karten trotzdem mit Kanka benutzen zu können, öffne die Dateien in Inkscape oder Photoshop speicher sie als SVG-Dateien, bevor du sie auf Kanka hochlädtst.
TEXT
,
        'question'  => 'Kann ich Karten in Kanka hochladen?',
    ],
    'mobile'                => [
        'answer'    => 'Derzeit gibt es keine extra Kanka-App für mobile Geräte, aber der Großteil der App funktioniert mobil. Eine Einschränkung ist die Linkhilfe (@), das nicht im Texteditor funktioniert. Wenn genug Unterstützung über Patreon kommt, hoffe ich, dass ich eines Tages jemanden bezahlen kann, der eine mobile App erstellt.',
        'question'  => 'Gibt es eine mobile App? Ist etwas in der Richtung geplant?',
    ],
    'multiworld'            => [
        'answer'    => 'Nein, brauchst du nicht! Du kannst so viele "Kampagnen" in der App haben, wie du möchtest. Jede Kampagne kann für eine Welt, ein Setting oder was immer du willst genutzt werden. Sobald du mehrere Kampagnen hast, kannst du einfach zwischen ihnen wechseln.',
        'question'  => 'Ich baue mehrere Welten in verschiedenen Settings auf. benötige ich für jede Welt einen anderes Konto?',
    ],
    'permissions'           => [
        'answer'    => 'Ja absolut, deswegen haben wir Kanka gemacht! Du kannst all deine Spieler zu deiner Kampagne einladen und ihnen Rollen und Berechtigungen erteilen.  Wir haben das System für  große Flexibiliät gebaut (sowohl opt-in als auch opt-out Konfigurationen möglich), um so viele Ansprüche und Situationen wie möglich abzudecken.',
        'question'  => 'Ich möchte Kanka nutzen, um meine RPG Welt aufzubauen. Meinen Spielern möchte ich ermöglichen manche Objekte und ihre Charakter zu bearbeiten. Geht das?',
    ],
    'show'                  => [
        'return'    => 'Zurück zum FAQ',
        'timestamp' => 'Letzte Aktualisierung am :date',
        'title'     => 'FAQ :name',
    ],
    'visibility'            => [
        'answer'    => 'Nur die Leute, die du zu deiner Kampagne eingeladen hast, können deine Welt sehen und bearbeiten. Deine Daten sind privat und immer unter deiner Kontrolle.',
        'question'  => 'Kann jeder meine Welt sehen?',
    ],
];
