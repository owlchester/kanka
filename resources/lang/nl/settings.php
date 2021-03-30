<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Schakel over naar Kanka Login',
            'update_email'      => 'Werk e-mail bij',
            'update_password'   => 'Vernieuw wachtwoord',
        ],
        'email'             => 'E-mailadres wijzigen',
        'email_success'     => 'E-mail bijgwerkt.',
        'password'          => 'Wijzig wachtwoord',
        'password_success'  => 'Wachtwoord bijgewerkt.',
        'social'            => [
            'error'     => 'Je gebruikt de Kanka-login al voor dit account.',
            'helper'    => 'Je account wordt momenteel beheerd door :provider. Je kunt stoppen met het gebruik en overschakelen naar de standaard Kanka-login door een wachtwoord in te stellen.',
            'success'   => 'Je account gebruikt nu de Kanka-login.',
            'title'     => 'Sociaal voor Kanka',
        ],
        'title'             => 'Account',
    ],
    'api'           => [
        'helper'    => 'Welkom bij de Kanka API\'s. Genereer een Persoonlijke Toegangstoken om in je API verzoek te gebruiken om informatie te verzamelen over de campaigns waarvan jij deel uitmaakt.',
        'link'      => 'Lees de API documentatie',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Verbind',
            'remove'    => 'Verwijder',
        ],
        'benefits'  => 'Kanka biedt enkele integratie met services van derden. Voor de toekomst zijn er meer integraties van derden gepland.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Er is een fout opgetreden bij het koppelen van je Discord-account aan Kanka. Probeer het a.u.b. opnieuw.',
            ],
            'success'   => [
                'add'       => 'Je Discord account is gekoppeld.',
                'remove'    => 'Je Discord account is ontkoppeld.',
            ],
            'text'      => 'Krijg automatisch toegang tot je abonnement rollen.',
        ],
        'title'     => 'App Integratie',
    ],
    'boost'         => [
        'benefits'      => [
            'campaign_gallery'  => 'Een campaign galerij om afbeeldingen te uploaden die je via de campaign kunt hergebruiken.',
            'entity_files'      => 'Upload tot wel 10 bestanden per entiteit.',
            'entity_logs'       => 'Volledige entiteit logboeken van wat er bij elke update op een entiteit is gewijzigd.',
            'first'             => 'Om voortdurende vooruitgang op Kanka te garanderen, worden sommige campaignfuncties ontgrendeld door een campaign te boosten. Boosts worden ontgrendeld via abonnementen. Iedereen die een campaign kan bekijken, kan deze een boost geven, zodat de DM niet altijd de rekening hoeft te betalen. Een campaign blijft een boost krijgen zolang een gebruiker de campaign een boost geeft en ze Kanka blijven steunen. Als een campaign niet langer een boost krijgt, gaan er geen gegevens verloren, deze worden alleen verborgen totdat de campaign weer een boost krijgt.',
            'header'            => 'Entiteit header afbeeldingen.',
            'headers'           => [
                'boosted'       => 'Boosted campaign voordelen',
                'superboosted'  => 'Superboosted campaign voordelen',
            ],
            'helpers'           => [
                'boosted'       => 'Het boosten van een campaign wijst een enkele booster toe aan de campaign.',
                'superboosted'  => 'Als je een campagne superboost, worden in totaal drie boosters aan de campaign toegewezen.',
            ],
            'images'            => 'Aangepaste standaard entiteit afbeeldingen.',
            'more'              => [
                'boosted'       => 'Alle boosted campaign functies',
                'superboosted'  => 'Alle superboosted campaign functies',
            ],
            'recovery'          => 'Herstel verwijderde entiteiten voor maximaal :amount dagen.',
            'second'            => 'Het boosten van een campaign levert de volgende voordelen op:',
            'superboost'        => 'Het superboosten van een campaign gebruikt 3 van je boosts en ontgrendelt extra functies bovenop die voor boosted campaigns.',
            'theme'             => 'Campaign level thema en custom stijl.',
            'third'             => 'Om een campaign een boost te geven, ga je naar de campaign pagina en klik je op de knop :boost_button boven de knop :edit_button.',
            'tooltip'           => 'Custom tooltips voor entiteiten.',
            'upload'            => 'Verhoogde uploadgrootte voor elk lid van de campaign.',
        ],
        'buttons'       => [
            'boost'         => 'Boost',
            'superboost'    => 'Superboost',
            'tooltips'      => [
                'boost'         => 'Het boosten van een campaign verbruikt :amount van je boosts',
                'superboost'    => 'Het superboosten van een campaign verbruikt :amount van je boosts',
            ],
        ],
        'campaigns'     => 'Boosted Campaigns :count / :max',
        'exceptions'    => [
            'already_boosted'       => 'Campaign :name is al boosted',
            'exhausted_boosts'      => 'Je hebt geen boosts meer om te geven. Haal je boost uit een campaign voordat je deze aan een andere geeft.',
            'exhausted_superboosts' => 'Je hebt geen boosts meer. Je hebt 3 boosters nodig om een campaign een superboost te geven.',
        ],
        'success'       => [
            'boost'         => 'Campaign :name boosted.',
            'delete'        => 'Je boost verwijderd van :name.',
            'superboost'    => 'Campaign :name superboosted',
        ],
        'title'         => 'Boost',
        'unboost'       => [
            'description'   => 'Weet je zeker dat je de campaign :tag niet langer een boost wilt geven?',
            'title'         => 'Een campaign unboosten',
        ],
    ],
    'countries'     => [
        'austria'       => 'Oostenrijk',
        'belgium'       => 'België',
        'france'        => 'Frankrijk',
        'germany'       => 'Duitsland',
        'italy'         => 'Italië',
        'netherlands'   => 'Nederland',
        'spain'         => 'Spanje',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Download PDF',
            'view_all'  => 'Bekijk alle',
        ],
        'empty'     => 'Geen facturen',
        'fields'    => [
            'amount'    => 'Aantal',
            'date'      => 'Datum',
            'invoice'   => 'Factuur',
            'status'    => 'Status',
        ],
        'header'    => 'Hieronder vind je een lijst met je laatste 24 facturen die je kunt downloaden.',
        'status'    => [
            'paid'      => 'Betaald',
            'pending'   => 'In afwachting',
        ],
        'title'     => 'Facturen',
    ],
    'layout'        => [
        'success'   => 'Lay-out opties bijgewerkt.',
        'title'     => 'Lay-out',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Marktplaats naam',
        ],
        'helper'    => 'Standaard wordt je gebruikersnaam weergegeven op de :marketplace. Met dit veld kun je deze waarde overschrijven.',
        'title'     => 'Marktplaats Instellingen',
        'update'    => 'Marktplaats instellingen opgeslagen.',
    ],
    'menu'          => [
        'account'               => 'Account',
        'api'                   => 'API',
        'apps'                  => 'Apps',
        'billing'               => 'Betalingsmiddel',
        'boost'                 => 'Boost',
        'invoices'              => 'Facturen',
        'layout'                => 'Lay-out',
        'marketplace'           => 'Marktplaats',
        'other'                 => 'Andere',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Betalingsmogelijkheden',
        'personal_settings'     => 'Persoonlijke Instellingen',
        'profile'               => 'Profiel',
        'settings'              => 'Instellingen',
        'subscription'          => 'Abbonement',
        'subscription_status'   => 'Abbonement Status',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Account koppelen',
            'view'  => 'Bezoek Kanka op Patreon',
        ],
        'benefits'          => 'Door ons te steunen op :patreon ontgrendel je allerlei :features voor jou en jouw campaigns, en helpt het ons ook meer tijd te besteden aan het verbeteren van Kanka.',
        'benefits_features' => 'geweldige functies',
        'deprecated'        => 'Verouderde functie - als je Kanka wilt steunen, doe dit dan met een :subscription. Patreon-koppeling is nog steeds actief voor onze klanten die hun account hebben gekoppeld voordat ze weggingen van Patreon.',
        'description'       => 'Synchroniseren met Patreon',
        'linked'            => 'Bedankt voor het steunen van Kanka op Patreon! Je account is gekoppeld.',
        'pledge'            => 'Toezegging: :name',
        'remove'            => [
            'button'    => 'Ontkoppel je Patreon-account',
            'success'   => 'Je Patreon-account is ontkoppeld.',
            'text'      => 'Als je je Patreon-account met Kanka ontkoppelt, worden je bonussen, naam in de hall of fame, campaign boosts en andere functies verwijderd die zijn gekoppeld aan het ondersteunen van Kanka. Geen van je boosted inhoud gaat verloren (bijv. entiteit headers). Door je opnieuw te abonneren, heb je toegang tot al je eerdere gegevens, inclusief de mogelijkheid om je eerder boosted campaigns een boost te geven.',
            'title'     => 'Ontkoppel je Patreon-account met Kanka',
        ],
        'success'           => 'Bedankt voor het steunen van Kanka op Patreon!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Je toezegging niveau wordt handmatig door ons ingesteld, dus het kan een paar dagen duren voordat we het correct hebben ingesteld. Mocht het een tijdje fout blijven, neem dan contact met ons op.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Profiel bijwerken',
        ],
        'avatar'    => 'Profiel Foto',
        'success'   => 'Profiel bijgewerkt.',
        'title'     => 'Persoonlijk profiel',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Annuleer abonnement',
            'subscribe'         => 'Abboneer',
            'update_currency'   => 'Bewaar de gewenste valuta',
        ],
        'benefits'              => 'Door ons te steunen, kun je enkele nieuwe :features ontgrendelen en ons helpen meer tijd te investeren in het verbeteren van Kanka. Er wordt geen creditcardinformatie opgeslagen of doorgegeven via onze servers. We gebruiken :stripe om alle facturering af te handelen.',
        'billing'               => [
            'helper'    => 'Je factuurgegevens worden veilig verwerkt en opgeslagen via :stripe. Deze betaalmethode wordt gebruikt voor al je abonnementen.',
            'saved'     => 'Opgeslagen betaalmethode',
            'title'     => 'Betalingsmethode bewerken',
        ],
        'cancel'                => [
            'text'  => 'Spijtig om je te zien gaan! Als je jouw abonnement opzegt, blijft het actief tot je volgende betalingscyclus, waarna je jouw campaign boosts en andere voordelen met betrekking tot het ondersteunen van Kanka kwijtraakt. Vul gerust het volgende formulier in om ons te laten weten wat we beter kunnen doen, of wat tot je beslissing heeft geleid.',
        ],
        'cancelled'             => 'Je abonnement is opgezegd. Je kunt een abonnement verlengen zodra je huidige abonnement afloopt.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Je abonneert je op de :tier tier, maandelijks gefactureerd voor :amount.',
                'yearly'    => 'Je abonneert je op de :tier tier, jaarlijks gefactureerd voor :amount.',
            ],
            'title' => 'Wijzig Abonnement Tier',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Wijzig de valuta van je voorkeur voor facturering',
        ],
        'errors'                => [
            'callback'      => 'Onze betalingsprovider heeft een fout gemeld. Probeer het opnieuw of neem contact met ons op als het probleem zich blijft voordoen.',
            'subscribed'    => 'Kan je abonnement niet verwerken. Stripe gaf de volgende hint.',
        ],
        'fields'                => [
            'active_since'      => 'Actief sinds',
            'active_until'      => 'Actief tot',
            'billing'           => 'Facturering',
            'currency'          => 'Facturering Valuta',
            'payment_method'    => 'Betalingsmiddel',
            'plan'              => 'Huidige plan',
            'reason'            => 'Reden',
        ],
        'helpers'               => [
            'alternatives'          => 'Betaal je abonnement met :method. Deze betaalmethode wordt aan het einde van je abonnement niet automatisch verlengd. :method is alleen beschikbaar in euro\'s.',
            'alternatives_warning'  => 'Het is niet mogelijk om je abonnement op te waarderen wanneer je deze methode gebruikt. Maak een nieuw abonnement aan wanneer je huidige afloopt.',
            'alternatives_yearly'   => 'Vanwege de beperkingen rond terugkerende betalingen, is de :method alleen beschikbaar voor jaarlijkse abonnementen',
        ],
        'manage_subscription'   => 'Beheer abonnement',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Voeg een nieuwe betaalmethode toe',
                'change'            => 'Verander de betaalmethode',
                'save'              => 'Bewaar betaalmethode',
                'show_alternatives' => 'Alternatieve betalingsmogelijkheden',
            ],
            'add_one'       => 'Je hebt momenteel geen betalingsmethode opgeslagen.',
            'alternatives'  => 'Je kunt je abonneren met behulp van deze alternatieve betalingsopties. Met deze actie wordt je account eenmaal in rekening gebracht en wordt je abonnement niet elke maand automatisch verlengd.',
            'card'          => 'Kaart',
            'card_name'     => 'Naam op kaart',
            'country'       => 'Land van verblijf',
            'ending'        => 'Eindigend in',
            'helper'        => 'Deze kaart wordt gebruikt voor al je abonnementen.',
            'new_card'      => 'Voeg een nieuwe betaalmethode toe',
            'saved'         => ':brand eindigend met :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Vertel ons desgewenst waarom je Kanka niet langer steunt. Ontbreekt er een functie? Is je financiële situatie veranderd?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount maandelijks gefactureerd',
            'cost_yearly'   => ':currency :amount jaarlijks gefactureerd',
        ],
        'sub_status'            => 'Abonnementsgegevens',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Neem contact met ons op voor het downgraden',
                'rollback'          => 'Schakel over naar Kobold',
                'subscribe'         => 'Verander naar :tier maandelijks',
                'subscribe_annual'  => 'Verander naar :tier jaarlijks',
            ],
        ],
        'success'               => [
            'alternative'   => 'Je betaling is geregistreerd. Je krijgt een melding zodra deze is verwerkt en je abonnement actief is.',
            'callback'      => 'Je inschrijving is gelukt. Je account wordt bijgewerkt zodra onze betalingsprovider ons op de hoogte stelt van de wijziging (dit kan enkele minuten duren).',
            'cancel'        => 'Je abonnement is opgezegd. Het blijft actief tot het einde van je huidige factureringsperiode.',
            'currency'      => 'De valuta-instelling van je voorkeur is bijgewerkt.',
            'subscribed'    => 'Je inschrijving is gelukt. Vergeet niet om je te abonneren op de Community Vote-nieuwsbrief om op de hoogte te worden gehouden wanneer een stemming live gaat. Je kunt je nieuwsbriefinstellingen wijzigen op je profielpagina.',
        ],
        'tiers'                 => 'Abonnement Tiers',
        'trial_period'          => 'Jaarabonnementen hebben een annuleringsbeleid van 14 dagen. Neem contact met ons op via :email als je jouw jaarabonnement wilt annuleren en een terugbetaling wilt ontvangen.',
        'upgrade_downgrade'     => [
            'button'    => 'Upgrade- en downgrade-informatie',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Je bonussen blijven geactiveerd tot het einde van je betalingsperiode.',
                    'boosts'    => 'Hetzelfde gebeurt voor je boosted campaigns. Boosted functies worden onzichtbaar, maar worden niet verwijderd wanneer een campaign niet langer wordt ge-boost.',
                    'kobold'    => 'Om je abonnement te annuleren, ga je naar het Kobold tier.',
                ],
                'title'     => 'Bij het opzeggen van je abonnement',
            ],
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'Je huidige niveau blijft actief tot het einde van je huidige factureringscyclus, waarna je wordt gedowngraded naar je nieuwe tier.',
                ],
                'title'     => 'Bij het downgraden naar een lager niveau',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Uw betalingsmethode wordt onmiddellijk gefactureerd en u krijgt toegang tot uw nieuwe niveau.',
                    'prorate'   => 'Bij het upgraden van Owlbear naar Elemental, wordt alleen het verschil met je nieuwe niveau in rekening gebracht.',
                ],
                'title'     => 'Bij het upgraden naar een hoger niveau',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'We konden uw creditcard niet belasten. Werk uw creditcardgegevens bij en we zullen proberen deze de komende dagen opnieuw in rekening te brengen. Als het opnieuw mislukt, wordt uw abonnement opgezegd.',
            'patreon'       => 'Uw account is momenteel gekoppeld aan Patreon. Ontkoppel uw account in uw: patreon-instellingen voordat u overschakelt naar een Kanka-abonnement.',
        ],
    ],
];
