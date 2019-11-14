# Entities

---

- [Entities](#entities)
- [Related Entities](#related-entities)

<a name="entities"></a>
## Entities

Nearly all models in Kanka are based on the concept of entities. A character is an entity, but because of historical choices, there are two actual models.
A `character` is a singular model and endpoint, and a character has both an `id` and an `entity_id` value. The `id` identifies the character against all other **characters**, while the `entity_id` identifies the character against all other **entities**. This can be confusing at first, but should not be an issue with the help of this documentation.

> {warning} Please note that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{id}`. For example, if an endpoint is listed as `characters`, you should use `kanka.io/api/{{version}}/campaigns/{id}/characters`.

Some common entities include:

* [Characters](/docs/{{version}}/characters)
* [Locations](/docs/{{version}}/locations)

### Common Attributes

Most entities have the following attributes.

| Attribute | Type | Description
| :- | :- | :- |
| `id` | `integer` | The id identifying the object against all other objects of the same type. |
| `name` | `string` | The name representing the object. |
| `entry` | `string` | The html description of the object. |
| `image` | `string` | The local path to the picture of the object. |
| `image_full` | `string` | The url to the picture of the object. |
| `image_thumb` | `string` | The url to the thumbnail of the object. |
| `is_private` | `boolean` | Determines if the object is only visible by `admin` members of the campaign.<br /> If the user requesting the API isn't a member of the `admin` role, such objects won't be returned. |
| `entity_id` | `integer` | The id identifying the objects against all other entities.
| `tags` | `array` | An array of tags that the object is related to. |
| `created_at` | `object` | An object representing when the object was created (server time) |
| `created_by` | `integer` | The `users`.`id` who created the object.
| `updated_at` | `object` | An object representing when the object was updated (server time) |
| `updated_by` | `integer` | The `users`.`id` who last updated the object.

<a name="related-entities"></a>
## Related Entities

There are several models in Kanka which represent objects attached to `entities`.

* [Attributes](/docs/{{version}}/attributes)
* [Entity Events](/docs/{{version}}/entity-events)
* [Entity Files](/docs/{{version}}/entity-files)
* [Entity Mentions](/docs/{{version}}/entity-mentions)
* [Entity Notes](/docs/{{version}}/entity-notes)
* [Entity Tags](/docs/{{version}}/entity-tags)
* [Entity Relations](/docs/{{version}}/entity-relations)
* [Entity Inventory](/docs/{{version}}/entity-inventory)

With each request to an object (ie. `character`, `location`, etc), you can include the following parameter to get those related objects directly.


| Parameter | Type | Description
| :- | :- | :- |
| `related` | `integer` | Set to `1` if you want the entity's related objects |

### Examples

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `characters?related=1` | Default |
| GET/HEAD | `characters/1?related=1` | Default |

### Result


```json
{
    "data": [
        {
            "id": 44,
            "name": "Frejya",
            "entry": "Lorem Ipsum",
            "image": null,
            "image_full": "{url}",
            "image_thumb": "{url}",
            "is_private": false,
            "entity_id": 76,
            "tags": [],
            "created_at": {
                "date": "2017-12-01 09:07:38.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "created_by": null,
            "updated_at": {
                "date": "2017-12-03 12:06:23.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_by": null,
            "location_id": 2,
            "attributes": [],
            "entity_notes": [],
            "entity_events": [
                {
                    "created_at": {
                        "date": "2018-05-04 05:16:04.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "created_by": null,
                    "default_order": null,
                    "entity_id": 76,
                    "id": 22,
                    "is_private": false,
                    "name": null,
                    "type": null,
                    "updated_at": {
                        "date": "2018-12-21 09:25:08.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "updated_by": null,
                    "value": null
                }
            ],
            "entity_files": [],
            "relations": [],
            "title": null,
            "age": null,
            "sex": null,
            "race_id": null,
            "type": null,
            "family_id": null,
            "is_dead": false,
            "traits": []
        }
    ]
}
```

Notice the new array objects `attributes`, `entity_files`, `entity_events`, `entity_notes` and `relations`.