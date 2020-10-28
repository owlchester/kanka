<?php

return [
    'app_backup'            => [
        'answer'    => 'Wir führen täglich zwei Sicherungen durch, um Datenverlust zu vermeiden. Unsere eigenen Kampagnen befinden sich ebenfalls auf dem Server, daher möchten wir kein Risiko eingehen!',
        'question'  => 'Wie oft werden die Daten von Kanka gesichert?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Die beste Art Attributvorlagen zu erklären, ist mit einem Beispiel. Stellen wir uns vor, dass deine Welt eine Menge Orte hat. Für viele dieser Orte möchtest du eigene Attribute wie "Bewohnerzahl", "Klima" und "Kriminalitätsrate" haben.

Nun kannst du diese Attribute in jedem Ort einzeln hinzufügen, das wird aber schnell mühsam und manchmal vergisst man das Attribut "Kriminalitätsrate" zu hinterlegen. Hier kommen die Attributvorlagen zum Einsatz.

Du kannst eine Attributvorlage mit deinen Attributen "Bewohnerzahl", "Klima" und "Kriminalitätsrate" füllen und später diese Vorlage bei deinen Orten benutzen. Die Attributvorlage wird automatisch in jedem Ort hinterlegt und du musst nur noch die Werte der Attribute füllen!
TEXT
,
        'question'  => 'Was sind Attributvorlagen?',
    ],
    'backup'                => [
        'answer'    => 'Einmal am Tag können Sie alle Daten Ihrer Kampagne als ZIP-Datei exportieren. Klicken Sie in der App im linken Menü auf "Kampagne" und dann auf "Exportieren". Dadurch wird ein Export erstellt, der 30 Minuten lang verfügbar ist. Sie können diesen Export nicht auf Kanka hochladen. Er dient nur Ihrer eigenen Sicherheit oder wenn Sie die Anwendung nicht mehr verwenden möchten.',
        'question'  => 'Wie kann ich meine Kampagne sichern oder exportieren?',
    ],
    'bugs'                  => [
        'answer'    => 'Treten Sie einfach unserem :discord server bei und melden Sie Ihren Fehler im Kanal #error-and-bugs.',
        'question'  => 'Wie kann ich einen Fehler melden?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka hat diese Funktion nicht. Wenn Sie jedoch versuchen, mehrere Spielgruppen in derselben Welt zu haben, sollten Sie dieselbe Kampagne verwenden und Ihre Gruppen durch eine Kombination aus Quests, Tags und Berechtigungen trennen',
        'question'  => 'Kann ich Objekte über mehrere Kampagnen hinweg synchronisieren?',
    ],
    'conversations'         => [
        'answer'    => 'Unterhaltungen können als Gespräche zwischen Charakteren oder zwischen Kampagnenmitgliedern eingerichtet werden. Wenn du zum Beispiel ein wichtiges Gespräch zwischen NSCs und SCs dokumentieren möchtest, kannst du dies mit diesem Modul tun. Sie können auch für Play-by-Post-Kampagnen verwendet werden.',
        'question'  => 'Was sind "Unterhaltungen"?',
    ],
    'custom'                => [
        'answer'    => 'Kanka wird mit einer Reihe vordefinierter Objekttypen erstellt, die miteinander interagieren. Um benutzerdefinierte Objekttypen zuzulassen, müsste die Anwendung vollständig geändert und das Ziel der Vereinfachung der Organisation verfehlt werden. Darüber hinaus ist Kanka flexibel mit Tags, die die meisten benutzerdefinierten Objekte darstellen können.',
        'question'  => 'Kann ich benutzerdefinierte Objekttypen erstellen?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Gehen Sie zu Ihrem Kampagnen-Dashboard und klicken Sie im linken Menü auf "Kampagne". Eine Schaltfläche "Löschen" wird angezeigt, wenn Sie das letzte Mitglied der Kampagne sind. Das Löschen einer Kampagne ist eine endgültige Aktion, mit der alle auf unseren Servern gespeicherten Daten, einschließlich Bilder, gelöscht werden.',
        'question'  => 'Wie kann ich eine Kampagne löschen?',
    ],
    'early-access'          => [
        'answer'    => 'Mit Early Access können wir unsere großartigen Abonnenten belohnen, indem wir ihnen einen exklusiven Zeitraum von 30 Tagen gewähren, in dem sie die neuesten Module vor allen anderen ausprobieren können.',
        'question'  => 'Was ist ein Early Access?',
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
    'gods-and-religions'    => [
        'answer'    => 'Wir empfehlen, Götter als Charaktere und Religionen als Organisationen zu schaffen. Wenn Sie Ihre Gottheiten schnell finden möchten, empfehlen wir, sie mit einem geeigneten Tag und / oder Typ zu versehen.',
        'question'  => 'Wo kann man Götter und Religionen erstellen?',
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
    'monsters'              => [
        'answer'    => 'Wir empfehlen die Verwendung des Rassen-Moduls für Völker, Spezien, Monster und alles Lebende, das kein Charakter ist.',
        'question'  => 'Wo kann man Monster erstellen?',
    ],
    'multiworld'            => [
        'answer'    => 'Nein, brauchst du nicht! Du kannst so viele "Kampagnen" in der App haben, wie du möchtest. Jede Kampagne kann für eine Welt, ein Setting oder was immer du willst genutzt werden. Sobald du mehrere Kampagnen hast, kannst du einfach zwischen ihnen wechseln.',
        'question'  => 'Ich baue mehrere Welten in verschiedenen Settings auf. benötige ich für jede Welt einen anderes Konto?',
    ],
    'nested'                => [
        'answer'    => 'Wenn Sie Ihre Objekte standardmäßig in einer verschachtelten Ansicht anzeigen möchten (z. B. die Schaltfläche Verschachtelte Ansicht in der Liste der Speicherorte), können Sie dies tun, indem Sie in die Optionen Profil und Layout wechseln. Dort können Sie die Option Verschachtelte Ansicht aktivieren. Dies gilt nur für Ihr Konto und nicht für Ihre Kampagnen.',
        'question'  => 'Kann ich festlegen, dass die Listen standardmäßig verschachtelt sind?',
    ],
    'organise_play'         => [
        'answer'    => 'Wir haben eine Partnerschaft mit :lfgm geschlossen, mit der Sie Ihre Sitzungen mit Ihrer Gruppe organisieren können. Sie können Ihre Kanka-Kampagne mit Ihrer LGFM-Kampagne synchronisieren, um Ihre nächsten Verfügbarkeiten direkt im Kampagnen-Dashboard anzuzeigen.',
        'question'  => 'Wie kann ich verwalten, wann ich meine Sitzungen ausführe?',
    ],
    'permissions'           => [
        'answer'    => 'Ja absolut, deswegen haben wir Kanka gemacht! Du kannst all deine Spieler zu deiner Kampagne einladen und ihnen Rollen und Berechtigungen erteilen.  Wir haben das System für  große Flexibiliät gebaut (sowohl opt-in als auch opt-out Konfigurationen möglich), um so viele Ansprüche und Situationen wie möglich abzudecken.',
        'question'  => 'Ich möchte Kanka nutzen, um meine RPG Welt aufzubauen. Meinen Spielern möchte ich ermöglichen manche Objekte und ihre Charakter zu bearbeiten. Geht das?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Langfristig ist geplant, dass Kanka sich in ein vielseitiges Tool für Worldbuilding und Kampagnenmanagement entwickelt, das systemunabhängig ist und systemspezifische Inhalte enthält, die von der Community in Form von "Community-Vorlagen" verwaltet werden. Ein längeres Ziel ist es, Tools zu entwickeln, die sich in andere Plattformen wie Virtual Table Top-Apps integrieren lassen, um diese mit den Welten von Kanka zu verbinden.

Was den zweiten Teil betrifft, so enden die meisten Hobbyprojekte im Burnout und der Schöpfer gibt sie auf. The :patreon wurde mit dem Ziel eingerichtet, dass wir Vollzeit an Kanka arbeiten können, ohne die finanzielle Sicherheit unserer Familien zu beeinträchtigen und die Serverkosten zu decken. Das Projekt ist auch Open Source und kann von der Community aufgegriffen werden, falls uns jemals etwas passieren sollte.
TEXT
,
        'question'  => 'Was sind die langfristigen Pläne?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Auf der Seite :public-campaigns können Sie sehen, wie andere Kanka für ihre Kampagnen verwenden.',
        'question'  => 'Wie benutzen andere Kanka?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Während dies für Englisch und andere Sprachen, die keine geschlechtsspezifischen Namen verwenden, einfach wäre, würde die Möglichkeit, den Namen von Modulen zu ändern, die grammatikalische Korrektheit und Benutzererfahrung für die meisten Sprachen beeinträchtigen, in denen Kanka auch verfügbar ist.',
        'question'  => 'Kann ich Module umbenennen? Zum Beispiel Familien in Clans oder Organisationen in Fraktionen?',
    ],
    'sections'              => [
        'community'     => 'Community',
        'general'       => 'Allgemeines',
        'other'         => 'Andere',
        'permissions'   => 'Berechtigungen',
        'pricing'       => 'Preisgestaltung',
        'worldbuilding' => 'Worldbuilding',
    ],
    'show'                  => [
        'return'    => 'Zurück zum FAQ',
        'timestamp' => 'Letzte Aktualisierung am :date',
        'title'     => 'FAQ :name',
    ],
    'user-switch'           => [
        'answer'    => 'Berechtigungen können schwierig werden, insbesondere bei großen Kampagnen. Als Kampagnenadministrator können Sie zur Mitgliederseite der Kampagne navigieren und auf die Schaltfläche "Wechseln" klicken, die neben Nicht-Administratormitgliedern der Kampagne angezeigt wird. Wenn Sie dies tun, melden Sie sich als dieser Benutzer an und können die Kampagne so sehen, wie sie es tun würde. Dies ist der einfachste Weg, um die Berechtigungen Ihrer Kampagne zu überprüfen.',
        'question'  => 'Meine Kampagnenberechtigungen sind festgelegt. Wie kann ich sie testen?',
    ],
    'visibility'            => [
        'answer'    => 'Nur die Leute, die du zu deiner Kampagne eingeladen hast, können deine Welt sehen und bearbeiten. Deine Daten sind privat und immer unter deiner Kontrolle.',
        'question'  => 'Kann jeder meine Welt sehen?',
    ],
];
