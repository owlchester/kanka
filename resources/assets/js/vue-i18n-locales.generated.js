export default {
    "ar": [],
    "base": {
        "maps": [],
        "calendars": [],
        "randomizers": [],
        "admin": [],
        "timelines": [],
        "campaigns": [],
        "front": [],
        "entities": []
    },
    "ca": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Canvia a l'inici de sessió des de Kanka",
                    "update_email": "Actualitza l'adreça de mail",
                    "update_password": "Actualitza la contrasenya"
                },
                "email": "Canvia l'adreça de mail",
                "email_success": "S'ha actualitzat l'adreça de mail.",
                "password": "Canvia la contrasenya",
                "password_success": "S'ha actualitzat la contrasenya.",
                "social": {
                    "error": "Ja esteu utilitzant l'inici de sessió de Kanka amb aquest compte.",
                    "helper": "El compte està vinculat amb {provider}. Podeu desvincular-la i canviar a l'inici de sessió estàndard de Kanka escrivint una contrasenya.",
                    "success": "El compte ara fa servir l'inici de sessió de Kanka.",
                    "title": "De social a Kanka"
                },
                "title": "Compte"
            },
            "api": {
                "experimental": "Benvingut a les APIs de Kanka! Aquestes prestacions encara són experimentals però haurien de ser prou estables perquè permetin comunicar-se amb les APIs. Creeu un Token d'Accés Personal per a usar a les vostres sol·licituds d'API, o useu el Token Client si voleu que la vostra app tingui accés a dades d'usuari.",
                "help": "Kanka oferirà pròximament una RESTful API perquè aplicacions terceres puguin connectar-se a l'app. Aquí s'aniran mostrant els detalls sobre com gestionar les claus API.",
                "link": "Llegeix la documentació de l'API",
                "request_permission": "Actualment estem construint una poderosa RESTful API perquè aplicacions terceres puguin connectar-se a l'app. No obstant això, de moment limitem el nombre d'usuaris que poden interactuar amb la API mentre la polim. Si voleu accedir a l'API i construir apps interessants que interactuin amb Kanka, contacteu-nos i us enviarem tota la informació que calgui.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Connecta",
                    "remove": "Elimina"
                },
                "benefits": "Kanka ofereix algunes integracions amb serveis de tercers. Hi ha més integracions planejades per al futur.",
                "discord": {
                    "errors": {
                        "add": "Hi ha hagut un error vinculant el vostre compte de Discord amb Kanka. Si us plau, torneu a intentar-ho."
                    },
                    "success": {
                        "add": "S'ha vinculat el vostre compte de Discord.",
                        "remove": "S'ha desvinculat el vostre compte de Discord."
                    },
                    "text": "Accediu als rols de subscripció automàticament."
                },
                "title": "Integració d'aplicacions"
            },
            "boost": {
                "benefits": {
                    "first": "Per a assegurar un progrés continu a Kanka, algunes característiques de la campanya es poden desbloquejar millorant-la. Les millores es desbloquegen a través de les subscripcions. Qualsevol que pugui veure una campanya pot millorar-la; així el màster no ha de pagar sempre el compte. Una campanya roman millorada mentre un usuari l'estigui millorant i continuï fent suport a Kanka. Si una campanya deixa d'estar millorada, les dades no es perden: només romanen ocultes fins que la campanya torni a ser millorada.",
                    "header": "Imatges de capçalera per a les entitats.",
                    "images": "Imatges per defecte personalitzades",
                    "more": "Saber més sobre totes les característiques.",
                    "second": "Millorar una campanya activa els següents beneficis:",
                    "theme": "Tema i estil personalitzat a nivell de campanya.",
                    "third": "Per a millorar una campanya, dirigiu-vos a la pàgina de la campanya i cliqueu el botó de \"{boost_button}\" que hi ha sobre el botó de \"{edit_button}\".",
                    "tooltip": "Descripcions emergents personalitzades per a les entitats.",
                    "upload": "Capacitat de pujada d'arxius ampliada per a tots els membres de la campanya."
                },
                "buttons": {
                    "boost": "Millora"
                },
                "campaigns": "Campanyes millorades {count}/{max}",
                "exceptions": {
                    "already_boosted": "La campanya {name} ja està millorada.",
                    "exhausted_boosts": "Us heu quedat sense millores. Elimineu una millora d'una campanya abans de donar-la-hi a una altra."
                },
                "success": {
                    "boost": "S'ha millorat la campanya {name}.",
                    "delete": "La vostra millora s'ha tret de {name}."
                },
                "title": "Millorar"
            },
            "countries": {
                "austria": "Àustria",
                "belgium": "Bèlgica",
                "france": "França",
                "germany": "Alemanya",
                "italy": "Itàlia",
                "netherlands": "Països Baixos",
                "spain": "Espanya"
            },
            "invoices": {
                "actions": {
                    "download": "Descarrega el PDF",
                    "view_all": "Veu-les totes"
                },
                "empty": "Sense factures",
                "fields": {
                    "amount": "Quantitat",
                    "date": "Data",
                    "invoice": "Factura",
                    "status": "Estat"
                },
                "header": "Podeu descarregar les últimes 24 factures a continuació.",
                "status": {
                    "paid": "Pagada",
                    "pending": "Pendent"
                },
                "title": "Factures"
            },
            "layout": {
                "success": "S'han actualitzat les opcions de disseny.",
                "title": "Disseny"
            },
            "menu": {
                "account": "Compte",
                "api": "API",
                "apps": "Aplicacions",
                "billing": "Mètode de pagament",
                "boost": "Millorar",
                "invoices": "Factures",
                "layout": "Disseny",
                "other": "Altres",
                "patreon": "Patreon",
                "payment_options": "Opcions de pagament",
                "personal_settings": "Configuració personal",
                "profile": "Perfil",
                "subscription": "Subscripció",
                "subscription_status": "Estat de la subscripció"
            },
            "patreon": {
                "actions": {
                    "link": "Vincula el compte",
                    "view": "Visita la pàgina de Patreon de Kanka"
                },
                "benefits": "Fer-nos suport a Patreon desbloqueja moltes {features} per a les campanyes, i ens ajuda a dedicar-li més temps a treballar en Kanka.",
                "benefits_features": "funcions increïbles",
                "deprecated": "Funcionalitat discontinuada. Si desitgeu fer suport a Kanka, podeu fer-ho mitjançant una {subscription}. La vinculació amb Patreon encara continua activa per als nostres Patrons que van vincular els seus comptes abans de la mudança de Patreon.",
                "description": "Sincronizant amb Patreon",
                "errors": {
                    "invalid_token": "Token no vàlid! Patreon no ha pogut validar la vostra petició.",
                    "missing_code": "Manca el codi! Patreon no ha enviat un codi per a identificar el vostre compte.",
                    "no_pledge": "Sense \"pledge\"! Patreon ha identificat el vostre compte, però no detecta cap \"pledge\" actiu."
                },
                "link": "Cliqueu següent botó si esteu fent suport a Kanka en Patreon actualment. Això us donarà accés a més coses fantàstiques extres!",
                "linked": "Gràcies per fer suport a Kanka en Patreon! S'ha vinculat el vostre compte.",
                "pledge": "Pledge {name}",
                "remove": {
                    "button": "Desvincula el meu compte de Patreon",
                    "success": "S'ha desvinculat el vostre compte de Patreon.",
                    "text": "Desvincular el vostre compte de Patreon de Kanka eliminarà els vostres bonus, el vostre nom del saló de la fama, les vostres millores i altres funcionalitats vinculades. No obstant això, el vostre contingut millorat no es perdrà: si torneu a subscriure-us, tornareu a tenir accés a aquestes dades, incloent la possibilitat de tornar a millorar aquesta campanya.",
                    "title": "Desvincular el compte de Patreon de Kanka"
                },
                "success": "Gràcies per fer suport a Kanka a Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Afegim manualment el vostre nivell de \"pledge\", així que tingueu en compte que podem trigar uns pocs dies. Si al cap d'un temps segueix sense estar bé, contacteu amb nosaltres."
            },
            "profile": {
                "actions": {
                    "update_profile": "Actualiza el perfil"
                },
                "avatar": "Foto de perfil",
                "success": "S'ha actualitzat el perfil.",
                "title": "Perfil personal"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Cancela la subscripció",
                    "subscribe": "Subscriu-me",
                    "update_currency": "Guarda com a moneda preferida"
                },
                "benefits": "En donar-nos suport, es desbloquegen noves {features} i ens ajudeu a dedicar més temps a la millora de Kanka. No es guarda cap informació bancària. Usem {stripe} per a gestionar els cobraments.",
                "billing": {
                    "helper": "La vostra informació de pagament es processa i es guarda de manera segura mitjançant {stripe}. Aquest mètode de pagament s'usarà per a totes les vostres subscripcions.",
                    "saved": "Mètode de pagament guardat",
                    "title": "Edita el mètode de pagament"
                },
                "cancel": {
                    "text": "Ens sap greu que marxeu! En cancel·lar la vostra subscripció, aquesta continuarà activa fins al nou cicle de facturació, després del qual perdreu les millores de campanya i altres beneficis relacionats. No dubteu en informar-nos sobre com podem millorar o què us ha dut a prendre aquesta decisió."
                },
                "cancelled": "S'ha cancel·lat la subscripció. Podeu renovar-la una vegada el període de la subscripció actual hagi acabat.",
                "change": {
                    "text": {
                        "monthly": "Us esteu subscrivint al nivell {tier}, que costa {amount} mensuals.",
                        "yearly": "Us esteu subscrivint al nivell {tier}, que costa {amount} anuals."
                    },
                    "title": "Canvia el nivell de subscripció"
                },
                "currencies": {
                    "eur": "Euros",
                    "usd": "Dòlars estatunidencs"
                },
                "currency": {
                    "title": "Canvia la moneda de facturació"
                },
                "errors": {
                    "callback": "El nostre proveïdor de pagaments ens ha informat d'un error. Si us plau, torneu a intentar-ho o informeu-nos si el problema persisteix.",
                    "subscribed": "No s'ha pogut processar la subscripció. Stripe ens ha donat aquest missatge:"
                },
                "fields": {
                    "active_since": "Activa des del",
                    "active_until": "Activa fins el",
                    "billing": "Cobrament",
                    "currency": "Moneda de cobrament",
                    "payment_method": "Mètode de pagament",
                    "plan": "Pla actual",
                    "reason": "Raó"
                },
                "helpers": {
                    "alternatives": "Paga per la subscripció usant {method}. Aquest mètode de pagament no es renovarà automàticament al final de la subscripció. {method} només està disponible amb euros.",
                    "alternatives_warning": "No es pot millorar la subscripció usant aquest mètode. Si us plau, feu una nova subscripció quan l'actual acabi.",
                    "alternatives_yearly": "A causa de les restriccions dels pagaments recurrents, {method} només està disponible per a les subscripcions anuals."
                },
                "manage_subscription": "Gestiona la subscripció",
                "payment_method": {
                    "actions": {
                        "add_new": "Afegeix un nou mètode de pagament",
                        "change": "Canvia el mètode de pagament",
                        "save": "Guarda el mètode de pagament",
                        "show_alternatives": "Mètodes de pagament alternatius"
                    },
                    "add_one": "Encara no teniu cap mètode de pagament guardat.",
                    "alternatives": "Podeu subscriure-us usant aquests mètodes de pagament alternatius. Això farà un sol cobrament al vostre compte i no es renovarà automàticament cada mes.",
                    "card": "Targeta",
                    "card_name": "Nom a la targeta",
                    "country": "País de residència",
                    "ending": "Acaba en",
                    "helper": "S'usarà aquesta targeta per a totes les vostres subscripcions.",
                    "new_card": "Afegeix un nou mètode de pagament",
                    "saved": "{brand} que acaba en {last4}"
                },
                "placeholders": {
                    "reason": "Opcionalment, podeu explicar-nos per què ja no feu suport a Kanka. Que faltava alguna cosa? Va canviar la vostra situació financera?"
                },
                "plans": {
                    "cost_monthly": "{amount} {currency} mensuals",
                    "cost_yearly": "{amount} {currency} anuals"
                },
                "sub_status": "Informació sobre la subscripció",
                "subscription": {
                    "actions": {
                        "downgrading": "Contacteu-nos per a baixar de nivell",
                        "rollback": "Canvia a Kobold",
                        "subscribe": "Canvia a {tier} mensualment",
                        "subscribe_annual": "Canvia a {tier} anualmente"
                    }
                },
                "success": {
                    "alternative": "S'ha registrat el pagament. Rebreu una notificació quan acabem de processar-ho i s'activi la subscripció.",
                    "callback": "La subscripció ha tingut èxit. El vostre compte s'actualitzarà quan el nostre proveïdor de pagaments ens informi del canvi (pot portar alguns minuts).",
                    "cancel": "S'ha cancel·lat la vostra subscripció. Continuarà activa fins al final del període de pagament.",
                    "currency": "S'ha actualitzat la vostra moneda preferida.",
                    "subscribed": "La subscripció ha tingut èxit. No oblideu subscriure-us a la newsletter de votacions comunitàries per a assabentar-vos quan s'obri una votació! Podeu canviar la configuració de newsletters des del perfil."
                },
                "tiers": "Nivells de subscripció",
                "trial_period": "Les subscripcions anuals tenen un període de cancel·lació de 14 dies. Contacteu-nos per {email} si vols cancel·lar la subscripció anual i recuperar els diners.",
                "upgrade_downgrade": {
                    "button": "Informació sobre pujar o baixar de nivell",
                    "downgrade": {
                        "bullets": {
                            "end": "El vostre nivell actual estarà actiu fins al final del cicle de pagament actual, després del qual es baixarà la subscripció al nou nivell."
                        },
                        "title": "Baixar de nivell"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "Es cobrarà amb el vostre mètode de pagament immediatament i tindreu accés al nou nivell.",
                            "prorate": "En pujar de nivell de Owlbear a Elemental, només es cobrarà la diferència entre els dos nivells."
                        },
                        "title": "Pujar de nivell"
                    }
                },
                "warnings": {
                    "incomplete": "No hem pogut fer el cobrament a la vostra targeta de crèdit. Si us plau, actualitzeu la informació de la targeta i tornarem a intentar-ho en els pròxims dies. Si torna a fallar, la  subscripció serà cancel·lada.",
                    "patreon": "El vostre compte es troba vinculat amb Patreon. Desvinculeu-lo des de la configuració de {patreon} abans de canviar-la per una subscripció de Kanka."
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Crea una nova conversa",
                "success": "S'ha creat la conversa «{name}».",
                "title": "Nova conversa"
            },
            "destroy": {
                "success": "S'ha eliminat la conversa «{name}»."
            },
            "edit": {
                "description": "Actualiza la conversa",
                "success": "S'ha actualitzat la conversa «{name}».",
                "title": "Conversa {name}"
            },
            "fields": {
                "messages": "Missatges",
                "name": "Nom",
                "participants": "Participants",
                "target": "Objectiu",
                "type": "Tipus"
            },
            "hints": {
                "participants": "Afegiu participants a la conversa clicant a la icona {icon} adalt a la dreta."
            },
            "index": {
                "add": "Nova conversa",
                "description": "Gestiona les converses de {name}.",
                "header": "Converses de {name}",
                "title": "Converses"
            },
            "messages": {
                "destroy": {
                    "success": "S'ha eliminat el missatge."
                },
                "is_updated": "Actualizat",
                "load_previous": "Carrega els missatges previs",
                "placeholders": {
                    "message": "El vostre missatge"
                }
            },
            "participants": {
                "create": {
                    "success": "S'ha afegit el participant {entity} a la conversa."
                },
                "description": "Afegeix o elimina participants d'una conversa",
                "destroy": {
                    "success": "El participant {entity} s'ha tret de la conversa."
                },
                "modal": "Participants",
                "title": "Participants de {name}"
            },
            "placeholders": {
                "name": "Nom de la conversa",
                "type": "Dins del joc, preparació, argument..."
            },
            "show": {
                "description": "Vista detallada de conversa",
                "title": "Conversa {name}"
            },
            "tabs": {
                "conversation": "Conversa",
                "participants": "Participants"
            },
            "targets": {
                "characters": "Personatges",
                "members": "Membres"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Accions",
                "apply": "Aplica",
                "back": "Enrere",
                "copy": "Copia",
                "copy_mention": "Copia la menció [ ]",
                "copy_to_campaign": "Copia a la campanya",
                "explore_view": "Vista de niu",
                "export": "Exporta",
                "find_out_more": "Saber-ne més",
                "go_to": "Ves a {name}",
                "json-export": "Exporta (JSON)",
                "more": "Més accions",
                "move": "Mou",
                "new": "Nou",
                "next": "Següent",
                "private": "Privat",
                "public": "Públic",
                "reset": "Restableix"
            },
            "add": "Afegeix",
            "alerts": {
                "copy_mention": "S'ha copiat la menció avançada de l'entitat al porta-retalls."
            },
            "attributes": {
                "actions": {
                    "add": "Afegeix un atribut",
                    "add_block": "Afegeix un bloc",
                    "add_checkbox": "Afegeix una casella",
                    "add_text": "Afegeix un text",
                    "apply_template": "Aplica una plantilla d'atributs",
                    "manage": "Administra",
                    "more": "Més opcions",
                    "remove_all": "Elimina'ls tots"
                },
                "create": {
                    "description": "Crea un nou atribut",
                    "success": "S'ha afegit l'atribut {name} a {entity}.",
                    "title": "Atribut nou per a {name}"
                },
                "destroy": {
                    "success": "S'ha eliminat l'atribut {name} de {entity}."
                },
                "edit": {
                    "description": "Actualitza un atribut existent",
                    "success": "S'ha actualitzat l'atribut {name} de {entity}.",
                    "title": "Actualitza l'atribut de {name}"
                },
                "fields": {
                    "attribute": "Atribut",
                    "community_templates": "Plantilles de la comunitat",
                    "is_private": "Atributs privats",
                    "is_star": "Fixat",
                    "template": "Plantilla",
                    "value": "Valor"
                },
                "helpers": {
                    "delete_all": "¿Segur que voleu eliminar tots els atributs d'aquesta entitat?"
                },
                "hints": {
                    "is_private": "Podeu amagar tots els atributs d'una entitat a tots els membres no administradors fent-la privada."
                },
                "index": {
                    "success": "S'han actualitzat els atributs de {entity}.",
                    "title": "Atributs de {name}"
                },
                "placeholders": {
                    "attribute": "Nombre de conquestes, Iniciativa, Població...",
                    "block": "Nom del bloc",
                    "checkbox": "Nom de la casella",
                    "section": "Nom de la secció",
                    "template": "Selecciona una plantilla",
                    "value": "Valor de l'atribut"
                },
                "template": {
                    "success": "S'ha aplicat la plantilla d'atributs {name} a {entity}",
                    "title": "Aplica una plantilla d'atributs a {name}"
                },
                "types": {
                    "attribute": "Atribut",
                    "block": "Bloc",
                    "checkbox": "Casella",
                    "section": "Secció",
                    "text": "Text multilínia"
                },
                "visibility": {
                    "entry": "L'atribut es mostra al menú de l'entitat.",
                    "private": "L'atribut només és visible per a membres amb el rol \"Admin\".",
                    "public": "L'atribut és visible per a tots els membres.",
                    "tab": "L'atribut només es mostra a la pestanya d'atributs."
                }
            },
            "boosted": "millorada",
            "boosted_campaigns": "Campanyes millorades",
            "bulk": {
                "actions": {
                    "edit": "Edita i etiqueta en grup"
                },
                "age": {
                    "helper": "Utilitza + i - abans del número per a canviar l'edat."
                },
                "delete": {
                    "title": "Eliminació de múltiples entitats",
                    "warning": "¿Segur que voleu eliminar les entitats seleccionades?"
                },
                "edit": {
                    "tagging": "Acció per a les etiquetes",
                    "tags": {
                        "add": "Afegeix",
                        "remove": "Elimina"
                    },
                    "title": "Edició de múltiples entitats"
                },
                "errors": {
                    "admin": "Només els administradors de la campanya poden canviar l'estatus privat de les entitats.",
                    "general": "Hi ha hagut un error en processar l'acció. Torneu a intentar-ho o contacteu-nos si el problema persisteix. Missatge d'error: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Ignora"
                    },
                    "helpers": {
                        "override": "Si està seleccionat, els permisos de les entitats seleccionades s'ignoraran i utilitzaran aquesta configuració. Si no està seleccionat, aquests permisos s'afegiran als existents."
                    },
                    "title": "Canvia els permisos a diverses entitats"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} entitat copiada a {campaign}.|[2,*] {count} entitats copiades a {campaign}.",
                    "editing": "{1} S'ha actualitzat {count} entitat.|[2,*] S'han actualitzat {count} entitats.",
                    "permissions": "{1} S'han canviat els permisos a {count} entitat.|[2,*] S'han canviat els permisos a {count} entitats.",
                    "private": "{1} Ara {count} entitat és privada.|[2,*] Ara {count} entitats són privades.",
                    "public": "{1} Ara {count} entitat és visible.|[2,*] Ara {count} entitats són visibles."
                }
            },
            "cancel": "Cancela",
            "click_modal": {
                "close": "Tanca",
                "confirm": "Confirma",
                "title": "Confirma l'acció"
            },
            "copy_to_campaign": {
                "bulk_title": "Copia entitats a una altra campanya",
                "panel": "Copia",
                "title": "Copia «{name}» a una altra campaña"
            },
            "create": "Crea",
            "datagrid": {
                "empty": "Encara no hi ha res a mostrar."
            },
            "delete_modal": {
                "close": "Tanca",
                "delete": "Elimina",
                "description": "¿Segur que voleu eliminar {tag}?",
                "mirrored": "Elimina la relació emmirallada",
                "title": "Confirmació de l'eliminació"
            },
            "destroy_many": {
                "success": "{1} S'ha eliminat {count} entitat.|[2,*] S'han eliminat {count} entitats."
            },
            "edit": "Edita",
            "errors": {
                "boosted": "Aquesta funció només està disponible per a les campanyes millorades.",
                "node_must_not_be_a_descendant": "Node invàlid (etiqueta, localització superior): seria un descendent de si mateix."
            },
            "events": {
                "hint": "Aquí es mostren els esdeveniments del calendari associats a aquesta entitat."
            },
            "export": "Exporta",
            "fields": {
                "ability": "Habilitat",
                "attribute_template": "Plantilla d'atributs",
                "calendar": "Calendari",
                "calendar_date": "Data del calendari",
                "character": "Personatge",
                "colour": "Color",
                "copy_attributes": "Copia els atributs",
                "copy_notes": "Copia les anotacions de l'entitat",
                "creator": "Creador",
                "dice_roll": "Tirada de daus",
                "entity": "Entitat",
                "entity_type": "Tipus d'entitat",
                "entry": "Entrada",
                "event": "Esdeveniment",
                "excerpt": "Extracte",
                "family": "Família",
                "files": "Fitxers",
                "has_image": "Té imatge",
                "header_image": "Imatge de capçalera",
                "image": "Imatge",
                "is_private": "Privada",
                "is_star": "Fixada",
                "item": "Objecte",
                "location": "Localització",
                "map": "Mapa",
                "name": "Nom",
                "organisation": "Organització",
                "position": "Posició",
                "race": "Raça",
                "tag": "Etiqueta",
                "tags": "Etiquetes",
                "timeline": "Línia de temps",
                "tooltip": "Descripció emergent",
                "type": "Tipus",
                "visibility": "Visibilitat"
            },
            "files": {
                "actions": {
                    "drop": "Feu clic per a afegir o arrossegueu un fitxer",
                    "manage": "Administra els fitxers de l'entitat"
                },
                "errors": {
                    "max": "Heu arribat al nombre màxim ({max}) de fitxers per a aquesta entitat.",
                    "no_files": "No hi ha fitxers."
                },
                "files": "Fitxers pujats",
                "hints": {
                    "limit": "Cada entitat pot tenir un màxim de {max} fitxers.",
                    "limitations": "Formats acceptats: JPG, PNG, GIF i PDF. Tamany màxim del fitxer: {size}."
                },
                "title": "Fitxers de {name}"
            },
            "filter": "Filtra",
            "filters": {
                "all": "Mostra tots els descendents",
                "clear": "Treu els filtres",
                "direct": "Filtra només els descendents directes",
                "filtered": "Es mostren {count} de {total} {entity}.",
                "hide": "Amaga els filtres",
                "options": {
                    "exclude": "Exclou",
                    "include": "Inclou",
                    "none": "Res"
                },
                "show": "Mostra els filtres",
                "sorting": {
                    "asc": "Ascendent per {field}",
                    "desc": "Descendent per {field}",
                    "helper": "Controla en quin ordre apareixen els resultats."
                },
                "title": "Filtres"
            },
            "forms": {
                "actions": {
                    "calendar": "Afegeix una data del calendari"
                },
                "copy_options": "Opcions de còpia"
            },
            "hidden": "Amagat",
            "hints": {
                "attribute_template": "Aplica una plantilla d'atributs directament al crear aquesta entitat.",
                "calendar_date": "Les dates del calendari faciliten el filtrat de les llistes, i també fixen els esdeveniments al calendari seleccionat.",
                "header_image": "Aquesta imatge es troba sobre la entitat. Per a obtenir resultats millors, feu servir una imatge apaisada.",
                "image_limitations": "Formats acceptats: JPG, PNG, GIF i SVG. Tamany màxim del fitxer: {size}.",
                "image_patreon": "¿Com s'augmenta el tamany màxim dels fitxers?",
                "is_private": "Si és privada, aquesta entitat només es mostrarà als membres que tinguin el rol \"Admin\".",
                "is_star": "Els elements fixats es mostraran al menú principal de l'entitat.",
                "map_limitations": "Formats acceptats: JPG, PNG, GIF i SVG. Tamany màxim del fitxer: {size}.",
                "tooltip": "Reemplaça la descripció emergent automàtica amb el contingut següent.",
                "visibility": "En seleccionar \"Administrador\", només els membres amb el rol d'administrador podran veure això. \"Només jo\" vol dir que només vós podeu veure això."
            },
            "history": {
                "created": "Creada per <strong>{name}</strong> el <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Creada el <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Desconegut",
                "updated": "Última modificació per <strong>{name}</strong> el <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Última modificació el <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Historial de canvis de l'entitat"
            },
            "image": {
                "error": "No s'ha pogut obtenir la imatge. Pot ser que la pàgina web no permeti descarregar-la (habitual a Squarespace o DeviantArt), o que l'enllaç ja no sigui vàlid. Assegureu-vos també que el pes de la imatge no supera els {size}."
            },
            "is_not_private": "Aquesta entitat no és privada.",
            "is_private": "Aquesta entitat és privada i només es mostra als administradors.",
            "linking_help": "Com es poden enllaçar altres entitats?",
            "manage": "Administra",
            "move": {
                "description": "Mou aquesta entitat a un altre lloc",
                "errors": {
                    "permission": "No teniu permís per a crear entitats d'aquest tipus a la campanya seleccionada.",
                    "same_campaign": "Heu de seleccionar una altra campanya per moure-hi l'entitat.",
                    "unknown_campaign": "Campanya desconeguda."
                },
                "fields": {
                    "campaign": "Nova campanya",
                    "copy": "Fes una còpia",
                    "target": "Nou tipus"
                },
                "hints": {
                    "campaign": "També podeu intentar moure aquesta entitat a una altra campanya.",
                    "copy": "Seleccioneu aquesta opció si voleu crear una còpia a la nova campanya.",
                    "target": "Tingueu en compte que algunes dades es poden perdre al moure un element d'un tipus a un altre."
                },
                "success": "S'ha mogut l'entitat «{name}».",
                "success_copy": "S'ha copiat l'entitat «{name}».",
                "title": "Mou {name}"
            },
            "new_entity": {
                "error": "Reviseu les dades introduïdes.",
                "fields": {
                    "name": "Nom"
                },
                "title": "Nova entitat"
            },
            "or_cancel": "o <a href=\"{url}\">Cancela</a>",
            "panels": {
                "appearance": "Aparença",
                "attribute_template": "Plantilla d'atributs",
                "calendar_date": "Data del calendari",
                "entry": "Presentació",
                "general_information": "Informació general",
                "move": "Mou",
                "system": "Sistema"
            },
            "permissions": {
                "action": "Acció",
                "actions": {
                    "bulk": {
                        "add": "Permet",
                        "deny": "Denega",
                        "ignore": "Ignora",
                        "remove": "Treu"
                    },
                    "bulk_entity": {
                        "allow": "Permet",
                        "deny": "Denega",
                        "inherit": "Hereta"
                    },
                    "delete": "Eliminar",
                    "edit": "Editar",
                    "entity_note": "Anotacions",
                    "read": "Llegir",
                    "toggle": "Canvia"
                },
                "allowed": "Permès",
                "fields": {
                    "member": "Membre",
                    "role": "Rol"
                },
                "helper": "Des d'aquí podeu afinar quins usuaris i rols poden interactuar amb aquesta entitat.",
                "helpers": {
                    "entity_note": "Permite a los usuarios crear notas dentro de esta entidad. Sin este permiso, podrán seguir viendo las notas de entidad que se muestren a todos.",
                    "setup": "Des d'aquí podeu afinar com els diferents rols i usuaris poden interactuar amb aquesta entitat. {allow} els permetrà fer l'acció; {deny} els la denegarà, i {inherit} utilitzarà el permís que ja tingui el rol o l'usuari. Un usuari amb una acció en {allow} podrà fer-la, malgrat que el seu rol estigui en {deny}."
                },
                "inherited": "Aquest rol ja té aquest permís a aquesta entitat.",
                "inherited_by": "Aquest usuari forma part del rol «{role}», que li atorga aquest permís en aquesta entitat.",
                "success": "Permisos guardats.",
                "title": "Permisos",
                "too_many_members": "Aquesta campanya té massa membres (>10) per a poder mostrar-los tots aquí. Utilitzeu el botó de permisos a la vista d'entitat per a controlar els permisos detalladament."
            },
            "placeholders": {
                "ability": "Trieu una habilitat",
                "calendar": "Trieu un calendari",
                "character": "Trieu un personatge",
                "entity": "Entitat",
                "event": "Trieu un esdeveniment",
                "family": "Trieu una família",
                "image_url": "Podeu pujar una imatge des d'una URL",
                "item": "Trieu un objecte",
                "location": "Trieu una localització",
                "map": "Trieu un mapa",
                "organisation": "Trieu una organització",
                "race": "Trieu una raça",
                "tag": "Trieu una etiqueta"
            },
            "relations": {
                "actions": {
                    "add": "Afegeix una relació"
                },
                "fields": {
                    "location": "Localització",
                    "name": "Nom",
                    "relation": "Relació"
                },
                "hint": "Es poden relacionar entitats per a representar les seves connexions."
            },
            "remove": "Elimina",
            "rename": "Canvia el nom",
            "save": "Guarda",
            "save_and_close": "Guarda i tanca",
            "save_and_copy": "Guarda i copia",
            "save_and_new": "Guarda i crea de nou",
            "save_and_update": "Guarda i segueix editant",
            "save_and_view": "Guarda i veu",
            "search": "Cerca",
            "select": "Selecciona",
            "tabs": {
                "abilities": "Habilitats",
                "attributes": "Atributs",
                "boost": "Millora",
                "calendars": "Calendaris",
                "default": "Per defecte",
                "events": "Esdeveniments",
                "inventory": "Inventari",
                "map-points": "Punts del mapa",
                "mentions": "Mencions",
                "menu": "Menú",
                "notes": "Anotacions",
                "permissions": "Permisos",
                "relations": "Relacions",
                "reminders": "Recordatoris",
                "timelines": "Línies de temps",
                "tooltip": "Descripció emergent"
            },
            "update": "Actualitza",
            "users": {
                "unknown": "Desconegut"
            },
            "view": "Veu",
            "visibilities": {
                "admin": "Admin",
                "admin-self": "Admin i jo",
                "all": "Tothom",
                "self": "Només jo"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "de": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Zu Kanka Login wechseln",
                    "update_email": "Email aktualisieren",
                    "update_password": "Passwort aktualisieren"
                },
                "description": "Deinen Account aktualisieren",
                "email": "Email ändern",
                "email_success": "Email aktualisiert.",
                "password": "Passwort ändern",
                "password_success": "Passwort aktualisiert.",
                "social": {
                    "error": "Du benutzt bereits das Kanka Login für dieses Konto.",
                    "helper": "Dein Konto ist momentan von {provider}. Du kannst aufhören dieses zu benutzen und auf ein Standard Kanka Login wechseln, indem du ein Kennwort setzt.",
                    "success": "Dein Konto benutzt jetzt das Kanka Login.",
                    "title": "Social Konto"
                },
                "title": "Account"
            },
            "api": {
                "description": "Aktualisiere deine API Einstellungen",
                "experimental": "Willkommen zur API von Kanka! Diese Features sind noch experimentell, aber sollten stabil genug sein, um mit API zu kommunizieren. Erstelle ein persönliches Access Token, welches in deinem API Request genutzt wird, oder nutze das Client Token wenn du möchtest, dass deine App Zugriff auf Nutzerdaten hat.",
                "help": "Kanka wird bald eine RESTful API zur Verfügung stellen, so dass Drittanbieter-Apps mit Kanka kommunizieren können. Details, wie du deine API Keys verwaltest, wirst du bald hier finden.",
                "link": "Lies die API Dokumentation",
                "request_permission": "Wir bauen zurzeit eine mächtige RESTful API, so das Drittanbieter-Apps sich zu Kanka verbinden können. Allerdings limitieren wir aktuell noch die Anzahl der Nutzer, die die API nutzen können, solange wir noch daran arbeiten. Wenn du Zugriff auf die API haben möchtest und coole Apps bauen möchtest, die mit Kanka kommunizieren, bitte kontaktiere uns und wir senden dir die Informationen, die du brauchst.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Verbinden",
                    "remove": "Entfernen"
                },
                "benefits": "Kanka bietet einige Integrationsmöglichkeiten für Dienste von Drittanbietern. Weitere Integrationen von Drittanbietern sind für die Zukunft geplant.",
                "discord": {
                    "errors": {
                        "add": "Beim Verknüpfen Ihres Discord-Kontos mit Kanka ist ein Fehler aufgetreten. Bitte versuche es erneut."
                    },
                    "success": {
                        "add": "Ihr Discord-Konto wurde verknüpft.",
                        "remove": "Ihr Discord-Konto wurde nicht verbunden."
                    },
                    "text": "Greifen Sie automatisch auf Ihre Abonnementrollen zu."
                },
                "title": "App Integration"
            },
            "boost": {
                "benefits": {
                    "first": "Um weitere Fortschritte bei Kanka zu erzielen, werden einige Kampagnenfunktionen durch Boosten einer Kampagne freigeschaltet. Boosts werden durch Abonnements freigeschaltet. Jeder, der eine Kampagne anzeigen kann, kann sie verbessern, sodass der DM nicht immer die Rechnung bezahlen muss. Eine Kampagne bleibt verstärkt, solange ein Benutzer die Kampagne verstärkt und Kanka weiterhin unterstützt. Wenn eine Kampagne nicht mehr verstärkt wird, gehen keine Daten verloren, sondern werden nur ausgeblendet, bis die Kampagne erneut erhöht wird.",
                    "header": "Objekt Header Bilder.",
                    "images": "Benutzerdefinitierte Standardobjektbilder.",
                    "more": "Erfahren Sie mehr über alle Funktionen.",
                    "second": "Das Boosten einer Kampagne bietet die folgenden Vorteile:",
                    "theme": "Leitmotiv auf Kampagnenebene und benutzerdefiniertes Design.",
                    "third": "Um eine Kampagne zu boosten, rufen Sie die Seite der Kampagne auf und klicken Sie auf die Schaltfläche \"{boost_button}\" über der Schaltfläche \"{edit_button}\".",
                    "tooltip": "Benutzerdefinierte Kurzinfo für Objekt.",
                    "upload": "Erhöhte Upload-Größe für jedes Mitglied in der Kampagne."
                },
                "buttons": {
                    "boost": "Boost"
                },
                "campaigns": "Geboostete Kampagne {count} / {max}",
                "exceptions": {
                    "already_boosted": "Kampagne {name} ist bereits geboostet",
                    "exhausted_boosts": "Sie haben keine Boosts mehr zu geben. Entfernen Sie Ihren Boost aus einer Kampagne, bevor Sie ihn einer anderen geben."
                },
                "success": {
                    "boost": "Kampagne {name} geboostet",
                    "delete": "Entferne den boost von {name}"
                },
                "title": "Boost"
            },
            "countries": {
                "austria": "Österreich",
                "belgium": "Belgien",
                "france": "Frankreich",
                "germany": "Deutschland",
                "italy": "Italien",
                "netherlands": "Niederlande",
                "spain": "Spanien"
            },
            "invoices": {
                "actions": {
                    "download": "PDF herunterladen",
                    "view_all": "Alle anzeigen"
                },
                "empty": "keine Rechnungen",
                "fields": {
                    "amount": "Menge",
                    "date": "Datum",
                    "invoice": "Rechnung",
                    "status": "Status"
                },
                "header": "Unten finden Sie eine Liste Ihrer letzten 24 Rechnungen, die heruntergeladen werden können.",
                "status": {
                    "paid": "Bezahlt",
                    "pending": "steht aus"
                },
                "title": "Rechnungen"
            },
            "layout": {
                "description": "Aktualisiere deine Layout Optionen",
                "success": "Layout Optionen aktualisiert.",
                "title": "Layout"
            },
            "marketplace": {
                "fields": {
                    "name": "Marktplatzname"
                },
                "helper": "Standardmäßig wird Ihr Benutzername auf dem {marketplace} angezeigt. Sie können diesen Wert mit diesem Feld überschreiben.",
                "title": "Marktplatz Einstellungen",
                "update": "Marktplatz Einstellungen gespeichert"
            },
            "menu": {
                "account": "Account",
                "api": "API",
                "apps": "Apps",
                "billing": "Zahlungsmethode",
                "boost": "Boost",
                "invoices": "Rechnungen",
                "layout": "Layout",
                "marketplace": "Marktplatz",
                "other": "Andere",
                "patreon": "Patreon",
                "payment_options": "Zahlungsmöglichkeiten",
                "personal_settings": "Persönliche Einstellungen",
                "profile": "Profil",
                "subscription": "Abonnement",
                "subscription_status": "Abonnement Status"
            },
            "patreon": {
                "actions": {
                    "link": "Account verlinken",
                    "view": "Besuche Kanka auf Patreon"
                },
                "benefits": "Eure Unterstützung auf Patreon erlaubt es euch größere Bilder hochzuladen, hilft uns die Serverkosten zu begleichen und mehr Arbeitszeit in Kanka zu stecken.",
                "benefits_features": "erstaunliche Eigenschaften",
                "deprecated": "Veraltete Funktion - Wenn Sie Kanka unterstützen möchten, tun Sie dies bitte mit einem {subscription}. Die Patreon-Verknüpfung ist weiterhin für unsere Benutzer aktiv, die ihr Konto vor dem Umzug von Patreon verknüpft haben.",
                "description": "Synchronisierung mit Patreon",
                "errors": {
                    "invalid_token": "Ungültiger Token! Patreon konnte die Anfrage nicht validieren.",
                    "missing_code": "Fehlender Code! Patreon hat keinen Code zurück geschickt, um deinen Account zu verifizieren.",
                    "no_pledge": "Kein Pledge! Patreon hat deinen Account verifiziert, aber konnte keinen aktiven Pledge feststellen."
                },
                "link": "Benutze diesen Button, wenn du aktuell Kanka auf Patreon unterstützt. Das gibt dir Zugriff auf einige tolle Extras.",
                "linked": "Danke, dass du Kanka auf Patreon unterstützt! Dein Account wurde verlinkt.",
                "pledge": "Pledge {name}",
                "remove": {
                    "button": "Trennen Sie die Verknüpfung Ihres Patreon-Kontos",
                    "success": "Ihr Patreon-Konto wurde getrennt.",
                    "text": "Wenn Sie die Verknüpfung Ihres Patreon-Kontos mit Kanka aufheben, werden Ihre Boni, Ihr Name in der Hall of Fame, Kampagnen-Boosts und andere Funktionen im Zusammenhang mit der Unterstützung von Kanka entfernt. Keiner Ihrer verstärkten Inhalte geht verloren (z. B. Objekt header). Wenn Sie sich erneut anmelden, haben Sie Zugriff auf alle Ihre vorherigen Daten, einschließlich der Möglichkeit, Ihre zuvor verstärkten Kampagnen zu verbessern.",
                    "title": "Trennen Sie Ihr Patreon-Konto von Kanka"
                },
                "success": "Danke, dass du Kanka auf Patreon unterstützt.",
                "title": "Patreon",
                "wrong_pledge": "Euer Patreon Tier wird manuell von uns gesetzt. Daher kann es sein, dass es bis zu ein paar Tagen dauert bis es korrekt hinterlegt wird. Wenn es länger falsch ist, kontaktiert uns bitte."
            },
            "profile": {
                "actions": {
                    "update_profile": "Aktualisiere dein Profil"
                },
                "avatar": "Profilbild",
                "description": "Aktualisiere dein Profil",
                "success": "Profil aktualisiert.",
                "title": "Persönliches Profil"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Abonnement beenden",
                    "subscribe": "Abonnieren",
                    "update_currency": "Speichern Sie die bevorzugte Währung"
                },
                "benefits": "Wenn Sie uns unterstützen, können Sie einige neue {features} freischalten und uns helfen  mehr Zeit in die Verbesserung von Kanka zu investieren. Es werden keine Kreditkarteninformationen gespeichert oder über unsere Server übertragen. Wir verwenden {stripe}, um alle Abrechnungen abzuwickeln.",
                "billing": {
                    "helper": "Ihre Zahlungsinformationen werden sicher verarbeitet und gespeichert durch {stripe}. Diese Zahlungsmethode wird für alle Ihre Abonnements verwendet.",
                    "saved": "Gespeicherte Zahlungsmethode",
                    "title": "Zahlungsmethode ändern"
                },
                "cancel": {
                    "text": "Es tut uns leid dich gehen zu sehen! Wenn Sie Ihr Abonnement kündigen, bleibt es bis zu Ihrem nächsten Abrechnungszyklus aktiv. Danach verlieren Sie Ihre Kampagnen-Boosts und andere Vorteile im Zusammenhang mit der Unterstützung von Kanka. Füllen Sie das folgende Formular aus, um uns mitzuteilen, was wir besser machen können oder was zu Ihrer Entscheidung geführt hat."
                },
                "cancelled": "Ihr Abonnement wurde gekündigt. Sie können ein Abonnement verlängern, sobald Ihr aktuelles Abonnement endet.",
                "change": {
                    "text": {
                        "monthly": "Sie abonnieren die {tier} Stufe , die monatlich in Rechnung gestellt wird für {amount}.",
                        "yearly": "Sie abonnieren die {tier} Stufe, die jährlich in Rechnung gestellt wird für {amount}."
                    },
                    "title": "Abonnementstufe ändern"
                },
                "currencies": {
                    "eur": "EUR",
                    "usd": "USD"
                },
                "currency": {
                    "title": "Ändern Sie Ihre bevorzugte Rechnungswährung"
                },
                "errors": {
                    "callback": "Unser Zahlungsanbieter hat einen Fehler gemeldet. Bitte versuchen Sie es erneut oder kontaktieren Sie uns, wenn das Problem weiterhin besteht.",
                    "subscribed": "Ihr Abonnement konnte nicht verarbeitet werden. Stripe lieferte den folgenden Hinweis."
                },
                "fields": {
                    "active_since": "aktiv seit",
                    "active_until": "aktiv bis",
                    "billed_monthly": "Monatlich abgerechnet",
                    "billing": "Abrechnung",
                    "currency": "Abrechnungswährung",
                    "payment_method": "Zahlungsmethode",
                    "plan": "Derzeitiger Plan",
                    "reason": "Ursache"
                },
                "helpers": {
                    "alternatives": "Bezahlen Sie Ihr Abonnement mit {method}. Diese Zahlungsmethode wird am Ende Ihres Abonnements nicht automatisch verlängert. {method} ist nur in Euro verfügbar.",
                    "alternatives_warning": "Ein Upgrade Ihres Abonnements mit dieser Methode ist nicht möglich. Bitte erstellen Sie ein neues Abonnement, wenn Ihr aktuelles Abonnement endet.",
                    "alternatives_yearly": "Aufgrund der Einschränkungen bei wiederkehrenden Zahlungen ist die {method} nur für Jahresabonnements verfügbar"
                },
                "manage_subscription": "Abonnement verwalten",
                "payment_method": {
                    "actions": {
                        "add_new": "Füge eine neue Zahlungsmethode hinzu",
                        "change": "Zahlungsmethode ändern",
                        "save": "Zahlungsmethode speichern",
                        "show_alternatives": "alternative Zahlungsoptionen"
                    },
                    "add_one": "Sie haben derzeit keine Zahlungsmethode gespeichert.",
                    "alternatives": "Sie können diese alternativen Zahlungsoptionen abonnieren. Diese Aktion belastet Ihr Konto einmal und erneuert Ihr Abonnement nicht jeden Monat automatisch.",
                    "card": "Karte",
                    "card_name": "Name auf der Karte",
                    "country": "Land des Wohnsitzes",
                    "ending": "gültig bis",
                    "helper": "Diese Karte wird für alle Ihre Abonnements verwendet.",
                    "new_card": "Fügen sie eine neue Zahlungsmethode hinzu",
                    "saved": "{brand} endet mit {last4}"
                },
                "placeholders": {
                    "reason": "Sagen Sie uns optional, warum Sie Kanka nicht mehr unterstützen. Fehlt eine Funktion? Hat sich Ihre finanzielle Situation geändert?"
                },
                "plans": {
                    "cost_monthly": "{currency} {amount} monatlich abgerechnet",
                    "cost_yearly": "{currency} {amount} jährlich abgerechnet"
                },
                "sub_status": "Abonnementinformationen",
                "subscription": {
                    "actions": {
                        "downgrading": "Bitte kontaktieren Sie uns für ein Downgrade",
                        "rollback": "Wechseln Sie zu Kobold",
                        "subscribe": "Wechseln Sie zu {tier} monatlich",
                        "subscribe_annual": "Wechseln Sie zu {tier} jährlich"
                    }
                },
                "success": {
                    "alternative": "Ihre Zahlung wurde registriert. Sie erhalten eine Benachrichtigung, sobald diese verarbeitet wurde und Ihr Abonnement aktiv ist.",
                    "callback": "Ihr Abonnement war erfolgreich. Ihr Konto wird aktualisiert, sobald unsere Zahlung uns über die Änderung informiert (dies kann einige Minuten dauern).",
                    "cancel": "Ihr Abonnement wurde gekündigt. Es bleibt bis zum Ende Ihres aktuellen Abrechnungszeitraums aktiv.",
                    "currency": "Ihre bevorzugte Währungseinstellung wurde aktualisiert.",
                    "subscribed": "Ihr Abonnement war erfolgreich. Vergessen Sie nicht, den Community Vote-Newsletter zu abonnieren, um benachrichtigt zu werden, wenn eine Abstimmung live geht. Sie können Ihre Newsletter-Einstellungen auf Ihrer Profilseite ändern."
                },
                "tiers": "Abonnementstufen",
                "trial_period": "Für Jahresabonnements gilt eine Stornierungsfrist von 14 Tagen. Kontaktieren Sie uns unter {email}, wenn Sie Ihr Jahresabonnement kündigen und eine Rückerstattung erhalten möchten.",
                "upgrade_downgrade": {
                    "button": "Upgrade- und Downgrade-Informationen",
                    "downgrade": {
                        "bullets": {
                            "end": "Ihre aktuelle Stufe bleibt bis zum Ende Ihres aktuellen Abrechnungszyklus aktiv. Danach werden Sie auf Ihre neue Stufe herabgestuft."
                        },
                        "title": "Beim Downgrade auf eine niedrigere Stufe"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "Ihre Zahlungsmethode wird sofort in Rechnung gestellt und Sie haben Zugriff auf Ihre neue Stufe.",
                            "prorate": "Beim Upgrade von Owlbear auf Elemental wird Ihnen nur die Differenz zu Ihrer neuen Stufe in Rechnung gestellt."
                        },
                        "title": "Beim Upgrade auf eine höhere Stufe"
                    }
                },
                "warnings": {
                    "incomplete": "Wir konnten Ihre Kreditkarte nicht belasten. Bitte aktualisieren Sie Ihre Kreditkarteninformationen. Wir werden versuchen, sie in den nächsten Tagen erneut zu belasten. Wenn es erneut fehlschlägt, wird Ihr Abonnement gekündigt.",
                    "patreon": "Ihr Konto ist derzeit mit Patreon verknüpft. Bitte trennen Sie die Verknüpfung Ihres Kontos in Ihren {patreon}-Einstellungen, bevor Sie zu einem Kanka-Abonnement wechseln."
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Erstelle eine neue Unterhaltung",
                "success": "Unterhaltung {name} erstellt.",
                "title": "Neue Unterhaltung"
            },
            "destroy": {
                "success": "Unterhaltung {name} gelöscht."
            },
            "edit": {
                "description": "Aktualisiere die Unterhaltung",
                "success": "Unterhaltung '{name}' aktualisiert.",
                "title": "Unterhaltung {name}"
            },
            "fields": {
                "messages": "Nachrichten",
                "name": "Name",
                "participants": "Teilnehmer",
                "target": "Ziel",
                "type": "Typ"
            },
            "hints": {
                "participants": "Bitte füge Teilnehmer zu deiner Unterhaltung hinzu, indem du das {icon} Symbol oben rechts drückst."
            },
            "index": {
                "add": "Neue Unterhaltung",
                "description": "Verwalte die Kategorie von {name}.",
                "header": "Unterhaltungen in {name}",
                "title": "Unterhaltungen"
            },
            "messages": {
                "destroy": {
                    "success": "Nachricht gelöscht."
                },
                "is_updated": "Aktualisiert",
                "load_previous": "Lade vorherige Nachrichten",
                "placeholders": {
                    "message": "Deine Nachricht"
                }
            },
            "participants": {
                "create": {
                    "success": "Teilnehmer {entity} zu Unterhaltung hinzugefügt."
                },
                "description": "Entferne oder füge Teilnehmer einer Unterhaltung hinzu",
                "destroy": {
                    "success": "Teilnehmer {entity} von Unterhaltung entfernt."
                },
                "modal": "Teilnehmer",
                "title": "Teilnehmer von {name}"
            },
            "placeholders": {
                "name": "Name der Unterhaltung",
                "type": "Im Spiel, Vorbereitung, Handlung"
            },
            "show": {
                "description": "Eine Detailansicht einer Unterhaltung",
                "title": "Unterhaltung {name}"
            },
            "tabs": {
                "conversation": "Unterhaltung",
                "participants": "Teilnehmer"
            },
            "targets": {
                "characters": "Charaktere",
                "members": "Mitglieder"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Aktionen",
                "apply": "Übernehmen",
                "back": "Zurück",
                "copy": "Kopieren",
                "copy_mention": "Kopie [] erwähnen",
                "copy_to_campaign": "Kopiere zu Kampagne",
                "explore_view": "Verschachtelte Ansicht",
                "export": "Exportieren",
                "find_out_more": "Mehr erfahren",
                "go_to": "Gehe zu {name}",
                "json-export": "Export (json)",
                "more": "Mehr Aktionen",
                "move": "Verschieben",
                "new": "Neu",
                "next": "Weiter",
                "private": "Privat",
                "public": "Öffentlich",
                "reset": "Zurücksetzen"
            },
            "add": "Hinzufügen",
            "alerts": {
                "copy_mention": "Die erweiterte Erwähnung dieses Objekts wurde in Ihre Zwischenablage kopiert."
            },
            "attributes": {
                "actions": {
                    "add": "Attribut hinzufügen",
                    "add_block": "Block hinzufügen",
                    "add_checkbox": "Checkbox hinzufügen.",
                    "add_text": "Text hinzufügen",
                    "apply_template": "Eine Attributvorlage anwenden",
                    "manage": "Verwalten",
                    "more": "Mehr Optionen",
                    "remove_all": "Alles löschen"
                },
                "create": {
                    "description": "Erstelle ein neues Attribut",
                    "success": "Attribut {name} zu {entity} hinzugefügt",
                    "title": "Neues Attribute für {name}"
                },
                "destroy": {
                    "success": "Attribut {name} für {entity} entfernt"
                },
                "edit": {
                    "description": "Aktualisiere ein bestehendes Attribut",
                    "success": "Attribut {name} für {entity} aktualisiert",
                    "title": "Aktualisiere Attribut für {name}"
                },
                "fields": {
                    "attribute": "Attribut",
                    "community_templates": "Community Vorlagen",
                    "is_private": "Private Attribute",
                    "is_star": "Angepinnt",
                    "template": "Vorlage",
                    "value": "Wert"
                },
                "helpers": {
                    "delete_all": "Möchten Sie wirklich alle Attribute dieses Objekts löschen?"
                },
                "hints": {
                    "is_private": "Sie können alle Attribute eines Objekts für alle Mitglieder außerhalb der Administratorrolle ausblenden, indem Sie sie privat machen."
                },
                "index": {
                    "success": "Attribute für {entity} aktualisiert",
                    "title": "Attribute für {name}"
                },
                "placeholders": {
                    "attribute": "Anzahl der Eroberungen, Challenge Rating, Initiative, Bevölkerung",
                    "block": "Blockname",
                    "checkbox": "Checkbox Name",
                    "section": "Abteilungsname",
                    "template": "Wähle eine Vorlage",
                    "value": "Wert des Attributs"
                },
                "template": {
                    "success": "Attributvorlage {name} wird auf {entity} angewendet",
                    "title": "Wende eine Attributvorlage auf {name} an"
                },
                "types": {
                    "attribute": "Attribute",
                    "block": "Block",
                    "checkbox": "Checkbox",
                    "section": "Abteilung",
                    "text": "Mehrzeiliger Text"
                },
                "visibility": {
                    "entry": "Das Attribut wird im Objektmenü angezeigt.",
                    "private": "Attribut nur für Mitglieder der Rolle \"Admin\" sichtbar.",
                    "public": "Attribut für alle Mitglieder sichtbar.",
                    "tab": "Das Attribut wird nur im Attribute-Reiter angezeigt."
                }
            },
            "boosted": "geboostet",
            "boosted_campaigns": "geboostete Kampagne",
            "bulk": {
                "actions": {
                    "edit": "Bearbeitung vieler Objekte"
                },
                "age": {
                    "helper": "Sie können + und - vor der Nummer verwenden, um das Alter dynamisch zu aktualisieren."
                },
                "delete": {
                    "title": "Mehrere Objekte löschen",
                    "warning": "Möchten Sie die ausgewählten Objekte wirklich löschen?"
                },
                "edit": {
                    "tagging": "Aktion für Tags",
                    "tags": {
                        "add": "Hinzufügen",
                        "remove": "Entfernen"
                    },
                    "title": "Mehrere Objekte bearbeiten"
                },
                "errors": {
                    "admin": "Nur Kampagnenadmins können den \"Privat\" Status eines Objektes ändern.",
                    "general": "Bei der Verarbeitung Ihrer Aktion ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut und kontaktieren Sie uns, wenn das Problem weiterhin besteht. Fehlermeldung: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Überschreiben"
                    },
                    "helpers": {
                        "override": "Wenn ausgewählt, werden die Berechtigungen der ausgewählten Objekte mit diesen überschrieben. Wenn das Kontrollkästchen deaktiviert ist, werden die ausgewählten Berechtigungen zu den vorhandenen Berechtigungen hinzugefügt."
                    },
                    "title": "Ändert die Berechtigungen für mehrere Objekte"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} der in {campaign} kopierten Objekte. | [2, *] {count}  der in {campaign} kopierten Objekte.",
                    "editing": "1} {count} objekt wurde aktualisiert. | [2, *] {count} objekte wurden aktualisiert.",
                    "permissions": "Berechtigungen für {count} Objekt geändert.|Berechtigungen für {count} Objekte geändert.",
                    "private": "{count} Objekt ist jetzt privat.|{count} Objekte sind jetzt privat.",
                    "public": "{count} Objekt ist jetzt sichtbar.|{count} Objekte sind jetzt sichtbar."
                }
            },
            "cancel": "Abbrechen",
            "click_modal": {
                "close": "Schließen",
                "confirm": "Bestätigen",
                "title": "Bestätige deine Aktion"
            },
            "copy_to_campaign": {
                "bulk_title": "Kopieren Sie Objekte in eine andere Kampagne",
                "panel": "Kopieren",
                "title": "Kopiere {name} in eine andere Kampagne"
            },
            "create": "Erstellen",
            "datagrid": {
                "empty": "Nichts zu sehen bisher."
            },
            "delete_modal": {
                "close": "Schließen",
                "delete": "Löschen",
                "description": "Bist du sicher das du {tag} entfernen möchtest?",
                "mirrored": "Entferne gespiegelte Beziehung.",
                "title": "Löschen bestätigen"
            },
            "destroy_many": {
                "success": "{count} Objekt gelöscht|{count} Objekte gelöscht"
            },
            "edit": "Bearbeiten",
            "errors": {
                "boosted": "Diese Funktion ist nur für geboostete Kampagnen verfügbar.",
                "node_must_not_be_a_descendant": "Ungültiges Objekt (Kategorie, Ort): es würde ein Nachkomme von sich selbst sein."
            },
            "events": {
                "hint": "Kalenderereignisse, die mit diesem Objekt verknüpft sind, werden hier dargestellt."
            },
            "export": "Exportieren",
            "fields": {
                "ability": "Fähigkeit",
                "attribute_template": "Attributsvorlage",
                "calendar": "Kalender",
                "calendar_date": "Kalenderdatum",
                "character": "Charakter",
                "colour": "Farbe",
                "copy_attributes": "Kopiere Attribute",
                "copy_notes": "Kopiere Objektnotizen",
                "creator": "Ersteller",
                "dice_roll": "Würfelwürf",
                "entity": "Objekt",
                "entity_type": "Objekttyp",
                "entry": "Eintrag",
                "event": "Ereignis",
                "excerpt": "Auszug",
                "family": "Familie",
                "files": "Dateien",
                "has_image": "hat ein Bild",
                "header_image": "Kopfzeilenbild",
                "image": "Bild",
                "is_private": "Privat",
                "is_star": "Angepinnt",
                "item": "Gegenstand",
                "location": "Ort",
                "map": "Karte",
                "name": "Name",
                "organisation": "Organisation",
                "position": "Position",
                "race": "Rasse",
                "tag": "Tag",
                "tags": "Tags",
                "timeline": "Zeitstrahl",
                "tooltip": "Kurzinfo",
                "type": "Typ",
                "visibility": "Sichtbarkeit"
            },
            "files": {
                "actions": {
                    "drop": "Klicken zum Hinzufügen oder Datei hierher ziehen (Drag & Drop).",
                    "manage": "Verwalte Objektdateien"
                },
                "errors": {
                    "max": "Du hast die maximale Anzahl ({max}) von Dateien in diesem Objekt erreicht.",
                    "no_files": "Keine Dateien."
                },
                "files": "Hochgeladene Dateien",
                "hints": {
                    "limit": "In jedem Objekt kann eine maximale Anzahl von {max} Dateien hochgeladen werden.",
                    "limitations": "Unterstütze Formate: jpg, png, gif, und pdf. Max. Dateigröße: {size}"
                },
                "title": "Objektdateien für {name}"
            },
            "filter": "Filter",
            "filters": {
                "all": "Filter um alle Unterobjekte zu sehen",
                "clear": "Filter zurücksetzen",
                "direct": "Filter um nur direkte Unterobjekte zu sehen",
                "filtered": "Zeige {count} von {total} {entity}.",
                "hide": "Verstecken",
                "options": {
                    "exclude": "Ausschließen",
                    "include": "Einschließen",
                    "none": "keine"
                },
                "show": "Zeigen",
                "sorting": {
                    "asc": "{field} Aufsteigend",
                    "desc": "{field} absteigend",
                    "helper": "Steuern Sie, in welcher Reihenfolge die Ergebnisse angezeigt werden."
                },
                "title": "Filter"
            },
            "forms": {
                "actions": {
                    "calendar": "Füge Datum hinzu"
                },
                "copy_options": "Kopiere Optionen"
            },
            "hidden": "Versteckt",
            "hints": {
                "attribute_template": "Wende eine Attributsvorlage direkt beim erstellen des Objektes an.",
                "calendar_date": "Ein Datum erlaubt es, Listen einfach zu filtern und pflegt ein Ereignis im ausgewählten Kalender.",
                "header_image": "Dieses Bild wird über dem Objekt platziert. Verwenden Sie ein breites Bild, um optimale Ergebnisse zu erzielen.",
                "image_limitations": "Unterstützte Formate: jpg, png und gif. Maximale Dateigröße: {size}.",
                "image_patreon": "Erhöhe das Limit indem du uns bei Patreon unterstützt.",
                "is_private": "Vor 'Zuschauern' verbergen",
                "is_star": "Angepinnte Objekte erscheinen im Objektmenü.",
                "map_limitations": "Unterstützte Formate: jpg, png, gif und svg. Max Dateigröße: {size}.",
                "tooltip": "Ersetzen Sie die automatisch generierte Kurzinfo durch den folgenden Inhalt.",
                "visibility": "Wenn die Sichtbarkeit auf Admin festgelegt wird, können dies nur Mitglieder in der Rolle Admin sehen. Wird es auf \"Selbst\" gesetzt, kannst es nur du sehen."
            },
            "history": {
                "created": "Erstellt von <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Erstelle <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Unbekannt",
                "updated": "Zuletzt aktualisiert von <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Letzte Änderung <span data-toggle = \"tooltip\" title = \": realdate\">: Datum </ span>",
                "view": "Zeige Objektprotokoll"
            },
            "image": {
                "error": "Wir konnten das von dir angeforderte Bild nicht laden. Es könnte sein, dass die Website nicht erlaubt, Bilder herunterzuladen (typisch für Squarespace und DeviantArt) oder dass der Link nicht mehr gültig ist."
            },
            "is_not_private": "Dieses Objekt ist derzeit nicht auf privat eingestellt.",
            "is_private": "Dieses Objekt ist privat und nicht von Zuschauern einsehbar.",
            "linking_help": "Wie kann ich zu anderen Objekten verlinken?",
            "manage": "Verwalten",
            "move": {
                "description": "Verschiebe diese Objekt an einen anderen Ort",
                "errors": {
                    "permission": "Du hast keine Berechtigung, Objekte diesen Typs in dieser Kampagne zu erstellen.",
                    "same_campaign": "Du musst eine andere Kampagne auswählen, in welche du das Objekt verschieben willst.",
                    "unknown_campaign": "Unbekannte Kampagne."
                },
                "fields": {
                    "campaign": "Neue Kampagne",
                    "copy": "Erstelle Kopie",
                    "target": "Neuer Typ"
                },
                "hints": {
                    "campaign": "Du kannst auch versuchen, dieses Objekt in eine andere Kampagne zu verschieben.",
                    "copy": "Wähle diese Option, wenn du eine Kopie in der neuen Kampagne erstellen willst.",
                    "target": "Bitte beachte, das einige Daten verloren gehen können, wenn ein Objekt von einem Typ zu einem anderen verschoben wird."
                },
                "success": "Objekt '{name}' verschoben",
                "success_copy": "Objekt '{name}' kopiert",
                "title": "Verschiebe {name} an einen anderen Ort"
            },
            "new_entity": {
                "error": "Bitte überprüfe deine Eingabe.",
                "fields": {
                    "name": "Name"
                },
                "title": "Neues Objekt"
            },
            "or_cancel": "oder <a href=\"{url}\">abbrechen</a>",
            "panels": {
                "appearance": "Aussehen",
                "attribute_template": "Attributsvorlage",
                "calendar_date": "Datum",
                "entry": "Eintrag",
                "general_information": "Allgemeine Informationen",
                "move": "Verschieben",
                "system": "System"
            },
            "permissions": {
                "action": "Aktion",
                "actions": {
                    "bulk": {
                        "add": "Hinzufügen",
                        "deny": "verweigern",
                        "ignore": "Ignorieren",
                        "remove": "Entfernen"
                    },
                    "bulk_entity": {
                        "allow": "erlauben",
                        "deny": "verweigern",
                        "inherit": "Erben"
                    },
                    "delete": "Löschen",
                    "edit": "Bearbeiten",
                    "entity_note": "Objektnotizen",
                    "read": "Lesen",
                    "toggle": "Umschalten"
                },
                "allowed": "Erlaubt",
                "fields": {
                    "member": "Mitglied",
                    "role": "Rolle"
                },
                "helper": "Benutze dieses Interface um die Berechtigungen von Nutzern und Rollen mit diesem Objekt  fein zu justieren.",
                "helpers": {
                    "entity_note": "Ermöglichen Sie Benutzern das Erstellen von Objektnotizen für dieses Objekt. Ohne diese Berechtigung können sie weiterhin Objekt Notizen sehen, die auf Sichtbarkeit Alle eingestellt sind.",
                    "setup": "Verwenden Sie diese Schnittstelle, um zu optimieren, wie Rollen und Benutzer mit diesem Objekt interagieren können. {allow} ermöglicht dem Benutzer oder der Rolle, diese Aktion auszuführen. {deny} wird ihnen diese Handlung verweigern. {inherit} verwendet die Berechtigung des Benutzers oder der Hauptrolle. Ein Benutzer, der auf {allow} eingestellt ist, kann die Aktion ausführen, auch wenn seine Rolle auf {deny} eingestellt ist."
                },
                "inherited": "Für diese Rolle ist die Berechtigung für diesen Objekttyp bereits festgelegt.",
                "inherited_by": "Dieser Benutzer ist Teil der Rolle '{role}', die diese Berechtigungen für diesen Objekttyp erteilt.",
                "success": "Berechtigungen gespeichert.",
                "title": "Berechtigungen",
                "too_many_members": "Diese Kampagne hat zu viele Mitglieder (> 10), um in dieser Benutzeroberfläche angezeigt zu werden. Verwenden Sie die Schaltfläche Berechtigung in der Objektansicht, um die Berechtigungen im Detail zu steuern."
            },
            "placeholders": {
                "ability": "Wähle eine Fähigkeit",
                "calendar": "Wähle einen Kalender",
                "character": "Wähle einen Character",
                "entity": "Objekt",
                "event": "Wähle ein Ereignis",
                "family": "Wähle eine Familie",
                "image_url": "Du kannst ein Bild auch von einer URL hochladen",
                "item": "Wähle einen Gegenstand",
                "location": "Wähle einen Ort",
                "map": "Wähle eine Karte",
                "organisation": "Wähle eine Organisation",
                "race": "Wähle eine Rasse",
                "tag": "Wähle ein Tag"
            },
            "relations": {
                "actions": {
                    "add": "Füge eine Beziehung hinzu"
                },
                "fields": {
                    "location": "Ort",
                    "name": "Name",
                    "relation": "Beziehung"
                },
                "hint": "Beziehungen zwischen Objekten können erstellt werden, um deren Verbindung darzustellen."
            },
            "remove": "Löschen",
            "rename": "Umbenennen",
            "save": "Speichern",
            "save_and_close": "Speichern und schließen",
            "save_and_copy": "Speichern und kopieren",
            "save_and_new": "Speichern und neu",
            "save_and_update": "Speichern und aktualisieren",
            "save_and_view": "Speichern und ansehen",
            "search": "Suchen",
            "select": "Auswählen",
            "tabs": {
                "abilities": "Fähigkeiten",
                "attributes": "Attribute",
                "boost": "Boost",
                "calendars": "Kalender",
                "default": "Standard",
                "events": "Ereignisse",
                "inventory": "Inventar",
                "map-points": "Kartenmarker",
                "mentions": "Erwähnungen",
                "menu": "Menü",
                "notes": "Notizen",
                "permissions": "Berechtigungen",
                "relations": "Beziehungen",
                "reminders": "Erinnerungen",
                "timelines": "Zeitstrahlen",
                "tooltip": "Kurztip"
            },
            "update": "Bearbeiten",
            "users": {
                "unknown": "Unbekannt"
            },
            "view": "Ansehen",
            "visibilities": {
                "admin": "Admin",
                "admin-self": "Selbst & Admin",
                "all": "Jeder",
                "self": "Selbst"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "el": {
        "maps": [],
        "calendars": [],
        "randomizers": [],
        "admin": [],
        "timelines": [],
        "campaigns": [],
        "front": [],
        "entities": []
    },
    "en": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Switch to Kanka Login",
                    "update_email": "Update email",
                    "update_password": "Update password"
                },
                "email": "Change email",
                "email_success": "Email updated.",
                "password": "Change password",
                "password_success": "Password updated.",
                "social": {
                    "error": "You are already using the Kanka login for this account.",
                    "helper": "Your account is currently managed by {provider}. You can stop using it and switch to the standard Kanka login by setting up a password.",
                    "success": "Your account now uses the Kanka login.",
                    "title": "Social to Kanka"
                },
                "title": "Account"
            },
            "api": {
                "experimental": "Welcome to the Kanka APIs! These features are still experimental but should be stable enough for you to start communicating with the APIs. Create a Personal Access Token to use in your api requests, or use the Client token if you want your app to have access to user data.",
                "help": "Kanka will soon provide an RESTful API so that third-party apps can connect to the app. Details on how to manage your API keys will be shown here.",
                "link": "Read the API documentation",
                "request_permission": "We are currently building a powerful RESTful API so that third-party apps can connect to the app. However, we are currently limiting the number of users who can interact with the API while we polish it. If you want to get access to the API and build cools apps that talk with Kanka, please contact us and we'll send you all the information you need.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Connect",
                    "remove": "Remove"
                },
                "benefits": "Kanka provides a few integration to third party services. More third party integrations are planned for the future.",
                "discord": {
                    "errors": {
                        "add": "An error occurred linking up your Discord account with Kanka. Please try again."
                    },
                    "success": {
                        "add": "Your Discord account has been linked.",
                        "remove": "Your Discord account has been unlinked."
                    },
                    "text": "Access your subscription roles automatically."
                },
                "title": "App Integration"
            },
            "boost": {
                "benefits": {
                    "first": "To secure continued progress on Kanka, some campaign features are unlocked by boosting a campaign. Boosts are unlocked through subscriptions. Anyone who can view a campaign can boost it, so that the DM doesn't always have to foot the bill. A campaign remains boosted as long as a user is boosting the campaign and they continue supporting Kanka. If a campaign is no longer boosted, data isn't lost, it is only hidden until the campaign is boosted again.",
                    "header": "Entity header images.",
                    "images": "Custom default entity images.",
                    "more": "Find out more about all features.",
                    "second": "Boosting a campaign enables the following benefits:",
                    "theme": "Campaign level theme and custom styling.",
                    "third": "To boost a campaign, go to the campaign's page, and click on the \"{boost_button}\" button above the \"{edit_button}\" button.",
                    "tooltip": "Custom tooltips for entities.",
                    "upload": "Increased upload size for every member in the campaign."
                },
                "buttons": {
                    "boost": "Boost"
                },
                "campaigns": "Boosted Campaigns {count} / {max}",
                "exceptions": {
                    "already_boosted": "Campaign {name} is already boosted.",
                    "exhausted_boosts": "You are out of boosts to give. Remove your boost from a campaign before giving it to another."
                },
                "success": {
                    "boost": "Campaign {name} boosted.",
                    "delete": "Removed your boost from {name}."
                },
                "title": "Boost"
            },
            "countries": {
                "austria": "Austria",
                "belgium": "Belgium",
                "france": "France",
                "germany": "Germany",
                "italy": "Italy",
                "netherlands": "The Netherlands",
                "spain": "Spain"
            },
            "invoices": {
                "actions": {
                    "download": "Download PDF",
                    "view_all": "View all"
                },
                "empty": "No invoices",
                "fields": {
                    "amount": "Amount",
                    "date": "Date",
                    "invoice": "Invoice",
                    "status": "Status"
                },
                "header": "Below is a list of your last 24 invoices which can be downloaded.",
                "status": {
                    "paid": "Paid",
                    "pending": "Pending"
                },
                "title": "Invoices"
            },
            "layout": {
                "success": "Layout options updated.",
                "title": "Layout"
            },
            "marketplace": {
                "title": "Marketplace Settings",
                "helper": "By default, your user name is shown on the {marketplace}. You can override this value with this field.",
                "fields": {
                    "name": "Marketplace name"
                },
                "update": "Marketplace settings saved."
            },
            "menu": {
                "account": "Account",
                "api": "API",
                "apps": "Apps",
                "billing": "Payment Method",
                "boost": "Boost",
                "invoices": "Invoices",
                "layout": "Layout",
                "marketplace": "Marketplace",
                "other": "Other",
                "patreon": "Patreon",
                "payment_options": "Payment Options",
                "personal_settings": "Personal Settings",
                "profile": "Profile",
                "subscription": "Subscription",
                "subscription_status": "Subscription Status"
            },
            "patreon": {
                "actions": {
                    "link": "Link Account",
                    "view": "Visit Kanka on Patreon"
                },
                "benefits": "Supporting us on {patreon} unlocks all sorts of {features} for you and your campaigns, and also helps us spend more time working on improving Kanka.",
                "benefits_features": "amazing features",
                "deprecated": "Deprecated feature - if you wish to support Kanka, please do so with a {subscription}. Patreon linking is still active for our Patrons who have linked their account before the move away from Patreon.",
                "description": "Syncing with Patreon",
                "linked": "Thank you for supporting Kanka on Patreon! Your account is linked.",
                "pledge": "Pledge: {name}",
                "remove": {
                    "button": "Unlink your Patreon account",
                    "success": "Your Patreon account has been unlinked.",
                    "text": "Unlinking your Patreon account with Kanka will remove your bonuses, name on the hall of fame, campaign boosts, and other features linked to supporting Kanka. None of your boosted content will be lost (e.g. entity headers). By subscribing again, you will have access to all your previous data, including the ability to boost your previously boosted campaigns.",
                    "title": "Unlink your Patreon account with Kanka"
                },
                "success": "Thank you for supporting Kanka on Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Your pledge level is set manually by us, so please allow up to a few days for us to properly set it. If it stays wrong for a while, please contact us."
            },
            "profile": {
                "actions": {
                    "update_profile": "Update profile"
                },
                "avatar": "Profile Picture",
                "success": "Profile updated.",
                "title": "Personal Profile"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Cancel subscription",
                    "subscribe": "Subscribe",
                    "update_currency": "Save prefered currency"
                },
                "benefits": "By supporting us, you can unlock some new {features} and help us invest more time into improving Kanka. No credit card information is stored or transits through our servers. We use {stripe} to handle all billing.",
                "billing": {
                    "helper": "Your billing information is processed and stored safely through {stripe}. This payment method is used for all of your subscriptions.",
                    "saved": "Saved payment method",
                    "title": "Edit Payment Method"
                },
                "cancel": {
                    "text": "Sorry to see you go! Cancelling your subscription will keep it active until your next billing cycle, after which you will lose your campaign boosts and other benefits related to supporting Kanka. Feel free to fill out the following form to inform us what we can do better, or what lead to your decision."
                },
                "cancelled": "Your subscription has been cancelled. You can renew a subscription once your current subscription ends.",
                "change": {
                    "text": {
                        "monthly": "You are subscribing at the {tier} tier, billed monthly for {amount}.",
                        "yearly": "You are subscribing at the {tier} tier, billed annualy for {amount}."
                    },
                    "title": "Change Subscription Tier"
                },
                "currencies": {
                    "eur": "EUR",
                    "usd": "USD"
                },
                "currency": {
                    "title": "Change your preferred billing currency"
                },
                "errors": {
                    "callback": "Our payment provider reported an error. Please try again or contact us if the problem persists.",
                    "subscribed": "Couldn't process your subscription. Stripe provided the following hint."
                },
                "fields": {
                    "active_since": "Active since",
                    "active_until": "Active until",
                    "billing": "Billing",
                    "currency": "Billing Currency",
                    "payment_method": "Payment method",
                    "plan": "Current plan",
                    "reason": "Reason"
                },
                "helpers": {
                    "alternatives": "Pay for your subscription using {method}. This payment method won't auto-renew at the end of your subscription. {method} is only available in Euros.",
                    "alternatives_warning": "Upgrading your subscription when using this method is not possible. Please create a new subscription when your current one ends.",
                    "alternatives_yearly": "Due to the restrictions surrounding recurring payments, {method} is only available for yearly subscriptions"
                },
                "manage_subscription": "Manage subscription",
                "payment_method": {
                    "actions": {
                        "add_new": "Add a new payment method",
                        "change": "Change payment method",
                        "save": "Save payment method",
                        "show_alternatives": "Alternative payment options"
                    },
                    "add_one": "You currently have no payment method saved.",
                    "alternatives": "You can subscribe using these alternative payment options. This action will charge your account once and not auto-renew your subscription every month.",
                    "card": "Card",
                    "card_name": "Name on card",
                    "country": "Country of residence",
                    "ending": "Ending in",
                    "helper": "This card will be used for all of your subscriptions.",
                    "new_card": "Add a new payment method",
                    "saved": "{brand} ending with {last4}"
                },
                "placeholders": {
                    "reason": "Optionally tell us why you are no longer supporting Kanka. Was a feature missing? Did your financial situation change?"
                },
                "plans": {
                    "cost_monthly": "{currency} {amount} billed monthly",
                    "cost_yearly": "{currency} {amount} billed yearly"
                },
                "sub_status": "Subscription information",
                "subscription": {
                    "actions": {
                        "downgrading": "Please contact us for downgrading",
                        "rollback": "Change to Kobold",
                        "subscribe": "Change to {tier} monthly",
                        "subscribe_annual": "Change to {tier} yearly"
                    }
                },
                "success": {
                    "alternative": "Your payment was registered. You will get a notification as soon as it is processed and your subscription is active.",
                    "callback": "Your subscription was successful. Your account will be updated as soon as our payment provided informs us of the change (this might take a few minutes).",
                    "cancel": "Your subscription was cancelled. It will continue to be active until the end of your current billing period.",
                    "currency": "Your prefered currency setting was updated.",
                    "subscribed": "Your subscription was successful. Don't forget to subscribe to the Community Vote newsletter to be notified when a vote goes live. You can change your newsletter settings in your Profile page."
                },
                "tiers": "Subscription Tiers",
                "trial_period": "Yearly subscriptions have a 14 day cancellation policy. Contact us at {email} if you wish to cancel your yearly subscription and get a refund.",
                "upgrade_downgrade": {
                    "button": "Upgrade & Downgrade Information",
                    "downgrade": {
                        "bullets": {
                            "end": "Your current tier will stay active until the end of your current billing cycle, after which you will be downgraded to your new tier."
                        },
                        "title": "When downgrading to a lower tier"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "Your payment method will be billed immediately and you will have access to your new tier.",
                            "prorate": "When upgrading from Owlbear to Elemental, you will only be billed the difference to your new tier."
                        },
                        "title": "When upgrading to a higher tier"
                    }
                },
                "warnings": {
                    "incomplete": "We couldn't charge your credit card. Please update your credit card information, and we will try charging it again in the next few days. If it fails again, your subscription will be cancelled.",
                    "patreon": "Your account is currently linked with Patreon. Please unlink your account in your {patreon} settings before switching to a Kanka subscription."
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Create a new conversation",
                "success": "Conversation '{name}' created.",
                "title": "New Conversation"
            },
            "destroy": {
                "success": "Conversation '{name}' removed."
            },
            "edit": {
                "description": "Update the conversation",
                "success": "Conversation '{name}' updated.",
                "title": "Conversation {name}"
            },
            "fields": {
                "messages": "Messages",
                "name": "Name",
                "participants": "Participants",
                "target": "Target",
                "type": "Type"
            },
            "hints": {
                "participants": "Please add participants to your conversation by pressing on the {icon} icon on the upper-right."
            },
            "index": {
                "add": "New Conversation",
                "description": "Manage the category of {name}.",
                "header": "Conversations in {name}",
                "title": "Conversations"
            },
            "messages": {
                "destroy": {
                    "success": "Message removed."
                },
                "is_updated": "Updated",
                "load_previous": "Load previous messages",
                "placeholders": {
                    "message": "Your message"
                }
            },
            "participants": {
                "create": {
                    "success": "Participant {entity} added to the conversation."
                },
                "description": "Add or remove participants of a conversation",
                "destroy": {
                    "success": "Participant {entity} removed from the conversation."
                },
                "modal": "Participants",
                "title": "Participants of {name}"
            },
            "placeholders": {
                "name": "Name of the conversation",
                "type": "In Game, Prep, Plot"
            },
            "show": {
                "description": "A detailed view of a conversation",
                "title": "Conversation {name}"
            },
            "tabs": {
                "conversation": "Conversation",
                "participants": "Participants"
            },
            "targets": {
                "characters": "Characters",
                "members": "Members"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Actions",
                "apply": "Apply",
                "back": "Back",
                "copy": "Copy",
                "copy_mention": "Copy [ ] mention",
                "copy_to_campaign": "Copy to Campaign",
                "explore_view": "Nested View",
                "export": "Export (PDF)",
                "find_out_more": "Find out more",
                "go_to": "Go to {name}",
                "json-export": "Export (JSON)",
                "move": "Move",
                "new": "New",
                "next": "Next",
                "reset": "Reset"
            },
            "add": "Add",
            "alerts": {
                "copy_mention": "The entity's advanced mention was copied to your clipboard."
            },
            "attributes": {
                "actions": {
                    "apply_template": "Apply an Attribute Template",
                    "manage": "Manage",
                    "more": "More options",
                    "remove_all": "Delete All"
                },
                "fields": {
                    "attribute": "Attribute",
                    "community_templates": "Community Templates",
                    "is_private": "Private Attributes",
                    "is_star": "Pinned",
                    "template": "Template",
                    "value": "Value"
                },
                "helpers": {
                    "delete_all": "Are you sure you want to delete all of this entity's attributes?"
                },
                "hints": {
                    "is_private": "You can hide all the attributes of an entity for all members outside of the admin role by making it private."
                },
                "index": {
                    "success": "Attributes for {entity} updated.",
                    "title": "Attributes for {name}"
                },
                "placeholders": {
                    "attribute": "Number of conquests, Challenge Rating, Initiative, Population",
                    "block": "Block name",
                    "checkbox": "Checkbox name",
                    "section": "Section name",
                    "template": "Select a template",
                    "value": "Value of the attribute"
                },
                "template": {
                    "success": "Attribute Template {name} applied to {entity}",
                    "title": "Apply an Attribute Template for {name}"
                },
                "types": {
                    "attribute": "Attribute",
                    "block": "Block",
                    "checkbox": "Checkbox",
                    "section": "Section",
                    "text": "Multiline Text"
                },
                "visibility": {
                    "entry": "Attribute is displayed on the entity menu.",
                    "private": "Attribute only visible to members of the \"Admin\" role.",
                    "public": "Attribute visible to all members.",
                    "tab": "Attribute is displayed only on the Attributes tab."
                }
            },
            "boosted": "Boosted",
            "boosted_campaigns": "Boosted Campaigns",
            "bulk": {
                "actions": {
                    "edit": "Bulk Edit & Tagging"
                },
                "age": {
                    "helper": "You can use + and - before the number to update the age by that amount."
                },
                "delete": {
                    "title": "Deleting multiple entities",
                    "warning": "Are you sure you want to delete the selected entities?"
                },
                "edit": {
                    "tagging": "Action for tags",
                    "tags": {
                        "add": "Add",
                        "remove": "Remove"
                    },
                    "title": "Editing multiple entities"
                },
                "errors": {
                    "admin": "Only campaign admins can change the private status of entities.",
                    "general": "An error occurred processing your action. Please try again and contact us if the problem persists. Error message: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Override"
                    },
                    "helpers": {
                        "override": "If selected, permissions of the selected entities will be overwritten with these. If unchecked, the selected permissions will be added to the existing ones."
                    },
                    "title": "Change permissions for several entities"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} entity copied to {campaign}.|[2,*] {count} entities copied to {campaign}.",
                    "editing": "{1} {count} entity was updated.|[2,*] {count} entities were updated.",
                    "permissions": "{1} Permissions changed for {count} entity.|[2,*] Permissions changed for {count} entities.",
                    "private": "{1} {count} entity is now private|[2,*] {count} entities are now private.",
                    "public": "{1} {count} entity is now visible|[2,*] {count} entities are now visible."
                }
            },
            "cancel": "Cancel",
            "click_modal": {
                "close": "Close",
                "confirm": "Confirm",
                "title": "Confirm your action"
            },
            "copy_to_campaign": {
                "bulk_title": "Copy entities to another campaign",
                "panel": "Copy",
                "title": "Copy '{name}' to another campaign"
            },
            "create": "Create",
            "datagrid": {
                "empty": "Nothing to show yet."
            },
            "delete_modal": {
                "close": "Close",
                "delete": "Delete",
                "description": "Are you sure you want to remove {tag}?",
                "mirrored": "Remove mirrored relation.",
                "title": "Delete confirmation"
            },
            "destroy_many": {
                "success": "Deleted {count} entity|Deleted {count} entities."
            },
            "edit": "Edit",
            "errors": {
                "boosted": "This feature is only available to boosted campaigns.",
                "node_must_not_be_a_descendant": "Invalid node (tag, parent location): it would be a descendant of itself."
            },
            "events": {
                "hint": "Shown below is a list of all the Calendars in which this entity was added using the \"Add an event to a calendar\" interface."
            },
            "export": "Export",
            "fields": {
                "ability": "Ability",
                "attribute_template": "Attribute Template",
                "calendar": "Calendar",
                "calendar_date": "Calendar Date",
                "character": "Character",
                "colour": "Colour",
                "copy_attributes": "Copy Attributes",
                "copy_notes": "Copy Entity Notes",
                "creator": "Creator",
                "dice_roll": "Dice Roll",
                "entity": "Entity",
                "entity_type": "Entity Type",
                "entry": "Entry",
                "event": "Event",
                "excerpt": "Excerpt",
                "family": "Family",
                "files": "Files",
                "has_image": "Has an image",
                "header_image": "Header Image",
                "image": "Image",
                "is_private": "Private",
                "is_star": "Pinned",
                "item": "Item",
                "location": "Location",
                "map": "Map",
                "name": "Name",
                "organisation": "Organisation",
                "position": "Position",
                "race": "Race",
                "tag": "Tag",
                "tags": "Tags",
                "timeline": "Timeline",
                "tooltip": "Tooltip",
                "type": "Type",
                "visibility": "Visibility"
            },
            "files": {
                "actions": {
                    "drop": "Click to Add or Drop a file",
                    "manage": "Manage Entity Files"
                },
                "errors": {
                    "max": "You have reached the maximum number ({max}) of files for this entity.",
                    "no_files": "No files."
                },
                "files": "Uploaded Files",
                "hints": {
                    "limit": "Each entity can have a maximum of {max} files uploaded to it.",
                    "limitations": "Supported formats: {formats}. Max file size: {size}"
                },
                "title": "Entity Files for {name}"
            },
            "filter": "Filter",
            "filters": {
                "all": "Filter to all descendants",
                "clear": "Clear Filters",
                "direct": "Filter to direct descendants",
                "filtered": "Showing {count} of {total} {entity}.",
                "hide": "Hide Filters",
                "options": {
                    "exclude": "Exclude",
                    "include": "Include",
                    "none": "None"
                },
                "show": "Show Filters",
                "sorting": {
                    "asc": "{field} Ascending",
                    "desc": "{field} Descending",
                    "helper": "Control in which order results appear."
                },
                "title": "Filters"
            },
            "forms": {
                "actions": {
                    "calendar": "Add a calendar date"
                },
                "copy_options": "Copy Options"
            },
            "hidden": "Hidden",
            "hints": {
                "attribute_template": "Apply an attribute template directly when creating or editing this entity.",
                "calendar_date": "A calendar date allows easy filtering in lists, and also maintains a calendar event in the selected calendar.",
                "header_image": "This image is placed above the entity. For best results, use a wide image.",
                "image_limitations": "Supported formats: jpg, png and gif. Max file size: {size}.",
                "image_patreon": "Increase file size limit?",
                "is_private": "If set to private, this entity will only be visible to members who are in the campaign's \"Admin\" role.",
                "is_star": "Pinned elements will appear on the entity's menu",
                "map_limitations": "Supported formats: jpg, png, gif and svg. Max file size: {size}.",
                "tooltip": "Replace the automatically generated tooltip with the following contents.",
                "visibility": "Setting the visibility to admin means only members in the Admin campaign role can view this. Setting it to self means only you can view this."
            },
            "history": {
                "created": "Created by <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Created <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Unknown",
                "updated": "Last modified by <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Last modified <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "View entity log"
            },
            "image": {
                "error": "We weren't able to get the image you requested. It could be that the website doesn't allow us to download the image (typically for Squarespace and DeviantArt), or that the link is no longer valid. Please also make sure that the image isn't larger than {size}."
            },
            "is_not_private": "This entity isn't currently set to private.",
            "is_private": "This entity is private and only visible to members of the Admin role.",
            "linking_help": "How can I link to other entries?",
            "manage": "Manage",
            "move": {
                "description": "Move this entity to another place",
                "errors": {
                    "permission": "You aren't allowed to create entities of that type in the target campaign.",
                    "same_campaign": "You need to select another campaign to move the entity to.",
                    "unknown_campaign": "Unknown campaign."
                },
                "fields": {
                    "campaign": "New campaign",
                    "copy": "Make a copy",
                    "target": "New type"
                },
                "hints": {
                    "campaign": "You can also try to move this entity to another campaign.",
                    "copy": "Select this option if you want to create copy in the new campaign.",
                    "target": "Please be aware that some data might be lost when moving an element from one type to another."
                },
                "success": "Entity '{name}' moved.",
                "success_copy": "Entity '{name}' copied.",
                "title": "Move {name}"
            },
            "new_entity": {
                "error": "Please review your values.",
                "fields": {
                    "name": "Name"
                },
                "title": "New entity"
            },
            "or_cancel": "or <a href=\"{url}\">cancel</a>",
            "panels": {
                "appearance": "Appearance",
                "attribute_template": "Attribute Template",
                "calendar_date": "Calendar Date",
                "entry": "Entry",
                "general_information": "General Information",
                "move": "Move",
                "system": "System"
            },
            "permissions": {
                "action": "Action",
                "actions": {
                    "bulk": {
                        "add": "Allow",
                        "deny": "Deny",
                        "ignore": "Skip",
                        "remove": "Remove"
                    },
                    "bulk_entity": {
                        "allow": "Allow",
                        "deny": "Deny",
                        "inherit": "Inherit"
                    },
                    "delete": "Delete",
                    "edit": "Edit",
                    "entity_note": "Entity Notes",
                    "read": "Read",
                    "toggle": "Toggle"
                },
                "allowed": "Allowed",
                "fields": {
                    "member": "Member",
                    "role": "Role"
                },
                "helper": "Use this interface to fine-tune which users and roles that can interact with this entity. {allow}",
                "helpers": {
                    "setup": "Use this interface to fine-tune how roles and users can interact with this entity. {allow} will allow the user or role to do this action. {deny} will deny them that action. {inherit} will use the user's role or main role's permission. A user set to {allow} is able to do the action, even if their role is set to {deny}."
                },
                "inherited": "This role already has this permission set for this entity type.",
                "inherited_by": "This user is part of the '{role}' role which grants this permissions on this entity type.",
                "success": "Permissions saved.",
                "title": "Permissions",
                "too_many_members": "This campaign has too many members (>10) to display in this interface. Please use the Permission button on the entity view to control permissions in detail."
            },
            "placeholders": {
                "ability": "Choose an ability",
                "calendar": "Choose a calendar",
                "character": "Choose a character",
                "entity": "Entity",
                "event": "Choose an event",
                "family": "Choose a family",
                "image_url": "You can upload an image from a URL instead",
                "item": "Choose an item",
                "journal": "Choose a journal",
                "location": "Choose a location",
                "map": "Choose a map",
                "organisation": "Choose an organisation",
                "race": "Choose a race",
                "tag": "Choose a tag"
            },
            "relations": {
                "actions": {
                    "add": "Add a relation"
                },
                "fields": {
                    "location": "Location",
                    "name": "Name",
                    "relation": "Relation"
                },
                "hint": "Relations between entities can be set up to represent their connections."
            },
            "remove": "Remove",
            "rename": "Rename",
            "save": "Save",
            "save_and_close": "Save and Close",
            "save_and_copy": "Save and Copy",
            "save_and_new": "Save and New",
            "save_and_update": "Save and Edit",
            "save_and_view": "Save and View",
            "search": "Search",
            "select": "Select",
            "tabs": {
                "abilities": "Abilities",
                "attributes": "Attributes",
                "boost": "Boost",
                "calendars": "Calendars",
                "default": "Default",
                "events": "Events",
                "inventory": "Inventory",
                "map-points": "Map Points",
                "mentions": "Mentions",
                "menu": "Menu",
                "notes": "Entity Notes",
                "permissions": "Permissions",
                "relations": "Relations",
                "reminders": "Reminders",
                "timelines": "Timelines",
                "tooltip": "Tooltip"
            },
            "update": "Update",
            "users": {
                "unknown": "Unknown"
            },
            "view": "View",
            "visibilities": {
                "admin": "Admin",
                "admin-self": "Self & Admin",
                "all": "All",
                "self": "Self"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "en-US": {
        "calendars": [],
        "crud": {
            "fields": {
                "colour": "Color",
                "organisation": "Organization"
            },
            "placeholders": {
                "organisation": "Choose an organization"
            }
        },
        "randomisers": []
    },
    "es": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Cambiar a inicio de sesión en Kanka",
                    "update_email": "Actualizar email",
                    "update_password": "Actualizar contraseña"
                },
                "description": "Actualizar cuenta",
                "email": "Cambiar email",
                "email_success": "Email actualizado.",
                "password": "Cambiar contraseña",
                "password_success": "Contraseña actualizada.",
                "social": {
                    "error": "Ya estás utilizando el inicio de sesión de Kanka con esta cuenta.",
                    "helper": "Tu cuenta está vinculada con {provider}. Puedes dejar de usarla y cambiar al inicio de sesión estándar de Kanka escribiendo una contraseña.",
                    "success": "Tu cuenta ahora usa el inicio de sesión de Kanka.",
                    "title": "De social a Kanka"
                },
                "title": "Cuenta"
            },
            "api": {
                "description": "Actualizar configuración de API",
                "experimental": "¡Bienvenido a las APIs de Kanka! Estas prestaciones aún son experimentales pero deberían ser lo suficientemente estables para que puedas comunicarte con las APIs. Crea un Token de Acceso Personal para usar en tus solicitudes de API, o usa el Token Cliente si quieres que tu app tenga acceso a datos de usuario.",
                "help": "Kanka ofrecerá próximamente una RESTful API para que aplicaciones terceras puedan conectarse a la app. Aquí se irán mostrando los detalles sobre cómo gestionar tus claves API.",
                "link": "Leer la documentación de la API",
                "request_permission": "Actualmente estamos construyendo una poderosa RESTful API para que aplicaciones terceras puedan conectarse a la app. Sin embargo, de momento limitamos el número de usuarios que pueden interactuar con la API mientras la pulimos. Si quieres acceder a la API y construir apps guays que interactúan con Kanka, contáctanos y te enviaremos toda la información que necesitas.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Conectar",
                    "remove": "Eliminar"
                },
                "benefits": "Kanka ofrece algunas integraciones con servicios de terceros. Hay más integraciones planeadas para el futuro.",
                "discord": {
                    "errors": {
                        "add": "Ha ocurrido un error tratando de vincular tu cuenta de Discord con Kanka. Por favor, inténtalo de nuevo."
                    },
                    "success": {
                        "add": "Se ha vinculado tu cuenta de Discord.",
                        "remove": "Se ha desvinculado tu cuenta de Discord."
                    },
                    "text": "Accede a los roles de suscripción automáticamente."
                },
                "title": "Integración de aplicaciones"
            },
            "boost": {
                "benefits": {
                    "first": "Para asegurar un progreso contínuo en Kanka, algunas características de campaña se pueden desbloquear mejorando la campaña. Las mejoras se desbloquean mediante {patreon}. Cualquiera que pueda ver una campaña puede mejorarla; así el máster no tiene que pagar la cuenta siempre. Una campaña permanece mejorada mientras un usuario la esté mejorando y continúe apoyando a Kanka en {patreon}. Si una campaña deja de estar mejorada, los datos no se pierden: solo permanecen ocultos hasta que la campaña vuelva a ser mejorada.",
                    "header": "Imágenes de cabecera para las entidades.",
                    "images": "Imágenes por defecto personalizadas",
                    "more": "Saber más sobre todas las características.",
                    "second": "Mejorar una campaña activa los siguientes beneficios:",
                    "theme": "Tema y estilo personalizado a nivel de campaña.",
                    "third": "Para mejorar una campaña, dirígete a la página de la campaña y haz clic en el botón de \"{boost_button}\" que hay sobre el botón de \"{edit_button}\".",
                    "tooltip": "Descripciones emergentes personalizadas para las entidades.",
                    "upload": "Capacidad de subida de archivos ampliada para todos los miembros de la campaña."
                },
                "buttons": {
                    "boost": "Mejorar"
                },
                "campaigns": "Campañas mejoradas {count} / {max}",
                "exceptions": {
                    "already_boosted": "La campaña {name} ya está mejorada.",
                    "exhausted_boosts": "Te has quedado sin mejoras. Elimina tu mejora de una campaña antes de dársela a otra."
                },
                "success": {
                    "boost": "Campaña {name} mejorada.",
                    "delete": "Tu mejora de {name} se ha eliminado."
                },
                "title": "Mejorar"
            },
            "countries": {
                "austria": "Austria",
                "belgium": "Bégica",
                "france": "Francia",
                "germany": "Alemania",
                "italy": "Italia",
                "netherlands": "Holanda",
                "spain": "España"
            },
            "invoices": {
                "actions": {
                    "download": "Descargar PDF",
                    "view_all": "Ver todas"
                },
                "empty": "Sin facturas",
                "fields": {
                    "amount": "Cantidad",
                    "date": "Fecha",
                    "invoice": "Factura",
                    "status": "Estado"
                },
                "header": "Puedes descargar tus últimas 24 facturas a continuación.",
                "status": {
                    "paid": "Pagada",
                    "pending": "Pendiente"
                },
                "title": "Facturas"
            },
            "layout": {
                "description": "Actualizar opciones de diseño",
                "success": "Opciones de diseño actualizadas.",
                "title": "Diseño"
            },
            "menu": {
                "account": "Cuenta",
                "api": "API",
                "apps": "Aplicaciones",
                "billing": "Método de pago",
                "boost": "Mejorar",
                "invoices": "Facturas",
                "layout": "Diseño",
                "other": "Otros",
                "patreon": "Patreon",
                "payment_options": "Opciones de pago",
                "personal_settings": "Ajustes personales",
                "profile": "Perfil",
                "subscription": "Suscripción",
                "subscription_status": "Estado de la suscripción"
            },
            "patreon": {
                "actions": {
                    "link": "Enlazar cuenta",
                    "view": "Visita la página de Patreon de Kanka"
                },
                "benefits": "Si nos ayudas en Patreon podrás subir imágenes más pesadas, y así nos ayudarás a cubrir los costes del servidor y a dedicarle más tiempo a trabajar en Kanka.",
                "benefits_features": "Funciones increíbles",
                "deprecated": "Funcionalidad discontinuada. Si deseas apoyar a Kanka, puedes hacerlo mediante una {subscription}. La vinculación con Patreon aún sigue activa para nuestros Patrons que vincularon sus cuentas antes de la mudanza de Patreon.",
                "description": "Sincronizando con Patreon",
                "errors": {
                    "invalid_token": "¡Token no válido! Patreon no ha podido validar tu petición.",
                    "missing_code": "¡Falta el código! Patreon no ha enviado un código para identificar tu cuenta.",
                    "no_pledge": "¡Sin \"pledge\"! Patreon ha identificado tu cuenta, pero no detecta ningún \"pledge\" activo."
                },
                "link": "Usa el siguiente botón si estás apoyando a Kanka en Patreon actualmente. ¡Esto te dará acceso a más cosas fantásticas extras!",
                "linked": "¡Gracias por apoyar a Kanka en Patreon! Se ha enlazado tu cuenta.",
                "pledge": "Pledge {name}",
                "remove": {
                    "button": "Desvincular mi cuenta de Patreon",
                    "success": "Tu cuenta de Patreon se ha desvinculado.",
                    "text": "Desvincular tu cuenta de Patreon de Kanka eliminará tus bonus, tu nombre en el salón de la fama, tus mejoras y otras funcionalidades vinculadas. Sin embargo, tu contenido mejorado no se perderá: si vuelves a suscribirte, volverás a tener acceso a esos datos, incluyendo la posibilidad de volver a mejorar dicha campaña.",
                    "title": "Desvincular mi cuenta de Patreon de Kanka"
                },
                "success": "¡Gracias por apoyar a Kanka en Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Añadimos manualmente tu nivel de \"pledge\", así que ten en cuenta que podemos tardar unos pocos días. Si al cabo de un tiempo sigue sin estar bien, contáctanos por favor."
            },
            "profile": {
                "actions": {
                    "update_profile": "Actualizar perfil"
                },
                "avatar": "Foto de perfil",
                "description": "Actualizar perfil",
                "success": "Perfil actualizado.",
                "title": "Perfil personal"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Cancelar suscripción",
                    "subscribe": "Suscribirse",
                    "update_currency": "Guardar moneda preferida"
                },
                "benefits": "Si nos apoyas, desbloquearás algunas nuevas {features} y nos ayudarás a dedicar más tiempo a la mejora de Kanka. No guardaremos tu información bancaria. Usamos {stripe} para gestionar los cobros.",
                "billing": {
                    "helper": "Tu información de pago se procesa y se guarda de forma segura mediante {stripe}. Este método de pago se usará para todas tus suscripciones.",
                    "saved": "Método de pago guardado",
                    "title": "Editar método de pago"
                },
                "cancel": {
                    "text": "¡Lamentamos verte marchar! Al cancelar tu suscripción, esta seguirá activa hasta el nuevo ciclo de facturación, tras lo cual perderás tus mejoras de campaña y otros beneficios relacionados. No tengas miedo de informarnos sobre cómo podemos mejorar o qué te ha llevado a tomar esta decisión."
                },
                "cancelled": "Se ha cancelado tu suscripción. Puedes renovarla una vez el período de la suscripción actual termine.",
                "change": {
                    "text": {
                        "monthly": "Estás suscribiéndote al nivel {tier}, que cuesta {amount} mensuales.",
                        "yearly": "Estás suscribiéndote al nivel {tier}, que cuesta {amount} anuales."
                    },
                    "title": "Cambiar nivel de suscripción"
                },
                "currencies": {
                    "eur": "Euros",
                    "usd": "Dólares estadounidenses"
                },
                "currency": {
                    "title": "Cambia la moneda de facturación"
                },
                "errors": {
                    "callback": "Nuestro proveedor de pagos nos ha informado de un error. Por favor, vuelve a intentarlo o infórmanos si el problema persiste.",
                    "subscribed": "No se ha podido procesar tu suscripción. Stripe nos ha dado este mensaje:"
                },
                "fields": {
                    "active_since": "Activa desde",
                    "active_until": "Activa hasta",
                    "billed_monthly": "Cobro mensual",
                    "billing": "Cobro",
                    "currency": "Moneda de cobro",
                    "payment_method": "Método de pago",
                    "plan": "Plan actual",
                    "reason": "Razón"
                },
                "helpers": {
                    "alternatives": "Paga por tu suscripción usando {method}. Este método de pago no se renovará automáticamente al final de tu suscripción. {method} solo está disponible en euros.",
                    "alternatives_warning": "No se puede mejorar la suscripción usando este método. Por favor, crea una nueva suscripción cuando la actual termine.",
                    "alternatives_yearly": "Debido a las restricciones de los pagos recurrentes, {method} solo está disponible para las suscripciones anuales."
                },
                "manage_subscription": "Gestionar suscripción",
                "payment_method": {
                    "actions": {
                        "add_new": "Añadir nuevo método de pago",
                        "change": "Cambiar método de pago",
                        "save": "Guardar método de pago",
                        "show_alternatives": "Métodos de pago alternativos"
                    },
                    "add_one": "Aún no tienes ningún método de pago guardado.",
                    "alternatives": "Puedes suscribirte usando estos métodos de pago alternativos. Esto hará un solo cobro en tu cuenta y no se renovará automáticamente cada mes.",
                    "card": "Tarjeta",
                    "card_name": "Nombre en la tarjeta",
                    "country": "País de residencia",
                    "ending": "Termina en",
                    "helper": "Se usará esta tarjeta para todas tus suscripciones.",
                    "new_card": "Añadir nuevo método de pago",
                    "saved": "{brand} que termina en {last4}"
                },
                "placeholders": {
                    "reason": "Opcionalmente, puedes contarnos por qué ya no apoyas a Kanka. ¿Faltaba algo? ¿Cambió tu situación financiera?"
                },
                "plans": {
                    "cost_monthly": "{amount} {currency} mensuales",
                    "cost_yearly": "{amount} {currency} anuales"
                },
                "sub_status": "Información sobre la suscripción",
                "subscription": {
                    "actions": {
                        "downgrading": "Contáctanos para bajar de nivel",
                        "rollback": "Cambiar a Kobold",
                        "subscribe": "Cambiar a {tier} al mes",
                        "subscribe_annual": "Cambiar a {tier} anualmente"
                    }
                },
                "success": {
                    "alternative": "Se ha registrado tu pago. Recibirás una notificación en cuanto terminemos de procesarlo y se active tu suscripción.",
                    "callback": "Tu suscripción ha tenido éxito. Tu cuenta será actualizada en cuanto nuestro proveedor de pagos nos informe del cambio (puede llevar algunos minutos).",
                    "cancel": "Se ha cancelado tu suscripción. Continuará activa hasta el final del período de pago.",
                    "currency": "Se ha actualizado tu moneda preferida.",
                    "subscribed": "Tu suscripción ha tenido éxito. ¡No te olvides de suscribirte a la newsletter de votaciones comunitarias para enterarte cuando se abra una votación! Puedes cambiar tu configuración de newsletters en tu perfil."
                },
                "tiers": "Niveles de suscripción",
                "trial_period": "Las suscripciones anuales tienen un período de cancelación de 14 días. Contáctanos en {email} si quieres cancelar tu suscripción anual y recuperar el dinero.",
                "upgrade_downgrade": {
                    "button": "Información acerca de subir o bajar de nivel",
                    "downgrade": {
                        "bullets": {
                            "end": "Tu nivel actual estará activo hasta el final de tu ciclo de pago actual, tras el cual se bajará tu suscripción al nuevo nivel."
                        },
                        "title": "Bajar de nivel"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "Se cobrará en tu método de pago inmediatamente y tendrás acceso al nuevo nivel.",
                            "prorate": "Al subir de nivel de Owlbear a Elemental, solo se te cobrará la diferencia entre los dos niveles."
                        },
                        "title": "Subir de nivel"
                    }
                },
                "warnings": {
                    "incomplete": "No hemos podido hacer el cobro en tu tarjeta de crédito. Por favor, actualiza la información de la tarjeta y volveremos a intentarlo en los próximos días. Si vuelve a fallar, tu suscripción será cancelada.",
                    "patreon": "Tu cuenta se encuentra vinculada con Patreon. Desvincúlala en la configuración de {patreon} antes de cambiarla por una suscripción de Kanka."
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Crear nueva conversación",
                "success": "Conversación \"{name}\" creada.",
                "title": "Nueva Conversación"
            },
            "destroy": {
                "success": "Conversación \"{name}\" eliminada."
            },
            "edit": {
                "description": "Actualizar la conversación",
                "success": "Conversación \"{name}\" actualizada.",
                "title": "Conversación {name}"
            },
            "fields": {
                "messages": "Mensajes",
                "name": "Nombre",
                "participants": "Participantes",
                "target": "Objetivo",
                "type": "Tipo"
            },
            "hints": {
                "participants": "Añade participantes a la conversación mediante el icono {icon} arriba a la derecha."
            },
            "index": {
                "add": "Nueva conversación",
                "description": "Gestiona las conversaciones de {name}.",
                "header": "Conversaciones de {name}",
                "title": "Conversaciones"
            },
            "messages": {
                "destroy": {
                    "success": "Mensaje eliminado."
                },
                "is_updated": "Actualizado",
                "load_previous": "Cargar mensajes previos",
                "placeholders": {
                    "message": "Tu mensaje"
                }
            },
            "participants": {
                "create": {
                    "success": "El participante {entity} se ha añadido a la conversación."
                },
                "description": "Añadir o eliminar participantes de una conversación",
                "destroy": {
                    "success": "El participante {entity} se ha eliminado de la conversación."
                },
                "modal": "Participantes",
                "title": "Participantes de {name}"
            },
            "placeholders": {
                "name": "Nombre de la conversación",
                "type": "Dentro del juego, Preparación, Argumento..."
            },
            "show": {
                "description": "Vista detallada de conversación",
                "title": "Conversación {name}"
            },
            "tabs": {
                "conversation": "Conversación",
                "participants": "Participantes"
            },
            "targets": {
                "characters": "Personajes",
                "members": "Miembros"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Acciones",
                "apply": "Aplicar",
                "back": "Atrás",
                "copy": "Copiar",
                "copy_mention": "Copiar mención [ ]",
                "copy_to_campaign": "Copiar a campaña",
                "explore_view": "Vista anidada",
                "export": "Exportar",
                "find_out_more": "Saber más",
                "go_to": "Ir a {name}",
                "json-export": "Exportar (JSON)",
                "move": "Mover",
                "new": "Nuevo",
                "next": "Siguiente",
                "reset": "Restablecer"
            },
            "add": "Añadir",
            "alerts": {
                "copy_mention": "La mención avanzada de la entidad se ha copiado al portapapeles."
            },
            "attributes": {
                "actions": {
                    "add": "Añadir atributo",
                    "add_block": "Añadir bloque",
                    "add_checkbox": "Añadir casilla",
                    "add_text": "Añadir texto",
                    "apply_template": "Aplicar plantilla de atributos",
                    "manage": "Administrar",
                    "more": "Más opciones",
                    "remove_all": "Eliminar todos"
                },
                "create": {
                    "description": "Crear nuevo atributo",
                    "success": "Atributo {name} añadido a {entity}.",
                    "title": "Nuevo atributo para {name}"
                },
                "destroy": {
                    "success": "Atributo {name} de {entity} eliminado."
                },
                "edit": {
                    "description": "Actualizar un atributo existente",
                    "success": "Atributo {name} de {entity} actualizado.",
                    "title": "Actualizar atributo de {name}"
                },
                "fields": {
                    "attribute": "Atributo",
                    "community_templates": "Plantillas de la comunidad",
                    "is_private": "Atributos privados",
                    "is_star": "Fijado",
                    "template": "Plantilla",
                    "value": "Valor"
                },
                "helpers": {
                    "delete_all": "¿Seguro que quieres eliminar todos los atributos de esta entidad?"
                },
                "hints": {
                    "is_private": "Oculta todos los atributos de una entidad a todos los miembros no administradores haciéndola privada."
                },
                "index": {
                    "success": "Atributos de {entity} actualizados.",
                    "title": "Atributos de {name}"
                },
                "placeholders": {
                    "attribute": "Número de conquistas, Iniciativa, Población...",
                    "block": "Nombre del bloque",
                    "checkbox": "Nombre de la casilla",
                    "section": "Nombre de la sección",
                    "template": "Seleccionar plantilla",
                    "value": "Valor del atributo"
                },
                "template": {
                    "success": "Plantilla de atributos {name} aplicada a {entity}",
                    "title": "Aplicar plantilla de atributos a {name}"
                },
                "types": {
                    "attribute": "Atributo",
                    "block": "Bloque",
                    "checkbox": "Casilla",
                    "section": "Sección",
                    "text": "Texto multilínea"
                },
                "visibility": {
                    "entry": "El atributo se muestra en el menú de la entidad.",
                    "private": "Atributo visible solo para miembros con el rol \"Admin\".",
                    "public": "Atributo visible por todos los miembros.",
                    "tab": "El atributo se muestra solo en la pestaña de Atributos."
                }
            },
            "boosted": "mejorada",
            "boosted_campaigns": "Campañas mejoradas",
            "bulk": {
                "actions": {
                    "edit": "Editar y etiquetar en lote"
                },
                "age": {
                    "helper": "Puedes usar + y - antes del número para modificar la edad."
                },
                "delete": {
                    "title": "Eliminar múltiples entidades",
                    "warning": "¿Seguro que quieres eliminar las entidades seleccionadas?"
                },
                "edit": {
                    "tagging": "Acción para las etiquetas",
                    "tags": {
                        "add": "Añadir",
                        "remove": "Eliminar"
                    },
                    "title": "Edición múltiple"
                },
                "errors": {
                    "admin": "Solamente los administradores de la campaña pueden cambiar el estatus privado de las entidades.",
                    "general": "Ha habido un error al procesar la acción. Vuelve a intentarlo o contáctanos si el problema persiste. Mensaje de error: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Ignorar"
                    },
                    "helpers": {
                        "override": "Si está seleccionado, los permisos de las entidades seleccionadas serán ignorados y usarán estos ajustes en su lugar. Si no está seleccionado, estos permisos se añadirán a los existentes."
                    },
                    "title": "Cambiar permisos a varias entidades"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} entidad copiada a {campaign}.|[2,*] {count} entidades copiadas a {campaign}.",
                    "editing": "{1} Se ha actualizado {count} entidad .|[2,*] Se han actualizado {count} entidades.",
                    "permissions": "{1} Permisos cambiados en {count} entidad.|[2,*] Permisos cambiados en {count} entidades.",
                    "private": "{1} Ahora {count} entidad es privada.|[2,*] Ahora {count} entidades son privadas.",
                    "public": "{1} Ahora {count} entidad es visible|[2,*] Ahora {count} son visibles."
                }
            },
            "cancel": "Cancelar",
            "click_modal": {
                "close": "Cerrar",
                "confirm": "Confirmar",
                "title": "Confirmar acción"
            },
            "copy_to_campaign": {
                "bulk_title": "Copiar entidades a otra campaña",
                "panel": "Copiar",
                "title": "Copiar \"{name}\" a otra campaña"
            },
            "create": "Crear",
            "datagrid": {
                "empty": "Aún no hay nada que mostrar."
            },
            "delete_modal": {
                "close": "Cerrar",
                "delete": "Eliminar",
                "description": "¿Seguro que quieres eliminar {tag}?",
                "mirrored": "Eliminar relación reflejada",
                "title": "Eliminar"
            },
            "destroy_many": {
                "success": "{1} Se ha eliminado {count} entidad .|[2,*] Se han eliminado {count} entidades."
            },
            "edit": "Editar",
            "errors": {
                "boosted": "Esta función solo está disponible para las campañas mejoradas.",
                "node_must_not_be_a_descendant": "Nodo inválido (etiqueta, localización superior): sería un descendiente de sí mismo."
            },
            "events": {
                "hint": "Los eventos del calendario asociados a esta entidad se muestran aquí."
            },
            "export": "Exportar",
            "fields": {
                "ability": "Habilidad",
                "attribute_template": "Plantilla de atributos",
                "calendar": "Calendario",
                "calendar_date": "Fecha del calendario",
                "character": "Personaje",
                "colour": "Color",
                "copy_attributes": "Copiar atributos",
                "copy_notes": "Copiar notas de la entidad",
                "creator": "Creador",
                "dice_roll": "Tirada de dados",
                "entity": "Entidad",
                "entity_type": "Tipo de entidad",
                "entry": "Entrada",
                "event": "Evento",
                "excerpt": "Extracto",
                "family": "Familia",
                "files": "Archivos",
                "has_image": "Tiene imagen",
                "header_image": "Imagen de cabecera",
                "image": "Imagen",
                "is_private": "Privado",
                "is_star": "Fijada",
                "item": "Objeto",
                "location": "Localización",
                "map": "Mapa",
                "name": "Nombre",
                "organisation": "Organización",
                "position": "Posición",
                "race": "Raza",
                "tag": "Etiqueta",
                "tags": "Etiquetas",
                "timeline": "Línea de tiempo",
                "tooltip": "Descripción emergente",
                "type": "Tipo",
                "visibility": "Visibilidad"
            },
            "files": {
                "actions": {
                    "drop": "Haz clic para añadir o arrastra un archivo",
                    "manage": "Administrar archivos de la entidad"
                },
                "errors": {
                    "max": "Has alcanzado el número máximo ({max}) de archivos para esta entidad.",
                    "no_files": "No hay archivos."
                },
                "files": "Archivos subidos",
                "hints": {
                    "limit": "Cada entidad puede tener un máximo de {max} archivos.",
                    "limitations": "Formatos soportados: jpg, png, gif y pdf. Tamaño máximo de archivo: {size}"
                },
                "title": "Archivos de {name}"
            },
            "filter": "Filtrar",
            "filters": {
                "all": "Mostrar todos los descendientes",
                "clear": "Quitar filtros",
                "direct": "Filtrar solo los descendientes directos",
                "filtered": "Mostrando {count} de {total} {entity}.",
                "hide": "Ocultar filtros",
                "options": {
                    "exclude": "Excluir",
                    "include": "Incluir",
                    "none": "Nada"
                },
                "show": "Mostrar filtros",
                "sorting": {
                    "asc": "Ascendiente por {field}",
                    "desc": "Descendiente por {field}",
                    "helper": "Controla en qué orden aparecen los resultados."
                },
                "title": "Filtros"
            },
            "forms": {
                "actions": {
                    "calendar": "Añadir fecha de calendario"
                },
                "copy_options": "Opciones de copia"
            },
            "hidden": "Oculto",
            "hints": {
                "attribute_template": "Aplica una plantilla de atributos directamente al crear esta entidad.",
                "calendar_date": "Las fechas de calendario hacen que sea más fácil filtrar las listas, y también fijan los eventos al calendario seleccionado.",
                "header_image": "Esta imagen está situada sobre la entidad. Para obtener mejores resultados, usa una imagen apaisada.",
                "image_limitations": "Formatos soportados: jpg, png y gif. Tamaño máximo del archivo: {size}.",
                "image_patreon": "¿Cómo se puede aumentar el tamaño máximo de los archivos?",
                "is_private": "Si es privada, esta entidad solo se mostrará a los miembros de la campaña que tengan el rol \"Admin\".",
                "is_star": "Los elementos fijados aparecerán en el menú principal de la entidad.",
                "map_limitations": "Formatos soportados: jpg, png, gif y svg. Tamaño máximo del archivo: {size}.",
                "tooltip": "Reemplaza la descripción emergente automática con el siguiente contenido.",
                "visibility": "Al seleccionar \"Administrador\", solo los miembros con el rol de administrador podrán ver esto. \"Solo yo\" significa que solo tú puedes ver esto."
            },
            "history": {
                "created": "Creado por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Creado el <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Desconocido",
                "updated": "Última modificación por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Última modificación <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Historial de cambios de la entidad"
            },
            "image": {
                "error": "No hemos podido obtener la imagen. Puede que la página web no nos permita descargarla (típico de Squarespace o DeviantArt), o que el enlace ya no sea válido. Asegúrate también de que la imagen no supera los {size}."
            },
            "is_not_private": "Esta entidad no es privada.",
            "is_private": "Esta entidad es privada y solo pueden verla los administradores.",
            "linking_help": "¿Como se enlazan otras entradas?",
            "manage": "Administrar",
            "move": {
                "description": "Mover esta entidad a otro lugar",
                "errors": {
                    "permission": "No tienes permiso para crear entidades de este tipo en la campaña seleccionada.",
                    "same_campaign": "Debes seleccionar otra campaña donde mover la entidad.",
                    "unknown_campaign": "Campaña desconocida."
                },
                "fields": {
                    "campaign": "Nueva campaña",
                    "copy": "Hacer una copia",
                    "target": "Nuevo tipo"
                },
                "hints": {
                    "campaign": "También puedes intentar mover esta entidad a otra campaña.",
                    "copy": "Selecciona esta opción si quieres crear una copia en la nueva campaña.",
                    "target": "Ten en cuenta que algunos datos pueden perderse al mover un elemento de un tipo a otro."
                },
                "success": "Entidad '{name}' movida.",
                "success_copy": "Entidad '{name}' copiada.",
                "title": "Mover {name}"
            },
            "new_entity": {
                "error": "Revisa los datos introducidos.",
                "fields": {
                    "name": "Nombre"
                },
                "title": "Nueva entidad"
            },
            "or_cancel": "o <a href=\"{url}\">Cancelar</a>",
            "panels": {
                "appearance": "Apariencia",
                "attribute_template": "Plantilla de atributos",
                "calendar_date": "Fecha de calendario",
                "entry": "Presentación",
                "general_information": "Información general",
                "move": "Mover",
                "system": "Sistema"
            },
            "permissions": {
                "action": "Acción",
                "actions": {
                    "bulk": {
                        "add": "Permitir",
                        "deny": "Denegar",
                        "ignore": "Ignorar",
                        "remove": "Quitar"
                    },
                    "bulk_entity": {
                        "allow": "Permitir",
                        "deny": "Denegar",
                        "inherit": "Heredar"
                    },
                    "delete": "Eliminar",
                    "edit": "Editar",
                    "entity_note": "Notas de entidad",
                    "read": "Leer",
                    "toggle": "Cambiar"
                },
                "allowed": "Permitido",
                "fields": {
                    "member": "Miembro",
                    "role": "Rol"
                },
                "helper": "Desde aquí puedes afinar qué usuarios y roles pueden interactuar con esta entidad.",
                "helpers": {
                    "entity_note": "Permite a los usuarios crear notas dentro de esta entidad. Sin este permiso, podrán seguir viendo las notas de entidad que se muestren a todos.",
                    "setup": "Desde aquí puedes afinar cómo los diferentes roles y usuarios pueden interactuar con esta entidad. {allow} les permitirá hacer dicha acción; {deny} se la denegará, y {inherit} usará el permiso que ya tenga el rol o usuario. Un usuario con una acción puesta en {allow} podrá hacerla, aunque su rol esté en {deny}."
                },
                "inherited": "Este rol ya tiene este permiso en esta entidad.",
                "inherited_by": "Este usuario forma parte del rol \"{role}\", que le otorga este permiso en esta entidad.",
                "success": "Permisos guardados.",
                "title": "Permisos",
                "too_many_members": "Esta campaña tiene demasiados miembros (>10) para poder mostrarlos todos aquí. Usa el botón de permisos en la vista de entidad para controlar los permisos detalladamente."
            },
            "placeholders": {
                "ability": "Escoge una habilidad",
                "calendar": "Escoge un calendario",
                "character": "Escoge un personaje",
                "entity": "Entidad",
                "event": "Elige un evento",
                "family": "Elige una familia",
                "image_url": "Puedes subir una imagen desde una URL",
                "item": "Elige un objeto",
                "location": "Elige una localización",
                "map": "Elige un mapa",
                "organisation": "Elige una organización",
                "race": "Elige una raza",
                "tag": "Elige una etiqueta"
            },
            "relations": {
                "actions": {
                    "add": "Añadir relación"
                },
                "fields": {
                    "location": "Localización",
                    "name": "Nombre",
                    "relation": "Relación"
                },
                "hint": "Se pueden relacionar entidades para representar sus conexiones."
            },
            "remove": "Eliminar",
            "rename": "Renombrar",
            "save": "Guardar",
            "save_and_close": "Guardar y cerrar",
            "save_and_copy": "Guardar y copiar",
            "save_and_new": "Guardar y crear nuevo",
            "save_and_update": "Guardar y seguir editando",
            "save_and_view": "Guardar y ver",
            "search": "Buscar",
            "select": "Seleccionar",
            "tabs": {
                "abilities": "Habilidades",
                "attributes": "Atributos",
                "boost": "Mejorar",
                "calendars": "Calendarios",
                "default": "Por defecto",
                "events": "Eventos",
                "inventory": "Inventario",
                "map-points": "Puntos del mapa",
                "mentions": "Menciones",
                "menu": "Menú",
                "notes": "Notas",
                "permissions": "Permisos",
                "relations": "Relaciones",
                "reminders": "Recordatorios",
                "timelines": "Líneas de tiempo",
                "tooltip": "Descripción emergente"
            },
            "update": "Actualizar",
            "users": {
                "unknown": "Desconocido"
            },
            "view": "Ver",
            "visibilities": {
                "admin": "Admin",
                "admin-self": "Yo + Admin",
                "all": "Todos",
                "self": "Solo yo"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "fr": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Changer au login Kanka",
                    "update_email": "Modifier l'email",
                    "update_password": "Modifier le mot de passe"
                },
                "email": "Modification de l'email",
                "email_success": "Email modifié.",
                "password": "Modification du mot de passe",
                "password_success": "Mot de passe modifié.",
                "social": {
                    "error": "Tu utilises déjà le login Kanka pour ce compte.",
                    "helper": "Ton compte est géré par {provider}. Tu peux changer au login Kanka en fournissant un login et un mot de passe.",
                    "success": "Ton compte utilise dorénavant le login Kanka.",
                    "title": "Social à Kanka"
                },
                "title": "Compte"
            },
            "api": {
                "experimental": "Bienvenue aux API de Kanka! Ces fonctionnalités sont encore experimentales mais assez stables pour que tu puisses intéragir avec les APIs. Crée un jeton personnel à utiliser dans tes requêtes API, ou un jeton client pour permettre à ton app d'accéder à tes données.",
                "help": "Kanka va prochainement mettre à disposition une API.",
                "link": "Lire la documentation",
                "request_permission": "Nous construisons en ce moment des API RESTful pour que des applications tierces communiquent avec Kanka. Cependant nous limitons actuellement le nombre d'utilisateurs qui peuvent intéragir avec nos API, du moins jusqu'à ce que la qualité de nos APIs soit assez bonne. Si tu veux accéder aux API et construire des applications qui communiquent avec Kanka, prends contact avec nous et nous te donnerons les infos dont tu as besoin!",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Lier",
                    "remove": "Retirer"
                },
                "benefits": "Kanka supporte quelques intégrations avec d'autres services. D'autres services seront ajoutés dans le futur.",
                "discord": {
                    "errors": {
                        "add": "Une erreur est survenue lors du liage de Discord avec le compte Kanka."
                    },
                    "success": {
                        "add": "Compte Discord lié.",
                        "remove": "Compte Discord délié."
                    },
                    "text": "Accès aux rôles automatique."
                },
                "title": "Intégration d'app"
            },
            "boost": {
                "benefits": {
                    "first": "Pour assurer une évolution continue de Kanka, certaines fonctionnalités de l'application sont débloquées lorsqu'une campagne est boostée. Les boosts sont débloqués grâce a un abonnement. Une campagne peut être boostée par n'importe qui, du moment que le compte a accès à la campagne en question. Une campagne reste boostée tant que le compte a un {subscription} actif. Si une campagne n'est plus boostée, les informations ne sont pas perdues mais deviennent simplement invisibles jusqu'à ce que la campagne soit à nouveau boostée.",
                    "header": "Image d'en-tête pour entité.",
                    "images": "Images d'entité par défaut personnalisées.",
                    "more": "En savoir plus sur toutes les fonctionnalités.",
                    "second": "Booster une campagne débloque les bénéfices suivants:",
                    "theme": "Thème de campagne et style personnalisé.",
                    "third": "Pour booster une campagne, aller sur la page de la campagne et cliquer sur le bouton \"{boost_button}\" situé au dessus du bouton \"{edit_button}\".",
                    "tooltip": "Infobulles personnalisées pour les entités.",
                    "upload": "Taille des fichiers uploadés plus grande pour tous les membres de la campagne."
                },
                "buttons": {
                    "boost": "Boost"
                },
                "campaigns": "Campagnes boostées {count} / {max}",
                "exceptions": {
                    "already_boosted": "La campagne {name} est déjà boostée.",
                    "exhausted_boosts": "Tu n'as plus de boost disponnible. Retire un boost d'une campagne avant de pouvoir l'attribuer à une autre."
                },
                "success": {
                    "boost": "Campagne {name} boostée.",
                    "delete": "Boost retiré de {name}."
                },
                "title": "Boost"
            },
            "countries": {
                "austria": "Autriche",
                "belgium": "Belgique",
                "france": "France",
                "germany": "Allemagne",
                "italy": "Italie",
                "netherlands": "Pays-Bas",
                "spain": "Espagne"
            },
            "invoices": {
                "actions": {
                    "download": "Télécharger PDF",
                    "view_all": "Tout voir"
                },
                "empty": "Aucune facture",
                "fields": {
                    "amount": "Montant",
                    "date": "Date",
                    "invoice": "Facture",
                    "status": "Status"
                },
                "header": "Liste des 24 dernières factures qui peuvent être téléchargées.",
                "status": {
                    "paid": "Payé",
                    "pending": "En attente"
                },
                "title": "Factures"
            },
            "layout": {
                "success": "Options de mise en page modifiées.",
                "title": "Mise en page"
            },
            "menu": {
                "account": "Compte",
                "api": "API",
                "apps": "Apps",
                "billing": "Méthode de paiement",
                "boost": "Boost",
                "invoices": "Factures",
                "layout": "Mise en Page",
                "other": "Autre",
                "patreon": "Patreon",
                "payment_options": "Options de paiement",
                "personal_settings": "Paramètres Personnels",
                "profile": "Profil",
                "subscription": "Abonnement",
                "subscription_status": "Status d'abonnement"
            },
            "patreon": {
                "actions": {
                    "link": "Lier le compte",
                    "view": "Visiter Kanka sur Patreon"
                },
                "benefits": "Nous supporter sur {patreon} active plein de {features} pour toi et tes campagnes, et nous permet de dédier plus de temps à travailler sur Kanka.",
                "benefits_features": "fonctionnalités sympas",
                "deprecated": "Fonction obsolète - si tu souhaites supporter Kanka, fais-le avec un abonnement. La liaison Patreon est toujours active pour nos Patrons qui ont lié leur compte avant le changement d'abonnement.",
                "description": "Synchronisation avec Patreon",
                "linked": "Merci pour ton support sur Patreon! Ton compte est dorénavant lié.",
                "pledge": "Pledge: {name}",
                "remove": {
                    "button": "Délier le compte Patreon",
                    "success": "Ton compte Patreon a été délié.",
                    "text": "Délier le compte Patreon de Kanka supprime les bonus, le nom du Hall of Fame, les boosters de campagne et d'autres fonctionnalités liées au supporter de Kanka. Aucun contenu boosté ne sera perdu (par exemple les en-têtes d'entité). Lors du réabonnement, toutes les données seront à nouveau visibles, y compris la possibilité de booster des campagnes précédemment boostées.",
                    "title": "Délier le compte Patreon de Kanka"
                },
                "success": "Merci pour ton support sur Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Ton pledge est inséré manuellement par nous, du coup ça peut prendre quelques jours pour être actualisé. Si ça prend longtemps, n'hésite pas à nous contacter."
            },
            "profile": {
                "actions": {
                    "update_profile": "Mettre à jour le profil"
                },
                "avatar": "Image de profil",
                "success": "Mise à jour effectuée.",
                "title": "Profil personnel"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Annuler l'abonnement",
                    "subscribe": "Abonner",
                    "update_currency": "Changer la devise"
                },
                "benefits": "En nous soutenant, tu peux débloquer de nouvelles fonctionnalités et nous aider à investir plus de temps dans l'amélioration de Kanka. Aucune information concernant ta carte de crédit n'est stockée ou ne transite par nos serveurs. Nous utilisons {stripe} pour gérer toutes les factures.",
                "billing": {
                    "helper": "Les informations de paiement sont gérées et sauvegardées de manière sécurisée à travers {stripe}. Cette méthode de paiement sera utilisée pour tous les abonnements.",
                    "saved": "Méthode de paiement",
                    "title": "Modifier la méthode de paiement"
                },
                "cancel": {
                    "text": "Désolé de te voir partir! L'annulation de ton abonnement le gardera actif jusqu'au la fin du mois payé, après quoi tu perdras les bonus de ta campagne et les autres avantages liés au soutien de Kanka. N'hésite pas à remplir le formulaire suivant pour nous informer de ce que nous pouvons améliorer, ou ce qui a conduit à ta décision."
                },
                "cancelled": "L'abonnement a été annulé. Un nouvel abonnement peut être fait dès que celui-ci arrive à terme.",
                "change": {
                    "text": {
                        "monthly": "Abonnement au niveau {tier}, facturé mensuellement pour {amount}.",
                        "yearly": "Abonnement au niveau {tier}, facturé annuellement pour {amount}."
                    },
                    "title": "Changement d'abonnement"
                },
                "currencies": {
                    "eur": "EUR",
                    "usd": "USD"
                },
                "currency": {
                    "title": "Changer la devise de facturation"
                },
                "errors": {
                    "callback": "Notre gestionnaire de paiement nous a remonté une erreur. Prière de réessayer et nous contacter si le problème persiste.",
                    "subscribed": "Erreur lors de la gestion de l'abonnement. Stripe nous a fourni l'erreur suivante."
                },
                "fields": {
                    "active_since": "Actif depuis",
                    "active_until": "Active jusqu'à",
                    "billing": "Facturation",
                    "currency": "Devise",
                    "payment_method": "Méthode de paiement",
                    "plan": "Abonnement actuel",
                    "reason": "Raison"
                },
                "helpers": {
                    "alternatives": "Payez votre abonnement en utilisant {method}. Ce mode de paiement ne sera pas renouvelé automatiquement à la fin de votre abonnement. {method} n'est disponible qu'en Euros.",
                    "alternatives_warning": "La mise à niveau de l'abonnement lors de l'utilisation de cette méthode n'est pas possible. Veuillez créer un nouvel abonnement à la fin de votre abonnement actuel.",
                    "alternatives_yearly": "En raison des restrictions entourant les paiements récurrents, {method} n'est disponible que pour les abonnements annuels"
                },
                "manage_subscription": "Gérer l'abonnement",
                "payment_method": {
                    "actions": {
                        "add_new": "Ajouter une méthode de paiement",
                        "change": "Modifier la méthode de paiement",
                        "save": "Enregister la méthode de paiement",
                        "show_alternatives": "Autres méthodes de paiement"
                    },
                    "add_one": "Aucune méthode de paiement actuellement saisie.",
                    "alternatives": "Un abonnement peut être souscrit avec ces méthodes de paiement. Cette action ne générera qu'une seule facture et ne renouvellera pas automatiquement l'abonnement chaque mois.",
                    "card": "Carte",
                    "card_name": "Nom sur la carte",
                    "country": "Pays de résidence",
                    "ending": "Se terminant par",
                    "helper": "Cette carte sera utilisée pour les abonnements.",
                    "new_card": "Ajouter une méthode de paiement",
                    "saved": "{brand} se terminant par {last4}"
                },
                "placeholders": {
                    "reason": "(optionnelle) dis-nous pourquoi tu ne souhaites plus être abonné à Kanka. Manquait-il une fonctionnalité? Ta situation financière a-t-elle changé?"
                },
                "plans": {
                    "cost_monthly": "{currency} {amount} facturé mensuellement",
                    "cost_yearly": "{currency} {amount} facturé annuellement"
                },
                "sub_status": "Information d'abonnement",
                "subscription": {
                    "actions": {
                        "downgrading": "Prière de nous contacter pour un déclassement",
                        "rollback": "Changer à Kobold",
                        "subscribe": "Changer à {tier} mensuel",
                        "subscribe_annual": "Changer à {tier} annuel"
                    }
                },
                "success": {
                    "alternative": "Le paiement a été enregistré. Une notification sera générée dès le paiement traité et l'abonnement activé.",
                    "callback": "Ton abonnement est réussi! Ton compte sera mis à jour dès que notre gestionnaire de paiement nous informera des changements (cela peut prendre quelques minutes).",
                    "cancel": "Ton abonnement est annulé. Il sera toujours actif jusqu'à la fin de la période actuelle.",
                    "currency": "Devise préférée sauvegardée.",
                    "subscribed": "Ton abonnement est réussi! N'oublie pas de t'abonner à la newsletter Community Vote pour être averti lorsqu'un vote sera ouvert. Tu peux modifier tes paramètres de newsletter sur ta page de profil."
                },
                "tiers": "Niveaux d'abonnements",
                "trial_period": "Les abonnements annuels ont une période d'annulation de 14 jours. Nous contacter à {email} pour annuler un abonnement et recevoir un remboursement.",
                "upgrade_downgrade": {
                    "button": "Information sur l'upgrade/downgrade",
                    "downgrade": {
                        "bullets": {
                            "end": "L'abonnement actuel reste actif jusqu'à la fin du cycle de paiement, après quoi le nouvel abonnement sera mis en place."
                        },
                        "title": "Lors du passage à un niveau inférieur"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "La méthode de paiement sera facturée immédiatement et les nouvelles fonctionnalités seront accessibles.",
                            "prorate": "Lors du changement de Owlbear à Elemental, seulement la différence sera facturée."
                        },
                        "title": "Lors du passage à un niveau supérieur"
                    }
                },
                "warnings": {
                    "incomplete": "Nous n'avons pas pu débiter la carte de crédit. Vérifier les informations de la carte et mettre à jour si nécessaire. Nous essayerons à nouveau durant les prochains jours. Si ça échoue de nouveau, l'abonnement sera annulé.",
                    "patreon": "Ce compte est actuellement lié à Patreon. Prière de délier le compte dans les paramètres {patreon} avant de pouvoir s'abonner à Kanka."
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Créer une nouvelle conversation",
                "success": "Conversation '{name}' créée.",
                "title": "Nouvelle Conversation"
            },
            "destroy": {
                "success": "Conversation '{name}' supprimée."
            },
            "edit": {
                "description": "Modifier la conversation",
                "success": "Conversation '{name}' modifiée.",
                "title": "Conversation {name}"
            },
            "fields": {
                "messages": "Messages",
                "name": "Nom",
                "participants": "Participants",
                "target": "Cible",
                "type": "Type"
            },
            "hints": {
                "participants": "Ajoute des participants à la conversation."
            },
            "index": {
                "add": "Nouvelle Conversation",
                "description": "Gérer les conversations de {name}.",
                "header": "Conversations dans {name}",
                "title": "Conversations"
            },
            "messages": {
                "destroy": {
                    "success": "Message supprimé."
                },
                "is_updated": "Modifié",
                "load_previous": "Messages précédents",
                "placeholders": {
                    "message": "Ton message"
                }
            },
            "participants": {
                "create": {
                    "success": "Participant {entity} ajouté à la conversation."
                },
                "description": "Ajouter ou retirer des participants à une conversation",
                "destroy": {
                    "success": "Participant {entity} retiré de la conversation."
                },
                "modal": "Participants",
                "title": "Participants de {name}"
            },
            "placeholders": {
                "name": "Nom de la conversation",
                "type": "In Game, Préparation, Quête"
            },
            "show": {
                "description": "Vue détaillée d'une conversation",
                "title": "Conversation {name}"
            },
            "tabs": {
                "conversation": "Conversation",
                "participants": "Participants"
            },
            "targets": {
                "characters": "Personnages",
                "members": "Membres"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Actions",
                "apply": "Appliquer",
                "back": "Retour",
                "copy": "Copier",
                "copy_mention": "Copier mention [ ]",
                "copy_to_campaign": "Copier vers une campagne",
                "explore_view": "Vue Imbriquée",
                "export": "Export",
                "find_out_more": "En savoir plus",
                "go_to": "Aller à {name}",
                "json-export": "Export (JSON)",
                "move": "Déplacer",
                "new": "Nouveau",
                "next": "Prochain",
                "reset": "Réinitialiser"
            },
            "add": "Ajouter",
            "alerts": {
                "copy_mention": "La mention avancée de cette entité a été copiée au presse-papier."
            },
            "attributes": {
                "actions": {
                    "apply_template": "Appliquer un modèle d'attribut",
                    "manage": "Gérer",
                    "more": "Plus d'options",
                    "remove_all": "Tout supprimer"
                },
                "fields": {
                    "attribute": "Attribut",
                    "community_templates": "Modèles Communautaires",
                    "is_private": "Attributs privés",
                    "is_star": "Épinglé",
                    "template": "Modèle",
                    "value": "Valeur"
                },
                "helpers": {
                    "delete_all": "Es-tu certain de vouloir supprimer tous les attributs de cette entité?"
                },
                "hints": {
                    "is_private": "Tous les attributs d'une entité peuvent être cachés des membres non-admin."
                },
                "index": {
                    "success": "Attributs modifiés pour {entity}.",
                    "title": "Attributs pour {name}"
                },
                "placeholders": {
                    "attribute": "Nombre de quêtes, niveau de difficulté, initiative, population",
                    "block": "Nom du bloc",
                    "checkbox": "Nom de la case à cocher",
                    "section": "Nom de la section",
                    "template": "Sélectionner un modèle",
                    "value": "Valeur de l'attribut"
                },
                "template": {
                    "success": "Modèle d'attribut {name} appliqué pour {entity}.",
                    "title": "Appliquer un modèle d'attribut pour {name}"
                },
                "types": {
                    "attribute": "Attribut",
                    "block": "Bloc",
                    "checkbox": "Case à cocher",
                    "section": "Section",
                    "text": "Texte multiligne"
                },
                "visibility": {
                    "entry": "Attribut affiché sur le menu d'entité.",
                    "private": "Attribut seulement visible aux membres du rôle \"Admin\".",
                    "public": "Attribut visible par tous les membres.",
                    "tab": "Attribut visible sous l'onglet Attributs."
                }
            },
            "boosted": "Boosté",
            "boosted_campaigns": "Campagnes Boostées",
            "bulk": {
                "actions": {
                    "edit": "Opération de masse"
                },
                "age": {
                    "helper": "Il est possible de préfixer le numéro avec + ou - pour modifier l'âge dynamiquement."
                },
                "delete": {
                    "title": "Suppression de plusieurs entités",
                    "warning": "Es-tu sûr de vouloir supprimer les entités sélectionnées?"
                },
                "edit": {
                    "tagging": "Action pour les étiquettes",
                    "tags": {
                        "add": "Ajouter",
                        "remove": "Retirer"
                    },
                    "title": "Modifications de plusieurs entités"
                },
                "errors": {
                    "admin": "Seulement les membres administrateur de la campagne peuvent changer le statut des entités.",
                    "general": "Un problème est survenu lors de l'exécution. Prière de ressayer de nouveau ou nous contacter en cas de problème persistant. Message d'erreur: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Remplacer"
                    },
                    "helpers": {
                        "override": "Si sélectionné, les permissions des entités sélectionnées seront remplacées par celles-ci. Si non-sélectionné, les permissions sélectionnées seront ajoutées à celles existantes."
                    },
                    "title": "Changer les permissions pour plusieurs entités"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} entité copiée à {campaign}.|[2,*] {count} entités copiées à {campaign}.",
                    "editing": "{count} entité modifiée.|{count} entités modifiées.",
                    "permissions": "Permissions changées pour {count} entité. |Permissions changées pour {count} entités.",
                    "private": "{count} entité est maintenant privée.|{count} entitées sont maintenant privées.",
                    "public": "{count} entité est maintenant visible.|{count} entitées sont maintenant visibles."
                }
            },
            "cancel": "Annuler",
            "click_modal": {
                "close": "Fermer",
                "confirm": "Confirmer",
                "title": "Confirme ton action"
            },
            "copy_to_campaign": {
                "bulk_title": "Copier vers une campagne",
                "panel": "Copier",
                "title": "Copier '{name}' vers une autre campagne"
            },
            "create": "Créer",
            "datagrid": {
                "empty": "Rien à afficher."
            },
            "delete_modal": {
                "close": "Fermer",
                "delete": "Supprimer",
                "description": "Es-tu sûr de vouloir supprimer {tag}?",
                "mirrored": "Supprimer la relation liée.",
                "title": "Confirmation de la suppression"
            },
            "destroy_many": {
                "success": "{count} élément supprimé.|{count} éléments supprimés."
            },
            "edit": "Modifier",
            "errors": {
                "boosted": "Cette fonctionnalité n'est accessible qu'aux campagnes boostées..",
                "node_must_not_be_a_descendant": "Node invalide (étiquette, lieu parent): l'entité serait un descendant de lui-même."
            },
            "events": {
                "hint": "Les événements de calendrier peuvent être associés à cette entité et être affichés ici."
            },
            "export": "Export",
            "fields": {
                "ability": "Pouvoirs",
                "attribute_template": "Modèle d'attribut",
                "calendar": "Calendrier",
                "calendar_date": "Date calendrier",
                "character": "Personnage",
                "colour": "Couleur",
                "copy_attributes": "Copier les attributs",
                "copy_notes": "Copier les notes d'entité",
                "creator": "Créateur",
                "dice_roll": "Jet de dés",
                "entity": "Entité",
                "entity_type": "Type d'entité",
                "entry": "Entrée",
                "event": "Evénement",
                "excerpt": "Extrait",
                "family": "Famille",
                "files": "Fichiers",
                "has_image": "Possède une image",
                "header_image": "Image d'en-tête",
                "image": "Image",
                "is_private": "Privé",
                "is_star": "Epinglé",
                "item": "Objet",
                "location": "Lieu",
                "map": "Carte",
                "name": "Nom",
                "organisation": "Organisation",
                "position": "Position",
                "race": "Race",
                "tag": "Etiquette",
                "tags": "Etiquettes",
                "timeline": "Chronologie",
                "tooltip": "Infobulle",
                "type": "Type",
                "visibility": "Visibilité"
            },
            "files": {
                "actions": {
                    "drop": "Ajouter un fichier en cliquant ou en glissant déposant",
                    "manage": "Gérer les fichiers d'entité"
                },
                "errors": {
                    "max": "Nombre maximal de fichier ({max}) atteint pour cette entité.",
                    "no_files": "Aucun fichier."
                },
                "files": "Fichiers uploadés",
                "hints": {
                    "limit": "Chaque entité peut avoir un nombre maximal de {max} fichiers uploadés.",
                    "limitations": "Formats supportés: {formats}. Taille maximale: {size}"
                },
                "title": "Fichiers d'entité pour {name}"
            },
            "filter": "Filtre",
            "filters": {
                "all": "Afficher tous les descendants",
                "clear": "Effacer les filtres",
                "direct": "Afficher seulement les descendants directs",
                "filtered": "Affichant {count} de {total} {entity}.",
                "hide": "Cacher les filtres",
                "options": {
                    "exclude": "Exclure",
                    "include": "Inclure",
                    "none": "Aucun(e)"
                },
                "show": "Afficher les filtres",
                "sorting": {
                    "asc": "{field} ascendant",
                    "desc": "{field} descendant",
                    "helper": "Contrôler l'ordre d'affichage des résultats."
                },
                "title": "Filtres"
            },
            "forms": {
                "actions": {
                    "calendar": "Ajouter une date de calendrier"
                },
                "copy_options": "Option de copie"
            },
            "hidden": "Caché",
            "hints": {
                "attribute_template": "Appliquer un modèle d'attribut lors de la création ou l'édition de cette entité.",
                "calendar_date": "Une date de calendrier permet un triage plus facile dans les listes, et garde à jour un événement de calendrier dans le calendrier sélectionné.",
                "header_image": "Cette image s'affiche au-delà de l'entité. Les images larges mènent a un meilleur résultat.",
                "image_limitations": "Formats supportés: jpg, png et gif. Taille max: {size}.",
                "image_patreon": "Augmenter la taille limite?",
                "is_private": "Cacher des membres de type non-Admin",
                "is_star": "Les éléments épinglés sont affichés sur le menu de l'entité.",
                "map_limitations": "Formats supportés: jpg, png, gif et svg. Taille maximale: {size}.",
                "tooltip": "Remplace l'infobulle automatiquement généré avec le texte ci-dessous.",
                "visibility": "Si la visibilité est définie à Admin, seuls les membres du rôle Admin de la campagne verront ceci. La visibilité \"Soi-même\" signifie que tu es le seul à le voir."
            },
            "history": {
                "created": "Créé par <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Créé <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Inconnu",
                "updated": "Dernière modification par <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Dernière modification <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Visionner les journaux de l'entité"
            },
            "image": {
                "error": "Impossible de récupérer l'image demandée. Il est possible que le site web ne nous permet pas de télécharger des images (cela arrive par example avec squarespace et DeviantArt), ou le lien n'est plus valide."
            },
            "is_not_private": "Cette entité n'est pas privée.",
            "is_private": "Cet élément est privé et pas visible.",
            "linking_help": "Comment lier vers d'autres éléments?",
            "manage": "Gérer",
            "move": {
                "description": "Déplacer cet élément vers un nouvel endroit",
                "errors": {
                    "permission": "Droits insuffisants pour créer une entité de ce type dans la campagne sélectionnée.",
                    "same_campaign": "Une autre campagne doit être sélectionnée pour y déplacer l'entité.",
                    "unknown_campaign": "Campagne inconnue."
                },
                "fields": {
                    "campaign": "Nouvelle campagne",
                    "copy": "Créer une copie",
                    "target": "Nouveau type"
                },
                "hints": {
                    "campaign": "Il est aussi possible de déplacer cette entité vers une autre campagne.",
                    "copy": "Activer cette option crée une copie dans la nouvelle campagne.",
                    "target": "Attention! Certaines informations peuvent être perdues lors du déplacement d'un élément."
                },
                "success": "Elément {name} déplacé.",
                "success_copy": "Entité '{name}' copiée.",
                "title": "Déplacer {name} autre part"
            },
            "new_entity": {
                "error": "Vérifier les valeurs.",
                "fields": {
                    "name": "Nom"
                },
                "title": "Nouvel élément"
            },
            "or_cancel": "ou <a href=\"{url}\">annuler</a>",
            "panels": {
                "appearance": "Apparence",
                "attribute_template": "Modèle d'attribut",
                "calendar_date": "Date Calendrier",
                "entry": "Entrée",
                "general_information": "Information Generale",
                "move": "Déplacer",
                "system": "Système"
            },
            "permissions": {
                "action": "Action",
                "actions": {
                    "bulk": {
                        "add": "Ajouter",
                        "deny": "Refuser",
                        "ignore": "Ignorer",
                        "remove": "Retirer"
                    },
                    "bulk_entity": {
                        "allow": "Permettre",
                        "deny": "Refuser",
                        "inherit": "Hériter"
                    },
                    "delete": "Supprimer",
                    "edit": "Modifier",
                    "entity_note": "Notes d'entité",
                    "read": "Lire",
                    "toggle": "Basculer"
                },
                "allowed": "Permis",
                "fields": {
                    "member": "Membre",
                    "role": "Rôle"
                },
                "helper": "En utilisant cette interface, il est possible d'affiner les permissions des membres et rôles de la campagne pouvant interagir avec cette entité.",
                "helpers": {
                    "setup": "Utilise cette interface pour affiner la manière dont les rôles et les utilisateurs peuvent interagir avec cette entité. {allow} permettra à l'utilisateur ou au rôle d'effectuer cette action. {deny} leur empêchera de prendre cette action. {inherit} utilisera le rôle de l'utilisateur ou l'autorisation de leur rôle. Un utilisateur avec {allow} peut effectuer l'action en question, même si son rôle est en {deny}."
                },
                "inherited": "Ce rôle a déjà cette permission pour ce type d'entité.",
                "inherited_by": "Cet utilisateur fait partie du rôle {role} qui permet cette permission pour ce type d'entité.",
                "success": "Permissions enregistrées.",
                "title": "Permissions",
                "too_many_members": "Cette campagne a trop de members (>10) pour afficher cette interface correctement. Prière d'utiliser le boutton Permission sur la vue de l'entité pour gérer les permissions."
            },
            "placeholders": {
                "ability": "Choix d'un pouvoir",
                "calendar": "Choix du calendrier",
                "character": "Choix du personnage",
                "entity": "Entité",
                "event": "Choix de l'événement",
                "family": "Choix de la famille",
                "image_url": "Ou depuis une URL",
                "item": "Choix d'un objet",
                "location": "Choix du lieu",
                "map": "Choix d'une carte",
                "organisation": "Choix d'une organisation",
                "race": "Choix d'une race",
                "tag": "Choix d'une étiquette"
            },
            "relations": {
                "actions": {
                    "add": "Ajouter une relation"
                },
                "fields": {
                    "location": "Lieu",
                    "name": "Nom",
                    "relation": "Relation"
                },
                "hint": "Des relations entre les entités peuvent être définies pour représenter leur connexion."
            },
            "remove": "Supprimer",
            "rename": "Renommer",
            "save": "Enregistrer",
            "save_and_close": "Enregistrer et Fermer",
            "save_and_copy": "Enregistrer et Copier",
            "save_and_new": "Enregistrer et Nouveau",
            "save_and_update": "Enregistrer et continuer la modification",
            "save_and_view": "Enregistrer et Afficher",
            "search": "Rechercher",
            "select": "Sélection",
            "tabs": {
                "abilities": "Pouvoirs",
                "attributes": "Attributs",
                "boost": "Boost",
                "calendars": "Calendriers",
                "default": "Défaut",
                "events": "Événements",
                "inventory": "Inventaire",
                "map-points": "Points de carte",
                "mentions": "Mentions",
                "menu": "Menu",
                "notes": "Notes",
                "permissions": "Permissions",
                "relations": "Relations",
                "reminders": "Rappels",
                "timelines": "Chronologies",
                "tooltip": "Infobulle"
            },
            "update": "Modifier",
            "users": {
                "unknown": "Inconnu"
            },
            "view": "Voir",
            "visibilities": {
                "admin": "Admin",
                "admin-self": "Soi-même & Admin",
                "all": "Tous",
                "self": "Soi-même"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "he": {
        "maps": [],
        "calendars": [],
        "conversations": {
            "create": {
                "description": "צור שיחה חדשה",
                "success": "השיחה '{name}' נוצרה.",
                "title": "שיחה חדשה"
            },
            "destroy": {
                "success": "השיחה '{name}' הוסרה."
            },
            "edit": {
                "description": "עדכן את השיחה",
                "success": "השיחה '{name}' עודכנה.",
                "title": "שיחה {name}"
            },
            "fields": {
                "messages": "הודעות",
                "name": "שם",
                "participants": "משתתפים",
                "target": "קטגוריה",
                "type": "סוג"
            },
            "hints": {
                "participants": "הוסף משתתפים בלחיצה על האייקון {icon} בצד שמאל למעלה."
            },
            "index": {
                "add": "שיחה חדשה",
                "description": "ניהול הקטגוריה של {name}.",
                "header": "שיחות ב{name}",
                "title": "שיחות"
            },
            "messages": {
                "destroy": {
                    "success": "ההודעה הוסרה."
                },
                "is_updated": "עודכן",
                "load_previous": "טען הודעות קודמות",
                "placeholders": {
                    "message": "ההודעה שלך"
                }
            },
            "participants": {
                "create": {
                    "success": "{entity} הוסף לשיחה."
                },
                "description": "הוסף או הסר משתתפים",
                "destroy": {
                    "success": "{entity} הוסר מהשיחה."
                },
                "modal": "משתתפים",
                "title": "המשתתפים של {name}"
            },
            "placeholders": {
                "name": "שם השיחה",
                "type": "בתוך המשחק, הכנה, עלילה"
            },
            "show": {
                "description": "מבט מפורט על שיחה",
                "title": "שיחה {name}"
            },
            "tabs": {
                "conversation": "שיחה",
                "participants": "משתתפים"
            },
            "targets": {
                "characters": "דמויות",
                "members": "שחקנים"
            }
        },
        "admin": [],
        "crud": {
            "actions": {
                "find_out_more": "לקריאה נוספת"
            },
            "boosted_campaigns": "מערכות מוגברות",
            "edit": "עריכה",
            "export": "ייצא",
            "fields": {
                "ability": "יכולת",
                "attribute_template": "תבנית מאפיינים",
                "calendar": "לוח שנה",
                "calendar_date": "תאריך בלוח שנה",
                "character": "דמות",
                "colour": "צבע",
                "copy_attributes": "העתק מאפיינים",
                "copy_notes": "העתק פתקי אובייקט",
                "creator": "יוצר",
                "dice_roll": "הטלת קוביה",
                "entity": "אובייקט",
                "entity_type": "סוג אובייקט",
                "entry": "ערך",
                "event": "אירוע",
                "excerpt": "תקציר",
                "family": "משפחה",
                "files": "קבצים",
                "has_image": "יש תמונה",
                "header_image": "תמונת כותרת",
                "image": "תמונה",
                "is_private": "פרטי",
                "is_star": "מוצמד",
                "item": "חפץ",
                "location": "מיקום",
                "map": "מפה",
                "name": "שם",
                "organisation": "ארגון",
                "position": "תפקיד",
                "race": "גזע",
                "tag": "תגית",
                "tags": "תגיות",
                "timeline": "ציר זמם",
                "tooltip": "רמז",
                "type": "סוג",
                "visibility": "נראות"
            },
            "files": {
                "actions": {
                    "drop": "גרור קובץ או לחץ להוספה",
                    "manage": "נהל קבצי אובייקט"
                },
                "errors": {
                    "max": "הגעת למקסימום הקבצים ({max}) לאובייקט זה.",
                    "no_files": "אין קבצים"
                },
                "files": "קבצים הועלו",
                "hints": {
                    "limit": "לכל אובייקט יכולים להיות עד {max} קבצים.",
                    "limitations": "סיומות נתמכות: jpg, .png, .gif., וpdf. גודל מירבי: {size}"
                },
                "title": "קבצים של {name}"
            },
            "filter": "סינון",
            "filters": {
                "all": "סנן לכל הצאצאים",
                "clear": "בטל סינון",
                "direct": "סנן לצאצאים ישירים",
                "filtered": "מציג {count} מתוך {total}.",
                "hide": "הסתר סינון",
                "options": {
                    "exclude": "לא כולל",
                    "include": "כולל"
                },
                "show": "הצג סינון",
                "sorting": {
                    "asc": "{field} עולה",
                    "desc": "{field} יורד",
                    "helper": "בחר באיזה סדר יופיעו התוצאות"
                },
                "title": "מסננים"
            },
            "forms": {
                "actions": {
                    "calendar": "הוסף תאריך בלוח שנה"
                },
                "copy_options": "העתק הגדרות"
            },
            "hidden": "מוסתר",
            "history": {
                "created": "נוצר על ידי <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "נוצר <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated": "עדכון אחרון על ידי <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "עדכון אחרון <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>"
            },
            "remove": "הסר",
            "rename": "שנה שם",
            "save": "שמור",
            "save_and_close": "שמור וסגור",
            "save_and_copy": "שמור והעתק",
            "save_and_new": "שמור וצור חדש",
            "save_and_update": "שמור והמשך לעדכן",
            "save_and_view": "שמור וצפה",
            "search": "חיפוש",
            "select": "בחר",
            "tabs": {
                "abilities": "יכולות",
                "attributes": "מאפיינים",
                "boost": "מוגבר",
                "calendars": "לוחות שנה",
                "default": "ברירת מחדל",
                "events": "אירועים",
                "inventory": "ציוד",
                "map-points": "נקודות מפה",
                "mentions": "אזכורים",
                "menu": "תפריט",
                "notes": "פתקי אובייקט",
                "permissions": "הרשאות",
                "relations": "ייחסים",
                "reminders": "תזכורות",
                "timelines": "צירי זמן",
                "tooltip": "רמז"
            },
            "update": "עדכן",
            "users": {
                "unknown": "לא ידוע"
            },
            "view": "צפייה",
            "visibilities": {
                "admin": "מנהלים",
                "admin-self": "עצמי ומנהלים",
                "all": "כולם",
                "self": "עצמי"
            }
        },
        "campaigns": [],
        "front": [],
        "entities": []
    },
    "hr": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Prebaci se na prijavu u Kanku",
                    "update_email": "Ažuriraj email",
                    "update_password": "Ažuriraj lozinku"
                },
                "email": "Promjena emaila",
                "email_success": "Email ažuriran.",
                "password": "Promjena lozinke",
                "password_success": "Lozinka promijenjena.",
                "social": {
                    "error": "Već koristiš prijavu u Kanku za ovaj račun.",
                    "helper": "Tvojim računom trenutno upravlja {provider}. Možeš ga prestati koristiti i prebaciti se na standardnu ​​prijavu u Kanku postavljanjem lozinke.",
                    "success": "Tvoj račun sad koristi Kanka prijavu.",
                    "title": "Društveno prema Kanki"
                },
                "title": "Račun"
            },
            "api": {
                "experimental": "Dobrodošli u Kanka API! Ove su funkcionalnosti još eksperimentalne, ali bi trebale biti dovoljno stabilne da započneš komunikaciju s API-ima. Napravi token osobnog pristupa koji će se upotrebljavati u tvojim API zahtjevima ili koristi token klijenta ako želiš da tvoja aplikacija ima pristup korisničkim podacima.",
                "help": "Kanka će uskoro pružati RESTful API tako da se aplikacije treće strane mogu povezati s aplikacijom. Pojedinosti o upravljanju API ključevima bit će prikazane ovdje.",
                "link": "Pročitaj dokumentaciju API-ja",
                "request_permission": "Trenutno gradimo moćan RESTful API tako da se aplikacije treće strane mogu povezati s aplikacijom. Međutim, trenutno ograničavamo broj korisnika koji mogu komunicirati s API-em dok ga poliramo. Ako želiš pristupiti API-ju i izgraditi programe koji razgovaraju s Kankom, kontaktiraj nas i poslat ćemo ti sve potrebne informacije.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Poveži",
                    "remove": "Ukloni"
                },
                "benefits": "Kanka pruža nekoliko integracija na usluge trećih strana. U budućnosti se planira više integracija trećih strana.",
                "discord": {
                    "errors": {
                        "add": "Došlo je do pogreške u povezivanju tvog Discord računa s Kankom. Molim te pokušaj ponovno."
                    },
                    "success": {
                        "add": "Tvoj Discord račun je povezan.",
                        "remove": "Veza s tvojim Discord računom je uklonjena."
                    },
                    "text": "Pristupi svojim ulogama za pretplatu automatski."
                },
                "title": "Integracija s aplikacijom"
            },
            "boost": {
                "benefits": {
                    "first": "Kako bi osigurali kontinuirani napredak na Kanki, pojedine značajke kampanje otključavaju se pojačavanjem kampanje. Pojačanja se otključavaju putem pretplate. Svatko tko može pogledati kampanju može ju pojačati tako da ne mora uvijek ista osoba plaćati račun. Kampanja ostaje pojačana sve dok korisnik pojačava kampanju i oni nastave podržavati Kanku. Ako se kampanja više ne pojačava, podaci se ne gube već su samo skriveni dok se kampanja ponovno ne pojača.",
                    "header": "Slike zaglavlja entiteta.",
                    "images": "Proizvoljne zadane slike entiteta.",
                    "more": "Saznaj više o svim značajkama.",
                    "second": "Pojačavanje kampanje omogućuje sljedeće prednosti:",
                    "theme": "Tema na razini kampanje i proizvoljno stiliziranje.",
                    "third": "Da biste pojačali kampanju, idite na stranicu kampanje i kliknite gumb \"{boost_button}\" iznad gumba \"{edit_button}\".",
                    "tooltip": "Proizvoljni kratki opisi entiteta.",
                    "upload": "Povećana veličina prijenosa za svakog člana u kampanji."
                },
                "buttons": {
                    "boost": "Pojačaj"
                },
                "campaigns": "Pojačane kampanje {count} / {max}",
                "exceptions": {
                    "already_boosted": "Kampanja {name} je već pojačana.",
                    "exhausted_boosts": "Nemaš više pojačanja za pokloniti. Ukloni svoje pojačanje iz neke kampanje prije nego što ga daš drugoj."
                },
                "success": {
                    "boost": "Kampanja {name} pojačana.",
                    "delete": "Tvoje pojačanje je uklonjeno s {name}."
                },
                "title": "Pojačanje"
            },
            "countries": {
                "austria": "Austrija",
                "belgium": "Belgija",
                "france": "Francuska",
                "germany": "Njemačka",
                "italy": "Italija",
                "netherlands": "Nizozemska",
                "spain": "Španjolska"
            },
            "invoices": {
                "actions": {
                    "download": "Preuzmi PDF",
                    "view_all": "Pogledaj sve"
                },
                "empty": "Nema fakture",
                "fields": {
                    "amount": "Količina",
                    "date": "Datum",
                    "invoice": "Faktura",
                    "status": "Status"
                },
                "header": "Ispod je popis zadnje 24 fakture koje možete preuzeti.",
                "status": {
                    "paid": "Plaćeno",
                    "pending": "U tijeku"
                },
                "title": "Fakture"
            },
            "layout": {
                "success": "Ažurirane opcije rasporeda.",
                "title": "Izgled"
            },
            "marketplace": {
                "fields": {
                    "name": "Naziv Tržnice"
                },
                "helper": "Prema zadanim postavkama tvoje korisničko se prikazuje na {marketplace}. Možeš to promijeniti ovim poljem.",
                "title": "Postavke Tržnice",
                "update": "Postavke Tržnice spremljene."
            },
            "menu": {
                "account": "Račun",
                "api": "API",
                "apps": "Aplikacije",
                "billing": "Način plaćanja",
                "boost": "Pojačanje",
                "invoices": "Fakture",
                "layout": "Raspored",
                "marketplace": "Tržnica",
                "other": "Ostalo",
                "patreon": "Patreon",
                "payment_options": "Mogućnosti plaćanja",
                "personal_settings": "Osobne postavke",
                "profile": "Profil",
                "subscription": "Pretplata",
                "subscription_status": "Status pretplate"
            },
            "patreon": {
                "actions": {
                    "link": "Poveži račun",
                    "view": "Posjeti Kanku na Patreonu"
                },
                "benefits": "Podržavajući nas na {patreon} otključavaš svakakve {features} za tebe i tvoje kampanje, a pomažeš nam i da provedemo više vremena radeći na poboljšanju Kanke.",
                "benefits_features": "nevjerojatne funkcionalnosti",
                "deprecated": "Zastarjela značajka - ako želite podržati Kanku, učinite to putem {subscription}. Patreon povezivanje je i dalje aktivno za one koji su povezali svoj račun prije našeg odlaska iz Patreona.",
                "description": "Sinkroniziranje s Patreonom",
                "linked": "Hvala ti što podržavaš Kanku na Patreonu! Tvoj račun je povezan.",
                "pledge": "Zalog: {name}",
                "remove": {
                    "button": "Prekini vezu s Patreon računom",
                    "success": "Uklonjena je poveznica na tvoj Patreon račun.",
                    "text": "Ako prekineš vezu tvog računa s Patreonom, Kanka će ukloniti tvoje bonuse, ime u kući slavnih, pojačanja kampanje, te druge značajke povezane s podrškom Kanke. Nijedan tvoj pojačani sadržaj neće biti izgubljen (npr. zaglavlja entiteta). Ako se ponovo pretplatiš, imat ćeš pristup svim svojim prethodnim podacima, uključujući mogućnost pojačanja prijašnjih pojačanih kampanja.",
                    "title": "Prekini vezu Patreon računa s Kankom"
                },
                "success": "Hvala što podržavaš Kanku u Patreonu!",
                "title": "Patreon",
                "wrong_pledge": "Razinu tvog zaloga smo postavili ručno pa nam dopusti do nekoliko dana da je pravilno postavimo. Ako neko vrijeme ostane krivo, obrati nam se."
            },
            "profile": {
                "actions": {
                    "update_profile": "Ažuriraj profil"
                },
                "avatar": "Profilna slika",
                "success": "Profil ažuriran.",
                "title": "Osobni profil"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Otkaži pretplatu",
                    "subscribe": "Pretplata",
                    "update_currency": "Spremite preferiranu valutu"
                },
                "benefits": "Podržavajući nas možete otključati neke nove {features} i pomoći nam da uložimo više vremena u poboljšanje Kanke. Podaci kreditne kartice se ne pohranjuju ili ne prolaze kroz naše poslužitelje. Koristimo {stripe} za obradu svih računa.",
                "billing": {
                    "helper": "Podaci o naplati obrađuju se i pohranjuju na sigurno putem {stripe}. Ovaj način plaćanja koristi se za sve tvoje pretplate.",
                    "saved": "Spremljen način plaćanja",
                    "title": "Uredi način plaćanja"
                },
                "cancel": {
                    "text": "Žao nam je što odlaziš! Ako otkažeš pretplatu, bit će aktivna do sljedećeg ciklusa naplate, nakon čega ćeš izgubiti pojačanja kampanje i druge pogodnosti povezane s podrškom Kanke. Slobodno ispuni sljedeći obrazac i obavijesti nas što možemo učiniti boljim ili što je dovelo do tvoje odluke."
                },
                "cancelled": "Tvoja pretplata je otkazana. Pretplatu možete obnoviti nakon završetka tvoje trenutne pretplate.",
                "change": {
                    "text": {
                        "monthly": "Pretplaćuješ se na sloj {tier} koji se naplaćuje mjesečno {amount}.",
                        "yearly": "Pretplaćuješ se na sloj {tier} koji se naplaćuje godišnje {amount}."
                    },
                    "title": "Promijenite razinu pretplate"
                },
                "currencies": {
                    "eur": "EUR",
                    "usd": "USD"
                },
                "currency": {
                    "title": "Promijenite željenu valutu naplate"
                },
                "errors": {
                    "callback": "Naš pružatelj plaćanja prijavio je pogrešku. Molimo pokušaj ponovo ili nam se obrati ako se problem nastavi.",
                    "subscribed": "Tvoju pretplatu nije moguće obraditi. Stripe je pružio sljedeći savjet."
                },
                "fields": {
                    "active_since": "Aktivno od",
                    "active_until": "Aktivno do",
                    "billing": "Naplata",
                    "currency": "Valuta naplate",
                    "payment_method": "Način plaćanja",
                    "plan": "Trenutni plan",
                    "reason": "Razlog"
                },
                "helpers": {
                    "alternatives": "Plati svoju pretplatu pomoću {method}. Na kraju pretplate ovaj se način plaćanja neće automatski obnoviti. {metoda} je dostupna samo u eurima.",
                    "alternatives_warning": "Nadogradnja pretplate prilikom korištenja ove metode nije moguća. Stvori novu pretplatu kada se završi trenutna.",
                    "alternatives_yearly": "Zbog ograničenja koja se odnose na ponavljajuća plaćanja, metoda {method} je dostupna samo za godišnje pretplate"
                },
                "manage_subscription": "Upravljanje pretplatom",
                "payment_method": {
                    "actions": {
                        "add_new": "Dodajte novi način plaćanja",
                        "change": "Promjena načina plaćanja",
                        "save": "Spremi način plaćanja",
                        "show_alternatives": "Alternativni načini plaćanja"
                    },
                    "add_one": "Trenutno nema spremljenog načina plaćanja.",
                    "alternatives": "Možeš se pretplatiti pomoću ovih alternativnih načina plaćanja. Ova radnja će teretiti tvoj račun jednom i neće automatski obnavljati pretplatu svaki mjesec.",
                    "card": "Kartica",
                    "card_name": "Ime na kartici",
                    "country": "Zemlja prebivališta",
                    "ending": "Završava za",
                    "helper": "Ova će se kartica koristiti za sve tvoje pretplate.",
                    "new_card": "Dodaj novi način plaćanja",
                    "saved": "{brand} završava s {last4}"
                },
                "placeholders": {
                    "reason": "Po želji nam možeš reći zašto više ne podržavaš Kanku. Nedostajala je funkcionalnost? Je li se promijenila tvoja financijska situacija?"
                },
                "plans": {
                    "cost_monthly": "{currency} {amount} naplaćeno mjesečno",
                    "cost_yearly": "{currency} {amount} naplaćeno godišnje"
                },
                "sub_status": "Informacije o pretplati",
                "subscription": {
                    "actions": {
                        "downgrading": "Molimo kontaktiraj nas radi smanjenja za nižu razinu",
                        "rollback": "Promjena u Kobold",
                        "subscribe": "Promjena u {tier} mjesečno",
                        "subscribe_annual": "Promjeni na {tier} godišnje"
                    }
                },
                "success": {
                    "alternative": "Tvoja uplata je registrirana. Primit ćeš obavijest čim se obradi i tvoja pretplata postane aktivna.",
                    "callback": "Tvoja pretplata je uspješna. Tvoj račun će biti ažuriran čim nas naš pružatelj plaćanja informira o promjeni (ovo može potrajati nekoliko minuta).",
                    "cancel": "Tvoja pretplata je otkazana. I dalje će biti aktivna do kraja tvog trenutnog razdoblja naplate.",
                    "currency": "Tvoja željena postavka valute je ažurirana.",
                    "subscribed": "Tvoja pretplata je bila uspješna. Ne zaboravi se pretplatiti na bilten glasanja zajednice kako bi te obavijestili kada započne novo glasanje. Postavke biltena možeš promijeniti na stranici profila."
                },
                "tiers": "Razina pretplate",
                "trial_period": "Godišnje pretplate imaju pravo otkaza 14 dana. Kontaktiraj nas na {email} ako želiš otkazati godišnju pretplatu i dobiti povrat novca.",
                "upgrade_downgrade": {
                    "button": "Informacije o promjeni razine",
                    "downgrade": {
                        "bullets": {
                            "end": "Tvoja trenutna razina ostat će aktivna do kraja tvog trenutnog ciklusa naplate, nakon čega ćeš biti nadograđen na svoju novu razinu."
                        },
                        "title": "Pri prelasku na niži nivo"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "Tvoj način plaćanja bit će naplaćen odmah i imat ćeš pristup svom novom sloju.",
                            "prorate": "Kada nadogradiš s Owlbear na Elemental, samo će ti se naplatiti ​​razlika do tvoje nove razine."
                        },
                        "title": "Pri nadogradnji na viši sloj"
                    }
                },
                "warnings": {
                    "incomplete": "Nismo mogli naplatiti tvoju kreditnu karticu. Ažuriraj podatke o svojoj kreditnoj kartici, a mi ćemo je pokušati ponovo naplatiti u narednih nekoliko dana. Ako opet ne uspije, pretplata će se otkazati.",
                    "patreon": "Tvoj račun je trenutno povezan s Patreonom. Prekini vezu s računom u tvojim postavkama {patreon} prije prelaska na Kanka pretplatu."
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Kreiraj novi razgovor",
                "success": "Kreiran razgovor \"{name}\".",
                "title": "Novi razgovor"
            },
            "destroy": {
                "success": "Uklonjen razgovor \"{name}\"."
            },
            "edit": {
                "description": "Ažuriraj razgovor",
                "success": "Ažuriran razgovor \"{name}\".",
                "title": "Razgovor {name}"
            },
            "fields": {
                "messages": "Poruke",
                "name": "Naziv",
                "participants": "Sudionici",
                "target": "Otvaranje poveznice",
                "type": "Tip"
            },
            "hints": {
                "participants": "Dodaj sudionike u razgovor pritiskom na ikonu {icon} u gornjem desnom kutu."
            },
            "index": {
                "add": "Novi razgovor",
                "description": "Upravljanje kategorijom u {name}.",
                "header": "Razgovori u {name}",
                "title": "Razgovori"
            },
            "messages": {
                "destroy": {
                    "success": "Poruka uklonjena."
                },
                "is_updated": "Ažurirano",
                "load_previous": "Učitaj prethodne poruke",
                "placeholders": {
                    "message": "Tvoja poruka"
                }
            },
            "participants": {
                "create": {
                    "success": "Sudionik {entity} dodan u razgovor."
                },
                "description": "Dodavaj ili ukloni sudionika razgovora",
                "destroy": {
                    "success": "Sudionik {entity} uklonjen iz razgovora."
                },
                "modal": "Sudionici",
                "title": "Sudionici u {name}"
            },
            "placeholders": {
                "name": "Naziv razgovora",
                "type": "U igri, Priprema, Zaplet"
            },
            "show": {
                "description": "Detaljan prikaz razgovora",
                "title": "Razgovor {name}"
            },
            "tabs": {
                "conversation": "Razgovor",
                "participants": "Sudionici"
            },
            "targets": {
                "characters": "Likovi",
                "members": "Članovi"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Akcije",
                "apply": "Primijeni",
                "back": "Natrag",
                "copy": "Kopiraj",
                "copy_mention": "Kopiraj [ ] spominjanje",
                "copy_to_campaign": "Kopiraj u kampanju",
                "explore_view": "Ugniježđeni pregled",
                "export": "Izvoz",
                "find_out_more": "Saznaj više",
                "go_to": "Idi na {name}",
                "json-export": "Izvoz (json)",
                "move": "Pomakni",
                "new": "Novo",
                "next": "Sljedeće",
                "reset": "Resetiraj"
            },
            "add": "Dodaj",
            "alerts": {
                "copy_mention": "Napredno spominjanje entiteta kopirano je u međuspremnik."
            },
            "attributes": {
                "actions": {
                    "apply_template": "Primjeni predložak atributa",
                    "manage": "Upravljanje",
                    "more": "Više opcija",
                    "remove_all": "Izbriši sve"
                },
                "fields": {
                    "attribute": "Atribut",
                    "community_templates": "Predlošci zajednice",
                    "is_private": "Privatni atributi",
                    "is_star": "Prikvačeno",
                    "template": "Predložak",
                    "value": "Vrijednost"
                },
                "helpers": {
                    "delete_all": "Jesi li siguran/a da želiš izbrisati sve atribute ovog entiteta?"
                },
                "hints": {
                    "is_private": "Možeš sakriti sve atribute entiteta od svih članova koji nisu administratori tako što ćeš ga učiniti privatnim."
                },
                "index": {
                    "success": "Ažurirani atributi za {entity}.",
                    "title": "Atributi za {name}"
                },
                "placeholders": {
                    "attribute": "Broj osvajanja, Razina izazova, Inicijativa, Stanovništvo",
                    "block": "Naziv bloka",
                    "checkbox": "Naziv potvrdnog okvira",
                    "section": "Naziv odjeljka",
                    "template": "Odaberi predložak",
                    "value": "Vrijednost atributa"
                },
                "template": {
                    "success": "Predložak atributa {name} primijenjen na {entity}",
                    "title": "Primijeni predložak atributa za {name}"
                },
                "types": {
                    "attribute": "Atribut",
                    "block": "Blok",
                    "checkbox": "Potvrdni okvir",
                    "section": "Odjeljak",
                    "text": "Tekst u više redova"
                },
                "visibility": {
                    "entry": "Atribut je prikazan u izborniku entiteta.",
                    "private": "Atribut vidljiv samo članovima uloge \"Administrator\".",
                    "public": "Atribut vidljiv svim članovima.",
                    "tab": "Atribut se prikazuje samo na kartici Atributi."
                }
            },
            "boosted": "Pojačano",
            "boosted_campaigns": "Pojačane kampanje",
            "bulk": {
                "actions": {
                    "edit": "Skupno uređivanje i označavanje"
                },
                "age": {
                    "helper": "Možeš koristiti + i - prije broja za ažuriranje dobi za taj iznos."
                },
                "delete": {
                    "title": "Brisanje više entiteta",
                    "warning": "Jesi li siguran/a da želiš izbrisati odabrane entitete?"
                },
                "edit": {
                    "tagging": "Akcija za oznake",
                    "tags": {
                        "add": "Dodaj",
                        "remove": "Ukloni"
                    },
                    "title": "Uređivanje više entiteta"
                },
                "errors": {
                    "admin": "Samo administratori kampanje mogu promijeniti privatni status entiteta.",
                    "general": "Došlo je do pogreške prilikom obrade tvoje akcije. Pokušaj ponovo i kontaktiraj nas ako se problem nastavi. Poruka o pogrešci: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Pregazi postojeće"
                    },
                    "helpers": {
                        "override": "Ako je uključeno, dopuštenja odabranih entiteta će biti pregažena s ovima. Ako nije uključeno, odabrana dopuštenja će biti dodana postojećim."
                    },
                    "title": "Promijeni dozvole za nekoliko entiteta"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} entitet kopiran u {campaign}.|{2,4} {count} entiteta kopirana u {campaign}.|{5,*} {count} entiteta kopirano u {campaign}.",
                    "editing": "{1} {count} entitet je ažuriran.|[2,4] {count} entiteta su ažurirana.|[5, *] {count} entiteta je ažurirano.",
                    "permissions": "{1} Ovlasti promijenjene za {count} entitet.|[2,*] Ovlasti promijenjene za {count} entiteta.",
                    "private": "{1} {count} entitet je sad privatan.|[2,4] {count} entiteta su sad privatna.|[5, *] {count} entiteta su sad privatno.",
                    "public": "{1} {count} entitet je sad vidljiv.|[2,4] {count} entiteta su sad vidljiva.|[5, *] {count} entiteta je sad vidljivo."
                }
            },
            "cancel": "Otkaži",
            "click_modal": {
                "close": "Zatvori",
                "confirm": "Potvrdi",
                "title": "Potvrdi svoju akciju"
            },
            "copy_to_campaign": {
                "bulk_title": "Kopiraj entitete u drugu kampanju",
                "panel": "Kopiraj",
                "title": "Kopiraj \"{name}\" u drugu kampanju"
            },
            "create": "Kreiraj",
            "datagrid": {
                "empty": "Nema ništa za prikazati."
            },
            "delete_modal": {
                "close": "Zatvori",
                "delete": "Obriši",
                "description": "Jesi li siguran/a da želiš ukloniti {tag}?",
                "mirrored": "Ukloni zrcalni odnos.",
                "title": "Izbriši potvrdu"
            },
            "destroy_many": {
                "success": "Obrisano {count} entitet|Obrisano {count} entiteta."
            },
            "edit": "Uredi",
            "errors": {
                "boosted": "Ova je funkcionalnost dostupna samo za pojačane kampanje.",
                "node_must_not_be_a_descendant": "Nevažeći čvor (oznaka, roditeljska lokacija): bio bi potomak sam sebi."
            },
            "events": {
                "hint": "Dolje je prikazan popis svih kalendara kojima je ovaj entitet dodan pomoću sučelja \"Dodavanje događaja u kalendar\"."
            },
            "export": "Izvoz",
            "fields": {
                "ability": "Sposobnost",
                "attribute_template": "Predložak atributa",
                "calendar": "Kalendar",
                "calendar_date": "Datum kalendara",
                "character": "Lik",
                "colour": "Boja",
                "copy_attributes": "Kopiraj atribute",
                "copy_notes": "Kopiraj entitetske bilješke",
                "creator": "Tvorac",
                "dice_roll": "Bacanje kockica",
                "entity": "Entitet",
                "entity_type": "Tip entiteta",
                "entry": "Unos",
                "event": "Događaj",
                "excerpt": "Isječak",
                "family": "Obitelj",
                "files": "Datoteke",
                "has_image": "Ima sliku",
                "header_image": "Slika zaglavlja",
                "image": "Slika",
                "is_private": "Privatno",
                "is_star": "Prikvačeno",
                "item": "Predmet",
                "location": "Lokacija",
                "map": "Karta",
                "name": "Naziv",
                "organisation": "Organizacija",
                "position": "Položaj",
                "race": "Rasa",
                "tag": "Oznaka",
                "tags": "Oznake",
                "timeline": "Kronologija",
                "tooltip": "Kratki opis",
                "type": "Tip",
                "visibility": "Vidljivost"
            },
            "files": {
                "actions": {
                    "drop": "Klikni za dodavanje ili dovuci datoteku",
                    "manage": "Upravljanje datotekama entiteta"
                },
                "errors": {
                    "max": "Dosegnut maksimalni broj ({max}) datoteka za ovaj entitet.",
                    "no_files": "Nema datoteka."
                },
                "files": "Prenesene datoteke",
                "hints": {
                    "limit": "Svaki entitet može imati maksimalno  {max} datoteka prenesenih na njega.",
                    "limitations": "Podržani formati: jpg, png, gif i pdf. Maksimalna veličina datoteke: {size}"
                },
                "title": "Entitetske datoteke za {name}"
            },
            "filter": "Filtar",
            "filters": {
                "all": "Filtriraj na sve potomke",
                "clear": "Očistite filtre",
                "direct": "Filtriraj na direktne potomke",
                "filtered": "Prikazuje se {count} od {total} {entity}.",
                "hide": "Sakrij filtre",
                "options": {
                    "exclude": "Izuzmi",
                    "include": "Uključi",
                    "none": "Ništa"
                },
                "show": "Prikaži filtre",
                "sorting": {
                    "asc": "{field} uzlazno",
                    "desc": "{field} silazno",
                    "helper": "Kontroliraj u kojem se prikazuju rezultati."
                },
                "title": "Filteri"
            },
            "forms": {
                "actions": {
                    "calendar": "Dodajte datum kalendara"
                },
                "copy_options": "Opcije kopiranja"
            },
            "hidden": "Skriveno",
            "hints": {
                "attribute_template": "Primijeni predložak atributa izravno prilikom stvaranja ovog entiteta.",
                "calendar_date": "Datum kalendara omogućava jednostavno filtriranje u popisima, također održavajući događaj kalendara u odabranom kalendaru.",
                "header_image": "Ova se slika postavlja iznad entiteta. Za najbolje rezultate koristite široku sliku.",
                "image_limitations": "Podržani formati: jpg, png i gif. Maksimalna veličina datoteke: {size}.",
                "image_patreon": "Povećaj ograničenje veličine datoteke?",
                "is_private": "Ako se postavi na privatno, ovaj će entitet biti vidljiv samo članovima koji su u ulozi kampanje \"Administrator\".",
                "is_star": "Prikvačeni elementi pojavit će se na izborniku entiteta",
                "map_limitations": "Podržani formati: jpg, png, gif i svg. Maksimalna veličina datoteke: {size}.",
                "tooltip": "Zamijeni automatski generirani kratki opis sljedećim sadržajem.",
                "visibility": "Postavljanje vidljivosti na \"Administratori\" znači da će samo članovi kampanje u ulozi Administrator vidjeti ovo. Postavljanje vidljivosti na \"Samo ja\" znači da samo ti vidiš ovo."
            },
            "history": {
                "created": "Kreirao/la <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Kreirano <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Nepoznato",
                "updated": "Zadnji/a promijenio/la <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Zadnji puta ažurirano <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Pogledaj zapisnik entiteta"
            },
            "image": {
                "error": "Nismo uspjeli dobiti sliku koju ste tražili. Može biti da nam web mjesto ne dopušta preuzimanje slike (uobičajeno za Squarespace i DeviantArt) ili da veza više nije valjana. Provjerite također da slika nije veća od {size}."
            },
            "is_not_private": "Ovaj entitet trenutno nije postavljen kao privatni.",
            "is_private": "Ovaj je entitet privatan i vidljiv samo članovima administratorske uloge.",
            "linking_help": "Kako mogu povezati s ostalim unosima?",
            "manage": "Upravljanje",
            "move": {
                "description": "Premjesti ovaj entitet na drugo mjesto",
                "errors": {
                    "permission": "Nije ti dopušteno stvarati entitete tog tipa u ciljanoj kampanji.",
                    "same_campaign": "Trebaš odabrati drugu kampanju u koju će se entitet premjestiti.",
                    "unknown_campaign": "Nepoznata kampanja."
                },
                "fields": {
                    "campaign": "Nova kampanja",
                    "copy": "Napravi kopiju",
                    "target": "Novi tip"
                },
                "hints": {
                    "campaign": "Možeš pokušati premjestiti ovaj entitet u drugu kampanju.",
                    "copy": "Odaberi ovu opciju ako želiš stvoriti kopiju u novoj kampanji.",
                    "target": "Imaj na umu da se neki podaci mogu izgubiti prilikom premještanja elementa iz jedne vrste u drugu."
                },
                "success": "Premješten entitet \"{name}\".",
                "success_copy": "Kopiran entitet \"{name}\".",
                "title": "Premjesti {name}"
            },
            "new_entity": {
                "error": "Pregledaj svoje vrijednosti.",
                "fields": {
                    "name": "Naziv"
                },
                "title": "Novi entitet"
            },
            "or_cancel": "ili <a href=\"{url}\">otkaži</a>",
            "panels": {
                "appearance": "Izgled",
                "attribute_template": "Predložak atributa",
                "calendar_date": "Datum kalendara",
                "entry": "Unos",
                "general_information": "Opće informacije",
                "move": "Premjesti",
                "system": "Sustav"
            },
            "permissions": {
                "action": "Akcija",
                "actions": {
                    "bulk": {
                        "add": "Dodaj",
                        "deny": "Zabrani",
                        "ignore": "Ignoriraj",
                        "remove": "Ukloni"
                    },
                    "bulk_entity": {
                        "allow": "Dozvoli",
                        "deny": "Zabrani",
                        "inherit": "Naslijedi"
                    },
                    "delete": "Brisanje",
                    "edit": "Uređivanje",
                    "entity_note": "Bilješke entiteta",
                    "read": "Čitanje",
                    "toggle": "Uključi ili isključi"
                },
                "allowed": "Dozvoljeno",
                "fields": {
                    "member": "Član",
                    "role": "Uloga"
                },
                "helper": "Koristi ovo sučelje za preciziranje korisnika i uloga koji mogu vidjeti ili koristiti ovaj entitet.",
                "helpers": {
                    "setup": "Koristi ovo sučelje za detaljno namještanje ovlasti uloga i korisnika za ovaj entitet. {allow} će dozvoliti korisniku ili ulozi da odradi tu akciju. {deny} će zabraniti akciju. {inherit} će koristiti ovlasti korisnikove ili glavne uloge. Korisnik kojemu je postavljano {allow}, može odrađivati akciju čak i ako uloga čiji je član ima {deny}."
                },
                "inherited": "Ova uloga već ima postavljeno dopuštenje za ovu vrstu entiteta.",
                "inherited_by": "Ovaj je korisnik dio uloge \"{role}\" koja daje ova dopuštenja ovom entitetu.",
                "success": "Ovlasti spremljene.",
                "title": "Ovlasti",
                "too_many_members": "Ova kampanja ima previše članova (> 10) za prikaz u ovom sučelju. Upotrijebite gumb Ovlasti na prikazu entiteta za detaljnu kontrolu ovlasti."
            },
            "placeholders": {
                "ability": "Izaberi sposobnost",
                "calendar": "Izaberi kalendar",
                "character": "Izaberi lika",
                "entity": "Entitet",
                "event": "Izaberi događaj",
                "family": "Izaberi obitelj",
                "image_url": "Umjesto toga možete prenijeti sliku sa URL-a",
                "item": "Izaberi predmet",
                "location": "Izaberi lokaciju",
                "map": "Izaberi kartu",
                "organisation": "Izaberi organizaciju",
                "race": "Izaberi rasu",
                "tag": "Izaberi oznaku"
            },
            "relations": {
                "actions": {
                    "add": "Dodaj odnos"
                },
                "fields": {
                    "location": "Lokacija",
                    "name": "Naziv",
                    "relation": "Odnos"
                },
                "hint": "Odnosi između entiteta mogu se postaviti tako da predstavljaju njihove veze."
            },
            "remove": "Ukloni",
            "rename": "Preimenuj",
            "save": "Spremi",
            "save_and_close": "Spremi i zatvori",
            "save_and_copy": "Spremi i kopiraj",
            "save_and_new": "Spremi i kreni na novo",
            "save_and_update": "Spremi i ažuriraj",
            "save_and_view": "Spremi i pogledaj",
            "search": "Pretraži",
            "select": "Odaberi",
            "tabs": {
                "abilities": "Sposobnosti",
                "attributes": "Atributi",
                "boost": "Pojačavanje",
                "calendars": "Kalendari",
                "default": "Zadano",
                "events": "Događaji",
                "inventory": "Inventar",
                "map-points": "Točke na karti",
                "mentions": "Spominjanja",
                "menu": "Izbornik",
                "notes": "Bilješke o entitetu",
                "permissions": "Ovlasti",
                "relations": "Odnosi",
                "reminders": "Podsjetnici",
                "timelines": "Kronologije",
                "tooltip": "Kratki opis"
            },
            "update": "Ažuriraj",
            "users": {
                "unknown": "Nepoznato"
            },
            "view": "Vidljivost",
            "visibilities": {
                "admin": "Administratori",
                "admin-self": "Ja i administratori",
                "all": "Svi",
                "self": "Samo ja"
            }
        },
        "campaigns": [],
        "front": [],
        "entities": []
    },
    "hu": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Kanka bejelentkezésre váltás",
                    "update_email": "E-mail megváltoztatása",
                    "update_password": "Jelszó megváltoztatása"
                },
                "description": "Fiók szerkesztése",
                "email": "Email-cím megváltoztatása",
                "email_success": "Az email-címet sikeresen megváltoztattuk",
                "password": "Jelszó megváltoztatása",
                "password_success": "A jelszót sikeresen megváltoztattuk",
                "social": {
                    "error": "Ehhez a fiókhoz már Kanka bejelentkezést használsz.",
                    "helper": "A fiókodat jelenleg a(z) {provider} kezeli. Hagyományos Kanka bejelentkezésre válthatsz egy jelszó megadásával.",
                    "success": "A fiókod mostantól a Kanka bejelentkezést használja.",
                    "title": "Közösségiről Kanka"
                },
                "title": "Fiók"
            },
            "api": {
                "description": "API beállítások frissítése",
                "experimental": "Üdvözlünk a Kanka APIkban! Ezek a funkciók még kísérleti állapotban vannak, de elég stabilak kell, hogy legyenek ahhoz, hogy elkezdhess kommunikálni a Kanka APIval. Hozz létre egy Személyes Hozzáférés Tokent, amit az api hívásaidban használhatsz, vagy használd a Kliens Tokent, ha azt szeretnéd, hogy az alkalmazásod hozzáférjen a felhasználó adataihoz.",
                "help": "A Kanka rövidesen egy teljes REST API-t fog biztosítani, hogy harmadik féltől származó alkalmazások tudjanak csatlakozni hozzá. Az API kulcsok kezelésének részleteiről rövidesen itt olvashatsz.",
                "link": "Olvasd el az API dokumentációt",
                "request_permission": "Jelenleg is dolgozunk egy REST API-n amivel harmadik féltől származó alkalmazások is csatlakozhatnak a Kankához, azonban amíg az utolsó simításokat végezzük rajta, addig korlátozzuk a hozzáférések számát. Ha szeretnél hozzáférni az APIhoz és király alkalmazásokat fejleszteni, amelyek a Kankával kommunikálnak, kérjük, hogy lépj kapcsolatba velünk, és elküldünk minden információt, amire szükséged lehet.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Kapcsolódás",
                    "remove": "Eltávolítás"
                },
                "benefits": "A Kanka integrációt nyújt néhány harmadik fél szolgáltatásához. További ilyen integrációkra lehet számítani a jövőben.",
                "discord": {
                    "errors": {
                        "0": "1",
                        "add": "Hiba történt a Kanka és a Discord fiókod összekapcsolása során. Kérlek próbáld meg ismét."
                    },
                    "success": {
                        "add": "A Discord fiókod össze lett kapcsolva.",
                        "remove": "A Discord fiókod le lett választva."
                    },
                    "text": "Férj hozzá az előfizetői szerepekhez automatikusan."
                },
                "title": "App Integráció"
            },
            "boost": {
                "benefits": {
                    "first": "Hogy biztosítsuk a Kanka folyamatos fejlődését, bizonyos funkciók az adott kampány boost-olása után válnak elérhetővé. A boost-olás lehetőségégének megszerzése {patreon}-on keresztül történik. Egy kampányt akárki boost-olhatja is, ha van joga megtekinteni azt, így nem minden esetben a Mesélőnek kell állnia a cehhet. Egy kampány addig marad boost-olva, amíg egy felhasználó fenntartja rajta a boost-ját, valamint a támogatását is {patreon}-on keresztül. Ha egy kampány boost-olása megszűnik, az adatok nem vesznek el, csupán eltűnnek szem elől, amíg ismét nem kerül boost-olásra.",
                    "header": "Entitás fejléc képek.",
                    "images": "Egyedi alapérzelmezett entitás képek.",
                    "more": "Tudj meg többet a funkciókról.",
                    "second": "Egy kampány Boost-olása az alábbi előnyöket biztosítja:",
                    "theme": "Kampány-szintű téma, és egyedi megjelenítési stílus.",
                    "third": "A kampány boost-olásához keresd fel a kampány oldalát, kattints a \"{boost_button}\" gombra, amely a \"{edit_button}\" felett helyezkedik el.",
                    "tooltip": "Egyedi entitás tooltip-ek.",
                    "upload": "Megnövelt fájlfeltöltési korlát az összes Tag számára."
                },
                "buttons": {
                    "boost": "Boost"
                },
                "campaigns": "Boost-olt kapányok száma: {count} / {max}",
                "exceptions": {
                    "already_boosted": "{name} kampány már boost-olva van.",
                    "exhausted_boosts": "Elfogytak a kiosztható Boost-jaid. Vond vissza egy boost-od valamelyik kampányról, mielőtt egy újnak adnál egyet."
                },
                "success": {
                    "boost": "{name} kampány boost-olva lett.",
                    "delete": "Boost visszavonva innen: {name}"
                },
                "title": "Boost"
            },
            "countries": {
                "austria": "Ausztria",
                "belgium": "Belgium",
                "france": "Franciaország",
                "germany": "Németország",
                "italy": "Olaszország",
                "netherlands": "Hollandia",
                "spain": "Spanyolország"
            },
            "invoices": {
                "actions": {
                    "download": "PDF letöltése",
                    "view_all": "Összes megtekintése"
                },
                "empty": "Nincs számla",
                "fields": {
                    "amount": "Mennyiség",
                    "date": "Dátum",
                    "invoice": "Számla",
                    "status": "Állapot"
                },
                "header": "Alább található a legutolsó 24 számla listája, melyek letölthetőek.",
                "status": {
                    "paid": "Fizetve",
                    "pending": "Függőben"
                },
                "title": "Számlák"
            },
            "layout": {
                "description": "Elrendezési beállítások frissítése",
                "success": "Az elrendezési beállításokat frissítettük.",
                "title": "Elrendezés"
            },
            "menu": {
                "account": "Fiók",
                "api": "API",
                "apps": "Appok",
                "billing": "Fizetési Mód",
                "boost": "Boost",
                "invoices": "Számlák",
                "layout": "Elrendezés",
                "other": "Egyéb",
                "patreon": "Patreon",
                "payment_options": "Fizetési lehetőségek",
                "personal_settings": "Személyes beállítások",
                "profile": "Profil",
                "subscription": "Előfizetés",
                "subscription_status": "Előfizetés állapota"
            },
            "patreon": {
                "actions": {
                    "link": "Fiókok összekapcsolása",
                    "view": "Látogasd meg a Kankát a Patreonon!"
                },
                "benefits": "A Patreon támogatóink nagyobb képeket tölthetnek fel, segítenek nekünk fedezni a szerverköltségeket, valamint lehetővé teszik, hogy több időt fordíthassunk a Kankán végzett munkánkra.",
                "benefits_features": "csodálatos képességek",
                "deprecated": "Elavult funkció - ha támogatni szeretnéd a Kankát, kérlek tedd az {subscription} segítségével. A Patreon-on keresztüli fizetés természetesen aktív marad azon támogatóinknak, akik még az új előfizetési rendszer élesbe állítása előtt kezdték a támogatást.",
                "description": "Szinkronizálás a Patreonnal",
                "errors": {
                    "invalid_token": "Érvénytelen token! A Patreon nem tudta érvényesíteni a kérésed.",
                    "missing_code": "Hiányzó kód! A Patreon nem küldött vissza kódot, amely a fiókodat azonosítja.",
                    "no_pledge": "Nincs támogatás! A Patreon azonosította a fiókodat, de nem tud aktív támogatásról."
                },
                "link": "Nyomd meg ezt a gombot, ha jelenleg támogatod a Kankát a Patreonon, aktiválva a bónuszaid.",
                "linked": "Köszönjük, hogy támogatsz minket a Patreonon! A fiókjaid összekapcsoltuk.",
                "pledge": "{name} támogatási szint",
                "remove": {
                    "button": "Patreon fiók leválasztása",
                    "success": "A Patreon fiókod le lett választva.",
                    "text": "A Patreon fiók leválasztása megszűntet minden bónuszt, a Dicsőségcsarnokbeli jelenléted, kampány boost-ot, és egyéb, a támogatással szerzett funkciókat a Kankán. Fontos megjegyezni, hogy egyik boost-tal kihelyezett tartalmad sem fog elveszni (pl. entitás fejlécek). Amint ismét előfizetővé válasz, újra hozzá fogsz férni ezekhez az adatokhoz, beleértve a lehetőségét, hogy boost-olj, egy korábban boostolt kampányodat.",
                    "title": "A Patreon fiókod leválasztása a Kankáról"
                },
                "success": "Köszönjük, hogy támogatsz minket a Patreonon!",
                "title": "Patreon",
                "wrong_pledge": "A támogatási szintedet manuálisan állítjuk be, így kérjük, adj nekünk pár napot, hogy megfelelően beállíthassuk. Ha továbbra is helytelennek látod, lépj velünk kapcsolatba."
            },
            "profile": {
                "actions": {
                    "update_profile": "Profil módosítása"
                },
                "avatar": "Profilkép",
                "description": "Profil módosítása",
                "success": "A profilodat sikeresen módosítottuk.",
                "title": "Személyes profil"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Előfizetés lemondása",
                    "subscribe": "Előfizetés",
                    "update_currency": "Választott pénznem mentése"
                },
                "benefits": "Támogatásoddal lehetőséged nyílik, hogy hozzáférj új {featureshez}, valamint ezzel is segítesz minket, hogy több időt szentelhessünk a Kanka fejlesztésének. A szerverünkön nem tárolunk, és nem küldünk keresztül semmilyen bankkártya információt. A számlázáshoz a {stripe} vesszük segítségül.",
                "billing": {
                    "helper": "A számlázási információid tárolása, és feldolgozása a {stripe}-on keresztül történik, biztonságos formában. Ez a fizetési mód kerül felhasználásra minden előfizetésed esetében.",
                    "saved": "Mentett fizetési mód",
                    "title": "Fizetési mód szerkesztése"
                },
                "cancel": {
                    "text": "Sajnáljuk, hogy mész! Az előfizetésed lemondása aktívan tartja előfizetésed a következő számlázási ciklusig, amikor is megszűnnek a kampány boost-jait, és minden egyéb előnyöd, amelyet a Kanka támogatásával szereztél. Ha van kedved, kérlek töltsd ki az alábbi kérdőívet, hogy megtudhassuk, hogy mit csinálhatnánk jobban a jövőben, illetve hogy mi vezetett arra a döntésre, hogy megszüntesd az előfizetésed."
                },
                "cancelled": "Az előfizetésed felmondásra került. Ismét megújíthatod előfizetésed, amint a jelenlegi előfizetésed lejár.",
                "change": {
                    "text": {
                        "monthly": "A {tier} szintre vagy előfizetve, a számlázás havonta történik, {amount} értékben.",
                        "yearly": "A {tier} szintre vagy előfizetve, a számlázás évente történik, {amount} értékben."
                    },
                    "title": "Előfizetői szint megváltoztatása"
                },
                "currencies": {
                    "eur": "EUR",
                    "usd": "USD"
                },
                "currency": {
                    "title": "Változtasd meg a számlázás kívánt pénznemét."
                },
                "errors": {
                    "callback": "A fizetési szolgáltatónk hibát jelzett. Kérlek próbáld meg újra, vagy vedd fel velünk a kapcsolatot, amennyiben a hiba továbbra is fennáll.",
                    "subscribed": "Nem sikerült feldolgoznunk az előfizetésed. A Stripe az alábbi hibaokot feltételezi:"
                },
                "fields": {
                    "active_since": "Előfizetés kezdete",
                    "active_until": "Előfizetés vége",
                    "billed_monthly": "Havonta számlázva",
                    "billing": "Számlázás",
                    "currency": "Számlázott összeg pénzneme",
                    "payment_method": "Fizetési mód",
                    "plan": "Aktuális terv",
                    "reason": "Indok"
                },
                "helpers": {
                    "alternatives": "Az előfizetésed fizetése a következővel {method}. Ez a fizetési mód nem fog automatikusan megújulni az előfizetésed végén. {method} csak Euróval történő fizetés esetén elérhető.",
                    "alternatives_warning": "Az előfizetésed fejlesztése ezzel a fizetési móddal nem lehetséges. Kérlek válassz új előfizetést, amikor a jelenlegi előfizetésed lejárna.",
                    "alternatives_yearly": "A megújuló előfizetés korlátozásai miatt, a(z) {metod} csak éves előfizetéssel használható."
                },
                "manage_subscription": "Előfizetés menedzselése",
                "payment_method": {
                    "actions": {
                        "add_new": "Új fizetési mód hozzáadása",
                        "change": "Fizetési mód megváltoztatása",
                        "save": "Fizetési mód mentése",
                        "show_alternatives": "Alternatív fizetési lehetőségek."
                    },
                    "add_one": "Jelenleg nincs mentett fizetési módod.",
                    "alternatives": "Előfizethetsz ezeket az alternatív előfizetési lehetőségeket választva. Ebben az esetben csupán egyszer kerül terhelésre a számlád, és nem fog automatikusan megújulni az előfizetésed minden hónapban.",
                    "card": "Kártya",
                    "card_name": "A kártyán szereplő név",
                    "country": "Tartózkodási hely",
                    "ending": "Lejárat",
                    "helper": "Ez a kártya kerül használatra minden előfizetésed esetén.",
                    "new_card": "Új fizetési mód hozzáadása",
                    "saved": "{brand} utolsó számjegyei: {last4}"
                },
                "placeholders": {
                    "reason": "Opcionálisan kérlek mondd el, miért nem támogatod tovább a Kankát. Esetleg anyagi okokból döntöttél így?"
                },
                "plans": {
                    "cost_monthly": "{amount} {currency} havonta kiszámlázva.",
                    "cost_yearly": "{amount} {currency} évente kiszámlázva."
                },
                "sub_status": "Előfizetési információk",
                "subscription": {
                    "actions": {
                        "downgrading": "Kérlek vedd fel velünk a kapcsolatot az alacsonyabb szintre váltáshoz",
                        "rollback": "Kobold előfizetői szintre váltás",
                        "subscribe": "{tier} előfizetői szintre váltás havi számlázással",
                        "subscribe_annual": "{tier} előfizetői szintre váltás éves számlázással"
                    }
                },
                "success": {
                    "alternative": "A fizetésed regisztrálásra került. Értesítést fogsz kapni, amint feldolgozásra került, és az előfizetésed aktiválódott.",
                    "callback": "Az előfizetés sikeresen megtörtént. A fiókod frissülni fog, amint a fizetési szolgáltatónk tudatja velünk a változást. (Ez néhány percet igénybe vehet.)",
                    "cancel": "Az előfizetésed lemondásra került. A jelenlegi előfizetés továbbra is aktív marad a számlázási periódus végéig.",
                    "currency": "A kívánt pénznem beállítása frissült.",
                    "subscribed": "Az előfizetés sikeres volt. Ne feledkezz el feliratkozni a Közösségi szavazás hírlevelére, hogy értesülj, amikor egy szavazás elindul. A hírlevél beállításait a Profilodnál tudod szerkeszteni."
                },
                "tiers": "Előfizetői szintek",
                "trial_period": "Az éves előfizetésekre 14 napos visszamondási jog él. Vedd fel velünk a kapcsolatot a következő címen: {email} amennyiben szeretnéd lemondani az éves előfizetésed, és az összeg visszatérítését kérvényezni.",
                "upgrade_downgrade": {
                    "button": "Magasabb, vagy Alacsonyabb szintre váltás információi",
                    "downgrade": {
                        "bullets": {
                            "end": "Az aktuális szintednek megfelelő előnyök a jelenlegi számlázási ciklusod végéig érvényben maradnak, amelyet követően az alacsonyabb szintű előfizetés lép érvénybe."
                        },
                        "title": "Amikor egy alacsonyabb szintű előfizetésre váltasz"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "A fizetési módod azonnal kiszámlázásra kerül, és egyből hozzáférsz az új előfizetői szint előnyeihez.",
                            "prorate": "Amikor Bagolymedvéből Elementállá emeled az előfizetésed, csak a szintek közötti különbség kerül kiszámlázásra."
                        },
                        "title": "Amikor magasabb szintű előfizetésre váltasz"
                    }
                },
                "warnings": {
                    "incomplete": "Nem sikerült az előfizetés összegét a kártyádra terhelni. Kérlek frissítsd a bakkártya adataidat, és a következő pár napban ismételten megpróbáljuk megterhelni az előfizetés összegével. Ha ismét sikertelen a tranzakció, az előfizetésed lemondásra kerül.",
                    "patreon": "A fiókod jelenleg a Patreon-nal van összekapcsolva. Kérlek csatlakoztasd le a fiókod a {patreon} beállításaiban, mielőtt Kanka előfizetésre váltanál!"
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Új beszélgetés létrehozása",
                "success": "'{name}' beszélgetést létrehoztuk.",
                "title": "Új beszélgetés"
            },
            "destroy": {
                "success": "'{name}' beszélgetést eltávolítottuk."
            },
            "edit": {
                "description": "A beszélgetés frissítése",
                "success": "'{name}' beszélgetést frissítettük.",
                "title": "{name} beszélgetés"
            },
            "fields": {
                "messages": "Üzenetek",
                "name": "Megnevezés",
                "participants": "Résztvevők",
                "target": "Célpont",
                "type": "Típus"
            },
            "hints": {
                "participants": "Kérjük, adj résztvevőket a beszélgetésedhez az {icon} ikonra kattintva a jobb felső részen."
            },
            "index": {
                "add": "Új beszélgetés",
                "description": "{name} kategória kezelése",
                "header": "Beszélgetés itt: {name}",
                "title": "Beszélgetés"
            },
            "messages": {
                "destroy": {
                    "success": "Üzenet eltávolítva."
                },
                "is_updated": "Frissítve",
                "load_previous": "Előző üzenet betöltése",
                "placeholders": {
                    "message": "Üzeneted"
                }
            },
            "participants": {
                "create": {
                    "success": "{entity} résztvevőt hozzáadtuk a beszélgetéshez."
                },
                "description": "Résztvevők hozzáadása vagy eltávolítása a beszélgetésből",
                "destroy": {
                    "success": "{entity} résztvevőt eltávolítottuk a beszélgetésből."
                },
                "modal": "Résztvevők",
                "title": "{name} résztvevői"
            },
            "placeholders": {
                "name": "A beszélgetés megnevezése",
                "type": "Játékbeli, előkészület, cselekmény"
            },
            "show": {
                "description": "Egy beszélgetés részletes megjelenítése",
                "title": "{name} beszélgetés"
            },
            "tabs": {
                "conversation": "Beszélgetés",
                "participants": "Résztvevők"
            },
            "targets": {
                "characters": "Karakterek",
                "members": "Tagok"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Műveletek",
                "apply": "Alkalmaz",
                "back": "Vissza",
                "copy": "Másolás",
                "copy_mention": "Említett [ ] másolása",
                "copy_to_campaign": "Másolás Kampányba",
                "explore_view": "Hierarchikus nézet",
                "export": "Export (pdf)",
                "find_out_more": "Tudj meg többet!",
                "go_to": "Ugrás {name} entitáshoz",
                "json-export": "Exportálás (json)",
                "more": "Több művelet",
                "move": "Mozgatás",
                "new": "Új",
                "next": "Következő",
                "private": "Privát",
                "public": "Nyilvános",
                "reset": "Visszaállítás"
            },
            "add": "Hozzáadás",
            "alerts": {
                "copy_mention": "Az entitás említését átmásoltuk a vágólapodra."
            },
            "attributes": {
                "actions": {
                    "add": "Tulajdonság hozzáadása",
                    "add_block": "Blokk hozzáadása",
                    "add_checkbox": "Jelölőnégyzet hozzáadása",
                    "add_text": "Szöveg hozzáadása",
                    "apply_template": "Tulajdonságsablon alkalmazása",
                    "manage": "Kezelés",
                    "remove_all": "Összes törlése"
                },
                "create": {
                    "description": "Új tulajdonság létrehozása",
                    "success": "{name} tulajdonságot hozzáadtuk {entity} entitáshoz.",
                    "title": "{name} entitáshoz új tulajdonság hozzáadása"
                },
                "destroy": {
                    "success": "{entity} {name} tulajdonságát eltávolítottuk."
                },
                "edit": {
                    "description": "Létező entitás frissítése",
                    "success": "{entity} {name} tulajdonságát frissítettük.",
                    "title": "{name} tulajdonságnak frissítése"
                },
                "fields": {
                    "attribute": "Tulajdonság",
                    "community_templates": "Közösségi sablonok",
                    "is_private": "Privát Tulajdonságok",
                    "is_star": "Kitűzve",
                    "template": "Sablon",
                    "value": "Érték"
                },
                "helpers": {
                    "delete_all": "Biztosan ki akarod törölni az entitás összes tulajdonságát?"
                },
                "hints": {
                    "is_private": "Elrejtheted egy entitás összes tulajdonságát az összes, nem-admin szerepű felhasználó elől, úgy, hogy priváttá teszed őket."
                },
                "index": {
                    "success": "{entity} számára frissítettük a tulajdonságokat.",
                    "title": "Tulajdonságok {name} számára"
                },
                "placeholders": {
                    "attribute": "Hódítások száma, Kihívási érték, kezdeményezés, népesség",
                    "block": "Blokk megnevezése",
                    "checkbox": "Jelölőnégyzet megnevezése",
                    "section": "Szakasz neve",
                    "template": "Válassz ki egy sablont!",
                    "value": "A tulajdonság értéke"
                },
                "template": {
                    "success": "{name} tulajdonságsablont alkalmaztuk {entity} entátáshoz.",
                    "title": "{name} számára tulajdonságsablon alkalmazása"
                },
                "types": {
                    "attribute": "Tulajdonság",
                    "block": "Blokk",
                    "checkbox": "Jelölőnégyzet",
                    "section": "Szakasz",
                    "text": "Többsoros szöveg"
                },
                "visibility": {
                    "entry": "A tulajdonság megjelenik az entitás menüjén",
                    "private": "A tulajdonság csak az \"Admin\" szerepű tagok számára látható.",
                    "public": "A tulajdonság minden tag számára látható.",
                    "tab": "A tulajdonság csak a Tulajdonságok fülön jelenik meg."
                }
            },
            "boosted": "Kiemelt",
            "boosted_campaigns": "Kiemelt kampányok",
            "bulk": {
                "actions": {
                    "edit": "Tömeges szerkesztés, és címkézés"
                },
                "age": {
                    "helper": "Használhatod a + és - gombokat a szám előtt, hogy frissítsd a korát az adott számmal."
                },
                "delete": {
                    "title": "Több entitás törlése egyidejűleg",
                    "warning": "Biztosan törölni szeretnéd a kijelölt entitásokat?"
                },
                "edit": {
                    "tagging": "Címkézési esemény",
                    "tags": {
                        "add": "Hozzáadás",
                        "remove": "Eltávolítás"
                    },
                    "title": "Több entitás együttes szerkesztése"
                },
                "errors": {
                    "admin": "Csak a kampány adminjai tudják megváltoztatni egy entitás privát státuszát.",
                    "general": "Hiba lépett fel a művelet feldolgozása közben. Kérlek próbáld újra, és vedd fel velünk a kapcsolatot, ha a probléma továbbra is fennáll. Hibaüzenet: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Felülírás"
                    },
                    "helpers": {
                        "override": "Bepipálás esetén a kijelölt entitásokra vonatkozó korábbi jogosultságok elvesznek, és teljesen felülírásra kerülnek ezekkel a jogosultságokkal. Ha nincs bepipálva, a most kijelölt jogosultságok egyszerűen csak hozzáadódnak a már meglévők mellé az egyes entitásoknál."
                    },
                    "title": "Jogosultság változtatása több entitásra vonatkozóan"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} entitásból másolat jött létre itt: {campaign}.|[2,*] {count} entitásból másolat jött létre itt: {campaign}.",
                    "editing": "{1} {count} entitás frissült.|[2,*] {count} entitás frissült.",
                    "permissions": "{1} Jogosultságok változtak meg meg {count} entitás esetén.|[2,*]Jogosultságok változtak meg {count} entitás esetén.",
                    "private": "{count} entitás most már privát|{count} entitás most már privát.",
                    "public": "{count} entitás most már látható|{count} entitás most már látható."
                }
            },
            "cancel": "Mégse",
            "click_modal": {
                "close": "Bezárás",
                "confirm": "Megerősítés",
                "title": "Igazold vissza az akciódat!"
            },
            "copy_to_campaign": {
                "bulk_title": "Entitások másolása egy másik kampányba",
                "panel": "Másolás",
                "title": "'{name}' másolása egy másik kampányba"
            },
            "create": "Létrehozás",
            "datagrid": {
                "empty": "Nincs megjeleníthető adat"
            },
            "delete_modal": {
                "close": "Bezárás",
                "delete": "Törlés",
                "description": "Biztos, hogy eltávolítod?",
                "mirrored": "Tükörkapcsolat eltávolítása.",
                "title": "Törlés megerősítése"
            },
            "destroy_many": {
                "success": "{count} entitást töröltünk|{count} entitást töröltünk."
            },
            "edit": "Szerkesztés",
            "errors": {
                "boosted": "Ez a lehetőség csak a kiemelt kampányokban érhető el.",
                "node_must_not_be_a_descendant": "Érvénytelen csomópont (címke, előd helyszín): saját maga leszármazottja lehet."
            },
            "events": {
                "hint": "Ez egy lista minden naptárról, amihez ezt az entitást hozzáadták az \"Esemény hozzáadása a naptárhoz\" felületen."
            },
            "export": "Export",
            "fields": {
                "ability": "Képesség",
                "attribute_template": "Tulajdonságsablon",
                "calendar": "Naptár",
                "calendar_date": "Naptári dátum",
                "character": "Karakter",
                "colour": "Szín",
                "copy_attributes": "Tulajdonság másolása",
                "copy_notes": "Entitásjegyzetek másolása",
                "creator": "Létrehozó",
                "dice_roll": "Dobás",
                "entity": "Entitás",
                "entity_type": "Entitás Típusa",
                "entry": "Bejegyzés",
                "event": "Esemény",
                "excerpt": "Kivonat",
                "family": "Család",
                "files": "Állományok",
                "has_image": "Rendelkezik képpel",
                "header_image": "Fejléc kép",
                "image": "Kép",
                "is_private": "Privát",
                "is_star": "Kitűzve",
                "item": "Tárgy",
                "location": "Helyszín",
                "map": "Térkép",
                "name": "Név",
                "organisation": "Szervezet",
                "position": "Elhelyezkedés",
                "race": "Faj",
                "tag": "Címke",
                "tags": "Címkék",
                "timeline": "Idővonal",
                "tooltip": "Tooltip",
                "type": "Típus",
                "visibility": "Láthatóság"
            },
            "files": {
                "actions": {
                    "drop": "Klikkelj ide egy állomány hozzáadásához vagy kidobásához",
                    "manage": "Az entitás állományainak kezelése"
                },
                "errors": {
                    "max": "Elérted az entitáshoz rendelhető állományok maximális számát ({max}).",
                    "no_files": "Nincs állomány."
                },
                "files": "Feltöltött állomány",
                "hints": {
                    "limit": "Minden entitáshoz maximum {max} állomány tölthető fel.",
                    "limitations": "Támogatott formátumok: jpg, png, gif és pdf. Maximális méret: {size}"
                },
                "title": "{name} állományai"
            },
            "filter": "Szűrő",
            "filters": {
                "all": "Szűrés minden leszármazottra",
                "clear": "Szűrők törlése",
                "direct": "Szűrés közvetlen leszármazottakra",
                "filtered": "{count} {entity} a(z) {total} elemből",
                "hide": "Szűrők elrejtése",
                "options": {
                    "exclude": "Nem tartalmazza",
                    "include": "Tartalmazza",
                    "none": "Nincs"
                },
                "show": "Szűrők megmutatása",
                "sorting": {
                    "asc": "{field} Növekvő sorrend",
                    "desc": "{field} Csökkenő sorrend",
                    "helper": "A találatok megjelenítésének sorrendje."
                },
                "title": "Szűrők"
            },
            "forms": {
                "actions": {
                    "calendar": "Naptári dátum hozzáadása"
                },
                "copy_options": "Másolási lehetőségek"
            },
            "hidden": "Rejtett",
            "hints": {
                "attribute_template": "Közvetlenül is alkalmazhatsz egy tulajdonságsablont, amikor létrehozod ezt az entitást.",
                "calendar_date": "Egy naptári dátum könnyű szűrést tesz lehetővé a listákban, és fenntart egy naptári eseményt is a választott naptárban.",
                "header_image": "Ez a kép az entitás fölött fog megjelenni. Érdemes széles képet választani.",
                "image_limitations": "Támogatott formátumok: jpg, png és gif. Maximális állományméret: {size}.",
                "image_patreon": "Megnöveled az állományméret korlátját?",
                "is_private": "Ha privátnak állítod be, ezt az entitást csak a kampány \"Admin\" szereplői fogják látni.",
                "is_star": "Kitűzött elemek az entitás menüjén jelennek meg",
                "map_limitations": "Támogatott formátumok: jpg, png, gif és svg. Maximális állományméret: {size}.",
                "tooltip": "Lecseréli az automatikusan generált tooltip szöveget az alábbi tartalommal.",
                "visibility": "Ha a láthatóságot Admin-ra állítod, akkor csak az Admin jogú felhasználók tudják megnézni ezt. 'Magam'-ra állítva csak te láthatod."
            },
            "history": {
                "created": "Létrehozta <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Létrejött <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Ismeretlen",
                "updated": "Utolsó módosítás: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Uoljára módosítva <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Entitásnapló megtekintése"
            },
            "image": {
                "error": "Nem érjük el a kívánt képet. Lehet, hogy a honlap nem engedi, hogy letöltsük a képet (ilyen a Squarespace és a DeviantArt), vagy a link nem érvényes már. Kérjük, arról is bizonyosodj meg, hogy a kép nem nagyobb, mint {size}."
            },
            "is_private": "Ez az entitás privát, így nem látható a nem-admin felhasználók számára.",
            "linking_help": "Hogyan hozhatok létre linket más entitásokhoz?",
            "manage": "Kezelés",
            "move": {
                "description": "Az entitás más helyre mozgatása",
                "errors": {
                    "permission": "Nincs engedélyed ilyen tipusú entitás létrehozására ebben a kampányban.",
                    "same_campaign": "Ki kell választanod egy másik kampányt, ahová az entitás szeretnéd mozgatni.",
                    "unknown_campaign": "Ismeretlen kampány."
                },
                "fields": {
                    "campaign": "Új kampány",
                    "copy": "Készíts másolatot",
                    "target": "Új típus"
                },
                "hints": {
                    "campaign": "Megpróbálhatod egy másik kampányba mozgatni ezt az entitást.",
                    "copy": "Ezt válaszd ki, ha szeretnél egy másolatot készíteni az új kampányba.",
                    "target": "Kérjük, ne felejtsd el, hogy néhány adat elveszhet, amikor egy elemet az egyik típusból egy másikban mozgatod."
                },
                "success": "'{name}' entitást átmozgattuk.",
                "success_copy": "'{name}' entitást másoltuk.",
                "title": "{name} mozgatása"
            },
            "new_entity": {
                "error": "Kérjük, nézd meg jól az értékeket!",
                "fields": {
                    "name": "Név"
                },
                "title": "Új entitás"
            },
            "or_cancel": "vagy <a href=\"{url}\">mégse</a>",
            "panels": {
                "appearance": "Megjelenés",
                "attribute_template": "Tulajdonságsablon",
                "calendar_date": "Naptári dátum",
                "entry": "Bejegyzés",
                "general_information": "Általános információ",
                "move": "Mozgatás",
                "system": "Rendszer"
            },
            "permissions": {
                "action": "Akció",
                "actions": {
                    "bulk": {
                        "add": "Hozzáadás",
                        "deny": "Tilt",
                        "ignore": "Figyelmen kívül hagyás",
                        "remove": "Eltávolítás"
                    },
                    "bulk_entity": {
                        "allow": "Engedélyez",
                        "deny": "Tilt",
                        "inherit": "Örököl"
                    },
                    "delete": "Törlés",
                    "edit": "Szerkesztés",
                    "entity_note": "Entitás jegyzetek",
                    "read": "Olvasás",
                    "toggle": "Átkapcsolás"
                },
                "allowed": "Engedélyezett",
                "fields": {
                    "member": "Tag",
                    "role": "Szerep"
                },
                "helper": "Használd ezt a felületet, hogy finomhangold, melyik felhasználó és szerep tud kapcsolatba lépni ezzel az entitással. {allow}",
                "helpers": {
                    "entity_note": "Entitás Jegyzetek létrehozásának engedélyezése a felhasználók számára ezen az entitáson. Enélkül a jogosultság nélkül a felhasználók látják majd az Entitás Jegyzeteket, ha azok láthatósága 'Mindenki'-re van állítva.",
                    "setup": "Használd ezt a felületet, hogy finomhangold, melyik felhasználó és szerep tud kapcsolatba lépni ezzel az entitással. {allow} engedélyezni fogja a felhasználó, vagy a szerep birtokosa számára, ennek a műveletnek az elvégzését. {deny} megtiltja hogy ezt a műveletet végezhessék. {inherit} beállítás esetén pedig a felhasználó szerepét, vagy fő szerepének jogosultságát fogja figyelembe venni. Egy felhasználói szinten beállított {allow} jog engedélyt fog adni a művelet elvégzésére, még akkor is, ha a felhasználó szerepköre {deny}-aná ezt."
                },
                "inherited": "Ez a szerep már rendelkezik ezzel a jogosultsággal ehhez a típusú entitáshoz.",
                "inherited_by": "Ez a felhasználó tagja a '{role}' szerepnek, amely rendelkezik jogosultsággal ezen az entitás típuson.",
                "success": "Engedélyeket elmentettük.",
                "title": "Engedélyek",
                "too_many_members": "A kampánynak túl sok tagja (>10) van ahhoz, hogy kijelezzük ezen a felületen. Kérjük, használd az entitás nézetben az Engedély gombot, hogy kezeld az engedélyek részleteit."
            },
            "placeholders": {
                "ability": "Válassz egy képességet",
                "calendar": "Válassz egy naptárat!",
                "character": "Válassz egy karaktert!",
                "entity": "Entitás",
                "event": "Válassz egy eseményt!",
                "family": "Válassz egy családot!",
                "image_url": "Egy URL-címről is feltölthetsz képet",
                "item": "Válassz egy tárgyat!",
                "location": "Válassz egy helyszínt!",
                "map": "Válassz térképet!",
                "organisation": "Válassz egy szervezetet!",
                "race": "Válassz egy fajt!",
                "tag": "Válassz egy címkét!"
            },
            "relations": {
                "actions": {
                    "add": "Hozz létre egy kapcsolatot"
                },
                "fields": {
                    "location": "Helyszín",
                    "name": "Név",
                    "relation": "Kapcsolat"
                },
                "hint": "Az entitások közötti kapcsolatok segítenek meghatározni a viszonyukat."
            },
            "remove": "Eltávolítás",
            "rename": "Átnevezés",
            "save": "Mentés",
            "save_and_close": "Mentés és bezárás",
            "save_and_copy": "Mentés és másolás",
            "save_and_new": "Mentés és új",
            "save_and_update": "Mentés és frissítés",
            "save_and_view": "Mentés és megtekintés",
            "search": "Keresés",
            "select": "Kiválasztás",
            "tabs": {
                "abilities": "Képességek",
                "attributes": "Tulajdonságok",
                "boost": "Boost",
                "calendars": "Naptárak",
                "default": "Alapértelmezett",
                "events": "Események",
                "inventory": "Felszerelés",
                "map-points": "Térképi pontok",
                "mentions": "Említések",
                "menu": "Menü",
                "notes": "Jegyzetek",
                "permissions": "Engedélyek",
                "relations": "Kapcsolatok",
                "reminders": "Emlékeztetők",
                "timelines": "Idővonalak",
                "tooltip": "Tooltip"
            },
            "update": "Frissítés",
            "users": {
                "unknown": "Ismeretlen"
            },
            "view": "Megtekintés",
            "visibilities": {
                "admin": "Admin",
                "admin-self": "Magam és az admin",
                "all": "Mindenki",
                "self": "Magam"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "it": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Vai al Login Kanka",
                    "update_email": "Aggiorna e-mail",
                    "update_password": "Aggiorna password"
                },
                "description": "Aggiorna il tuo account",
                "email": "Cambia e-mail",
                "email_success": "E-Mail aggiornata.",
                "password": "Cambia password",
                "password_success": "Password aggiornata.",
                "social": {
                    "error": "Stai già utilizzando il login Kanka per questo account.",
                    "helper": "Il tuo account è attualmente gestito da {provider}. Puoi smettere di utilizzarlo e passare al login standard di Kanka impostando una password.",
                    "success": "Il tuo account ora utilizza il login Kanka.",
                    "title": "Social a Kanka"
                },
                "title": "Account"
            },
            "api": {
                "description": "Aggiorna le impostazioni delle tue API",
                "experimental": "Benvenuto alle API di Kanka! Queste caratteristiche sono ancora in fase di sperimentazione ma dovrebbero essere abbastanza stabili per permetterti di incominciare a comunicare con le APIs. Crea un Token di Accesso Personale da utilizzare nelle tue richieste api o utilizza il Token del Client se vuoi che la tua app abbia accesso ai dati utente.",
                "help": "Kanka fornirà presto una RESTful API in modo che applicazioni di terze parti possano connettervisi. I dettagli su come gestire le tue chiavi API saranno mostrati qui.",
                "link": "Leggi la documentazione delle API",
                "request_permission": "Stiamo attualmente creando una potente RESTful API in modo che applicazioni di terze parti possano connettervisi. Stiamo attualmente limitando il numero di utenti che possono interagire con le API mentre le miglioriamo. Se vuoi avere accesso alle API e creare eccezionali apps che comunichino con Kanka, per favore contattaci e noi ti invieremo tutte le informazioni di cui hai bisogno.",
                "title": "API"
            },
            "layout": {
                "description": "Aggiorna le tue impostazioni di layout",
                "success": "Impostazioni di layout aggiornate.",
                "title": "Layout"
            },
            "menu": {
                "account": "Account",
                "api": "API",
                "layout": "Layout",
                "patreon": "Patreon",
                "personal_settings": "Impostazioni Personali",
                "profile": "Profilo"
            },
            "patreon": {
                "actions": {
                    "link": "Collega Account",
                    "view": "Visita Kanka su Patreon"
                },
                "benefits": "Supportarci su Patreon fa si che tu possa caricare immagini più grandi, aiuti noi a coprire i costi del server e ci permetti di dedicare più tempo a lavorare su Kanka.",
                "description": "Connetti con Patreon",
                "errors": {
                    "invalid_token": "Token non valido! Patreon non può verificare la tua richiesta.",
                    "missing_code": "Codice mancante! Patreon non ha ritornato un codice per l'identificazione del tuo account.",
                    "no_pledge": "Nessun pledge! Patreon ha riconosciuto il tuo account my non è a conoscenza di nessun pledge attivo."
                },
                "link": "Usa questo bottone se stai attualmente supportando Kanka su {patreon}. Questo sbloccherà i bonus",
                "linked": "Grazie per supportare Kanka su Patreon! Il tuo account è stato collegato.",
                "pledge": "Pledge: {name}",
                "success": "Grazie per supportare Kanka su Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Il livello del tuo pledge è settato manualmente da noi, quindi per favore daccia fino a qualche giorno per settarlo correttamente. Se resta sbagliato per diverso tempo ti preghiamo di contattarci."
            },
            "profile": {
                "actions": {
                    "update_profile": "Aggiorna profilo"
                },
                "avatar": "Immagine del profilo",
                "description": "Aggiorna il tuo profilo",
                "success": "Profilo aggiornato.",
                "title": "Profilo Personale"
            }
        },
        "conversations": {
            "create": {
                "description": "Crea una nuova conversazione",
                "success": "Conversazione '{name}' creata.",
                "title": "Nuova conversazione"
            },
            "destroy": {
                "success": "Conversazione '{name}' rimossa."
            },
            "edit": {
                "description": "Aggiorna la conversazione",
                "success": "Conversazione '{name}' aggiornata.",
                "title": "Conversazione {name}"
            },
            "fields": {
                "messages": "Messaggi",
                "name": "Nome",
                "participants": "Partecipanti",
                "target": "Bersaglio",
                "type": "Tipo"
            },
            "hints": {
                "participants": "Per favore aggiungi partecipanti alla tua conversazione premendo l'icona {icon} in altro a destra."
            },
            "index": {
                "add": "Nuova conversazione",
                "description": "Gestisci la categoria di {name}.",
                "header": "Conversazioni in {name}",
                "title": "Conversazioni"
            },
            "messages": {
                "destroy": {
                    "success": "Messaggio rimosso."
                },
                "is_updated": "Aggiornata",
                "load_previous": "Carica i messaggi precedenti",
                "placeholders": {
                    "message": "Il tuo messaggio"
                }
            },
            "participants": {
                "create": {
                    "success": "Partecipante {entity} aggiunto alla conversazione."
                },
                "description": "Aggiungi o rimuovi partecipanti di una conversazione",
                "destroy": {
                    "success": "Partecipante {entity} rimosso dalla conversazione."
                },
                "modal": "Partecipanti",
                "title": "Partecipanti di {name}"
            },
            "placeholders": {
                "name": "Nome della conversazione",
                "type": "In Gioco, Preparazione, Trama"
            },
            "show": {
                "description": "Una vista dettagliata della conversazione",
                "title": "Conversazione {name}"
            },
            "tabs": {
                "conversation": "Conversazione",
                "participants": "Partecipanti"
            },
            "targets": {
                "characters": "Personaggi",
                "members": "Membri"
            }
        },
        "admin": [],
        "crud": {
            "actions": {
                "actions": "Azioni",
                "apply": "Applica",
                "back": "Indietro",
                "copy": "Copia",
                "copy_mention": "Copia [ ] menzione",
                "copy_to_campaign": "Copia nella Campagna",
                "explore_view": "Vista annidata",
                "export": "Esporta (PDF)",
                "find_out_more": "Scopri di più",
                "go_to": "Vai a {name}",
                "json-export": "Esporta (JSON)",
                "more": "Più Azioni",
                "move": "Sposta",
                "new": "Nuovo",
                "next": "Prossimo",
                "private": "Privato",
                "public": "Pubblico",
                "reset": "Resetta"
            },
            "add": "Aggiungi",
            "alerts": {
                "copy_mention": "La menzione avanzata dell'entità è stata copiata nei tuoi appunti."
            },
            "attributes": {
                "actions": {
                    "add": "Aggiungi un attributo",
                    "add_block": "Aggiungi un blocco",
                    "add_checkbox": "Aggiungi un checkbox",
                    "add_text": "Aggiungi un testo",
                    "apply_template": "Applica un Template per gli Attributi",
                    "manage": "Gestisci",
                    "remove_all": "Cancella tutti"
                },
                "create": {
                    "description": "Crea un nuovo attributo",
                    "success": "L'Attributo {name} è stato aggiunto a {entity}",
                    "title": "Nuovo Attributo per {name}"
                },
                "destroy": {
                    "success": "L'attributo {name} è stato rimosso da {entity}"
                },
                "edit": {
                    "description": "Aggiorna un attributo esistente",
                    "success": "L'attributo {name} per {entity} è stato aggiornato.",
                    "title": "Aggiorna l'attributo per {name}"
                },
                "fields": {
                    "attribute": "Attributo",
                    "community_templates": "Templates della Community",
                    "is_private": "Attributi Privati",
                    "is_star": "Fissato",
                    "template": "Template",
                    "value": "Valore"
                },
                "helpers": {
                    "delete_all": "Sei sicuro di voler cancellare tutti gli attributi di questa entità?"
                },
                "hints": {
                    "is_private": "Puoi nascondere tutti gli attributi di un'entità per tutti i membri al di fuori del gruppo degli amministratori rendendoli privati."
                },
                "index": {
                    "success": "Attributo aggiornato per {entity}.",
                    "title": "Attributi per {name}"
                },
                "placeholders": {
                    "attribute": "Numero di conquiste, Grado di Sfida, Iniziativa, Popolazione",
                    "block": "Nome del blocco",
                    "checkbox": "Nome del checkbox",
                    "section": "Nome della sezione",
                    "template": "Seleziona un template",
                    "value": "Valore dell'attributo"
                },
                "template": {
                    "success": "Il Template di Attributi {name} è stato applicato su {entity}",
                    "title": "Applica un Template degli Attributi per {name}"
                },
                "types": {
                    "attribute": "Attributo",
                    "block": "Blocco",
                    "checkbox": "Checkbox",
                    "section": "Sezione",
                    "text": "Testo multilinea"
                },
                "visibility": {
                    "entry": "Gli Attributi sono mostrati nella tab Principale.",
                    "private": "Attributo visibile solamente ai membri del ruolo \"Admin\".",
                    "public": "Attributo visibile a tutti i membri.",
                    "tab": "Gli attributi sono visualizzati solamente nella tab degli Attributi."
                }
            },
            "boosted": "Potenziata",
            "boosted_campaigns": "Campagne potenziate",
            "bulk": {
                "actions": {
                    "edit": "Modifica in blocco & assegnazione dei tag"
                },
                "age": {
                    "helper": "Puoi usare + e - prima del numero per aggiornare l'età di quel quantitativo."
                },
                "delete": {
                    "title": "Rimuovendo molteplici entità",
                    "warning": "Sei sicuro di voler cancellare le entità selezionate?"
                },
                "edit": {
                    "tagging": "Azione per i tag",
                    "tags": {
                        "add": "Aggiungi",
                        "remove": "Rimuovi"
                    },
                    "title": "Modificando molteplici entità"
                },
                "errors": {
                    "admin": "Solo gli amministratori della campagna possono cambiare lo stato di visibilità delle entità.",
                    "general": "C'è stato un errore nell'elaborazione della tua azione. Per favore prova di nuovo e contattaci qualora il problema dovesse persistere. Messaggio di errore: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Sovrascrivi"
                    },
                    "helpers": {
                        "override": "Se selezionato, i permessi delle entità selezionate saranno sovrascritti con questi. Se non selezionato i permessi selezionati saranno aggiunti a quelli già assegnati."
                    },
                    "title": "Cambia i permessi a più entità"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} entità copiata in {campaign}.|[2,*] {count} entità copiate in {campaign}.",
                    "editing": "{1} {count} entità è stata aggiornata.|[2,*] {count} entitià sono state aggiornate.",
                    "permissions": "{1} Permessi modificati per {count} entità.|[2,*] Permessi modificati per {count} entità.",
                    "private": "{1} {count} entità è adesso privata|[2,*] {count} entità sono adesso private.",
                    "public": "{1} {count} entità è adesso visibile|[2,*] {count} entità sono adesso visibili."
                }
            },
            "cancel": "Annulla",
            "click_modal": {
                "close": "Chiudi",
                "confirm": "Conferma",
                "title": "Conferma la tua azione"
            },
            "copy_to_campaign": {
                "bulk_title": "Copia le entità in un'altra campagna",
                "panel": "Copia",
                "title": "Copia '{name}' in una'ltra campagna"
            },
            "create": "Crea",
            "datagrid": {
                "empty": "Ancora non c'è nulla da mostrare."
            },
            "delete_modal": {
                "close": "Chiudi",
                "delete": "Cancella",
                "description": "Sei sicuro di voler rimuovere {tag}?",
                "mirrored": "Rimuovere la relazione speculare.",
                "title": "Conferma di cancellazione"
            },
            "destroy_many": {
                "success": "Cancellata {count} entità|Cancellate {count} entità."
            },
            "edit": "Modifica",
            "errors": {
                "boosted": "Questa funzionalità è disponibile solo per le campagne potenziate.",
                "node_must_not_be_a_descendant": "Nodo non valido (tag, luogo padre): sarebbe un discendente di sé stesso."
            },
            "events": {
                "hint": "Qui sotto puoi vedere una lista di tutti i calendari ai quali questa entità è stata aggiunta usando \"Aggiungi un evento ad un calendario\"."
            },
            "export": "Esporta",
            "fields": {
                "ability": "Abilità",
                "attribute_template": "Template di Attributi",
                "calendar": "Calendario",
                "calendar_date": "Data del Calendario",
                "character": "Personaggio",
                "colour": "Colore",
                "copy_attributes": "Copia Attributo",
                "copy_notes": "Copia le Note dell'Entità",
                "creator": "Creatore",
                "dice_roll": "Tiro di dado",
                "entity": "Entità",
                "entity_type": "Tipo di Entità",
                "entry": "Dato inserito",
                "event": "Evento",
                "excerpt": "Estratto",
                "family": "Famiglia",
                "files": "Files",
                "header_image": "Immagine dell'intestazione",
                "image": "Immagine",
                "is_private": "Privato",
                "is_star": "Fissato",
                "item": "Oggetto",
                "location": "Luogo",
                "map": "Mappa",
                "name": "Nome",
                "organisation": "Organizzazione",
                "race": "Razza",
                "tag": "Tag",
                "tags": "Tags",
                "tooltip": "Tooltip",
                "type": "Tipo",
                "visibility": "Visibilità"
            },
            "files": {
                "actions": {
                    "drop": "Clicca per Aggiungere o Trascina un file",
                    "manage": "Gestisci i files dell'entità"
                },
                "errors": {
                    "max": "Hai raggiunto il numero massimo di file ({max}) per questa entità.",
                    "no_files": "Nessun file."
                },
                "files": "Files Caricati",
                "hints": {
                    "limit": "Ciascuna entità può avere un massimo di {max} files caricati.",
                    "limitations": "Formati supportati: jpg, png, gif, e pdf. Dimensione massima del file: {size}"
                },
                "title": "Files dell'entità {name}"
            },
            "filter": "Filtra",
            "filters": {
                "all": "Filtra includendo tutti i discendenti",
                "clear": "Pulisci i Filtri",
                "direct": "Filtra includendo solamente i discendenti diretti",
                "filtered": "Visualizzati {count} di {total} {entity}.",
                "hide": "Nascondi i Filtri",
                "show": "Visualizza i Filtri",
                "sorting": {
                    "asc": "{field} in ordine crescente",
                    "desc": "{field} in ordine decrescente",
                    "helper": "Gestisci l'ordine di visualizzazione dei risultati."
                },
                "title": "Filtri"
            },
            "forms": {
                "actions": {
                    "calendar": "Aggiungi una data del calendario"
                },
                "copy_options": "Copia opzioni"
            },
            "hidden": "Nascosto",
            "hints": {
                "attribute_template": "Applica un template per gli attributi direttamente quando si crea questa entità.",
                "calendar_date": "La data di un calendario permette un semplice filtro nelle liste e mantiene un evento nel calendario selezionato.",
                "header_image": "Questa immagine è posizionata sopra all' entità. Per un miglior risultato, utilizza un'immagine larga.",
                "image_limitations": "Formati supportati: jpg, png e gif. Dimensione massima del file: {size}.",
                "image_patreon": "Aumentare la dimensione massima dei file?",
                "is_private": "Se impostata come privata, questa entità sarà visibile solamente ai membri appartenenti al ruolo \"Proprietario\" della campagna.",
                "is_star": "Gli elementi fissati appariranno nel menù dell'entità",
                "map_limitations": "Formati supportati{jpg}, png, gif e svg. Dimensione massima del file: {size}.",
                "tooltip": "Sostituisci il tooltip generato automaticamente con il seguente contenuto.",
                "visibility": "Impostare la visibilità agli amministratori significa che solamente i membri del ruolo \"Proprietario\" della campagna potranno visualizzarlo. Impostarlo a \"Te stesso\" significa che solo tu potrai vederlo."
            },
            "history": {
                "created": "Creato da <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Creato <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Sconosciuto",
                "updated": "Modificato l'ultima volta da <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Ultima modifica <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Visualizza i log dell'entità"
            },
            "image": {
                "error": "Non siamo stati in gradi di recuperare l'immagine richiesta. Potrebbe essere che il sito web non ci permetta di scaricare l'immagine (solitamente ciò riguarda Squarespace e DeviantArt) o che il link non sia più valido. Per favore controlla anche che la dimensione dell'immagine non sia maggiore di {size}."
            },
            "is_private": "Questa entità è privata e visibile solamente ai membri del ruolo \"Proprietario\".",
            "linking_help": "Come posso creare un collegamento ad altre entità?",
            "manage": "Gestisci",
            "move": {
                "description": "Sposta questa entità in un altro posto",
                "errors": {
                    "permission": "Non sei autorizzato a creare entità di questo tipo nella campagna selezionata.",
                    "same_campaign": "Devi selezionare un'altra campagna verso cui spostare l'entità.",
                    "unknown_campaign": "Campagna sconosciuta"
                },
                "fields": {
                    "campaign": "Nuova campagna",
                    "copy": "Crea una copia",
                    "target": "Nuovo tipo"
                },
                "hints": {
                    "campaign": "Puoi anche provare a spostare questa entità in un'altra campagna",
                    "copy": "Seleziona questa opzione se vuoi crearne una copia nella nuova campagna.",
                    "target": "Per favore considera che alcuni dati potrebbero andare persi nel caso si spostasse un elemento da un tipo ad un altro."
                },
                "success": "Entità '{name}' spostata.",
                "success_copy": "Entità '{name}' copiata.",
                "title": "Sposta {name}"
            },
            "new_entity": {
                "error": "Per favore controlla i tuoi valori.",
                "fields": {
                    "name": "Nome"
                },
                "title": "Nuova entità"
            },
            "or_cancel": "o <a href=\"{url}\">annulla</a>",
            "panels": {
                "appearance": "Aspetto",
                "attribute_template": "Template di attributi",
                "calendar_date": "Data del Calendario",
                "entry": "Elemento",
                "general_information": "Informazioni Generali",
                "move": "Sposta",
                "system": "Sistema"
            },
            "permissions": {
                "action": "Azione",
                "actions": {
                    "bulk": {
                        "add": "Aggiungi",
                        "deny": "Nega",
                        "ignore": "Ignora",
                        "remove": "Rimuovi"
                    },
                    "bulk_entity": {
                        "allow": "Permetti",
                        "deny": "Nega",
                        "inherit": "Eredita"
                    },
                    "delete": "Cancella",
                    "edit": "Modifica",
                    "entity_note": "Note dell'Entità",
                    "read": "Lettura",
                    "toggle": "Attiva/Disattiva"
                },
                "allowed": "Permesso",
                "fields": {
                    "member": "Membro",
                    "role": "Ruolo"
                },
                "helper": "Utilizza questa interfaccia per rifinire e specificare quali utenti e ruoli possono interagire con questa entità.",
                "helpers": {
                    "entity_note": "Permetti agli utenti di creare Note per questa Entità. Senza questo permesso, essi saranno ancora in grado di vedere le note dell'entità impostate come visibili per Tutti.",
                    "setup": "Utilizza questa interfaccia per rifinire e specificare come utenti e ruoli possono interagire con questa entità. {allow} permetterà all'utente o al ruolo di fare questa azione. {deny} negherà loro tale azione. {inherit} farà riferimento al ruolo dell'utente o al permesso del ruolo. Un utente impostato come {allow} sarà in grado di fare l'azione anche se il suo ruolo sarà invece impostato su {deny}."
                },
                "inherited": "Questo ruolo ha già questo permesso impostato per questa tipologia di entità.",
                "inherited_by": "Questo utente fa parte del ruolo '{role}' che gli conferisce questo permesso su questa tipologia di entità.",
                "success": "Permessi salvati.",
                "title": "Permessi",
                "too_many_members": "Questa campagna ha troppi membri (più di 10) per poterli mostrare tutti in questa interfaccia. Ti preghiamo di usare il tasto Permessi sulla pagine dell'entità per poter verificare i permessi nel dettaglio."
            },
            "placeholders": {
                "ability": "Seleziona un'abilità",
                "calendar": "Seleziona un calendario",
                "character": "Seleziona un personaggio",
                "entity": "Entità",
                "event": "Seleziona un evento",
                "family": "Seleziona una famiglia",
                "image_url": "Altrimenti puoi caricare un'immagine da un URL",
                "item": "Seleziona un'oggetto",
                "location": "Seleziona un luogo",
                "map": "Seleziona una mappa",
                "organisation": "Seleziona un'organizzazione",
                "race": "Seleziona una razza",
                "tag": "Seleziona un tag"
            },
            "relations": {
                "actions": {
                    "add": "Aggiungi una relazione"
                },
                "fields": {
                    "location": "Luogo",
                    "name": "Nome",
                    "relation": "Relazione"
                },
                "hint": "Le relazioni fra le entità possono essere impostate per rappresentare le loro connessioni."
            },
            "remove": "Rimuovi",
            "rename": "Rinomina",
            "save": "Salva",
            "save_and_close": "Salva e Chiudi",
            "save_and_copy": "Salva e Copia",
            "save_and_new": "Salva e Crea Nuovo",
            "save_and_update": "Salve e Aggiorna",
            "save_and_view": "Salva e Visualizza",
            "search": "Cerca",
            "select": "Seleziona",
            "tabs": {
                "abilities": "Abilità",
                "attributes": "Attributi",
                "boost": "Potenzia",
                "calendars": "Calendari",
                "default": "Predefinito",
                "events": "Eventi",
                "inventory": "Inventario",
                "map-points": "Punti della Mappa",
                "mentions": "Menzioni",
                "menu": "Menù",
                "notes": "Note",
                "permissions": "Permessi",
                "relations": "Relazioni",
                "reminders": "Promemoria",
                "tooltip": "Tooltip"
            },
            "update": "Aggiorna",
            "users": {
                "unknown": "Sconosciuto"
            },
            "view": "Visualizza",
            "visibilities": {
                "admin": "Proprietario",
                "admin-self": "Te Stesso e Proprietario",
                "all": "Tutti",
                "self": "Te stesso"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "nl": {
        "admin": []
    },
    "pl": {
        "maps": [],
        "calendars": [],
        "randomizers": [],
        "admin": [],
        "timelines": [],
        "campaigns": [],
        "front": [],
        "entities": []
    },
    "pt": [],
    "pt-BR": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Trocar para o login do Kanka",
                    "update_email": "Atualizar e-mail",
                    "update_password": "Atualizar senha"
                },
                "email": "Mudar e-mail",
                "email_success": "E-mail atualizado com sucesso",
                "password": "Mudar senha",
                "password_success": "Senha atualizada com sucesso",
                "social": {
                    "error": "Você já está usando o login do Kanka nesta conta!",
                    "helper": "Atualmente, sua conta está sendo gerenciada pelo {provider}. Você pode mudar isto e trocar para o login padrão do Kanka ao escolher uma senha.",
                    "success": "Sucesso! Sua conta agora usa o login do Kanka.",
                    "title": "Social para Kanka"
                },
                "title": "Conta"
            },
            "api": {
                "experimental": "Bem-vindo às APIs Kanka! Esses recursos ainda são experimentais, mas devem ser estáveis o suficiente para que você comece a se comunicar com as APIs. Crie um token de acesso pessoal para usar em suas solicitações de API ou use o token de cliente se desejar que seu aplicativo tenha acesso aos dados do usuário.",
                "help": "Em breve, Kanka fornecerá uma API RESTful para que aplicativos de terceiros possam se conectar ao aplicativo. Detalhes sobre como gerenciar suas chaves de API serão mostrados aqui.",
                "link": "Leia a documentação da API",
                "request_permission": "No momento, estamos construindo uma API RESTful poderosa para que aplicativos de terceiros possam se conectar ao aplicativo. No entanto, atualmente estamos limitando o número de usuários que podem interagir com a API enquanto a aperfeiçoamos. Se você deseja acessar a API e construir aplicativos maneiros que se comunicam com o Kanka, entre em contato conosco e enviaremos todas as informações de que você precisa.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Conectar",
                    "remove": "Remover"
                },
                "benefits": "Kanka oferece integração com alguns serviços de terceiros. Mais integrações de terceiros estão planejadas para o futuro.",
                "discord": {
                    "errors": {
                        "add": "Ocorreu um erro ao vincular sua conta do Discord ao kanka. Por favor, tente novamente."
                    },
                    "success": {
                        "add": "Sua conta do Discord foi vinculada com sucesso!",
                        "remove": "Sua conta do Discord foi desvinculada com sucesso."
                    },
                    "text": "Acesse seus cargos de assinatura automaticamente."
                },
                "title": "Integração de aplicativos"
            },
            "boost": {
                "benefits": {
                    "first": "Para garantir o progresso contínuo no Kanka, alguns recursos da campanha são desbloqueados ao impulsionar uma campanha. Os impulsos são desbloqueados por meio de assinaturas. Qualquer um que pode ver uma campanha pode impulsioná-la, para que o Mestre nem sempre tenha que pagar a conta. Uma campanha permanece impulsionada enquanto um usuário estiver impulsionando a campanha e eles continuarem apoiando Kanka. Se uma campanha não é mais impulsionada, os dados não são perdidos, só ficam ocultos até que a campanha seja impulsionada novamente.",
                    "header": "Imagens de cabeçalho da entidade.",
                    "images": "Imagens de entidade padrão personalizadas.",
                    "more": "Descubra mais sobre todos os recursos.",
                    "second": "Impulsionar uma campanha oferece os seguintes benefícios:",
                    "theme": "Tema nível da campanha e estilo personalizado.",
                    "third": "Para impulsionar uma campanha, vá até a página da campanha e clique no botão \"{boost_button}\" acima do botão \"{edit_button}\".",
                    "tooltip": "Dicas de ferramentas personalizadas para entidades.",
                    "upload": "Aumento do tamanho de upload para todos os membros da campanha."
                },
                "buttons": {
                    "boost": "Impulsionamento"
                },
                "campaigns": "Campanhas impulsionadas {count} / {max}",
                "exceptions": {
                    "already_boosted": "Campanha {name} já está sendo impulsionada",
                    "exhausted_boosts": "Você está sem impulsos para dar. Remova o impulso de uma campanha antes de dar a outra."
                },
                "success": {
                    "boost": "Campanha {name} impulsionada",
                    "delete": "Seu impulsionamento foi removido de {name}"
                },
                "title": "Impulso"
            },
            "countries": {
                "austria": "Áustria",
                "belgium": "Bélgica",
                "france": "França",
                "germany": "Alemanha",
                "italy": "Itália",
                "netherlands": "Holanda",
                "spain": "Espanha"
            },
            "invoices": {
                "actions": {
                    "download": "Baixar PDF",
                    "view_all": "Ver tudo"
                },
                "empty": "Sem faturas",
                "fields": {
                    "amount": "Quantidade",
                    "date": "Data",
                    "invoice": "Fatura",
                    "status": "Status"
                },
                "header": "Abaixo está alista de suas últimas 24 faturas, que podem ser baixadas",
                "status": {
                    "paid": "Pago",
                    "pending": "Pendente"
                },
                "title": "Faturas"
            },
            "layout": {
                "success": "Opções de layout atualizadas.",
                "title": "Layout"
            },
            "marketplace": {
                "fields": {
                    "name": "Nome do Mercado"
                },
                "helper": "Como padrão, seu nome de usuário é mostrado no {marketplace}:. Você pode alterar isso neste campo.",
                "title": "Configurações do Mercado",
                "update": "Configurações do Mercado salvas com sucesso."
            },
            "menu": {
                "account": "Conta",
                "api": "API",
                "apps": "Aplicativos",
                "billing": "Formas de Pagamento",
                "boost": "Impulsionamento",
                "invoices": "Faturas",
                "layout": "Layout",
                "marketplace": "Mercado",
                "other": "Outros",
                "patreon": "Patreon",
                "payment_options": "Formas de pagamento",
                "personal_settings": "Configurações pessoais",
                "profile": "Perfil",
                "subscription": "Assitatura",
                "subscription_status": "Status da assinatura"
            },
            "patreon": {
                "actions": {
                    "link": "Vincular conta",
                    "view": "Visite Kanka no Patreon"
                },
                "benefits": "Apoiando-nos em {patreon} desbloqueia todos os tipos de {features} para você e suas campanhas, e também nos ajuda a passar mais tempo trabalhando para melhorar o Kanka.",
                "benefits_features": "Recursos incríveis",
                "deprecated": "Recurso obsoleto - se você deseja oferecer suporte ao Kanka, faça-o com uma {subscription}. A vinculação do Patreon ainda está ativa para nossos clientes que vincularam suas contas antes de termos deixado o Patreon.",
                "description": "Sincronizando com o Patreon",
                "linked": "Obrigado por apoiar o Kanka no Patreon! Sua conta está vinculada.",
                "pledge": "Pledge {name}",
                "remove": {
                    "button": "Desvincular sua conta Patreon",
                    "success": "Sua conta Patreon foi desvinculada",
                    "text": "Desvincular sua conta do Patreon com Kanka removerá seus bônus, nome no Hall da fama, impulsionamentos de campanha e outros recursos vinculados ao suporte de Kanka. Nenhum de seus conteúdos impulsionados serão perdidos (por exemplo, cabeçalhos de entidade). Ao se inscrever novamente, você terá acesso a todos os seus dados anteriores, incluindo a capacidade de impulsionar suas campanhas previamente impulsionadas.",
                    "title": "Desvincule sua conta Patreon com Kanka"
                },
                "success": "Obrigado por apoiar Kanka no Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Seu nível de pledge é definido manualmente por nós, portanto, espere alguns dias para que possamos defini-lo corretamente. Se continuar errado por muito tempo, entre em contato conosco."
            },
            "profile": {
                "actions": {
                    "update_profile": "Atualizar perfil"
                },
                "avatar": "Foto de Perfil",
                "success": "Perfil atualizado",
                "title": "Perfil pessoal"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Cancelar assinatura",
                    "subscribe": "Assinar",
                    "update_currency": "Salvar moeda preferida"
                },
                "benefits": "Ao nos apoiar, você pode desbloquear alguns novos {features} e nos ajudar a investir mais tempo para melhorar o Kanka. Nenhuma informação de cartão de crédito é armazenada ou transita por nossos servidores. Usamos {stripe} para lidar com todo o faturamento.",
                "billing": {
                    "helper": "Suas informações de faturamento são processadas e armazenadas com segurança através de {stripe}. Este método de pagamento é usado para todas as suas assinaturas.",
                    "saved": "Método de pagamento salvo",
                    "title": "Editar método de pagamento"
                },
                "cancel": {
                    "text": "Lamentamos ver você ir! O cancelamento de sua assinatura a manterá ativa até o próximo ciclo de faturamento, após o qual você perderá os impulsionamentos à sua campanha e outros benefícios relacionados ao suporte ao Kanka. Sinta-se à vontade para preencher o formulário a seguir para nos informar o que podemos fazer melhor ou o que levou à sua decisão."
                },
                "cancelled": "Sua assinatura foi cancelada. Você pode renovar uma assinatura assim que sua assinatura atual terminar.",
                "change": {
                    "text": {
                        "monthly": "Você está se inscrevendo no nível {tier}, cobrado mensalmente em {amount}.",
                        "yearly": "Você está se inscrevendo no nível {tier}, cobrado anualmente em {amount}."
                    },
                    "title": "Alterar nível de assinatura"
                },
                "currencies": {
                    "eur": "EUR",
                    "usd": "USD"
                },
                "currency": {
                    "title": "Altere sua moeda de cobrança preferida"
                },
                "errors": {
                    "callback": "Nosso provedor de pagamento relatou um erro. Tente novamente ou entre em contato conosco se o problema persistir.",
                    "subscribed": "Não foi possível processar sua assinatura. Stripe forneceu a sugestão seguinte."
                },
                "fields": {
                    "active_since": "Ativa desde",
                    "active_until": "Ativa até",
                    "billing": "Cobrança",
                    "currency": "Moeda de cobrança",
                    "payment_method": "Método de pagamento",
                    "plan": "Plano atual",
                    "reason": "Razão"
                },
                "helpers": {
                    "alternatives": "Pague sua assinatura usando {method}. Este método de pagamento não será renovado automaticamente no final da sua assinatura. {method} disponível apenas em euros.",
                    "alternatives_warning": "Não é possível atualizar sua assinatura ao usar este método. Faça uma nova assinatura quando a atual terminar.",
                    "alternatives_yearly": "Devido às restrições em torno dos pagamentos recorrentes, {method} está disponível apenas para assinaturas anuais"
                },
                "manage_subscription": "Gerenciar assinatura",
                "payment_method": {
                    "actions": {
                        "add_new": "Adicionar novo método de pagamento",
                        "change": "Mudar método de pagamento",
                        "save": "Salvar método de pagamento",
                        "show_alternatives": "Métodos de pagamento alternativos"
                    },
                    "add_one": "No momento, você não tem um método de pagamento salvo.",
                    "alternatives": "Você pode se inscrever usando essas opções alternativas de pagamento. Esta ação cobrará sua conta uma vez e não renovará automaticamente sua assinatura todos os meses.",
                    "card": "Cartão",
                    "card_name": "Nome no cartão",
                    "country": "País de residência",
                    "ending": "Terminado em",
                    "helper": "Este cartão será usado para todas suas assinaturas.",
                    "new_card": "Adicionar novo método de pagamento",
                    "saved": "{brand} terminando em {last4}"
                },
                "placeholders": {
                    "reason": "Opcionalmente, diga-nos por que você não está mais apoiando o Kanka. Estava faltando algum recurso? Sua situação financeira mudou?"
                },
                "plans": {
                    "cost_monthly": "{currency} {amount} cobrado mensalmente",
                    "cost_yearly": "{currency} {amount} cobrado anualmente"
                },
                "sub_status": "Informação da assinatura",
                "subscription": {
                    "actions": {
                        "downgrading": "Entre em contato conosco para fazer o downgrade",
                        "rollback": "Mudar para Kobold",
                        "subscribe": "Mudar para {tier} mensalmente",
                        "subscribe_annual": "Mudar para {tier} anualmente"
                    }
                },
                "success": {
                    "alternative": "Seu pagamento foi registrado. Você receberá uma notificação assim que for processado e sua assinatura estiver ativa.",
                    "callback": "Sua assinatura foi realizada com sucesso. Sua conta será atualizada assim que nosso provedor de pagamento nos informar sobre a mudança (isso pode levar alguns minutos).",
                    "cancel": "Sua assinatura foi cancelada. Ela continuará ativa até o final do seu período de faturamento atual.",
                    "currency": "Sua configuração de moeda preferida foi atualizada.",
                    "subscribed": "Sua assinatura foi realizada com sucesso. Não se esqueça de assinar a newsletter do Voto da Comunidade para ser notificado quando uma votação estiver disponível. Você pode alterar as configurações da newsletter em sua página de perfil."
                },
                "tiers": "Níveis de assinatura",
                "trial_period": "As assinaturas anuais têm uma política de cancelamento de 14 dias. Entre em contato conosco por {email} se desejar cancelar sua assinatura anual e obter um reembolso.",
                "upgrade_downgrade": {
                    "button": "Informação de Upgrade e Downgrade",
                    "downgrade": {
                        "bullets": {
                            "end": "Seu nível atual permanecerá ativo até o final do seu ciclo de faturamento atual, após o qual você será rebaixado para o novo nível."
                        },
                        "title": "Ao fazer downgrade para um nível menor"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "Seu método de pagamento será cobrado imediatamente e você terá acesso ao seu novo nível.",
                            "prorate": "Ao fazer upgrade de Urso-Coruja para Elemental, você só será cobrado pela diferença de seu novo nível."
                        },
                        "title": "Ao fazer upgrade para um nível maior"
                    }
                },
                "warnings": {
                    "incomplete": "Não foi possível cobrar seu cartão de crédito. Atualize as informações do seu cartão de crédito e tentaremos cobrar novamente nos próximos dias. Se falhar novamente, sua assinatura será cancelada.",
                    "patreon": "Sua conta está atualmente vinculada ao Patreon. Desvincule sua conta nas configurações de {patreon} antes de mudar para uma assinatura Kanka."
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Criar nova conversa",
                "success": "Conversa '{name}' criada",
                "title": "Nova conversa"
            },
            "destroy": {
                "success": "Conversa '{name}' apagada"
            },
            "edit": {
                "description": "Atualizar conversa",
                "success": "Conversa '{name}' atualizada",
                "title": "Conversa {name}"
            },
            "fields": {
                "messages": "Mensagens",
                "name": "Nome",
                "participants": "Participantes",
                "target": "Alvo",
                "type": "Tipo"
            },
            "hints": {
                "participants": "Por favor, adicione participantes à sua conversa pressionando o ícone {icon} no canto superior direito."
            },
            "index": {
                "add": "Nova conversa",
                "description": "Gerenciar categoria de {name}",
                "header": "Conversas em {name}",
                "title": "Conversas"
            },
            "messages": {
                "destroy": {
                    "success": "Mensagem removida"
                },
                "is_updated": "Atualizada",
                "load_previous": "Carregar mensagens mais antigas",
                "placeholders": {
                    "message": "Sua mensagem"
                }
            },
            "participants": {
                "create": {
                    "success": "Participante {entity} adicionado(a) à conversa"
                },
                "description": "Adicionar ou remover participantes da conversa",
                "destroy": {
                    "success": "Participante {entity} removido(a) da conversa"
                },
                "modal": "Participantes",
                "title": "Participantes de {name}"
            },
            "placeholders": {
                "name": "Nome da conversa",
                "type": "Dentro do jogo, Pré-mesa, Plot"
            },
            "show": {
                "description": "Uma vista detalhada da conversa",
                "title": "Conversa {name}"
            },
            "tabs": {
                "conversation": "Conversa",
                "participants": "Participantes"
            },
            "targets": {
                "characters": "Personagens",
                "members": "Membros"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Ações",
                "apply": "Aplicar",
                "back": "Voltar",
                "copy": "Copiar",
                "copy_mention": "Copiar [] menção",
                "copy_to_campaign": "Copiar para a Campanha",
                "explore_view": "Visão Aninhada",
                "export": "Exportar",
                "find_out_more": "Descubra mais",
                "go_to": "Ir para {name}",
                "json-export": "Exportar (JSON)",
                "more": "Mais Ações",
                "move": "Mover",
                "new": "Novo",
                "next": "Próximo",
                "private": "Privado",
                "public": "Público",
                "reset": "Redefinir"
            },
            "add": "Adicionar",
            "alerts": {
                "copy_mention": "A menção avançada da entidade foi copiada para sua área de transferência."
            },
            "attributes": {
                "actions": {
                    "add": "Adicionar um atributo",
                    "apply_template": "Aplicar um Modelo de Atributo",
                    "manage": "Gerenciar",
                    "more": "Mais opções",
                    "remove_all": "Deletar tudo"
                },
                "create": {
                    "description": "Criar um novo atributo",
                    "success": "Atributo {name} adicionado a {entity}",
                    "title": "Novo Atributo para {name}"
                },
                "destroy": {
                    "success": "Atributo {name} para {entity} removido"
                },
                "edit": {
                    "description": "Atualizar um atributo existente",
                    "success": "Atributo {name} para {entity} atualizado",
                    "title": "Atualizar atributo para {name}"
                },
                "fields": {
                    "attribute": "Atributo",
                    "community_templates": "Modelos da Comunidade",
                    "is_private": "Atributos privados",
                    "is_star": "FIxado",
                    "template": "Modelo",
                    "value": "Valor"
                },
                "helpers": {
                    "delete_all": "Tem certeza de que deseja excluir todos os atributos desta entidade?"
                },
                "hints": {
                    "is_private": "Você pode ocultar todos os atributos de uma entidade para todos os membros fora da função administrativa, tornando-a privada."
                },
                "index": {
                    "success": "Atributos de {entity} atualizados.",
                    "title": "Atributos de {name}"
                },
                "placeholders": {
                    "attribute": "Número de conquistas, Nível de Desafio, Iniciativa, População",
                    "block": "Nome do bloco",
                    "checkbox": "Nome da caixa de seleção",
                    "section": "Nome da seleção",
                    "template": "Selecione um modelo",
                    "value": "Valor do atributo"
                },
                "template": {
                    "success": "Modelo de Atributo {name} aplicado em {entity}",
                    "title": "Aplicar um Modelo de Atributo a {name}"
                },
                "types": {
                    "attribute": "Atributo",
                    "block": "Bloco",
                    "checkbox": "Caixa de seleção",
                    "section": "Seção",
                    "text": "Texto multilinha"
                },
                "visibility": {
                    "entry": "O atributo é exibido no menu da entidade.",
                    "private": "Atributo visível apenas para membros da função de Admnistrador.",
                    "public": "Atributos visíveis a todos os membros",
                    "tab": "Atributos mostrados apenas na aba de atributos"
                }
            },
            "boosted": "Impulsionada",
            "boosted_campaigns": "Campanhas impulsionadas",
            "bulk": {
                "actions": {
                    "edit": "Edição em massa e tagging"
                },
                "age": {
                    "helper": "Você pode usar + e - antes do número para atualizar a idade naquela quantidade"
                },
                "delete": {
                    "title": "Deletando entidades múltiplas",
                    "warning": "Tem certeza que você quer deletar as entidades selecionadas?"
                },
                "edit": {
                    "tagging": "Ação para tags",
                    "tags": {
                        "add": "Adicionar",
                        "remove": "Remover"
                    },
                    "title": "Editando múltiplas entidades"
                },
                "errors": {
                    "admin": "Apenas administradores de campanha podem mudar o status privado de entidades",
                    "general": "Ocorreu um erro ao processar sua ação. Tente novamente e entre em contato conosco se o problema persistir. Mensagem de erro {hint}"
                },
                "permissions": {
                    "fields": {
                        "override": "Substituir"
                    },
                    "helpers": {
                        "override": "Se selecionado, as permissões das entidades selecionadas serão substituídas por estas. Se desmarcada, as permissões selecionadas serão adicionadas às existentes."
                    },
                    "title": "Alterar permissões para várias entidades"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} entidade copiada para {campaign}. | [2, *] {count} entidades copiadas para {campaign}.",
                    "editing": "{1} {count} entidade foi atualizada | [2, *]  {count} entidades foram atualizadas",
                    "permissions": "{1} Permissões alteradas para {count} entidade | [2, *] Permissões mudadas para {count} entidades",
                    "private": "{1} {count} entidade agora é privada | [2, *] {count} entidades agora são privadas",
                    "public": "{1} {count} entidade agora é visível | [2, *] {count} entidades agora são visíveis"
                }
            },
            "cancel": "Cancelar",
            "click_modal": {
                "close": "Fechar",
                "confirm": "Confirmar",
                "title": "Confirmar sua ação"
            },
            "copy_to_campaign": {
                "bulk_title": "Copiar entidades para outra campanha",
                "panel": "Copiar",
                "title": "Copiar {name} para outra campanha"
            },
            "create": "Criar",
            "datagrid": {
                "empty": "Nada para mostrar (ainda)"
            },
            "delete_modal": {
                "close": "Fechar",
                "delete": "Deletar",
                "description": "Tem certeza que deseja remover {tag}?",
                "mirrored": "Remover relação espelhada",
                "title": "Confirmação de apagamento"
            },
            "destroy_many": {
                "success": "Deletado {count} entity|Deletado {count} entities."
            },
            "edit": "Editar",
            "errors": {
                "boosted": "Esta função está disponível apenas para campanhas impulsionadas",
                "node_must_not_be_a_descendant": "Nó inválido (tag, localização principal): seria um descendente de si mesmo."
            },
            "events": {
                "hint": "Abaixo é mostrada uma lista de todos os calendários em que esta entidade foi adicionada usando a interface \"Adicionar um evento a um calendário\"."
            },
            "export": "Exportar",
            "fields": {
                "ability": "Habilidade",
                "attribute_template": "Modelo de atributo",
                "calendar": "Calendário",
                "calendar_date": "Data do Calendário",
                "character": "Personagem",
                "colour": "Cor",
                "copy_attributes": "Copiar atributos",
                "copy_notes": "Copiar notas de entidade",
                "creator": "Criador",
                "dice_roll": "Rolagem de Dados",
                "entity": "Entidade",
                "entity_type": "Tipo de entidade",
                "entry": "Entrada",
                "event": "Evento",
                "excerpt": "Resumo",
                "family": "Família",
                "files": "Arquivos",
                "has_image": "Contém uma imagem",
                "header_image": "Imagem de cabeçalho",
                "image": "Imagem",
                "is_private": "Privado",
                "is_star": "Fixado",
                "item": "Item",
                "location": "Local",
                "map": "Mapa",
                "name": "Nome",
                "organisation": "Organização",
                "position": "Posição",
                "race": "Raça",
                "tag": "Tag",
                "tags": "Tags",
                "timeline": "Linha do Tempo",
                "tooltip": "Dica",
                "type": "Tipo",
                "visibility": "Visibilidade"
            },
            "files": {
                "actions": {
                    "drop": "Clique ou arraste e solte para adicionar um arquivo",
                    "manage": "Gerencias arquivos de entidade"
                },
                "errors": {
                    "max": "Você atingiu o número máximo ({max}) de arquivos para esta entidade.",
                    "no_files": "Sem arquivos"
                },
                "files": "Arquivos carregados",
                "hints": {
                    "limit": "Cada entidade pode ter no máximo {max} arquivos carregados nela.",
                    "limitations": "Formatos suportados: {formats}. Tamanho máximo do arquivo: {size}"
                },
                "title": "Arquivos de entidade de {name}"
            },
            "filter": "Filtro",
            "filters": {
                "all": "Filtrar para todos descendentes",
                "clear": "Limpar filtros",
                "direct": "Filtrar para descendentes diretos",
                "filtered": "Mostrando {count} total de {entity}",
                "hide": "Esconder filtros",
                "options": {
                    "exclude": "Excluir",
                    "include": "Incluir",
                    "none": "Nenhum"
                },
                "show": "Mostrar filtros",
                "sorting": {
                    "asc": "{field} Ascendente",
                    "desc": "{field} Descendente",
                    "helper": "Controle em que ordem os resultados aparecem"
                },
                "title": "Filtros"
            },
            "forms": {
                "actions": {
                    "calendar": "Adicionar uma data no calendário"
                },
                "copy_options": "Copiar opções"
            },
            "hidden": "Esconder",
            "hints": {
                "attribute_template": "Aplique um modelo de atributo diretamente ao criar ou editar esta entidade.",
                "calendar_date": "Uma data de calendário permite fácil filtragem em listas e também mantém um evento de calendário no calendário selecionado.",
                "header_image": "Esta imagem é colocada acima da entidade. Para obter melhores resultados, use uma imagem larga.",
                "image_limitations": "Formatos suportados: jpg, png and gif. Tamanho máximo do arquivo: {size}.",
                "image_patreon": "Aumentar limite do tamanho das imagens?",
                "is_private": "Esconder de \"Espectadores\"",
                "is_star": "Elementos fixados aparecerão no menu da entidade",
                "map_limitations": "Formatos suportados: jpg, png, gif and svg. Tamanho máximo do arquivo: {size}.",
                "tooltip": "Substitua a dica de ferramenta gerada automaticamente pelo conteúdo a seguir.",
                "visibility": "Definir a visibilidade para admin significa que apenas os membros no cargo de admnistrador de campanha  podem ver isso. Definir como apenas eu significa que apenas você pode ver isso."
            },
            "history": {
                "created": "Criado por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Criado <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Desconhecido",
                "updated": "Modificado pela última vez por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Modificado pela última vez em <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Ver histórico da entidade"
            },
            "image": {
                "error": "Nós não fomos capazes de conseguir a imagem requisitada. Pode ser que o site não autorize o download da imagem por nós (tipicamente para Squarespace e DeviantArt), ou o link não está mais válido."
            },
            "is_not_private": "Atualmente, esta entidade é privada",
            "is_private": "Essa entidade é privada e não visível para usuários espectadores.",
            "linking_help": "Como eu posso vincular a outras entidades?",
            "manage": "Gerenciar",
            "move": {
                "description": "Mover a entidade para outro lugar",
                "errors": {
                    "permission": "Você não tem permissão para criar entidades deste tipo na campanha escolhida",
                    "same_campaign": "Você deve selecionar a campanha para qual moverá esta entidade",
                    "unknown_campaign": "Campanha desconhecida"
                },
                "fields": {
                    "campaign": "Nova campanha",
                    "copy": "Fazer uma cópia",
                    "target": "Novo tipo"
                },
                "hints": {
                    "campaign": "Você também pode mover esta entidade para outra camapnha",
                    "copy": "Selecione esta opção se você deseja criar uma cópia na nova campanha",
                    "target": "Esteja ciente que alguns dados podem ser perdidos ao mudar um elemento de um tipo para outro."
                },
                "success": "Entidade {name} movida.",
                "success_copy": "Entidade {name} copiada",
                "title": "Mover {name} para outro lugar"
            },
            "new_entity": {
                "error": "Por favor cheque seus valores",
                "fields": {
                    "name": "Nome"
                },
                "title": "Nova entidade"
            },
            "or_cancel": "ou <a href=\"{url}\">cancel</a>",
            "panels": {
                "appearance": "Aparência",
                "attribute_template": "Modelo de atributo",
                "calendar_date": "Data do calendário",
                "entry": "Entrada",
                "general_information": "Informações Gerais",
                "move": "Mover",
                "system": "Sistema"
            },
            "permissions": {
                "action": "Ação",
                "actions": {
                    "bulk": {
                        "add": "Permitir",
                        "deny": "Negar",
                        "ignore": "Pular",
                        "remove": "Remover"
                    },
                    "bulk_entity": {
                        "allow": "Permitir",
                        "deny": "Negar",
                        "inherit": "Herdar"
                    },
                    "delete": "Deletar",
                    "edit": "Editar",
                    "entity_note": "Notas da entidade",
                    "read": "Ler",
                    "toggle": "Alternar"
                },
                "allowed": "Permitido",
                "fields": {
                    "member": "Membro",
                    "role": "Cargo"
                },
                "helper": "Use essa interface para escolher quais usuários e cargos podem interagir com essa entidade.",
                "helpers": {
                    "setup": "Use esta interface para ajustar como funções e usuários podem interagir com esta entidade. {allow} permitirá que o usuário ou função execute esta ação. {deny} irá negar a eles essa ação. {inherit} usará o cargo do usuário ou a permissão do cargo principal. Um usuário definido como {allow} é capaz de realizar a ação, mesmo se sua função for definida como {deny}"
                },
                "inherited": "Este cargo já tem esta permissão para este tipo de entidade",
                "inherited_by": "Este usuário faz parte do cargo {role} que concede essas permissões neste tipo de entidade.",
                "success": "Permissões salvas.",
                "title": "Permissões",
                "too_many_members": "Esta campanha tem muitos membros (> 10) para exibir nesta interface. Use o botão permissão na visualização da entidade para controlar as permissões em detalhes."
            },
            "placeholders": {
                "ability": "Escolha uma habilidade",
                "calendar": "Escolha um calendário",
                "character": "Escolha um personagem",
                "entity": "Entidade",
                "event": "Escolha um evento",
                "family": "Escolha uma família",
                "image_url": "Você também pode dar upload de uma imagem por uma URL",
                "item": "Escolha um item",
                "location": "Escolha um local",
                "map": "Escolha um mapa",
                "organisation": "Escolha uma organização",
                "race": "Escolha uma raça",
                "tag": "Escolha uma tag"
            },
            "relations": {
                "actions": {
                    "add": "Adicionar uma relação"
                },
                "fields": {
                    "location": "Local",
                    "name": "Nome",
                    "relation": "Relação"
                },
                "hint": "As relações entre entidades podem ser configuradas para representar suas conexões."
            },
            "remove": "Remover",
            "rename": "Renomear",
            "save": "Salvar",
            "save_and_close": "Salvar e Fechar",
            "save_and_copy": "Salvar e Copiar",
            "save_and_new": "Salvar e Novo",
            "save_and_update": "Salvar e Editar",
            "save_and_view": "Salvar e Visualizar",
            "search": "Buscar",
            "select": "Selecionar",
            "tabs": {
                "abilities": "Habilidades",
                "attributes": "Atributos",
                "boost": "Impulso",
                "calendars": "Calendários",
                "default": "Padrão",
                "events": "Eventos",
                "inventory": "Inventário",
                "map-points": "pontos do Mapa",
                "mentions": "Menções",
                "menu": "Menu",
                "notes": "Notas da entidade",
                "permissions": "Permissões",
                "relations": "Relações",
                "reminders": "Lembretes",
                "timelines": "Linhas do Tempo",
                "tooltip": "Dica"
            },
            "update": "Atualizar",
            "users": {
                "unknown": "Desconhecido"
            },
            "view": "Ver",
            "visibilities": {
                "admin": "Adm",
                "admin-self": "Eu e o Adm",
                "all": "Todos",
                "self": "Apenas eu"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "ru": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Вход Kanka",
                    "update_email": "Обновить электронную почту",
                    "update_password": "Обновить пароль"
                },
                "email": "Смена электронной почты",
                "email_success": "Электронная почта обновлена.",
                "password": "Смена пароля",
                "password_success": "Пароль обновлен.",
                "social": {
                    "error": "Вы уже используете вход Kanka на этом аккаунте.",
                    "helper": "Ваш аккаунт сейчас управляется с помощью {provider}. Вы можете остановить это и включить стандартный вход Kanka через ввод пароля.",
                    "success": "Теперь ваш аккаунт использует вход Kanka.",
                    "title": "Вход Kanka"
                },
                "title": "Аккаунт"
            },
            "api": {
                "experimental": "Добро пожаловать в Kanka API! Эти функции пока экспериментальные, но достаточно стабильные, чтобы вы могли начать общаться с помощью API. Создайте личный токен доступа для использования ваших API запросов или используйте клиентский токен, если вы хотите, чтобы ваше приложение имело доступ к данным пользователей.",
                "help": "Kanka скоро обеспечит RESTful API, чтобы приложения третьей стороны могли подключаться к этому приложению. Детали управления API ключами будут показаны ниже.",
                "link": "Читать API документацию",
                "request_permission": "Мы работаем над созданием RESTful API, чтобы приложения третьей стороны могли подключаться к этому приложению. Однако, мы ограничиваем число пользователей, которые могут взаимодействовать с API, пока мы работаем над ним. Если вы хотите получить доступ к API и создавать крутые приложения для доступа к Kanka, пожалуйста свяжитесь с нами, и мы отправим вам всю необходимую информацию.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Подключиться",
                    "remove": "Удалить"
                },
                "benefits": "Kanka поддерживает несколько соединений с сервисами третьей стороны. Больше соединений планируется в будущем.",
                "discord": {
                    "errors": {
                        "add": "При соединении с вашим Discord аккаунтом через Kanka произошла ошибка. Пожалуйста, попробуйте снова."
                    },
                    "success": {
                        "add": "Ваш Discord аккаунт подключен.",
                        "remove": "Ваш Discord аккаунт отключен."
                    },
                    "text": "Получите доступ к вашим ролям подписки автоматически."
                },
                "title": "Подключение к приложению"
            },
            "boost": {
                "benefits": {
                    "first": "Для гарантии продолжения развития Kanka, некоторые черты Кампаний доступны только с помощью усилителей Кампаний. Усилители доступны по подписке. Любой, кто видит Кампанию, может усилить ее, так что Админ не всегда должен за это платить. Кампания остается усиленной пока пользователь ее усиливает и продолжает поддерживать Kanka. Если Кампания теряет усиление, то данные не теряются, они просто скрываются, пока Кампанию снова не усилят.",
                    "header": "Изображения заголовков объектов",
                    "images": "Заказные изображения объектов по умолчанию",
                    "more": "Узнать больше обо всех функциях",
                    "second": "Усиление Кампании дает следующие преимущества:",
                    "theme": "Тема уровней Кампании и заказной стиль",
                    "third": "Чтобы усилить Кампанию, перейдите на ее страницу и нажмите на кнопку \"{boost_button}\" над кнопкой \"{edit_button}\".",
                    "tooltip": "Заказные подсказки для объектов",
                    "upload": "Увеличенный вес загружаемых файлов для всех членов Кампании"
                },
                "buttons": {
                    "boost": "Усилить"
                },
                "campaigns": "Усиленные Кампании {count}/{max}",
                "exceptions": {
                    "already_boosted": "Кампания {name} уже усилена.",
                    "exhausted_boosts": "У вас закончились усилители. Уберите усилитель с одной из Кампаний, чтобы применить его на другую."
                },
                "success": {
                    "boost": "Кампания {name} усилена.",
                    "delete": "Ваше усиление удалено с {name}."
                },
                "title": "Усилить"
            },
            "countries": {
                "austria": "Австрия",
                "belgium": "Бельгия",
                "france": "Франция",
                "germany": "Германия",
                "italy": "Италия",
                "netherlands": "Нидерланды",
                "spain": "Испания"
            },
            "invoices": {
                "actions": {
                    "download": "Скачать PDF",
                    "view_all": "Показать все"
                },
                "empty": "Нет счетов",
                "fields": {
                    "amount": "Количество",
                    "date": "Дата",
                    "invoice": "Счет",
                    "status": "Статус"
                },
                "header": "Ниже список ваших последних 24 счетов, которые можно скачать.",
                "status": {
                    "paid": "Оплачен",
                    "pending": "Неоплачен"
                },
                "title": "Счета"
            },
            "layout": {
                "success": "Оформление обновлено.",
                "title": "Оформление"
            },
            "menu": {
                "account": "Аккаунт",
                "api": "API",
                "apps": "Приложения",
                "billing": "Способ оплаты",
                "boost": "Усилители",
                "invoices": "Счета",
                "layout": "Оформление",
                "other": "Другое",
                "patreon": "Patreon",
                "payment_options": "Способы оплаты",
                "personal_settings": "Персональные настройки",
                "profile": "Профиль",
                "subscription": "Подписка",
                "subscription_status": "Статус подписки"
            },
            "patreon": {
                "actions": {
                    "link": "Подключить аккаунт",
                    "view": "Посетить Kanka на Patreon"
                },
                "benefits": "Поддержка нашего {patreon} разблокирует все {features} для вас и ваших Кампаний, а также позволит нам проводить больше времени, работая над улучшением Kanka.",
                "benefits_features": "потрясающие функции",
                "deprecated": "Устаревшая функция - если вы хотите поддержать Kanka, пожалуйста сделайте это с помощью {subscription}. Ссылка на Patreon до сих пор активна для наших патреонцев, которые подключили их аккаунты до выхода с Patreon.",
                "description": "Синхронизация с Patreon.",
                "linked": "Спасибо за поддержку на Patreon! Ваш аккаунт подключен.",
                "pledge": "Залог: {name}",
                "remove": {
                    "button": "Отключить ваш Patreon аккаунт",
                    "success": "Ваш Patreon аккаунт отключен.",
                    "text": "Отключение вашего Patreon аккаунта Kanka удалит ваши бонусы, имя в Зале Славы, усилители Кампаний и другие функции, включенные в поддержку Kanka. Все созданное при усилении не пропадет (например заголовки объектов). Подписавшись назад вы получите доступ ко всем этим данным, включая возможность усиливать ваши кампании.",
                    "title": "Отключение вашего Patreon аккаунта Kanka"
                },
                "success": "Спасибо за поддержку Kanka на Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Уровень вашего залога устанавливается нами вручную, так что, пожалуйста, дайте нам пару дней на то, чтобы правильно его настроить."
            },
            "profile": {
                "actions": {
                    "update_profile": "Обновить профиль"
                },
                "avatar": "Картинка профиля",
                "success": "Профиль обновлен",
                "title": "Личный профиль"
            },
            "subscription": {
                "actions": {
                    "cancel_sub": "Отменить подписку",
                    "subscribe": "Подписаться",
                    "update_currency": "Сохранить предпочитаемую валюту"
                },
                "benefits": "Поддерживая нас, вы можете разблокировать новые {features} и помочь нам проводить больше времени над улучшением Kanka. Информация кредитной карты не сохраняется и не передается через наши сервера. Мы используем {stripe} для управления оплатой.",
                "billing": {
                    "helper": "Информация о вашей оплате обработана и сохранена с помощью {stripe}. Этот способ оплаты используется для всех ваших подписок.",
                    "saved": "Сохраненный способ оплаты",
                    "title": "Редактировать Способ Оплаты"
                },
                "cancel": {
                    "text": "Жаль, что вы уходите! Отмена вашей подписки сохранит ее активной до следующего цикла оплаты, после которого вы потеряете ваши усилители Кампаний и другие привилегии относящиеся к поддержке Kanka. Можете заполнить следующую форму, чтобы сообщить нам, что мы можем сделать лучше или почему вы приняли это решение."
                },
                "cancelled": "Ваша подписка отменена. Вы можете обновить подписку, как только у вас закончится нынешняя подписка.",
                "change": {
                    "text": {
                        "monthly": "Вы подписываетесь на уровень {tier}, оплачиваемый в {amount} в месяц.",
                        "yearly": "Вы подписываетесь на уровень {tier}, оплачиваемый в {amount} в год."
                    },
                    "title": "Изменение уровня подписки"
                },
                "currencies": {
                    "eur": "EUR",
                    "usd": "USD"
                },
                "currency": {
                    "title": "Изменение вашей предпочитаемой валюты оплаты"
                },
                "errors": {
                    "callback": "Наш провайдер счетов сообщил об ошибке. Пожалуйста, попробуйте еще раз или свяжитесь с нами, если проблема повторится.",
                    "subscribed": "Невозможно обработать вашу подписку. Stripe предоставил следующий совет."
                },
                "fields": {
                    "active_since": "Активна с",
                    "active_until": "Активна до",
                    "billing": "Оплата",
                    "currency": "Валюта оплаты",
                    "payment_method": "Способ оплаты",
                    "plan": "Текущий план",
                    "reason": "Причина"
                },
                "helpers": {
                    "alternatives": "Оплатите свою подписку с помощью {method}. Этот способ оплаты не будет обновляться по окончанию вашей подписки. {method} доступен только для Евро.",
                    "alternatives_warning": "Повышение вашего уровня подписки при данном способе невозможно. Пожалуйста, создайте новую подписку, когда закончится текущая.",
                    "alternatives_yearly": "Из-за ограничений, связанных с повторяющимися оплатами, {method} доступен только для годовых подписок."
                },
                "manage_subscription": "Управление подпиской",
                "payment_method": {
                    "actions": {
                        "add_new": "Добавить новый способ оплаты",
                        "change": "Изменить способ оплаты",
                        "save": "Сохранить способ оплаты",
                        "show_alternatives": "Альтернативные способы оплаты"
                    },
                    "add_one": "У вас нет сохраненного способа оплаты.",
                    "alternatives": "Вы можете подписаться с помощью альтернативных способов оплаты. Это действие изменит ваш аккаунт один раз и не будет обновлять его каждый месяц.",
                    "card": "Карта",
                    "card_name": "Имя на карте",
                    "country": "Страна проживания",
                    "ending": "Заканчивается на",
                    "helper": "Эта карта будет использоваться для всех ваших подписок.",
                    "new_card": "Добавить новый способ оплаты",
                    "saved": "{brand} заканчивается на {last4}"
                },
                "placeholders": {
                    "reason": "Если хотите, можете сказать нам, почему вы больше не поддерживаете Kanka. Отсутствует необходимая функция? Изменилась ваша финансовая ситуация?"
                },
                "plans": {
                    "cost_monthly": "{currency} {amount} выплачивается в месяц",
                    "cost_yearly": "{currency} {amount} выплачивается в год"
                },
                "sub_status": "Информация о подписке",
                "subscription": {
                    "actions": {
                        "downgrading": "Пожалуйста, свяжитесь с нами для понижения",
                        "rollback": "Изменить на Kobold",
                        "subscribe": "Изменить на месячный {tier}",
                        "subscribe_annual": "Изменять на годовой {tier}"
                    }
                },
                "success": {
                    "alternative": "Ваша оплата зарегистрирована. Вы получите уведомление, как только она будет обработана и ваша подписка будет активирована.",
                    "callback": "Ваша подписка успешно оформлена. Ваш аккаунт будет обновлен, как только наш провайдер счетов сообщит нам об изменении (это может занять несколько минут)",
                    "cancel": "Ваша подписка была отменена. Она будет активной до окончания вашего текущего периода оплаты.",
                    "currency": "Настройки вашей предпочитаемой валюты обновлены.",
                    "subscribed": "Ваша подписка успешно оформлена. Не забудьте подписаться на рассылку голосований, чтобы знать, когда начнется голосование. Вы можете изменить свои настройки рассылки на странице вашего профиля."
                },
                "tiers": "Уровни подписки",
                "trial_period": "У годовых подписок есть возможность отмены в течение 14 дней. Свяжитесь с нами через {email}, если вы хотите отменить вашу годовую подписку и получить деньги назад.",
                "upgrade_downgrade": {
                    "button": "Информация о повышении и понижении",
                    "downgrade": {
                        "bullets": {
                            "end": "Ваш текущий уровень будет активен до окончания текущего цикла оплаты, после чего вы будете понижены до вашего нового уровня."
                        },
                        "title": "При понижении на уровень"
                    },
                    "upgrade": {
                        "bullets": {
                            "immediate": "Ваш способ оплаты будет немедленно оплачен и вы получите доступ к вашему новому уровню.",
                            "prorate": "При повышении с Owlbear на Elemental вы заплатите только разницу с вашим новым уровнем."
                        },
                        "title": "При повышении на уровень"
                    }
                },
                "warnings": {
                    "incomplete": "Не удалось снять деньги с вашей карты. Пожалуйста обновите информацию вашей кредитной карты, и мы попробуем снова в течение следующих нескольких дней. Если ошибка произойдет снова, ваша подписка будет отменена.",
                    "patreon": "Ваш аккаунт подключен к Patreon. Пожалуйста, отключите ваш аккаунт в ваших настройках {patreon} перед включением Kanka подписки."
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Создание нового Разговора",
                "success": "Разговор \"{name}\" создан.",
                "title": "Новый Разговор"
            },
            "destroy": {
                "success": "Разговор \"{name}\" удален."
            },
            "edit": {
                "description": "Обновление Разговора",
                "success": "Разговор \"{name}\" обновлен.",
                "title": "Разговор {name}"
            },
            "fields": {
                "messages": "Сообщения",
                "name": "Названия",
                "participants": "Участники",
                "target": "Участники",
                "type": "Тип"
            },
            "hints": {
                "participants": "Добавьте в свой Разговор участников, нажав на иконку {icon} справа вверху."
            },
            "index": {
                "add": "Новый Разговор",
                "description": "Управление категорией {name}.",
                "header": "Разговоры в {name}",
                "title": "Разговоры"
            },
            "messages": {
                "destroy": {
                    "success": "Сообщение удалено."
                },
                "is_updated": "Обновлено",
                "load_previous": "Загрузить предыдущие сообщения",
                "placeholders": {
                    "message": "Ваше сообщение"
                }
            },
            "participants": {
                "create": {
                    "success": "Участник {entity} добавлен в Разговор."
                },
                "description": "Добавление или удаление участников Разговора.",
                "destroy": {
                    "success": "Участник {entity} удален из Разговора"
                },
                "modal": "Участники",
                "title": "Участники {name}"
            },
            "placeholders": {
                "name": "Название Разговора",
                "type": "Игровой, подготовка, выдуманный"
            },
            "show": {
                "description": "Детальный вид разговора.",
                "title": "Разговор {name}"
            },
            "tabs": {
                "conversation": "Разговор",
                "participants": "Участники"
            },
            "targets": {
                "characters": "Персонажи",
                "members": "Члены"
            }
        },
        "admin": [],
        "timelines": [],
        "crud": {
            "actions": {
                "actions": "Действия",
                "apply": "Применить",
                "back": "Назад",
                "copy": "Копировать",
                "copy_mention": "Копировать [ ] ссылку",
                "copy_to_campaign": "Копировать в Кампанию",
                "explore_view": "Свернутый вид",
                "export": "Экспортировать (PDF)",
                "find_out_more": "Узнать больше",
                "go_to": "Перейти к {name}",
                "json-export": "Экспортировать (JSON)",
                "move": "Переместить",
                "new": "Новый",
                "next": "Следующее",
                "reset": "Сброс"
            },
            "add": "Добавить",
            "alerts": {
                "copy_mention": "Специальная ссылка на объект скопирована в ваш буфер обмена."
            },
            "attributes": {
                "actions": {
                    "apply_template": "Применить Шаблон Атрибутов",
                    "manage": "Управление",
                    "more": "Другое",
                    "remove_all": "Удалить все"
                },
                "fields": {
                    "attribute": "Атрибут",
                    "community_templates": "Шаблоны сообщества",
                    "is_private": "Приватные атрибуты",
                    "is_star": "Закреплен",
                    "template": "Шаблон",
                    "value": "Значение"
                },
                "helpers": {
                    "delete_all": "Вы уверены, что хотите удалить все атрибуты этого объекта?"
                },
                "hints": {
                    "is_private": "Вы можете скрыть все атрибуты объекта для всех участников без роли \"Админ\", сделав их приватными."
                },
                "index": {
                    "success": "Атрибуты для {name} обновлены.",
                    "title": "Атрибуты для {name}"
                },
                "placeholders": {
                    "attribute": "Число завоеваний, оценка испытаний, инициатива, население",
                    "block": "Название блока",
                    "checkbox": "Название флажка",
                    "section": "Название раздела",
                    "template": "Выберите Шаблон",
                    "value": "Значение атрибута"
                },
                "template": {
                    "success": "Шаблон Атрибутов {name} применен к {entity}",
                    "title": "Применение Шаблона Атрибутов к {name}"
                },
                "types": {
                    "attribute": "Атрибут",
                    "block": "Блок",
                    "checkbox": "Флажок",
                    "section": "Раздел",
                    "text": "Большой текст"
                },
                "visibility": {
                    "entry": "Атрибут расположен в меню объектов.",
                    "private": "Атрибут виден только участникам с ролью \"Админ\".",
                    "public": "Атрибут виден всем участникам.",
                    "tab": "Атрибут отображается только во вкладке атрибутов."
                }
            },
            "boosted": "Усилена",
            "boosted_campaigns": "Усиленные Кампании",
            "bulk": {
                "actions": {
                    "edit": "Массовый редактор и Тэги"
                },
                "age": {
                    "helper": "Вы можете использовать + и - перед числом, чтобы изменить возраст на это число."
                },
                "delete": {
                    "title": "Удаление нескольких объектов",
                    "warning": "Вы уверены, что хотите удалить выбранные объекты?"
                },
                "edit": {
                    "tagging": "Действие с тэгами",
                    "tags": {
                        "add": "Добавить",
                        "remove": "Удалить"
                    },
                    "title": "Редактирование нескольких объектов"
                },
                "errors": {
                    "admin": "Статус приватности объектов могут редактировать только Админы Кампании.",
                    "general": "При выполнении вашего действия произошла ошибка. Пожалуйста, попробуйте снова и свяжитесь с нами, если проблема повторится. Сообщение ошибки: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Перезапись"
                    },
                    "helpers": {
                        "override": "Если включена, то разрешения выбранных объектов будут заменены. Если нет, эти разрешения будут добавлены к существующим."
                    },
                    "title": "Изменение разрешений нескольких объектов"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} объект скопирован в {campaign}.|[2, 4] {count} объекта скопировано в {campaign}.|[5, *] {count} объектов скопировано в {campaign}.",
                    "editing": "{1} {count} объект обновлен.|[2, 4] {count} объекта обновлено.|[5, *] {count} объектов обновлено.",
                    "permissions": "{1} Разрешения изменены для {count} объекта.|[2, *] Разрешения изменены для {count} объектов.",
                    "private": "{1} {count} объект теперь приватен.|[2, 4] {count} объекта теперь приватно.|[5, *] {count} объектов теперь приватны.",
                    "public": "{1} {count} объект теперь невидим.|[2, 4] {count} объекта теперь невидимы.|[5, *] {count} объектов теперь невидимы."
                }
            },
            "cancel": "Отмена",
            "click_modal": {
                "close": "Закрыть",
                "confirm": "Подтвердить",
                "title": "Подтверждение вашего действия"
            },
            "copy_to_campaign": {
                "bulk_title": "Копирование объектов в другую Кампанию",
                "panel": "Копировать",
                "title": "Копирование \"{name}\" в другую Кампанию"
            },
            "create": "Создать",
            "datagrid": {
                "empty": "Нечего показать."
            },
            "delete_modal": {
                "close": "Закрыть",
                "delete": "Удалить",
                "description": "Вы уверены, что хотите удалить {tag}?",
                "mirrored": "Удалить зеркальную связь",
                "title": "Подтверждение удаления"
            },
            "destroy_many": {
                "success": "Удален {count} объект.|Удалено {count} объектов."
            },
            "edit": "Редактировать",
            "errors": {
                "boosted": "Эта функция доступна только для усиленный Кампаний.",
                "node_must_not_be_a_descendant": "Неправильный узел (Тэг, родительская Локация): это потомок самого себя."
            },
            "events": {
                "hint": "Ниже расположен список всех Календарей, в которые добавлено это событие с помощью \"Добавить Событие в Календарь\"."
            },
            "export": "Экспортировать",
            "fields": {
                "ability": "Способность",
                "attribute_template": "Шаблон Артибутов",
                "calendar": "Календарь",
                "calendar_date": "Дата Календаря",
                "character": "Персонаж",
                "colour": "Цвет",
                "copy_attributes": "Копировать атрибуты",
                "copy_notes": "Копировать заметки объекта",
                "creator": "Создатель",
                "dice_roll": "Бросок Кубика",
                "entity": "Объект",
                "entity_type": "Тип объекта",
                "entry": "Текст",
                "event": "Событие",
                "excerpt": "Выдержка",
                "family": "Семья",
                "files": "Файлы",
                "has_image": "Есть изображение",
                "header_image": "Изображение заголовка",
                "image": "Изображение",
                "is_private": "Приватный",
                "is_star": "Закреплен",
                "item": "Предмет",
                "location": "Локация",
                "map": "Карта",
                "name": "Название",
                "organisation": "Организация",
                "position": "Позиция",
                "race": "Раса",
                "tag": "Тэг",
                "tags": "Тэги",
                "timeline": "Хронология",
                "tooltip": "Подсказка",
                "type": "Тип",
                "visibility": "Видимость"
            },
            "files": {
                "actions": {
                    "drop": "Нажмите, чтобы добавить или удалить файл",
                    "manage": "Управление файлами объектов"
                },
                "errors": {
                    "max": "Вы достигли лимита ({max}) файлов для этого объекта.",
                    "no_files": "Нет файлов."
                },
                "files": "Обновленные файлы",
                "hints": {
                    "limit": "Каждый объект может иметь не более {max} загруженных файлов.",
                    "limitations": "Форматы: jpg, png, gif и pdf. Макс. размер файла: {size}."
                },
                "title": "Файлы объекта {name}"
            },
            "filter": "Фильтр",
            "filters": {
                "all": "Фильтр для всех потомков",
                "clear": "Очистить фильтры",
                "direct": "Фильтр для прямых потомков",
                "filtered": "Показано {count} из {total} {entity}",
                "hide": "Скрыть фильтры",
                "options": {
                    "exclude": "Исключить",
                    "include": "Включить",
                    "none": "Нет"
                },
                "show": "Показать фильтры",
                "sorting": {
                    "asc": "По возрастанию {field}",
                    "desc": "По убыванию {field}",
                    "helper": "Управление порядком сортировки результатов"
                },
                "title": "Фильтры"
            },
            "forms": {
                "actions": {
                    "calendar": "Добавить дату Календаря."
                },
                "copy_options": "Копировать опции"
            },
            "hidden": "Скрытый",
            "hints": {
                "attribute_template": "Применять Шаблон Атрибутов непосредственно при создании объекта.",
                "calendar_date": "Дата Календаря позволяет легко фильтровать в списках, а также хранит Событие выбранного Календаря.",
                "header_image": "Это изображение будет расположено над объектом. Лучше использовать широкое изображение.",
                "image_limitations": "Форматы: jpg, png и gif. Макс. размер файла: {size}.",
                "image_patreon": "Увеличить лимит размера файла?",
                "is_private": "Если установлено на \"Приватный\", то этот объект могут видеть только участники Кампании с ролью \"Админ\".",
                "is_star": "Закрепленные элементы появятся в меню объектов.",
                "map_limitations": "Форматы: jpg, png, gif и svg. Макс. размер файла: {size}.",
                "tooltip": "Заменить автоматически сгенерированную подсказку на следующее содержание.",
                "visibility": "Значение видимости \"Админ\" означает, что это могут видеть только участники Кампании с ролью \"Админ\". Значение \"Я\" означает, что это можете видеть только вы."
            },
            "history": {
                "created": "Создан <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>.",
                "created_date": "Создан <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>.",
                "unknown": "Неизвестно",
                "updated": "Последнее изменение от <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>.",
                "updated_date": "Последнее изменение <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>.",
                "view": "Показать журнал объекта"
            },
            "image": {
                "error": "Нам не удалось получить запрошенное изображение. Возможно, сайт не позволяет нам скачать изображение (типично для Squarespace и DeviantArt) или эта ссылка уже не действительна. Пожалуйста, убедитесь также, что изображение не превышает {size}."
            },
            "is_not_private": "В данный момент этот объект не приватен.",
            "is_private": "Этот объект приватен и виден только участникам с ролью \"Админ\".",
            "linking_help": "Как я могу ссылаться на другие объекты.",
            "manage": "Управление",
            "move": {
                "description": "Перемещение этого объекта в другое место.",
                "errors": {
                    "permission": "Вам не разрешено создавать объекты этого типа в этой Кампании.",
                    "same_campaign": "Вам нужно выбрать другую Кампанию, чтобы переместить в нее этот объект.",
                    "unknown_campaign": "Неизвестная Кампания."
                },
                "fields": {
                    "campaign": "Новая Кампания",
                    "copy": "Создать копию",
                    "target": "Новый тип"
                },
                "hints": {
                    "campaign": "Вы также можете попробовать переместить этот объект в другую Кампанию.",
                    "copy": "Выберите эту опцию, если хотите создать копию в новой Кампании.",
                    "target": "Пожалуйста, учтите, что некоторые данные могут быть потеряны при перемещении элемента из одного типа в другой."
                },
                "success": "Объект \"{name}\" перемещен.",
                "success_copy": "Объект \"{name}\" скопирован.",
                "title": "Перемещение {name}"
            },
            "new_entity": {
                "error": "Пожалуйста, проверьте ваши значения.",
                "fields": {
                    "name": "Название"
                },
                "title": "Новый объект"
            },
            "or_cancel": "или <a href=\"{url}\">отменить</a>",
            "panels": {
                "appearance": "Оформление",
                "attribute_template": "Шаблон Атрибутов",
                "calendar_date": "Дата Календаря",
                "entry": "Текст",
                "general_information": "Основная информация",
                "move": "Переместить",
                "system": "Система"
            },
            "permissions": {
                "action": "Действия",
                "actions": {
                    "bulk": {
                        "add": "Разрешить",
                        "deny": "Запретить",
                        "ignore": "Пропустить",
                        "remove": "Удалить"
                    },
                    "bulk_entity": {
                        "allow": "Разрешить",
                        "deny": "Запретить",
                        "inherit": "Наследовать"
                    },
                    "delete": "Удалить",
                    "edit": "Редактировать",
                    "entity_note": "Заметки объекта",
                    "read": "Читать",
                    "toggle": "Изменить"
                },
                "allowed": "Позволено",
                "fields": {
                    "member": "Участник",
                    "role": "Роль"
                },
                "helper": "Используйте этот интерфейс, чтобы настроить, какие пользователи и роли могут взаимодействовать с этим объектом. {allow}",
                "helpers": {
                    "setup": "Используйте этот интерфейс, чтобы настроить то, как роли и пользователи могут взаимодействовать с этим объектом. {allow} позволит пользователю или роли совершать это действие. {deny} запретит им это действие. {inherit} будет использовать разрешение роли пользователя или основной роли. Пользователь с {allow} может совершать даже те действия, которые для его роли установлены как {deny}."
                },
                "inherited": "У этой роли уже есть это разрешение для этого типа объектов.",
                "inherited_by": "Этот пользователь входит в роль \"{role}\", у которой есть эти разрешения для этого типа объектов.",
                "success": "Разрешения сохранены.",
                "title": "Разрешения",
                "too_many_members": "В этой Кампании слишком много участников (>10) для отображения этого интерфейса. Пожалуйста, используйте кнопку \"Разрешения\" объекта для детального контроля разрешений."
            },
            "placeholders": {
                "ability": "Выберите Способность",
                "calendar": "Выберите Календарь",
                "character": "Выберите Персонажа",
                "entity": "Объект",
                "event": "Выберите Событие",
                "family": "Выберите Семью",
                "image_url": "Вы также можете загрузить изображение из URL",
                "item": "Выберите Предмет",
                "location": "Выберите Локацию",
                "map": "Выберите Карту",
                "organisation": "Выберите Организацию",
                "race": "Выберите Расу",
                "tag": "Выберите Тэг"
            },
            "relations": {
                "actions": {
                    "add": "Добавить связь"
                },
                "fields": {
                    "location": "Локация",
                    "name": "Название",
                    "relation": "Связь"
                },
                "hint": "Связи между объектами можно назначить для обозначения их отношений друг с другом."
            },
            "remove": "Удалить",
            "rename": "Переименовать",
            "save": "Сохранить",
            "save_and_close": "Сохранить и Копировать",
            "save_and_copy": "Сохранить и Копировать",
            "save_and_new": "Сохранить и Создать",
            "save_and_update": "Сохранить и Обновить",
            "save_and_view": "Сохранить и Показать",
            "search": "Искать",
            "select": "Выбрать",
            "tabs": {
                "abilities": "Способности",
                "attributes": "Атрибуты",
                "boost": "Усиление",
                "calendars": "Календари",
                "default": "Умолчание",
                "events": "События",
                "inventory": "Инвентарь",
                "map-points": "Точки на карте",
                "mentions": "Упоминания",
                "menu": "Меню",
                "notes": "Заметки объекта",
                "permissions": "Разрешения",
                "relations": "Связи",
                "reminders": "Напоминания",
                "timelines": "Хронологии",
                "tooltip": "Подсказка"
            },
            "update": "Обновить",
            "users": {
                "unknown": "Неизвестно"
            },
            "view": "Показать",
            "visibilities": {
                "admin": "Админ",
                "admin-self": "Вы и Админ",
                "all": "Все",
                "self": "Вы"
            }
        },
        "campaigns": [],
        "front": [],
        "entities": []
    },
    "sk": {
        "maps": [],
        "calendars": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Prepnúť na prihlásenie do Kanky",
                    "update_email": "Aktualizovať e-mail",
                    "update_password": "Aktualizovať heslo"
                },
                "description": "Aktualizuj tvoje konto",
                "email": "Zmeniť e-mail",
                "email_success": "E-mail bol aktualizovaný.",
                "password": "Zmeniť heslo",
                "password_success": "Heslo bolo aktualizované.",
                "social": {
                    "error": "Pre toto konto už používaš prihlásenie v Kanke.",
                    "helper": "Tvoje konto je teraz spravované {provider}. Môžeš ho prestať používať a prepnúť na štandardné prihlásenie pomocou Kanky nastavením hesla.",
                    "success": "Tvoje konto teraz používa prihlásenie v Kanke.",
                    "title": "Konto cez sociálnu sieť"
                },
                "title": "Konto"
            },
            "api": {
                "experimental": "Vitaj v API Kanky! Tieto funkcionality sú stále experimentálne, ale mali by byť dostatočne stabilné na komunikáciu s API rozhraním. Vytvor si osobný prístupový žetón a použi ho v dotazovaní na API alebo použi klientský žetón, ak chceš, aby mala tvoja aplikácia prístup k užívateľským údajom.",
                "help": "Kanka bude čoskoro poskytovať prístup cez RESTful API, aby sa na ňu vedeli pripojiť aplikácie tretích strán. Detaily ohľadom správy tvojich API kľúčov nájdeš na tomto mieste.",
                "link": "Čítať API dokumentáciu",
                "request_permission": "Aktuálne pracujeme na silnej RESTful API, aby sa ku Kanke vedeli pripojiť aplikácie tretích strán. Zároveň ale obmedzujeme počet užívateľov, ktorí sa na rozhranie vedia pripojiť, dokiaľ na ňom pracujeme. Ak chceš prístup k API a vytvárať fajnové aplikácie, ktoré komunikujú s Kankou, kontaktuj nás a my ti zašleme všetky informácie, ktoré potrebuješ.",
                "title": "API"
            },
            "apps": {
                "actions": {
                    "connect": "Pripojiť",
                    "remove": "Odstrániť"
                },
                "benefits": "Kanka poskytuje niekoľko integrácií so službami tretích strán. Široká integrácia s aplikáciami tretích strán je plánovaná v budúcnosti.",
                "discord": {
                    "errors": {
                        "add": "Pri prepojení tvojho Discord účtu s Kankou sa vyskytla chyba. Prosím, skús to ešte raz."
                    },
                    "success": {
                        "add": "Tvoje Discord konto bolo prepojené.",
                        "remove": "Tvoje Discord konto bolo odpojené."
                    },
                    "text": "Pristupuj automaticky k tvojej roli predplatného."
                },
                "title": "Integrácia aplikácie"
            },
            "boost": {
                "benefits": {
                    "first": "Aby sme zabezpečili pre Kanku ďalší vývoj, niektoré funkcionality sa odomknú len pre boostnuté kampane. Boosty je možné získať pomocou predplatného. Hocikto, kto vie zobraziť danú kampaň, môže ju aj boostnuť, aby nemusel za ne platiť GM. Kampaň je boostnutá, dokedy ju daný užívateľ boostuje a je podporovateľ Kanky. Ak kampaň prestane byť boostnutá, dané údaje nie sú stratené, len skryté, dokiaľ nie je boostnutá opäť.",
                    "header": "Obrázky záhlaví objektov.",
                    "images": "Nastaviteľné štandardné obrázky objektov.",
                    "more": "Zisti viac o všetkých funkcionalitách.",
                    "second": "Boostnutie kampane odomkne nasledujúce výhody:",
                    "theme": "Nastaviteľnú tému a vizuálny štýl kampane.",
                    "third": "Ak chceš boostnuť kampaň, prejdi na stránku kampane a klikni na \"{boost_button}\" tlačidlo nad \"{edit_button}\" tlačidlom.",
                    "tooltip": "Nastaviteľné bubliny pre objekty.",
                    "upload": "Navýšená veľkosť pre nahrávanie súborov pre každého člena kampane."
                },
                "buttons": {
                    "boost": "Boost"
                },
                "campaigns": "Boostnuté kampane {count} / {max}",
                "exceptions": {
                    "already_boosted": "Kampaň {name} už je boostnutá.",
                    "exhausted_boosts": "Nemáš už žiadne boosty na rozdávanie. Odstráň najprv boost od existujúcej kampane pred priradením inej."
                },
                "success": {
                    "boost": "Kampaň {name} boostnutá",
                    "delete": "Boost z kampane {name} odstránený."
                },
                "title": "Boost"
            },
            "countries": {
                "austria": "Rakúsko",
                "belgium": "Belgicko",
                "france": "Francúzsko",
                "germany": "Nemecko",
                "italy": "Taliansko",
                "netherlands": "Holandsko",
                "spain": "Španielsko"
            },
            "invoices": {
                "actions": {
                    "download": "Stiahnuť PDF",
                    "view_all": "Zobraziť všetky"
                },
                "empty": "Žiadne faktúry",
                "fields": {
                    "amount": "Množstvo",
                    "date": "Dátum",
                    "invoice": "Faktúra",
                    "status": "Stav"
                },
                "header": "Nižšie sa nachádza zoznam posledných 24 faktúr, ktoré si môžeš stiahnuť.",
                "status": {
                    "paid": "Zaplatená",
                    "pending": "Čaká sa na platbu"
                },
                "title": "Faktúry"
            },
            "layout": {
                "success": "Nastavenia schémy aktualizované.",
                "title": "Schéma"
            },
            "marketplace": {
                "fields": {
                    "name": "Meno pre trhovisko"
                },
                "helper": "Štandardne sa v {marketplace} zobrazí tvoje meno. Prepísať ho môžeš nastavením v tomto poli.",
                "title": "Nastavenia pre trhovisko",
                "update": "Nastavenia pre trhovisko uložené."
            },
            "menu": {
                "account": "Konto",
                "api": "API",
                "apps": "Apps",
                "billing": "Spôsob platby",
                "boost": "Boost",
                "invoices": "Faktúry",
                "layout": "Schéma",
                "marketplace": "Trhovisko",
                "other": "Iné",
                "patreon": "Patreon",
                "payment_options": "Možnosti platby",
                "personal_settings": "Osobné nastavenia",
                "profile": "Profil",
                "subscription": "Predplatné",
                "subscription_status": "Stav predplatného"
            },
            "patreon": {
                "actions": {
                    "link": "Prepojiť konto",
                    "view": "Navštív Kanku na Patreone"
                }
            }
        },
        "conversations": {
            "create": {
                "description": "Vytvoriť novú diskusiu",
                "success": "Diskusia {name} vytvorená.",
                "title": "Nová diskusia"
            },
            "destroy": {
                "success": "Diskusia {name} odstránená."
            },
            "edit": {
                "description": "Upraviť diskusiu",
                "success": "Diskusia {name} upravená.",
                "title": "Diskusia {name}"
            },
            "fields": {
                "messages": "Správy",
                "name": "Meno",
                "participants": "Účastníci",
                "target": "Cieľ",
                "type": "Typ"
            },
            "hints": {
                "participants": "Prosím, pridaj do diskusiu účastníkov tým, že klikneš na symbol {icon} hore vpravo."
            },
            "index": {
                "add": "Nová diskusia",
                "description": "Spravovať kategóriu {name}.",
                "header": "Diskusie v {name}",
                "title": "Diskusie"
            },
            "messages": {
                "destroy": {
                    "success": "Správa odstránená."
                },
                "is_updated": "Upravená",
                "load_previous": "Nahrať predchádzajúce správy",
                "placeholders": {
                    "message": "Tvoja správa"
                }
            },
            "participants": {
                "create": {
                    "success": "Účastník {entity} pridaný do diskusie."
                },
                "description": "Pridať alebo odstrániť účastníkov z diskusie",
                "destroy": {
                    "success": "Účastník {entity} odstránený z diskusie."
                },
                "modal": "Účastníci",
                "title": "Účastníci {name}"
            },
            "placeholders": {
                "name": "Názov diskusie",
                "type": "V hre, príprave, deji"
            },
            "show": {
                "description": "Detailné zobrazenie diskusie",
                "title": "Diskusia {name}"
            },
            "tabs": {
                "conversation": "Diskusia",
                "participants": "Účastníci"
            },
            "targets": {
                "characters": "Postavy",
                "members": "Členovia"
            }
        },
        "admin": [],
        "crud": {
            "actions": {
                "actions": "Akcie",
                "apply": "Použiť",
                "back": "Naspäť",
                "copy": "Kopírovať",
                "copy_mention": "Kopírovať [ ] referenciu",
                "copy_to_campaign": "Kopírovať do kampane",
                "explore_view": "Vnorené zobrazenie",
                "export": "Exportovať (PDF)",
                "find_out_more": "Dozvedieť sa viac",
                "go_to": "Prejsť na {name}",
                "json-export": "Exportovať (json)",
                "more": "Ďalšie akcie",
                "move": "Premiestniť",
                "new": "Nový",
                "next": "Ďalej",
                "private": "Súkromný",
                "public": "Verejný",
                "reset": "Resetovať"
            },
            "add": "Pridať",
            "alerts": {
                "copy_mention": "Rozšírená referencia objektu bola skopírovaná do tvojej schránky."
            },
            "attributes": {
                "actions": {
                    "add": "Pridať atribúť",
                    "add_block": "Pridať blok",
                    "add_checkbox": "Pridať zaškrtávacie políčko",
                    "add_text": "Pridať text",
                    "apply_template": "Použiť šablónu atribútov",
                    "manage": "Spravovať",
                    "more": "Ďalšie možnosti",
                    "remove_all": "Odstrániť všetko"
                },
                "create": {
                    "description": "Vytvoriť nový atribút",
                    "success": "Atribút {name} pridaný k {entity}.",
                    "title": "Nový atribút pre {name}"
                },
                "destroy": {
                    "success": "Atribút {name} odstránený z {entity}."
                },
                "edit": {
                    "description": "Upraviť existujúci atribút",
                    "success": "Atribút {name} upravený pre {entity}.",
                    "title": "Upraviť atribút pre {name}"
                },
                "fields": {
                    "attribute": "Atribút",
                    "community_templates": "Komunitné šablóny",
                    "is_private": "Súkromné atribúty",
                    "is_star": "Pripnutý",
                    "template": "Šablóna",
                    "value": "Hodnota"
                },
                "helpers": {
                    "delete_all": "Naozaj chceš odstrániť všetky atribúty tohto objektu?"
                },
                "hints": {
                    "is_private": "Všetky atribúty objektu je možné skryť pred všetkými členmi okrem tých s rolou Admin, ak ho nastavíš ako súkromný."
                },
                "index": {
                    "success": "Atribúty pre {entity} upravené.",
                    "title": "Atribúty pre {name}"
                },
                "placeholders": {
                    "attribute": "Počet dobytí, úroveň obtiažnosti výzvy, iniciatíva, obyvateľstvo",
                    "block": "Názov bloku",
                    "checkbox": "Názov zaškrtávacieho políčka",
                    "section": "Názov sekcie",
                    "template": "Vybrať šablónu",
                    "value": "Hodnota atribútu"
                },
                "template": {
                    "success": "Šablóna atribútov {name} použitá na {entity}",
                    "title": "Použiť šablónu atribútov na {name}"
                },
                "types": {
                    "attribute": "Atribút",
                    "block": "Blok",
                    "checkbox": "Zaškrtávacie políčko",
                    "section": "Sekcia",
                    "text": "Viacriadkový text"
                },
                "visibility": {
                    "entry": "Atribút je zobrazený v menu objektu.",
                    "private": "Atribút viditeľný len pre členov s rolou Admin.",
                    "public": "Atribút viditeľný pre všetkých členov.",
                    "tab": "Atribút je zobrazený len v karte atribútov."
                }
            },
            "boosted": "Boostnutá",
            "boosted_campaigns": "Boostnuté kampane",
            "bulk": {
                "actions": {
                    "edit": "Hromadná úprava a kategórie"
                },
                "age": {
                    "helper": "Môžeš použiť + a - pred číslom na úpravu veku o danú hodnotu."
                },
                "delete": {
                    "title": "Odstraňujú sa viaceré objekty",
                    "warning": "Naozaj chceš odstrániť vybrané objekty?"
                },
                "edit": {
                    "tagging": "Akcie s kategóriami",
                    "tags": {
                        "add": "Pridať",
                        "remove": "Odstrániť"
                    },
                    "title": "Úprava viacerých objektov"
                },
                "errors": {
                    "admin": "Iba administrátori kampane vedia zmeniť súkromný štatút objektu.",
                    "general": "Pri spracovávaní tvojej akcie došlo k chybe. Prosím, skús to opäť a kontaktuj nás, ak problém pretrváva. Hlásenie chyby: {hint}."
                },
                "permissions": {
                    "fields": {
                        "override": "Prepísať"
                    },
                    "helpers": {
                        "override": "Ak aktivované, oprávnenia vybratých objektov budú týmito prepísané. Ak deaktivované, vybrané oprávnenia budú pridané k predchádzajúcim."
                    },
                    "title": "Zmeniť oprávnenia pre viaceré objekty"
                },
                "success": {
                    "copy_to_campaign": "{1} {count} objekt bol skopírovaný do {campaign}.|[2,4] {count} objekty boli skopírované do {campaign}.|[5,*] {count} objektov bolo skopírovaných do {campaign}.",
                    "editing": "{1} {count} objekt bol upravený.|[2,4] {count} objekty boli upravené.|[5,*] {count} objektov bolo upravených.",
                    "permissions": "{1} Oprávnenia zmenené pre {count} objekt.|[2,4] Oprávnenia zmenené pre {count} objekty.|[5,*] Oprávnenia zmenené pre {count} objektov.",
                    "private": "{1} {count} objekt je teraz súkromný.|[2,4] {count} objekty je teraz súkromné.|[5,*] {count} objektov je teraz súkromných.",
                    "public": "{1} {count} objekt je teraz viditeľný.|[2,4] {count} objekty sú teraz viditeľné.|[5,*] {count} objektov je teraz viditeľných."
                }
            },
            "cancel": "Zrušiť",
            "click_modal": {
                "close": "Zavrieť",
                "confirm": "Potvrdiť",
                "title": "Potvrdiť akciu"
            },
            "copy_to_campaign": {
                "bulk_title": "Kopírovať objekty do inej kampane",
                "panel": "Kopírovať",
                "title": "Kopírovať {name} do inej kampane"
            },
            "create": "Vytvoriť",
            "datagrid": {
                "empty": "Zatiaľ je tu prázdno."
            },
            "delete_modal": {
                "close": "Zatvoriť",
                "delete": "Odstrániť",
                "description": "Naozaj chceš odstrániť {tag}?",
                "mirrored": "Odstrániť zrkadlený vzťah.",
                "title": "Potvrdiť odstránenie"
            },
            "destroy_many": {
                "success": "{count} objekt zmazaný|{count} objekty zmazané"
            },
            "edit": "Upraviť",
            "errors": {
                "boosted": "Táto funkcia je dostupná iba pre boostnuté kampane.",
                "node_must_not_be_a_descendant": "Neplatný objekt (kategória, miesto): bol by potomok samého seba."
            },
            "events": {
                "hint": "Kalendárne udalosti, ktoré sú prepojené s týmto objektom, sa zobrazujú na tomto mieste."
            },
            "export": "Exportovať",
            "fields": {
                "ability": "Schopnosť",
                "attribute_template": "Šablóna atribútov",
                "calendar": "Kalendár",
                "calendar_date": "Dátum",
                "character": "Postava",
                "colour": "Farba",
                "copy_attributes": "Kopírovať atribúty",
                "copy_notes": "Kopírovať poznámky objektu",
                "creator": "Autor",
                "dice_roll": "Hod kockou",
                "entity": "Objekt",
                "entity_type": "Typ objektu",
                "entry": "Záznam",
                "event": "Udalosť",
                "excerpt": "Výpis",
                "family": "Rod",
                "files": "Súbory",
                "has_image": "S obrázkom",
                "header_image": "Obrázok záhlavia",
                "image": "Obrázok",
                "is_private": "Súkromný",
                "is_star": "Pripnutý",
                "item": "Predmet",
                "location": "Miesto",
                "map": "Mapa",
                "name": "Názov",
                "organisation": "Organizácia",
                "position": "Pozícia",
                "race": "Rasa",
                "tag": "Kategória",
                "tags": "Kategórie",
                "timeline": "Časová os",
                "tooltip": "Bublina",
                "type": "Typ",
                "visibility": "Viditeľnosť"
            },
            "files": {
                "actions": {
                    "drop": "Kliknutím pridať alebo súbor pretiahnuť na toto miesto (Drag & Drop).",
                    "manage": "Spravovať súbory objektov"
                },
                "errors": {
                    "max": "Max. počet ({max}) súborov v tomto objekte dosiahnutý.",
                    "no_files": "Žiadne súbory."
                },
                "files": "Nahraté súbory",
                "hints": {
                    "limit": "Do každého objektu môže byť nahratých maximálne {max} súborov.",
                    "limitations": "Podporované formáty: jpg, png, gif a pdf. Max. veľkosť súboru: {size}."
                },
                "title": "Súbory objektu {name}"
            },
            "filter": "Filter",
            "filters": {
                "all": "Filter zobrazenia všetkých podobjektov",
                "clear": "Resetovať filter",
                "direct": "Filter zobrazenia iba priamych podobjektov",
                "filtered": "Zobraziť {count} z {total} {entity}.",
                "hide": "Skryť",
                "options": {
                    "exclude": "Vylúčiť",
                    "include": "Zahrnúť",
                    "none": "Žiadne"
                },
                "show": "Zobraziť filtre",
                "sorting": {
                    "asc": "{field} vzostupne",
                    "desc": "{field} zostupne",
                    "helper": "Nastav poradie zoradenia výsledkov."
                },
                "title": "Filter"
            },
            "forms": {
                "actions": {
                    "calendar": "Doplniť dátum"
                },
                "copy_options": "Kopírovať nastavenia"
            },
            "hidden": "Skrytý",
            "hints": {
                "attribute_template": "Aplikovať šablónu atribútov automaticky pri vytvorení objektu.",
                "calendar_date": "Dátum umožňuje filtrovať zoznamy a zadať udalosť do vybraného kalendára.",
                "header_image": "Tento obrázok je umiestnený nad objekt. Odporúčame používať obrázok na šírku.",
                "image_limitations": "Podporované formáty: jpg, png a gif. Max. veľkosť súboru: {size}.",
                "image_patreon": "Zvýš svoj limit tým, že nás podporíš na Patreone.",
                "is_private": "Nastaviť ako súkromný.",
                "is_star": "Pripnuté objekty sa zobrazia v menu objektu.",
                "map_limitations": "Podporované formáty: jpg, png, gif a svg. Max. veľkosť súboru: {size}.",
                "tooltip": "Nahradiť automaticky generovaný obsah bubliny týmto obsahom.",
                "visibility": "Ak je viditeľnosť nastavená na \"Admin\", vidia to len členovia a členky roly Admin. Ak je nastavená na \"Vlastník\", môže to vidieť len ty."
            },
            "history": {
                "created": "Vytvorené: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "created_date": "Vytvorené: <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Neznámy",
                "updated": "Posledná úprava: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "updated_date": "Posledná úprava: <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Zobraziť protokol objektu"
            },
            "image": {
                "error": "Požadovaný obrázok nebolo možné stiahnuť. Zdá sa, že daná webová stránka nepovoľuje sťahovanie obrázkov (typické správanie Squarescape a DeviantArt) alebo že link už nie je platný."
            },
            "is_not_private": "Tento objekt nie je aktuálne nastavený ako súkromný.",
            "is_private": "Tento objekt je súkromný a viditeľný len pre členov s rolou Admin.",
            "linking_help": "Ako môžem prepojiť ďalšie objekty?",
            "manage": "Spravovať",
            "move": {
                "description": "Premiestniť objekt na iné miesto",
                "errors": {
                    "permission": "Nemáš oprávnenie vytvoriť objekty tohto typu v tejto kampani.",
                    "same_campaign": "Musíš vybrať inú kampaň, do ktorej chceš daný objekt premiestniť.",
                    "unknown_campaign": "Neznáma kampaň"
                },
                "fields": {
                    "campaign": "Nová kampaň",
                    "copy": "Vytvoriť kópiu",
                    "target": "Nový typ"
                },
                "hints": {
                    "campaign": "Môžeš tiež skúsiť premiestniť tento objekt do inej kampane.",
                    "copy": "Vyber si túto možnosť, ak chceš vytvoriť kópiu v novej kampani.",
                    "target": "Prosím, uvedom si, že niektoré dáta môžu zmiznúť, ak sa objekt premiestni do iného typu."
                },
                "success": "Objekt {name} premiestnený",
                "success_copy": "Objekt {name} skopírovaný",
                "title": "Premiestniť {name} na iné miesto"
            },
            "new_entity": {
                "error": "Prosím, prekontroluj tvoje zadanie.",
                "fields": {
                    "name": "Názov"
                },
                "title": "Nový objekt"
            },
            "or_cancel": "alebo <a href=\"{url}\">Zrušiť</a>",
            "panels": {
                "appearance": "Výzor",
                "attribute_template": "Šablóna atribútov",
                "calendar_date": "Dátum",
                "entry": "Záznam",
                "general_information": "Všeobecné informácie",
                "move": "Premiestniť",
                "system": "Systém"
            },
            "permissions": {
                "action": "Akcie",
                "actions": {
                    "bulk": {
                        "add": "Povoliť",
                        "deny": "Zakázať",
                        "ignore": "Ignorovať",
                        "remove": "Odstrániť"
                    },
                    "bulk_entity": {
                        "allow": "Povoliť",
                        "deny": "Zakázať",
                        "inherit": "Zdediť"
                    },
                    "delete": "Zmazať",
                    "edit": "Upraviť",
                    "entity_note": "Poznámky objektu",
                    "read": "Čítať",
                    "toggle": "Prepnúť"
                },
                "allowed": "Povolené",
                "fields": {
                    "member": "Člen",
                    "role": "Rola"
                },
                "helper": "Použi toto rozhranie na nastavenie oprávnení pre užívateľov a role pre daný objekt.",
                "helpers": {
                    "entity_note": "Povoliť užívateľom vytvárať poznámky k tomuto objektu. Aj bez tohto oprávnenia budú ešte stále vidieť poznámky s nastavením viditeľnosti pre všetkých.",
                    "setup": "Pomocou tohto rozhrania môžeš presne nastaviť ako role a užívatelia pracujú s týmto objektom. {allow} dovolí užívateľovi alebo role urobiť danú akciu. {deny} im túto akciu zakáže. {inherit} preberie nastavenie z roly užívateľa alebo z oprávnení hlavnej roly. Užívateľ s nastavením {allow} môže danú akciu vykonať, aj keď má jeho rola nastavenie {deny}."
                },
                "inherited": "Táto rola má už pridelené oprávnenia na tento typ objektov.",
                "inherited_by": "Tomuto užívateľovi je pridelená rola {role}, ktorá mu poskytuje oprávnenia na tento typ objektov.",
                "success": "Oprávnenia uložené.",
                "title": "Oprávnenia",
                "too_many_members": "Táto kampaň má príliš veľa členov (> 10), aby boli zobrazení v tomto rozhraní. Prosím, použi tlačidlo Oprávnení na danom objekte, aby sa zobrazili detaily nastavenia oprávnení."
            },
            "placeholders": {
                "ability": "Vybrať schopnosť",
                "calendar": "Vybrať kalendár",
                "character": "Vybrať postavu",
                "entity": "Objekt",
                "event": "Vybrať udalosť",
                "family": "Vybrať rod",
                "image_url": "Obrázok je možné pridať aj nahratím cez URL.",
                "item": "Vyber predmet",
                "location": "Vyber miesto",
                "map": "Vyber mapu",
                "organisation": "Vyber organizáciu",
                "race": "Vyber rasu",
                "tag": "Vyber kategóriu"
            },
            "relations": {
                "actions": {
                    "add": "Pridať vzťah"
                },
                "fields": {
                    "location": "Miesto",
                    "name": "Názov",
                    "relation": "Vzťah"
                },
                "hint": "Vzťahy je možné vytvoriť medzi objektami a zobraziť tak ich prepojenie."
            },
            "remove": "Zmazať",
            "rename": "Premenovať",
            "save": "Uložiť",
            "save_and_close": "Uložiť a zavrieť",
            "save_and_copy": "Uložiť a kopírovať",
            "save_and_new": "Uložiť a nový",
            "save_and_update": "Uložiť a upraviť",
            "save_and_view": "Uložiť a zobraziť",
            "search": "Hľadať",
            "select": "Vybrať",
            "tabs": {
                "abilities": "Schopnosti",
                "attributes": "Atribúty",
                "boost": "Boost",
                "calendars": "Kalendáre",
                "default": "Štandardný",
                "events": "Udalosti",
                "inventory": "Inventár",
                "map-points": "Značky na mape",
                "mentions": "Referencie",
                "menu": "Menu",
                "notes": "Poznámky",
                "permissions": "Oprávnenia",
                "relations": "Vzťahy",
                "reminders": "Pripomenutia",
                "timelines": "Časové osi",
                "tooltip": "Bublina"
            },
            "update": "Upraviť",
            "users": {
                "unknown": "Neznámy"
            },
            "view": "Zobraziť",
            "visibilities": {
                "admin": "Admin",
                "admin-self": "Vlastník a Admin",
                "all": "Všetci",
                "self": "Vlastník"
            }
        },
        "campaigns": [],
        "front": [],
        "randomisers": [],
        "entities": []
    },
    "tr": {
        "maps": [],
        "calendars": [],
        "conversations": {
            "create": {
                "description": "Yeni bir muhabbet yarat",
                "success": "'{name}' muhabbeti yaratıldı.",
                "title": "Yeni Muhabbet"
            },
            "destroy": {
                "success": "'{name}' muahbbeti kaldırıldı."
            },
            "edit": {
                "description": "Muhabbeti güncelle",
                "success": "'{name}' muhabbeti güncellendi.",
                "title": "{name} Muhabbeti"
            },
            "fields": {
                "messages": "Mesajlar",
                "name": "Ad",
                "participants": "Katılımcılar",
                "target": "Hedef",
                "type": "Tür"
            },
            "hints": {
                "participants": "Lütfen sağ-üstteki {icon} ikonuna tıklayarak muhabbetinize katılımcılar ekleyin."
            },
            "index": {
                "add": "Yeni Muhabbet",
                "description": "{name} kategorisini yönet.",
                "header": "{name} Muhabbetleri",
                "title": "Muhabbetler"
            },
            "messages": {
                "destroy": {
                    "success": "Mesaj kaldırıldı."
                },
                "is_updated": "Güncellendi",
                "load_previous": "Önceki mesajları yükle",
                "placeholders": {
                    "message": "Mesajınız"
                }
            },
            "participants": {
                "create": {
                    "success": "{entity} katılımcısı muhabbete eklendi."
                },
                "description": "Bir muhabbetin katılımcılarını ekle veya kaldır",
                "destroy": {
                    "success": "{name} katılımcısı muhabbetten kaldırıldı."
                },
                "modal": "Katılımcılar",
                "title": "{name} Katılımcıları"
            },
            "placeholders": {
                "name": "Muhabbetin adı",
                "type": "Oyun İçi, Hazırlık, Plan"
            },
            "show": {
                "description": "Muhabbete detaylı bir bakış",
                "title": "{name} Muhabbeti"
            },
            "tabs": {
                "conversation": "Muhabbet",
                "participants": "Katılımcılar"
            },
            "targets": {
                "characters": "Karakterler",
                "members": "Üyeler"
            }
        },
        "randomizers": [],
        "admin": [],
        "timelines": [],
        "campaigns": [],
        "front": [],
        "entities": []
    },
    "zh_CN": []
}
