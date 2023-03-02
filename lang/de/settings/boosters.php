<?php

return [
    'actions'   => [
        'boost_name'    => 'Boost :name',
    ],
    'available' => 'Verfügbare Booster :amount/:total',
    'benefits'  => [
        'boosted'       => 'Durch das Boosten einer Kampagne mit :one Booster werden der Zugriff auf den :marketplace, Themenoptionen, größere Uploads für alle Mitglieder, die Wiederherstellung gelöschter Objekte und :more freigeschaltet.',
        'more'          => 'weitere erstaunliche Funktionen',
        'superboosted'  => 'Durch das Superboosten einer Kampagne mit :amount-Boostern werden alle Vorteile einer Booster-Kampagne freigeschaltet, sowie eine Kampagnengalerie, vollständige Protokolländerungen an Objekten und :more.',
    ],
    'boost'     => [
        'actions'   => [
            'confirm'   => 'Booste es!',
            'remove'    => 'Stoppe boosten von :campaign',
            'subscribe' => 'Kanka abonnieren',
            'upgrade'   => 'Aktualisieren Sie Ihr Abonnement',
        ],
        'confirm'   => 'Wie aufregend! Du bist dabei, :campaign zu verstärken. Dadurch wird einer (:Kosten) deiner verfügbaren Kampagnen-Booster zugewiesen.',
        'duration'  => 'Zugewiesene Booster bleiben zugewiesen, bis du sie manuell entfernst oder dein Abonnement endet.',
        'errors'    => [
            'boosted'           => 'Oh oh, sieht so aus, als ob die Kampagne bereits geboosted wurde!',
            'out-of-boosters'   => 'Ach nein! Du hast nicht genügend Booster zur Verfügung. Du hast :available und benötigen :cost. Beende entweder das Boosten anderer Kampagnen oder führe ein Upgrade durch.',
        ],
        'pitch'     => 'Werde Abonnent, um Kampagnen-Booster freizuschalten.',
        'success'   => 'Die :campaign Kampagne wird jetzt geboostet. Genieße all die neuen fantastischen Funktionen!',
        'title'     => 'Boost :campaign',
        'upgrade'   => 'Aktualisieren Sie Ihr Abonnement',
    ],
    'campaign'  => [
        'boosted'       => 'Geboostet von :user seid :time',
        'superboosted'  => 'Supergeboostet von :user seid :time',
        'unboosted'     => 'boosten beenden',
    ],
    'intro'     => [
        'anyone'    => 'Du bist nicht darauf beschränkt, nur von dir erstellte Kampagnen zu fördern. Du kannst jede Kampagne fördern, an der du teilnimmst oder die du sehen kannst. Dazu gehören Kampagnen, bei denen du ein Spieler bist, oder :public, die dir Spaß machen.',
        'data'      => 'Wenn eine Kampagne nicht mehr geboostet wird, wird der Zugriff auf geboosterte Funktionen entfernt. Es werden jedoch keine Inhalte gelöscht, sodass der Zugriff auf die Kampagne in der Zukunft wiederhergestellt wird.',
        'first'     => 'Erweiterte Funktionen werden freigeschaltet, indem du deine Booster einer Kampagne Boosten oder Superboosten zuweist. Die Anzahl der Booster, die du hast, wird durch dein :Abonnement bestimmt. Diese Nummer steht dir als Abonnent jederzeit zur Verfügung. Das Boosten einer Kampagne weist du einen deiner Booster zu, während das Superboosten einer Kampagne drei davon zuweist.',
    ],
    'pitch'     => [
        'benefits'      => [
            'backup'        => 'Stelle eine zuvor gelöschtest Objekt für bis zu :amount Tage wieder her',
            'customisable'  => 'Vollständige Anpassung des Aussehens einer Kampagne',
            'entities'      => 'Bessere Kontrolle darüber, wie sich Objekte verhalten und erscheinen',
            'icons'         => 'Zugriff auf Tausende schöner Symbole für Karten und Zeileisten',
            'relations'     => 'Untersuche die Beziehungen eines Objekts visuell in einem visuellen Explorer',
            'title'         => 'Geboostete Kampagnen erhalten',
            'upload'        => 'Größere Upload-Größe für alle Kampagnenmitglieder',
        ],
        'description'   => 'Weise Kampagnen Booster zu und helfe dabei, erstaunliche Funktionen für alle Beteiligten freizuschalten. Nicht beeindruckt von geboosteten Kampagnen? Wir haben Sie mit supergeboosteten Kampagnen abgedeckt!',
        'more'          => 'Sehe dir die vollständige Liste der Vergünstigungen auf unserer :Booster-Seite an.',
        'title'         => 'Bringe eine Kampagne mit Anpassungen und Vorteilen für alle Mitglieder auf die nächste Stufe',
    ],
    'ready'     => [
        'available'         => 'Deine verfügbaren Kampagnen-Booster.',
        'pricing'           => 'Alle deine Abonnementstufen beinhalten mindestens einen Kampagnen-Booster und einen Startbetrag pro Monat.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Booste Kampagne',
    ],
    'superboost'=> [
        'actions'   => [
            'confirm'   => 'Superbooste es!',
            'remove'    => 'Stoppe superboosten :campaign',
        ],
        'confirm'   => 'Wie aufregend! Du bist dabei, :campaign zu superboosten. Dadurch werden drei (:Kosten) deiner verfügbaren Kampagnen-Booster zugewiesen.',
        'errors'    => [
            'boosted'   => 'Oh oh, sieht so aus, als ob :campaign bereits superboosted ist!',
        ],
        'success'   => 'Die :campaign Kampagne ist jetzt supergeboostet. Genieße all die neuen fantastischen Funktionen!',
        'title'     => 'Superboost :campaign',
        'upgrade'   => 'Bereit für das ultimative Kanka-Erlebnis? Superboosting :campaign weist :cost zusätzliche Kampagnen-Booster zu.',
    ],
    'title'     => 'Kampagnen-Booster',
    'unboost'   => [
        'confirm'   => 'Ja, ich bin sicher',
        'status'    => [
            'boosting'      => 'boosting',
            'superboosting' => 'superboosting',
        ],
        'success'   => 'Die :campaign Kampagne wird nicht länger geboostet, und ihre Booster sind wieder verfügbar',
        'title'     => 'boosten der Kampagne beenden',
        'warning'   => 'Möchtest du :action :campaign wirklich beenden? Dadurch werden deine zugewiesenen Booster freigegeben und alle Inhalte und Funktionen im Zusammenhang mit den Vorteilen ausgeblendet, bis die Kampagne erneut geboostet wird.',
    ],
];
