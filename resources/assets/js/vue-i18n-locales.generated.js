export default {
    "ar": [],
    "de": {
        "admin": [],
        "calendars": [],
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
        "crud": {
            "actions": {
                "apply": "Übernehmen",
                "back": "Zurück",
                "copy": "Kopieren",
                "copy_to_campaign": "Kopiere zu Kampagne",
                "explore_view": "Verschachtelte Ansicht",
                "export": "Exportieren",
                "find_out_more": "Mehr erfahren",
                "go_to": "Gehe zu {name}",
                "more": "Mehr Aktionen",
                "move": "Verschieben",
                "new": "Neu",
                "next": "Weiter",
                "private": "Privat",
                "public": "Öffentlich"
            },
            "add": "Hinzufügen",
            "attributes": {
                "actions": {
                    "add": "Attribut hinzufügen",
                    "add_block": "Block hinzufügen",
                    "add_checkbox": "Checkbox hinzufügen.",
                    "add_text": "Text hinzufügen",
                    "apply_template": "Eine Attributvorlage anwenden",
                    "manage": "Verwalten",
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
                    "is_star": "Angepinnt",
                    "template": "Vorlage",
                    "value": "Wert"
                },
                "index": {
                    "success": "Attribute für {entity} aktualisiert",
                    "title": "Attribute für {name}"
                },
                "placeholders": {
                    "attribute": "Anzahl der Eroberungen, Challenge Rating, Initiative, Bevölkerung",
                    "block": "Blockname",
                    "checkbox": "Checkbox Name",
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
                    "text": "Mehrzeiliger Text"
                },
                "visibility": {
                    "entry": "Das Attribut wird im Objektmenü angezeigt.",
                    "private": "Attribut nur für Mitglieder der Rolle \"Admin\" sichtbar.",
                    "public": "Attribut für alle Mitglieder sichtbar.",
                    "tab": "Das Attribut wird nur im Attribute-Reiter angezeigt."
                }
            },
            "bulk": {
                "errors": {
                    "admin": "Nur Kampagnenadmins können den \"Privat\" Status eines Objektes ändern."
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
                "node_must_not_be_a_descendant": "Ungültiges Objekt (Kategorie, Ort): es würde ein Nachkomme von sich selbst sein."
            },
            "events": {
                "hint": "Kalenderereignisse, die mit diesem Objekt verknüpft sind, werden hier dargestellt."
            },
            "export": "Exportieren",
            "fields": {
                "attribute_template": "Attributsvorlage",
                "calendar": "Kalender",
                "calendar_date": "Datum",
                "character": "Charakter",
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
                "image": "Bild",
                "is_private": "Privat",
                "is_star": "Angepinnt",
                "item": "Gegenstand",
                "location": "Ort",
                "name": "Name",
                "organisation": "Organisation",
                "race": "Rasse",
                "tag": "Tag",
                "tags": "Tags",
                "visibility": "Sichtbarkeit"
            },
            "files": {
                "actions": {
                    "drop": "Klicken zum Hinzufügen oder Datei hierher ziehen (Drag & Drop).",
                    "manage": "Verwalte Objektdateien"
                },
                "errors": {
                    "max": "Du hast die maximale Anzahl ({max}) von Dateien in diesem Objekt erreicht."
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
                "show": "Zeigen",
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
                "image_limitations": "Unterstützte Formate: jpg, png und gif. Maximale Dateigröße: {size}.",
                "image_patreon": "Erhöhe das Limit indem du uns bei Patreon unterstützt.",
                "is_private": "Vor 'Zuschauern' verbergen",
                "is_star": "Angepinnte Objekte erscheinen im Objektmenü.",
                "map_limitations": "Unterstützte Formate: jpg, png, gif und svg. Max Dateigröße: {size}.",
                "visibility": "Wenn die Sichtbarkeit auf Admin festgelegt wird, können dies nur Mitglieder in der Rolle Admin sehen. Wird es auf \"Selbst\" gesetzt, kannst es nur du sehen."
            },
            "history": {
                "created": "Erstellt von <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Unbekannt",
                "updated": "Zuletzt aktualisiert von <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Zeige Objektprotokoll"
            },
            "image": {
                "error": "Wir konnten das von dir angeforderte Bild nicht laden. Es könnte sein, dass die Website nicht erlaubt, Bilder herunterzuladen (typisch für Squarespace und DeviantArt) oder dass der Link nicht mehr gültig ist."
            },
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
                        "remove": "Entfernen"
                    },
                    "delete": "Löschen",
                    "edit": "Bearbeiten",
                    "entity_note": "Objektnotizen",
                    "read": "Lesen"
                },
                "allowed": "Erlaubt",
                "fields": {
                    "member": "Mitglied",
                    "role": "Rolle"
                },
                "helper": "Benutze dieses Interface um die Berechtigungen von Nutzern und Rollen mit diesem Objekt  fein zu justieren.",
                "success": "Berechtigungen gespeichert.",
                "title": "Berechtigungen"
            },
            "placeholders": {
                "calendar": "Wähle einen Kalender",
                "character": "Wähle einen Character",
                "entity": "Objekt",
                "event": "Wähle ein Ereignis",
                "family": "Wähle eine Familie",
                "image_url": "Du kannst ein Bild auch von einer URL hochladen",
                "item": "Wähle einen Gegenstand",
                "location": "Wähle einen Ort",
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
            "save_and_new": "Speichern und neu",
            "save_and_update": "Speichern und aktualisieren",
            "save_and_view": "Speichern und ansehen",
            "search": "Suchen",
            "select": "Auswählen",
            "tabs": {
                "attributes": "Attribute",
                "calendars": "Kalender",
                "default": "Standard",
                "events": "Ereignisse",
                "inventory": "Inventar",
                "map-points": "Kartenmarker",
                "mentions": "Erwähnungen",
                "menu": "Menü",
                "notes": "Notizen",
                "permissions": "Berechtigungen",
                "relations": "Beziehungen"
            },
            "update": "Bearbeiten",
            "users": {
                "unknown": "Unbekannt"
            },
            "view": "Ansehen",
            "visibilities": {
                "admin": "Admin",
                "all": "Jeder",
                "self": "Selbst"
            }
        },
        "entities": [],
        "randomisers": [],
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
            "layout": {
                "description": "Aktualisiere deine Layout Optionen",
                "success": "Layout Optionen aktualisiert.",
                "title": "Layout"
            },
            "menu": {
                "account": "Account",
                "api": "API",
                "layout": "Layout",
                "patreon": "Patreon",
                "personal_settings": "Persönliche Einstellungen",
                "profile": "Profil"
            },
            "patreon": {
                "actions": {
                    "link": "Account verlinken",
                    "view": "Besuche Kanka auf Patreon"
                },
                "benefits": "Eure Unterstützung auf Patreon erlaubt es euch größere Bilder hochzuladen, hilft uns die Serverkosten zu begleichen und mehr Arbeitszeit in Kanka zu stecken.",
                "description": "Synchronisierung mit Patreon",
                "errors": {
                    "invalid_token": "Ungültiger Token! Patreon konnte die Anfrage nicht validieren.",
                    "missing_code": "Fehlender Code! Patreon hat keinen Code zurück geschickt, um deinen Account zu verifizieren.",
                    "no_pledge": "Kein Pledge! Patreon hat deinen Account verifiziert, aber konnte keinen aktiven Pledge feststellen."
                },
                "link": "Benutze diesen Button, wenn du aktuell Kanka auf Patreon unterstützt. Das gibt dir Zugriff auf einige tolle Extras.",
                "linked": "Danke, dass du Kanka auf Patreon unterstützt! Dein Account wurde verlinkt.",
                "pledge": "Pledge {name}",
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
            }
        }
    },
    "en": {
        "admin": [],
        "calendars": [],
        "campaigns": [],
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
        "crud": {
            "actions": {
                "actions": "Actions",
                "apply": "Apply",
                "back": "Back",
                "copy": "Copy",
                "copy_mention": "Copy [ ] mention",
                "copy_to_campaign": "Copy to Campaign",
                "explore_view": "Nested View",
                "export": "Export",
                "find_out_more": "Find out more",
                "go_to": "Go to {name}",
                "more": "More Actions",
                "move": "Move",
                "new": "New",
                "next": "Next",
                "private": "Private",
                "public": "Public"
            },
            "add": "Add",
            "alerts": {
                "copy_mention": "The entity's advanced mention was copied to your clipboard."
            },
            "attributes": {
                "actions": {
                    "add": "Add an attribute",
                    "add_block": "Add a block",
                    "add_checkbox": "Add a checkbox",
                    "add_text": "Add a text",
                    "apply_template": "Apply an Attribute Template",
                    "manage": "Manage",
                    "remove_all": "Delete All"
                },
                "create": {
                    "description": "Create a new attribute",
                    "success": "Attribute {name} added to {entity}.",
                    "title": "New Attribute for {name}"
                },
                "destroy": {
                    "success": "Attribute {name} for {entity} removed."
                },
                "edit": {
                    "description": "Update an existing attribute",
                    "success": "Attribute {name} for {entity} updated.",
                    "title": "Update attribute for {name}"
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
                "edit": {
                    "tagging": "Action for tags",
                    "tags": {
                        "add": "Add",
                        "remove": "Remove"
                    },
                    "title": "Editing multiple entities"
                },
                "errors": {
                    "admin": "Only campaign admins can change the private status of entities."
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
                "header_image": "Header Image",
                "image": "Image",
                "is_private": "Private",
                "is_star": "Pinned",
                "item": "Item",
                "location": "Location",
                "name": "Name",
                "organisation": "Organisation",
                "race": "Race",
                "tag": "Tag",
                "tags": "Tags",
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
                    "limitations": "Supported formats: jpg, png, gif, and pdf. Max file size: {size}"
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
                "attribute_template": "Apply an attribute template directly when creating this entity.",
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
                "unknown": "Unknown",
                "updated": "Last modified by <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "View entity log"
            },
            "image": {
                "error": "We weren't able to get the image you requested. It could be that the website doesn't allow us to download the image (typically for Squarespace and DeviantArt), or that the link is no longer valid. Please also make sure that the image isn't larger than {size}."
            },
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
                        "add": "Add",
                        "ignore": "Ignore",
                        "remove": "Remove"
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
                "helper": "Use this interface to fine-tune which users and roles that can interact with this entity.",
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
                "location": "Choose a location",
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
            "save_and_new": "Save and New",
            "save_and_update": "Save and Update",
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
        "entities": [],
        "front": [],
        "randomisers": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Switch to Kanka Login",
                    "update_email": "Update email",
                    "update_password": "Update password"
                },
                "description": "Update your account",
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
                "description": "Update your API settings",
                "experimental": "Welcome to the Kanka APIs! These features are still experimental but should be stable enough for you to start communicating with the APIs. Create a Personal Access Token to use in your api requests, or use the Client token if you want your app to have access to user data.",
                "help": "Kanka will soon provide an RESTful API so that third-party apps can connect to the app. Details on how to manage your API keys will be shown here.",
                "link": "Read the API documentation",
                "request_permission": "We are currently building a powerful RESTful API so that third-party apps can connect to the app. However, we are currently limiting the number of users who can interact with the API while we polish it. If you want to get access to the API and build cools apps that talk with Kanka, please contact us and we'll send you all the information you need.",
                "title": "API"
            },
            "boost": {
                "benefits": {
                    "first": "To secure continued progress on Kanka, some campaign features are unlocked by boosting a campaign. Boosts are unlocked through {patreon}. Anyone who can view a campaign can boost it, so that the DM doesn't always have to foot the bill. A campaign remains boosted as long as a user is boosting the campaign and they continue supporting Kanka on {patreon}. If a campaign is no longer boosted, data isn't lost, it is only hidden until the campaign is boosted again.",
                    "header": "Entity header images.",
                    "more": "Find out more about all features.",
                    "second": "Boosting a campaign enables the following benefits:",
                    "theme": "Campaign level theme and custom styling.",
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
            "layout": {
                "description": "Update your layout options",
                "success": "Layout options updated.",
                "title": "Layout"
            },
            "menu": {
                "account": "Account",
                "api": "API",
                "boost": "Boost",
                "layout": "Layout",
                "patreon": "Patreon",
                "personal_settings": "Personal Settings",
                "profile": "Profile",
                "subscription": "Subscription",
                "subscription_status": "Subscription Status",
                "payment_options": "Payment Options"
            },
            "patreon": {
                "actions": {
                    "link": "Link Account",
                    "view": "Visit Kanka on Patreon"
                },
                "benefits": "Supporting us on {patreon} unlocks all sorts of {features} for you and your campaigns, and also helps us spend more time working on improving Kanka.",
                "benefits_features": "amazing features",
                "description": "Syncing with Patreon",
                "errors": {
                    "invalid_token": "Invalid token! Patreon couldn't validate your request.",
                    "missing_code": "Missing code! Patreon didn't send back a code identifying your account.",
                    "no_pledge": "No pledge! Patreon identified your account, but doesn't know of any active pledge."
                },
                "link": "Use the following button if you are currently supporting Kanka on {patreon}. This will unlock the bonuses",
                "linked": "Thank you for supporting Kanka on Patreon! Your account is linked.",
                "pledge": "Pledge: {name}",
                "success": "Thank you for supporting Kanka on Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Your pledge level is set manually by us, so please allow up to a few days for us to properly set it. If it stays wrong for a while, please contact us."
            },
            "profile": {
                "actions": {
                    "update_profile": "Update profile"
                },
                "avatar": "Profile Picture",
                "description": "Update your profile",
                "success": "Profile updated.",
                "title": "Personal Profile"
            },
            "subscription": {
                "billing": {
                    "title": "Edit Payment Method",
                    "helper": "Your billing information is processed and stored safely through {stripe}. This payment method is used for all of your subscriptions.",
                    "saved": "Saved payment method"
                },
                "manage_subscription": "Manage your subscription",
                "benefits": "By supporting us, you can unlock some new {features} and help is invest more time into improving Kanka. No credit card information is stored or transits through our servers. We use {strip} to handle all billing.",
                "sub_status": "Subscription status",
                "fields": {
                    "plan": "Current plan",
                    "price": "Price",
                    "active_since": "Active since",
                    "active_until": "Active until"
                },
                "actions": {
                    "cancel_sub": "Cancel subscription"
                },
                "payment_method": {
                    "card": "Card",
                    "card_name": "Name on card",
                    "new_card": "Add a new payment method",
                    "add_one": "You currently have no payment method saved.",
                    "actions": {
                        "save": "Save payment method",
                        "add_new": "Add a new payment method"
                    },
                    "helper": "This card will be used for all of your subscriptions.",
                    "select": "Select a method payment",
                    "ending": "Ending in"
                },
                "subscription": {
                    "select": "Select subscription",
                    "actions": {
                        "subscribe": "Subscribe",
                        "processing": "Processing"
                    }
                },
                "success": {
                    "cancel": "Your subscription was cancelled.",
                    "subscribed": "Your subscription was successful."
                }
            }
        }
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
        "admin": [],
        "calendars": [],
        "conversations": {
            "create": {
                "description": "Crear nueva conversación",
                "success": "Conversación '{name}' creada.",
                "title": "Nueva Conversación"
            },
            "destroy": {
                "success": "Conversación '{name}' eliminada."
            },
            "edit": {
                "description": "Actualizar la conversación",
                "success": "Conversación '{name}' actualizada.",
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
                "participants": "Por favor, añade participantes a la conversación."
            },
            "index": {
                "add": "Nueva Conversación",
                "description": "Gestiona las conversaciones de {name}.",
                "header": "Conversaciones en {name}",
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
                "type": "Dentro del juego, Preparación, Argumento"
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
                "more": "Más acciones",
                "move": "Mover",
                "new": "Nuevo",
                "next": "Siguiente",
                "private": "Privado",
                "public": "Público"
            },
            "add": "Añadir",
            "alerts": {
                "copy_mention": "La mención avanzada de la entidad se ha copiado a tu portapapeles."
            },
            "attributes": {
                "actions": {
                    "add": "Añadir atributo",
                    "add_block": "Añadir un bloque",
                    "add_checkbox": "Añadir una casilla",
                    "add_text": "Añadir texto",
                    "apply_template": "Aplicar una plantilla de atributos",
                    "manage": "Administrar",
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
                    "title": "Actualizar atributo a {name}"
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
                    "is_private": "Puedes ocultar todos los atributos de una entidad a todos los miembros no administradores haciéndola privada."
                },
                "index": {
                    "success": "Atributos de {entity} actualizados.",
                    "title": "Atributos de {name}"
                },
                "placeholders": {
                    "attribute": "Número de conquistas, Iniciativa, Población",
                    "block": "Nombre del bloque",
                    "checkbox": "Nombre de la casilla",
                    "section": "Nombre de la sección",
                    "template": "Seleccionar plantilla",
                    "value": "Valor del atributo"
                },
                "template": {
                    "success": "Plantilla de atributos {name} aplicada en {entity}",
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
            "boosted": "Mejorada",
            "bulk": {
                "actions": {
                    "edit": "Editar y etiquetar en lote"
                },
                "edit": {
                    "tagging": "Acción para las etiquetas",
                    "tags": {
                        "add": "Añadir",
                        "remove": "Eliminar"
                    },
                    "title": "Editando múltiples entidades"
                },
                "errors": {
                    "admin": "Solamente los administradores de la campaña pueden cambiar el estatus privado de las entidades."
                },
                "permissions": {
                    "fields": {
                        "override": "Ignorar"
                    },
                    "helpers": {
                        "override": "Si está seleccionado, los permisos de las entidades seleccionadas serán ignorados y en cambio usarán estos ajustes. Si no está seleccionado, los estos permisos se añadirán a los existentes."
                    },
                    "title": "Cambiar permisos a varias entidades"
                },
                "success": {
                    "editing": "{count} entidad se ha actualizado.|{count} entidades se han actualizado.",
                    "permissions": "Permisos cambiados en {count} entidad.|Permisos cambiados en {count} entidades.",
                    "private": "{count} entidad es ahora privada|{count} entidades son ahora privadas.",
                    "public": "{count} entidad es ahora visible|{count} son ahora visibles."
                }
            },
            "cancel": "Cancelar",
            "click_modal": {
                "close": "Cerrar",
                "confirm": "Confirmar",
                "title": "Confirmar acción"
            },
            "copy_to_campaign": {
                "panel": "Copiar",
                "title": "Copiar '{name}' a otra campaña"
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
                "success": "{count} entidad eliminada|{count} entidades eliminadas."
            },
            "edit": "Editar",
            "errors": {
                "node_must_not_be_a_descendant": "Nodo inválido (categoría, localización superior): sería un descendiente de sí mismo."
            },
            "events": {
                "hint": "Los eventos del calendario asociados a esta entidad se muestran aquí."
            },
            "export": "Exportar",
            "fields": {
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
                "header_image": "Imagen de cabecera",
                "image": "Imagen",
                "is_private": "Privado",
                "is_star": "Fijada",
                "item": "Objeto",
                "location": "Localización",
                "name": "Nombre",
                "organisation": "Organización",
                "race": "Raza",
                "tag": "Etiqueta",
                "tags": "Etiquetas",
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
                "image_patreon": "Aumenta el límite apoyándonos en Patreon",
                "is_private": "Ocultar a los \"Invitados\"",
                "is_star": "Los elementos fijados aparecerán en el menú principal de la entidad.",
                "map_limitations": "Formatos soportados: jpg, png, gif y svg. Tamaño máximo del archivo: {size}.",
                "tooltip": "Reemplaza la descripción emergente automática con uno de los siguientes contenidos.",
                "visibility": "Al seleccionar \"Administrador\", solo los miembros con el rol de administrador podrán ver esto. \"Solo yo\" significa que solo tú puedes ver esto."
            },
            "history": {
                "created": "Creado por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Desconocido",
                "updated": "Última modificación por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Historial de cambios de la entidad"
            },
            "image": {
                "error": "No hemos podido obtener la imagen. Puede que la página web no nos permita descargarla (típico de Squarespace o DeviantArt), o que el enlace ya no es válido."
            },
            "is_private": "Esta entidad es privada y no será visible por los usuarios Invitados.",
            "linking_help": "¿Como puedo enlazar otras entradas?",
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
                    "target": "Por favor ten en cuenta que algunos datos pueden perderse al mover un elemento de un tipo a otro."
                },
                "success": "Entidad '{name}' movida.",
                "success_copy": "Entidad '{name}' copiada.",
                "title": "Mover {name}"
            },
            "new_entity": {
                "error": "Por favor revisa lo introducido.",
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
                        "add": "Añadir",
                        "ignore": "Ignorar",
                        "remove": "Eliminar"
                    },
                    "delete": "Eliminar",
                    "edit": "Editar",
                    "entity_note": "Notas de entidad",
                    "read": "Leer"
                },
                "allowed": "Permitido",
                "fields": {
                    "member": "Miembro",
                    "role": "Rol"
                },
                "helper": "Usa esta interfaz para afinar qué usuarios y roles pueden interactuar con esta entidad.",
                "inherited": "Este rol ya tiene este permiso en esta entidad.",
                "inherited_by": "Este usuario forma parte del rol \"{role}\", que le otorga este permiso en esta entidad.",
                "success": "Permisos guardados.",
                "title": "Permisos",
                "too_many_members": "Esta campaña tiene demasiados miembros (>10) para mostrarlos todos en esta interfaz. Puedes usar el botón de permisos en la vista de entidad para controlar los permisos detalladamente."
            },
            "placeholders": {
                "calendar": "Escoge un calendario",
                "character": "Escoge un personaje",
                "entity": "Entidad",
                "event": "Elige un evento",
                "family": "Elige una familia",
                "image_url": "Puedes subir una imagen desde una URL",
                "item": "Elige un objeto",
                "location": "Escoge una localización",
                "organisation": "Elige una organización",
                "race": "Elige una raza",
                "tag": "Elige una etiqueta"
            },
            "relations": {
                "actions": {
                    "add": "Añadir una relación"
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
            "save_and_close": "Guardar y Cerrar",
            "save_and_new": "Guardar y Crear nuevo",
            "save_and_update": "Guardar y Seguir editando",
            "save_and_view": "Guardar y Ver",
            "search": "Buscar",
            "select": "Seleccionar",
            "tabs": {
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
                "tooltip": "Descripción emergente"
            },
            "update": "Actualizar",
            "users": {
                "unknown": "Desconocido"
            },
            "view": "Ver",
            "visibilities": {
                "admin": "Admin",
                "all": "Todos",
                "self": "Solo yo"
            }
        },
        "entities": [],
        "randomisers": [],
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
            "boost": {
                "benefits": {
                    "first": "Para asegurar un progreso contínuo en Kanka, algunas características de campaña se pueden desbloquear mejorando la campaña. Las mejoras se desbloquean mediante {patreon}. Cualquiera que pueda ver una campaña puede mejorarla; así el máster no tiene que pagar la cuenta siempre. Una campaña permanece mejorada mientras un usuario la esté mejorando y continúe apoyando a Kanka en {patreon}. Si una campaña deja de estar mejorada, los datos no se pierden: solo permanecen ocultos hasta que la campaña vuelva a ser mejorada.",
                    "header": "Imágenes de cabecera para las entidades.",
                    "more": "Saber más sobre todas las características.",
                    "second": "Mejorar una campaña activa los siguientes beneficios:",
                    "theme": "Tema y estilo personalizado a nivel de campaña.",
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
            "layout": {
                "description": "Actualizar opciones de diseño",
                "success": "Opciones de diseño actualizadas.",
                "title": "Diseño"
            },
            "menu": {
                "account": "Cuenta",
                "api": "API",
                "boost": "Mejorar",
                "layout": "Diseño",
                "patreon": "Patreon",
                "personal_settings": "Ajustes personales",
                "profile": "Perfil"
            },
            "patreon": {
                "actions": {
                    "link": "Enlazar cuenta",
                    "view": "Visita la página de Patreon de Kanka"
                },
                "benefits": "Si nos ayudas en Patreon podrás subir imágenes más pesadas, y así nos ayudarás a cubrir los costes del servidor y a dedicarle más tiempo a trabajar en Kanka.",
                "benefits_features": "Funciones increíbles",
                "description": "Sincronizando con Patreon",
                "errors": {
                    "invalid_token": "¡Token no válido! Patreon no ha podido validar tu petición.",
                    "missing_code": "¡Falta el código! Patreon no ha enviado un código para identificar tu cuenta.",
                    "no_pledge": "¡Sin \"pledge\"! Patreon ha identificado tu cuenta, pero no detecta ningún \"pledge\" activo."
                },
                "link": "Usa el siguiente botón si estás apoyando a Kanka en Patreon actualmente. ¡Esto te dará acceso a más cosas fantásticas extras!",
                "linked": "¡Gracias por apoyar a Kanka en Patreon! Se ha enlazado tu cuenta.",
                "pledge": "Pledge {name}",
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
            }
        }
    },
    "fr": {
        "admin": [],
        "calendars": [],
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
                "target": "CIble",
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
                "load_previous": "Messages précédants",
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
                "more": "Autres Actions",
                "move": "Déplacer",
                "new": "Nouveau",
                "next": "Prochain",
                "private": "Privé",
                "public": "Publique"
            },
            "add": "Ajouter",
            "alerts": {
                "copy_mention": "La mention avancée de cette entité a été copier au presse-papier."
            },
            "attributes": {
                "actions": {
                    "add": "Ajouter un attribut",
                    "add_block": "Ajouter un block",
                    "add_checkbox": "Ajouter une case à docher",
                    "add_text": "Ajouter un text",
                    "apply_template": "Appliquer un modèle d'attribut",
                    "manage": "Gérer",
                    "remove_all": "Tout supprimer"
                },
                "create": {
                    "description": "Créer un nouvel attribut",
                    "success": "Attribut {name} ajouté à {entity}.",
                    "title": "Nouvel attribut pour {name}"
                },
                "destroy": {
                    "success": "Attribut {name} supprimé de {entity}."
                },
                "edit": {
                    "description": "Modifier un attribut existant",
                    "success": "Attribut {name} modifié pour {entity}.",
                    "title": "Modifier l'attribut pour {name}"
                },
                "fields": {
                    "attribute": "Attribut",
                    "community_templates": "Modèles Communautaire",
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
                    "block": "Nom du bloque",
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
                    "block": "Block",
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
                "edit": {
                    "tagging": "Action pour les étiquettes",
                    "tags": {
                        "add": "Ajouter",
                        "remove": "Retirer"
                    },
                    "title": "Modifications de plusieurs entités"
                },
                "errors": {
                    "admin": "Seulement les membres administrateur de la campagne peuvent changer le status des entités."
                },
                "permissions": {
                    "fields": {
                        "override": "Remplacer"
                    },
                    "helpers": {
                        "override": "Si sélectionné, les permissions des entités sélectionnées seront remplacer par ceux-ci. Si non-sélectionné, les permissions sélectionnées seront ajoutées à celles existantes."
                    },
                    "title": "Changer les permissions pour plusieurs entités"
                },
                "success": {
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
                "description": "Est-tu sûr de vouloir supprimer {tag}?",
                "mirrored": "Supprimer la relation liée.",
                "title": "Confirmation la suppression"
            },
            "destroy_many": {
                "success": "{count} élément supprimé.|{count} éléments supprimés."
            },
            "edit": "Modifier",
            "errors": {
                "boosted": "Cette fonctionalité n'est que accessible pour aux campagnes boostées..",
                "node_must_not_be_a_descendant": "Node invalide (étiquette, lieu parent): l'entité serait un descendant de lui-même."
            },
            "events": {
                "hint": "Les événements de calendrier peuvent être associé à cette entité et être affiché ici."
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
                "header_image": "Image d'en-tête",
                "image": "Image",
                "is_private": "Privé",
                "is_star": "Epinglé",
                "item": "Objet",
                "location": "Lieu",
                "name": "Nom",
                "organisation": "Organisation",
                "race": "Race",
                "tag": "Etiquette",
                "tags": "Etiquettes",
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
                "files": "Fichiers uploadé",
                "hints": {
                    "limit": "Chaque entité peut avoir un nombre maximal de {max} fichiers uploadé.",
                    "limitations": "Formats supportés: jpg, png, gif et pdf. Taille maximale: {size}"
                },
                "title": "Fichiers d'entité pour {name}"
            },
            "filter": "Filtre",
            "filters": {
                "all": "Afficher tous les descendants",
                "clear": "Effacer les filtres",
                "direct": "Affichier seulement descendants directs",
                "filtered": "Affichant {count} de {total} {entity}.",
                "hide": "Cacher les filtres",
                "show": "Afficher les filtres",
                "sorting": {
                    "asc": "{field} ascendant",
                    "desc": "{field} descendant",
                    "helper": "Controler l'ordre d'affichage des résultats."
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
                "attribute_template": "Appliquer un modèl d'attribut lors de la création de cette entité.",
                "calendar_date": "Une date de calendrier permet un triage plus facile dans les listes, et garde à jour un événement de calendrier dans le calendrier sélectionné.",
                "header_image": "Cette image s'affiche au dela de l'entité. Les images larges mènent a un meilleur résultat.",
                "image_limitations": "Formats supportés: jpg, png et gif. Taille max: {size}.",
                "image_patreon": "Augmenter la taille limite?",
                "is_private": "Cacher des membres de type non-Admin",
                "is_star": "Les éléments épinglés sont affichés sur le menu de l'entité.",
                "map_limitations": "Formats supportés: jpg, png, gif et svg. Taille maximale: {size}.",
                "tooltip": "Remplace l'infobulle automatiquement généré avec le text ci-dessous.",
                "visibility": "Si la visibilité est définie à Admin, seuls les membres du rôle Admin de la campagne verront ceci. La visibilité \"Soit-même\" signifie que seulement tu peux le voir."
            },
            "history": {
                "created": "Créé par <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Inconnu",
                "updated": "Dernière modification par <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Visionner les journaux de l'entité"
            },
            "image": {
                "error": "Impossible de récupérer l'image demandée. Il est possible que le site web ne nous permet pas de télécharger des images (cela arrive par example avec squarespace et DeviantArt), ou le lien n'est plus valide."
            },
            "is_private": "Cet élément est privé et pas visible.",
            "linking_help": "Comment lier vers d'autres éléments?",
            "manage": "Gérer",
            "move": {
                "description": "Déplacer cet élément à un nouveau endroit",
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
                    "copy": "Activer cette option créé une copie dans la nouvelle campagne.",
                    "target": "Attention! Certaines informations peuvent être perdues lors du déplacement d'un élément."
                },
                "success": "Elément {name} déplacé.",
                "success_copy": "Entité '{name}' copiée.",
                "title": "Déplacer {name} autre part"
            },
            "new_entity": {
                "error": "Vérifier les valeures.",
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
                        "ignore": "Ignorer",
                        "remove": "Retirer"
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
                "tooltip": "Infobulle"
            },
            "update": "Modifier",
            "users": {
                "unknown": "Inconnu"
            },
            "view": "Voir",
            "visibilities": {
                "admin": "Admin",
                "admin-self": "Sois-même & Admin",
                "all": "Tous",
                "self": "Sois-même"
            }
        },
        "entities": [],
        "front": [],
        "randomisers": [],
        "settings": {
            "account": {
                "actions": {
                    "social": "Changer au login Kanka",
                    "update_email": "Modifier l'email",
                    "update_password": "Modifier le mot de passe"
                },
                "description": "Modification du compte",
                "email": "Modification de l'email",
                "email_success": "Email modifié.",
                "password": "Modification du mot de passe",
                "password_success": "Mot de passe modifié.",
                "social": {
                    "error": "Tu utilises déjà le login Kanka pour ce compte.",
                    "helper": "Ton compte est géré par {provider}. Tu peux changer au login Kanka en fournissant un login et un mot de passe.",
                    "success": "Ton compte utilise d'orénavant le login Kanka.",
                    "title": "Social à Kanka"
                },
                "title": "Compte"
            },
            "api": {
                "description": "Modifier les options d'API",
                "experimental": "Bienvenus aux API de Kanka! Ces fonctionalités sont encore experimental mais assez stable que tu puisses intéragire avec les APIs. Créé un jeton personnel pour utiliser dans tes requêtes API, ou un jeton client pour permettre à ton app d'accéder à tes données.",
                "help": "Kanka va prochainement mettre à disposition une API.",
                "link": "Lire la documentation",
                "request_permission": "Nous construisons en ce moment des API RESTful pour que des applications tièrces communiquent avec Kanka. Cependant nous limitons actuellement le nombre d'utilisateurs qui peuvent intéragire avec nos API, du moins jusqu'à ce que la qualité de nos APIs soit assez bonne. Si tu veux accéder aux API et construire des applications qui communiquent avec Kanka, prends contact avec nous et nous te donneront les infos dont tu as besoin!",
                "title": "API"
            },
            "boost": {
                "benefits": {
                    "first": "Pour assurer une évolution continue de Kanka, certaines fonctionalités de l'application sont débloquées lorsqu'une campagne est boostée. Des boosts sont débloqués au travers de {patreon}. Une campagne peut être boostée par peu importe qui, du moment que le compte peut lire la campagne. Une campagne est boostée tant que le compte soutient Kanka sur {patreon}. Si une campagne n'est plus boostée, les informations ne sont pas perdues mais simplement invisible jusqu'à ce que la campagne devienne à nouveau boostée.",
                    "header": "Image d'en-tête pour entité.",
                    "more": "En savoir plus sur toutes les fonctionalités.",
                    "second": "Booster une campagne débloques les bénéfices suivants:",
                    "theme": "Thème de campagne et style personnalisé.",
                    "tooltip": "Infobulles personnalisés pour les entités.",
                    "upload": "Tailles de fichiers téléversés plus grand pour tous les membres de la campagne."
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
            "layout": {
                "description": "Modifier les options de mise en page",
                "success": "Options de mise en page modifiées.",
                "title": "Mise en page"
            },
            "menu": {
                "account": "Compte",
                "api": "API",
                "boost": "Boost",
                "layout": "Mise en Page",
                "patreon": "Patreon",
                "personal_settings": "Paramètres Personnels",
                "profile": "Profil"
            },
            "patreon": {
                "actions": {
                    "link": "Lier le compte",
                    "view": "Visiter Kanka sur Patreon"
                },
                "benefits": "Nous supporter sur {patreon} active plein de {features} pour toi et tes campagnes, et nous permet de dédié plus de temps à travailler sur Kanka.",
                "benefits_features": "fonctionalités sympas",
                "description": "Synchronisation avec Patreon",
                "errors": {
                    "invalid_token": "Token invalid! Patreon n'a pas validé la requête.",
                    "missing_code": "Code manquant! Patreon n'a pas envoyé de code d'authentification pour ton compte.",
                    "no_pledge": "Pas de pledge! Patreon a identifié ton compte, mais ne croit pas que tu nous supportes."
                },
                "link": "Si tu supportes Kanka sur Patreon, tu peux utiliser le bouton pour lier ton compte. Cela te donnera accès a des bonus sympas!",
                "linked": "Merci pour ton support sur Patreon! Ton comptes est d'orénavant lié.",
                "pledge": "Pledge: {name}",
                "success": "Merci pour ton support sur Patreon!",
                "title": "Patreon",
                "wrong_pledge": "Ton pledge est inséré manuellement par nous, du coups ça peut prendre quelques jours pour être actualisé. Si ça reste faux longtemps, n'hésites pas à nous contacter."
            },
            "profile": {
                "actions": {
                    "update_profile": "Mettre à jour le profil"
                },
                "avatar": "Image de profil",
                "description": "Mettre à jour le profil",
                "success": "Mise à jour effectuée.",
                "title": "Profil personnel"
            }
        }
    },
    "hu": {
        "admin": [],
        "calendars": [],
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
        "crud": {
            "actions": {
                "actions": "Akciók",
                "apply": "Alkalmaz",
                "back": "Vissza",
                "copy": "Másolás",
                "copy_mention": "Említett [ ] másolása",
                "copy_to_campaign": "Másolás Kampányba",
                "explore_view": "Hierarchikus nézet",
                "export": "Export",
                "find_out_more": "Tudj meg többet!",
                "go_to": "Ugrás {name} entitáshoz",
                "more": "Több művelet",
                "move": "Mozgatás",
                "new": "Új",
                "next": "Következő",
                "private": "Privát",
                "public": "Nyilvános"
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
            "boosted": "Boost-olt",
            "bulk": {
                "actions": {
                    "edit": "Tömeges szerkesztés, és címkézés"
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
                    "admin": "Csak a kampány adminjai tudják megváltoztatni egy entitás privát státuszát."
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
                "node_must_not_be_a_descendant": "Érvénytelen csomópont (címke, előd helyszín): saját maga leszármazottja lehet."
            },
            "events": {
                "hint": "Ez egy lista minden naptárról, amihez ezt az entitást hozzáadták az \"Esemény hozzáadása a naptárhoz\" felületen."
            },
            "export": "Export",
            "fields": {
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
                "header_image": "Fejléc kép",
                "image": "Kép",
                "is_private": "Privát",
                "is_star": "Kitűzve",
                "item": "Tárgy",
                "location": "Helyszín",
                "name": "Név",
                "organisation": "Szervezet",
                "race": "Faj",
                "tag": "Címke",
                "tags": "Címkék",
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
                "created": "Létrehozás: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Ismeretlen",
                "updated": "Utolsó módosítás: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
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
                        "ignore": "Figyelmen kívül hagyás",
                        "remove": "Eltávolítás"
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
                "helper": "Használd ezt a felületet, hogy finomhangold, melyik felhasználó és szerep tud kapcsolatba lépni ezzel az entitással.",
                "inherited": "Ez a szerep már rendelkezik ezzel a jogosultsággal ehhez a típusú entitáshoz.",
                "inherited_by": "Ez a felhasználó tagja a '{role}' szerepnek, amely rendelkezik jogosultsággal ezen az entitás típuson.",
                "success": "Engedélyeket elmentettük.",
                "title": "Engedélyek",
                "too_many_members": "A kampánynak túl sok tagja (>10) van ahhoz, hogy kijelezzük ezen a felületen. Kérjük, használd az entitás nézetben az Engedély gombot, hogy kezeld az engedélyek részleteit."
            },
            "placeholders": {
                "calendar": "Válassz egy naptárat!",
                "character": "Válassz egy karaktert!",
                "entity": "Entitás",
                "event": "Válassz egy eseményt!",
                "family": "Válassz egy családot!",
                "image_url": "Egy URL-címről is feltölthetsz képet",
                "item": "Válassz egy tárgyat!",
                "location": "Válassz egy helyszínt!",
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
            "save_and_new": "Mentés és új",
            "save_and_update": "Mentés és frissítés",
            "save_and_view": "Mentés és megtekintés",
            "search": "Keresés",
            "select": "Kiválasztás",
            "tabs": {
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
                "tooltip": "Tooltip"
            },
            "update": "Frissítés",
            "users": {
                "unknown": "Ismeretlen"
            },
            "view": "Megtekintés",
            "visibilities": {
                "admin": "Admin",
                "all": "Mindenki",
                "self": "Magam"
            }
        },
        "entities": [],
        "randomisers": [],
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
            "boost": {
                "benefits": {
                    "first": "Hogy biztosítsuk a Kanka folyamatos fejlődését, bizonyos funkciók az adott kampány boost-olása után válnak elérhetővé. A boost-olás lehetőségégének megszerzése {patreon}-on keresztül történik. Egy kampányt akárki boost-olhatja is, ha van joga megtekinteni azt, így nem minden esetben a Mesélőnek kell állnia a cehhet. Egy kampány addig marad boost-olva, amíg egy felhasználó fenntartja rajta a boost-ját, valamint a támogatását is {patreon}-on keresztül. Ha egy kampány boost-olása megszűnik, az adatok nem vesznek el, csupán eltűnnek szem elől, amíg ismét nem kerül boost-olásra.",
                    "header": "Entitás fejléc képek.",
                    "more": "Tudj meg többet a funkciókról.",
                    "second": "Egy kampány Boost-olása az alábbi előnyöket biztosítja:",
                    "theme": "Kampány-szintű téma, és egyedi megjelenítési stílus.",
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
            "layout": {
                "description": "Elrendezési beállítások frissítése",
                "success": "Az elrendezési beállításokat frissítettük.",
                "title": "Elrendezés"
            },
            "menu": {
                "account": "Fiók",
                "api": "API",
                "boost": "Boost",
                "layout": "Elrendezés",
                "patreon": "Patreon",
                "personal_settings": "Személyes beállítások",
                "profile": "Profil"
            },
            "patreon": {
                "actions": {
                    "link": "Fiókok összekapcsolása",
                    "view": "Látogasd meg a Kankát a Patreonon!"
                },
                "benefits": "A Patreon támogatóink nagyobb képeket tölthetnek fel, segítenek nekünk fedezni a szerverköltségeket, valamint lehetővé teszik, hogy több időt fordíthassunk a Kankán végzett munkánkra.",
                "benefits_features": "csodálatos képességek",
                "description": "Szinkronizálás a Patreonnal",
                "errors": {
                    "invalid_token": "Érvénytelen token! A Patreon nem tudta érvényesíteni a kérésed.",
                    "missing_code": "Hiányzó kód! A Patreon nem küldött vissza kódot, amely a fiókodat azonosítja.",
                    "no_pledge": "Nincs támogatás! A Patreon azonosította a fiókodat, de nem tud aktív támogatásról."
                },
                "link": "Nyomd meg ezt a gombot, ha jelenleg támogatod a Kankát a Patreonon, aktiválva a bónuszaid.",
                "linked": "Köszönjük, hogy támogatsz minket a Patreonon! A fiókjaid összekapcsoltuk.",
                "pledge": "{name} támogatási szint",
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
            }
        }
    },
    "it": {
        "admin": [],
        "calendars": [],
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
        "crud": {
            "actions": {
                "apply": "Applica",
                "back": "Indietro",
                "copy": "Copia",
                "copy_to_campaign": "Copia nella Campagna",
                "explore_view": "Vista annidata",
                "export": "Esporta",
                "find_out_more": "Scopri di più",
                "go_to": "Vai a {name}",
                "more": "Più Azioni",
                "move": "Muovi",
                "new": "Nuovo",
                "next": "Prossimo",
                "private": "Privato",
                "public": "Pubblico"
            },
            "add": "Aggiungi",
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
                    "success": "Il Template di Attributi {name} si applica su {entity}",
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
            "bulk": {
                "errors": {
                    "admin": "Solo gli amministratori della campagna possono cambiare lo stato di visibilità delle entità."
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
                    "permissions": "Permessi modificati a {count} entità.|Permessi modificati a {count} entità.",
                    "private": "{count} entità è adesso privata|{count} entità sono adesso private.",
                    "public": "{count} entità è adesso visibile|{count} entità sono adesso visibili."
                }
            },
            "cancel": "Annulla",
            "click_modal": {
                "close": "Chiudi",
                "confirm": "Conferma",
                "title": "Conferma la tua azione"
            },
            "copy_to_campaign": {
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
                "description": "Sei sicuro di vole rimuovere {tag}?",
                "mirrored": "Rimuove relazioni speculari.",
                "title": "Conferma di cancellazione"
            },
            "destroy_many": {
                "success": "Cancellata {count} entità|Cancellate {count} entità."
            },
            "edit": "Modifica",
            "errors": {
                "node_must_not_be_a_descendant": "Nodo non valido (tag, luogo padre): sarebbe un discendente di se stesso."
            },
            "events": {
                "hint": "Quella visualizzata sotto è una lista di tutti i Calendari in cui questa entità è stata aggiunta usando \"Aggiungi un evento ad un calendario\"."
            },
            "export": "Esporta",
            "fields": {
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
                "name": "Nome",
                "organisation": "Organizzazione",
                "race": "Razza",
                "tag": "Tag",
                "tags": "Tags",
                "tooltip": "Tooltip",
                "visibility": "Visibilità"
            },
            "files": {
                "actions": {
                    "drop": "Premi per Aggiungere o Trascina un file",
                    "manage": "Gestisci i file dell'entità"
                },
                "errors": {
                    "max": "Hai raggiunto il numero massimo di file ({max}) per questa entità."
                },
                "files": "Files Caricati",
                "hints": {
                    "limit": "Ogni entità può avere un massimo di {max} files caricati.",
                    "limitations": "Formati supportati: jpg, png, gif, and pdf. Dimensione massima del file: {size}"
                },
                "title": "File dell'entità {name}"
            },
            "filter": "Filtra",
            "filters": {
                "all": "Filtra includendo tutti i discendenti",
                "clear": "Pulisci i Filtri",
                "direct": "Filtra includendo solamente i discendenti diretti",
                "filtered": "Visualizzati {count} di {total} {entity}.",
                "hide": "Nascondi i Filtri",
                "show": "Visualizza i Filtri",
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
                "calendar_date": "La data di un calendario permette un semplice filtro nelle lista ed inoltre mantiene un evento nel calendario selezionato.",
                "header_image": "Questa immagine è posizionata sopra alle entità. Per un miglior risultato utilizza un'immagine larga.",
                "image_limitations": "Formati supportati: jpg, png and gif. Dimensione massima del file: {size}.",
                "image_patreon": "Aumentare la dimensione massima dei file?",
                "is_private": "Nascondi dalle utenze non \"Admin\".",
                "is_star": "Gli elementi fissati appariranno nel menù dell'entità",
                "map_limitations": "Formati supportati{jpg}, png, gif e svg. Dimensione massima del file: {size}.",
                "tooltip": "Sostituisci il tooltip generato automaticamente con il seguente contenuto.",
                "visibility": "Impostare la visibilità agli amministratori significa che solamente i membri del ruolo \"Proprietario\" della campagna potranno visualizzarlo. Impostarlo a \"Te stesso\" significa che solo tu potrai vederlo."
            },
            "history": {
                "created": "Creato da <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Sconosciuto",
                "updated": "Ultima modifica da <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Visualizza i log dell'entità"
            },
            "image": {
                "error": "Noi non siamo stati in gradi di recuperare l'immagine richiesta. Potrebbe essere che il sito web non ci permetta di scaricare l'immagine (solitamente per Squarespace e DeviantArt) o che il link non sia più valido. Per favore controlla anche che la dimensione dell'immagine non sia maggiore di {size}."
            },
            "is_private": "Questa entità è privata e non visibile alle utenze non amministratrici.",
            "linking_help": "Come posso creare un collegamento ad altre entità inserite?",
            "manage": "Gestisci",
            "move": {
                "description": "Muovi questa entità in un'altro posto",
                "errors": {
                    "permission": "Non sei autorizzato a creare entità di questo tipo nella campagna selezionata.",
                    "same_campaign": "Devi selezionare un'altra campagna dove muore l'entità.",
                    "unknown_campaign": "Campagna sconosciuta"
                },
                "fields": {
                    "campaign": "Nuova campagna",
                    "copy": "Crea una Copia",
                    "target": "Nuovo tipo"
                },
                "hints": {
                    "campaign": "Puoi anche provare a muovere questa entità in un'altra campagna",
                    "copy": "Seleziona questa opzione se vuoi crearne una copia nella nuova campagna.",
                    "target": "Per favore considera che alcuni dati potrebbero andare perso nel caso si muovesse un elemento da un tipo ad un'altro."
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
                        "remove": "Rimuovi"
                    },
                    "delete": "Cancellazione",
                    "edit": "Modifica",
                    "entity_note": "Note dell'Entità",
                    "read": "Lettura"
                },
                "allowed": "Permesso",
                "fields": {
                    "member": "Membro",
                    "role": "Ruolo"
                },
                "helper": "Utilizza questa interfaccia per specificare quali utenti e ruoli possono interagire con questa entità.",
                "inherited": "Questo ruolo ha già questo permesso impostato per questa tipologia di entità.",
                "inherited_by": "Questo utente fa parte del ruolo '{role}' che gli conferisce questo permesso su questa tipologia di entità.",
                "success": "Permessi salvati.",
                "title": "Permessi"
            },
            "placeholders": {
                "calendar": "Seleziona un calendario",
                "character": "Seleziona un personaggio",
                "entity": "Entità",
                "event": "Seleziona un evento",
                "family": "Seleziona una famiglia",
                "image_url": "Altrimenti puoi caricare un'immagine da un URL",
                "item": "Seleziona un'oggetto",
                "location": "Seleziona un luogo",
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
                    "name": "Nomi",
                    "relation": "Relazioni"
                },
                "hint": "Le relazioni fra gli elementi possono essere impostate per rappresentare le loro connessioni."
            },
            "remove": "Rimuovi",
            "rename": "Rinomina",
            "save": "Salva",
            "save_and_close": "Salva e Chiudi",
            "save_and_new": "Salva e Nuovo",
            "save_and_update": "Salve ed Aggiorna",
            "save_and_view": "Salva e Visualizza",
            "search": "Cerca",
            "select": "Seleziona",
            "tabs": {
                "attributes": "Attributi",
                "boost": "Potenzia",
                "calendars": "Calendari",
                "default": "Default",
                "events": "Eventi",
                "inventory": "Inventario",
                "map-points": "Punti della Mappa",
                "mentions": "Menzioni",
                "menu": "Menù",
                "notes": "Note",
                "permissions": "Permessi",
                "relations": "Relazioni",
                "tooltip": "Tooltip"
            },
            "update": "Aggiorna",
            "users": {
                "unknown": "Sconosciuto"
            },
            "view": "Visualizza",
            "visibilities": {
                "admin": "Proprietario",
                "all": "Tutti",
                "self": "Te stesso"
            }
        },
        "entities": [],
        "randomisers": [],
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
        }
    },
    "nl": {
        "admin": []
    },
    "pt": [],
    "pt-BR": {
        "admin": [],
        "calendars": [],
        "crud": {
            "actions": {
                "back": "Voltar",
                "copy": "Copiar",
                "export": "Exportar",
                "more": "Mais Ações",
                "move": "Mover",
                "new": "Novo",
                "private": "Privado",
                "public": "Público"
            },
            "add": "Adicionar",
            "attributes": {
                "actions": {
                    "add": "Adicionar um atributo",
                    "apply_template": "Aplicar um Modelo de Atributo",
                    "manage": "Gerenciar"
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
                    "template": "Modelo",
                    "value": "Valor"
                },
                "index": {
                    "success": "Atributos de {entity} atualizados.",
                    "title": "Atributos de {name}"
                },
                "placeholders": {
                    "attribute": "Número de conquistas, Nível de Desafio, Iniciativa, População",
                    "template": "Selecione um modelo",
                    "value": "Valor do atributo"
                },
                "template": {
                    "success": "Modelo de Atributo {name} aplicado em {entity}",
                    "title": "Aplicar um Modelo de Atributo a {name}"
                }
            },
            "bulk": {
                "errors": {
                    "admin": "Apenas administradores de campanha podem mudar o status privado de entidades"
                }
            },
            "cancel": "Cancelar",
            "click_modal": {
                "close": "Fechar",
                "confirm": "Confirmar",
                "title": "Confirmar sua ação"
            },
            "create": "Criar",
            "delete_modal": {
                "close": "Fechar",
                "delete": "Deletar",
                "description": "Tem certeza que deseja remover {tag}?",
                "title": "Confirmação de apagamento"
            },
            "destroy_many": {
                "success": "Deletado {count} entity|Deletado {count} entities."
            },
            "edit": "Editar",
            "fields": {
                "character": "Personagem",
                "creator": "Criador",
                "dice_roll": "Rolagem de Dados",
                "entity": "Entidade",
                "entry": "Entrada",
                "event": "Evento",
                "image": "Imagem",
                "is_private": "Privado",
                "location": "Local"
            },
            "filter": "Filtro",
            "hidden": "Esconder",
            "hints": {
                "is_private": "Esconder de \"Espectadores\""
            },
            "image": {
                "error": "Nós não fomos capazes de conseguir a imagem requisitada. Pode ser que o site não autorize o download da imagem por nós (tipicamente para Squarespace e DeviantArt), ou o link não está mais válido."
            },
            "is_private": "Essa entidade é privada e não visível para usuários espectadores.",
            "linking_help": "Como eu posso vincular a outras entidades?",
            "manage": "Gerenciar",
            "move": {
                "description": "Mover a entidade para outro lugar",
                "fields": {
                    "target": "Novo tipo"
                },
                "hints": {
                    "target": "Esteja ciente que alguns dados podem ser perdidos ao mudar um elemento de um tipo para outro."
                },
                "success": "Entidade {name} movida.",
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
                "general_information": "Informações Gerais",
                "move": "Mover"
            },
            "permissions": {
                "action": "Ação",
                "actions": {
                    "delete": "Deletar",
                    "edit": "Editar",
                    "read": "Ler"
                },
                "allowed": "Permitido",
                "fields": {
                    "member": "Membro",
                    "role": "Cargo"
                },
                "helper": "Use essa interface para escolher quais usuários e cargos podem interagir com essa entidade.",
                "success": "Permissões salvas.",
                "title": "Permissões"
            },
            "placeholders": {
                "character": "Escolha um personagem",
                "event": "Escolha um evento",
                "family": "Escolha uma família",
                "image_url": "Você também pode dar upload de uma imagem por uma URL",
                "location": "Escolha um local"
            },
            "relations": {
                "actions": {
                    "add": "Adicionar uma relação"
                },
                "fields": {
                    "location": "Local",
                    "name": "Nome",
                    "relation": "Relação"
                }
            },
            "remove": "Remover",
            "save": "Salvar",
            "save_and_new": "Salvar e Novo",
            "search": "Buscar",
            "select": "Selecionar",
            "tabs": {
                "attributes": "Atributos",
                "calendars": "Calendários",
                "permissions": "Permissões",
                "relations": "Relações"
            },
            "update": "Atualizar",
            "view": "Ver"
        },
        "entities": [],
        "randomisers": []
    },
    "ru": {
        "admin": [],
        "crud": {
            "actions": {
                "back": "Back"
            }
        }
    },
    "sk": {
        "admin": [],
        "calendars": [],
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
        "crud": {
            "actions": {
                "apply": "Použiť",
                "back": "Naspäť",
                "copy": "Kopírovať",
                "copy_to_campaign": "Kopírovať do kampane",
                "explore_view": "Vložené zobrazenie",
                "export": "Exportovať",
                "find_out_more": "Dozvedieť sa viac",
                "go_to": "Prejsť na {name}",
                "more": "Ďalšie akcie",
                "move": "Premiestniť",
                "new": "Nový",
                "next": "Ďalej",
                "private": "Súkromný",
                "public": "Verejný"
            },
            "add": "Pridať",
            "attributes": {
                "actions": {
                    "add": "Pridať atribúť",
                    "add_block": "Pridať blok",
                    "add_checkbox": "Pridať zaškrtávacie políčko",
                    "add_text": "Pridať text",
                    "apply_template": "Použiť šablónu atribútov",
                    "manage": "Spravovať",
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
            "bulk": {
                "edit": {
                    "tags": {
                        "add": "Pridať",
                        "remove": "Odstrániť"
                    }
                },
                "errors": {
                    "admin": "Iba administrátori kampane vedia zmeniť súkromný štatút objektu."
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
                    "permissions": "Oprávnenia zmenené pre {count} objekt.|Oprávnenia zmenené pre {count} objektov.",
                    "private": "{count} objekt je teraz súkromný.|{count} objektov je teraz súkromných.",
                    "public": "{count} objekt je teraz viditeľný.|{count} objektov je teraz viditeľných."
                }
            },
            "cancel": "Zrušiť",
            "click_modal": {
                "close": "Zavrieť",
                "confirm": "Potvrdiť",
                "title": "Potvrdiť akciu"
            },
            "copy_to_campaign": {
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
                "node_must_not_be_a_descendant": "Neplatný objekt (kategória, miesto): bol by potomok samého seba."
            },
            "events": {
                "hint": "Kalendárne udalosti, ktoré sú prepojené s týmto objektom, sa zobrazujú na tomto mieste."
            },
            "export": "Exportovať",
            "fields": {
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
                "header_image": "Obrázok záhlavia",
                "image": "Obrázok",
                "is_private": "Súkromný",
                "is_star": "Pripnutý",
                "item": "Predmet",
                "location": "Miesto",
                "name": "Názov",
                "organisation": "Organizácia",
                "race": "Rasa",
                "tag": "Deň",
                "tags": "Štítky",
                "visibility": "Viditeľnosť"
            },
            "files": {
                "actions": {
                    "drop": "Kliknutím pridať alebo súbor pretiahnuť na toto miesto (Drag & Drop).",
                    "manage": "Spravovať súbory objektov"
                },
                "errors": {
                    "max": "Max. počet ({max}) súborov v tomto objekte dosiahnutý."
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
                "show": "Zobraziť",
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
                "image_limitations": "Podporované formáty: jpg, png a gif. Max. veľkosť súboru: {size}.",
                "image_patreon": "Zvýš svoj limit tým, že nás podporíš na Patreone.",
                "is_private": "Nastaviť ako súkromný.",
                "is_star": "Pripnuté objekty sa zobrazia v menu objektu.",
                "map_limitations": "Podporované formáty: jpg, png, gif a svg. Max. veľkosť súboru: {size}.",
                "visibility": "Ak je viditeľnosť nastavená na \"Admin\", vidia to len členovia a členky roly Admin. Ak je nastavená na \"Vlastník\", môže to vidieť len ty."
            },
            "history": {
                "created": "Vytvorené: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "unknown": "Neznámy",
                "updated": "Posledná úprava: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
                "view": "Zobraziť protokol objektu"
            },
            "image": {
                "error": "Požadovaný obrázok nebolo možné stiahnuť. Zdá sa, že daná webová stránka nepovoľuje sťahovanie obrázkov (typické správanie Squarescape a DeviantArt) alebo že link už nie je platný."
            },
            "is_private": "Tento objekt je súkromný a neviditeľný pre divákov.",
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
                        "add": "Pridať",
                        "ignore": "Ignorovať",
                        "remove": "Odstrániť"
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
                "success": "Oprávnenia uložené.",
                "title": "Oprávnenia"
            },
            "placeholders": {
                "calendar": "Vybrať kalendár",
                "character": "Vybrať postavu",
                "entity": "Objekt",
                "event": "Vybrať udalosť",
                "family": "Vybrať rod",
                "image_url": "Obrázok je možné pridať aj nahratím cez URL.",
                "item": "Vybrať predmet",
                "location": "Vybrať miesto",
                "organisation": "Vybrať organizáciu",
                "race": "Vybrať rasu",
                "tag": "Vybrať deň"
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
            "save_and_new": "Uložiť a nový",
            "save_and_update": "Uložiť a upraviť",
            "save_and_view": "Uložiť a zobraziť",
            "search": "Hľadať",
            "select": "Vybrať",
            "tabs": {
                "attributes": "Atribúty",
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
                "reminders": "Pripomenutia"
            },
            "update": "Upraviť",
            "users": {
                "unknown": "Neznámy"
            },
            "view": "Zobraziť",
            "visibilities": {
                "admin": "Admin",
                "all": "Všetci",
                "self": "Vlastník"
            }
        },
        "entities": [],
        "randomisers": []
    },
    "tr": [],
    "zh_CN": []
}
