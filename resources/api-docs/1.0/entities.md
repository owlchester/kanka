# Entities

- [Entities](#entities)
- [Entity Types](#entity-types)
- [Single Entity](#entity)
- [Filtering Entities](#filtering-entities)
- [Related Entities](#related-entities)
- [Recently Edited Entities](#recent-entities)
- [Create Entities](#create-entities)
- [Patching an Entity](#patch-entities)
- [Transform Entities](#transform-entities)
- [Transfer Entities](#transfer-entities)
- [Deleted Entities](#deleted-entities)
- [Recover Deleted Entities](#recover-entities)


<a name="entities"></a>
## Entities

Nearly all models in Kanka are based on the concept of entities. A character is an entity, but because of historical choices, there are two actual models.
A `character` is a singular model and endpoint, and a character has both an `id` and an `entity_id` value. The `id` identifies the character against all other **characters**, while the `entity_id` identifies the character against all other **entities**. This can be confusing at first, but should not be an issue with the help of this documentation.

> {warning} Please note that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{id}`. For example, if an endpoint is listed as `characters`, you should use `api.kanka.io/{{version}}/campaigns/{id}/characters`.

Some common entities include:

* [Characters](/api-docs/{{version}}/characters)
* [Locations](/api-docs/{{version}}/locations)

### Common Attributes

Most entities have the following attributes.

| Attribute               | Type | Description                                                                                                                                                                           
|:------------------------| :- |:--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `id`                    | `integer` | The id identifying the object against all other objects of the same type.                                                                                                             |
| `name`                  | `string` | The name representing the object.                                                                                                                                                     |
| `type`                  | `string` | The entity's type field.                                                                                                                                                              |
| `type_id`               | `integer` | The type of entity as an integer.                                                                                                                                                     |
| `entity_type_code`      | `integer` | The type of entity as a code (character, map).                                                                                                                                        |
| `child_id`              | `integer` | The id identifying the entity against all other entities of the same type (ie unique character id).                                                                                   |
| `image`                 | `string` | The local path to the picture of the object.                                                                                                                                          |
| `image_full`            | `string` | The url to the picture of the object.                                                                                                                                                 |
| `image_thumb`           | `string` | The url to the thumbnail of the object.                                                                                                                                               |
| `image_uuid`            | `uuid` | The image gallery uuid of the entity                                                                                                                                                  |
| `header_uuid`           | `uuid` | The image gallery uuid of the entity header                                                                                                                                           |
| `is_private`            | `boolean` | Determines if the object is only visible by `admin` members of the campaign.<br /> If the user requesting the API isn't a member of the `admin` role, such objects won't be returned. |
| `is_template`           | `boolean` | Determines if the object is a template.                                                                                                                                               |
| `is_attributes_private` | `boolean` | Determines if the entity's attributes are only visible to members of the campaign's admin role.                                                                                       |
| `tags`                  | `array` | An array of tags that the object is related to.                                                                                                                                       |
| `created_at`            | `object` | An object representing when the object was created (server time)                                                                                                                      |
| `created_by`            | `integer` | The `users`.`id` who created the object.                                                                                                                                              
| `updated_at`            | `object` | An object representing when the object was updated (server time)                                                                                                                      |
| `updated_by`            | `integer` | The `users`.`id` who last updated the object.                                                                                                                                         


<a name="entity-types"></a>
## Entity Types / Modules

You can see all entity types/modules and their ID's on the following endpoint: [Entity Types](/api-docs/{{version}}/campaigns/modules)


<a name="entity"></a>
## Single Entity

To get the details of a single entity, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}` | Default |

### Results
```json
{
    "data": {
        "id": 95,
        "name": "Redkeep",
        "type": "A castle in the sky",
        "type_id": 2,
        "entity_type": "location",
        "child_id": 95,
        "tags": [],
        "is_private": false,
        "campaign_id": 1,
        "is_attributes_private": false,
        "tooltip": null,
        "header_image": null,
        "header_uuid": null,
        "image_uuid": null,
        "created_at": "2017-12-07T14:23:57.000000Z",
        "created_by": null,
        "updated_at": "2017-12-07T14:23:57.000000Z",
        "updated_by": null,
        "archived_at": null
    }
}
```

The `child_id` property in this case is the location's id. So if you want to get the whole location based on this entity, call `locations/95`.

<a name="filtering-entities"></a>
## Filtering Entities

You can filter the returned entities on the `entities/` endpoint with the following options.

| Parameter     | Values             | Description                                                                                                                    |
|:--------------|:-------------------|:-------------------------------------------------------------------------------------------------------------------------------||
| `type_id[]`   | `array`            | Filter the returned entities by their [type_id](/api-docs/{{version}}/campaigns/modules) field. Ex `type_id[]=1&type_id[]=420`            |
| `name`        | `string`           | The name of the entity (like %% search)                                                                                        |
| `type`        | `string`           | The type of the entity, for exmaple "NPC" on a character (like %% search)                                                      |
| `is_private`  | `bool`             | Search for private entities with `is_private=true`                                                                             |
| `is_template` | `bool`             | Search for entities that are set as templates                                                                                  |
| `created_by`  | `int`              | User ID of entities created by that user                                                                                       |
| `updated_by`  | `int`              | User ID of entities updated by that user                                                                                       |
| `tags[]`        | `array`            | Filter on tags. Ex `tags[]=5&tags[]=13`                                                                                        |


For example, call `entities?type_id[]=5&type_id[]=10` to get entities of the Object and Quest modules.

<a name="related-entities"></a>
## Related Entities

You can call this endpoint with the `?related` option described below to get the entity's related objects. This parameter works for both the `entities/` endpoints and the individual "child" endpoints (ie `characters/`).

There are several models in Kanka which represent objects attached to `entities`.

* [Attributes](/api-docs/{{version}}/entities/attributes)
* [Reminders](/api-docs/{{version}}/entities/reminders)
* [Entity Files](/api-docs/{{version}}/entities/entity-files)
* [Entity Mentions](/api-docs/{{version}}/entities/entity-mentions)
* [Entity Tags](/api-docs/{{version}}/entities/entity-tags)
* [Entity Connections](/api-docs/{{version}}/entities/connections)
* [Inventory](/api-docs/{{version}}/entities/entity-inventory)
* [Entity Abilities](/api-docs/{{version}}/entities/entity-abilities)
* [Entity Links](/api-docs/{{version}}/entities/entity-links)
* [Posts](/api-docs/{{version}}/entities/posts)

With each request to an object (ie. `character`, `location`, etc), you can include the following parameter to get those related objects directly.


| Parameter | Type | Description
| :- | :- | :- |
| `related` | `integer` | Set to `1` if you want the entity's related objects |

### Examples

| Method | URI | Headers |
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
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": null,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": null,
            "location_id": 2,
            "attributes": [],
            "posts": [],
            "entity_events": [
                {
                    "created_at":  "2019-01-30T00:01:44.000000Z",
                    "created_by": null,
                    "default_order": null,
                    "entity_id": 76,
                    "id": 22,
                    "is_private": false,
                    "name": null,
                    "type": null,
                    "updated_at":  "2019-08-29T13:48:54.000000Z",
                    "updated_by": null,
                    "value": null
                }
            ],
            "entity_files": [],
            "entity_abilities": [],
            "entity_links": [],
            "relations": [],
            "title": null,
            "age": null,
            "sex": null,
            "races": [],
            "type": null,
            "families": [],
            "is_dead": false,
            "traits": [],
            "archived_at": null
        }
    ]
}
```

Notice the new array objects `attributes`, `entity_files`, `entity_events`, `posts`, `entity_abilities` and `relations`.

<a name="recent-entities"></a>
## Recently modified Entities

You can see the 10 most recently edited entities on the `entities/recent` endpoint with the following option.

| Parameter | Values | Description |
| :- | :- | :- |
| `amount` | `int` | Number of most recently edited entities to show, has to be a value from 1 to 10, 1 being the default |

### Result


```json
{
    "data": [
        {
            "id": 8,
            "name": "Sword of Cebolla",
            "type": "item",
            "type_id": 5,
            "child_id": 1,
            "tags": [],
            "is_private": false,
            "is_template": false,
            "campaign_id": 1,
            "is_attributes_private": false,
            "tooltip": null,
            "header_image": null,
            "image_uuid": null,
            "created_at": "2023-08-22T20:22:21.000000Z",
            "created_by": null,
            "updated_at": "2024-08-22T20:22:21.000000Z",
            "updated_by": null,
            "archived_at": null,
            "urls": {
                "view": "{url}",
                "api": "{url}"
            }
        }
    ],
}
```

<a name="create-entities"></a>
## Create Entities

To create up to 20 entities at once, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `entities` | `array` (Required) | An array containing all the entities |
| `entities.*.name` | `string` (Required) | Name of the entity |
| `entities.*.module` | `int`  (Required) | Id of the module to which the entity will belong to|
| `entities.*.entry` | `string` | The html description of the entity. |
| `entities.*.type` | `string`  | Type of the entity |
| `entities.*.tags` | `array`  | An array containing the ids of tags to apply to the entity|


### Example


```json
{
    "entities": [
        {
            "name": "Frejya",
            "module": 1,
            "type": "Legendary Warrior",
            "tags": [
            2, 3
            ]
        },
        {
            "name": "Frejya's tabern",
            "module": 3,
            "type": "Tabern",
            "entry": "Lorem ipsum"
        },       
        {
            "name": "Goblin",
            "module": 20,
            "entry": "Lorem ipsum"
        }
    ]
}
```

### Results

> {success} Code 200 with JSON body of the new entities.


<a name="patch-entities"></a>
## Patching an Entity

To patch an entity, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PATCH | `entities` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` | Name of the entity. |
| `type` | `string` | The type of the entity. |
| `is_private` | `boolean` | If the entity is only visible to `admin` members of the campaign. |
| `is_template` | `boolean` | If the entity is set as a template. |
| `tooltip` | `string`  | The entity's tooltip (premium campaign feature). |
| `entry` | `string`  | The html description of the entity. |
| `image_uuid` | `uuid` | The image gallery uuid of the entity. |   
| `header_uuid` | `uuid` | The image gallery uuid of the entity's header. |
| `parent_id` | `int` | The id of the entity's parent entity (only for custom modules). |


### Example


```json
{
    "name": "Frejya",
    "type": "Legendary Warrior",
    "is_private": 0,
    "is_template": 1,
    "tooltip": "Warrior from ancient times",
    "entry": "One of the strongest warriors of the land",
    "image_uuid": "00000000-0000-0000-0000-000000000000",
    "header_uuid": "00000000-0000-0000-0000-000000000000"
}


```

### Results

> {success} Code 200 with JSON body of the patched entity.


<a name="transform-entities"></a>
## Transform Entities

You can post an array with the ids of the entities you want to transform to the `/transform` endpoint to transform them into a different entity type that exists in the campaign.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `transform` | Default |

| Parameter | Type | Description
| :- | :- | :- |
| `entities` | `array`(required) | The ids of the entities to transform. |
| `entity_type` | `int`(required) | The id of the entity type the entity will be transformed to. |

### Result

> {success} Code 200 with JSON.

<a name="transfer-entities"></a>
## Transfer Entities

You can post an array with the ids of the entities you want to transfer to another campaign to the `/transfer` endpoint to transfer or copy them.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `transfer` | Default |

| Parameter | Type | Description
| :- | :- | :- |
| `entities` | `array`(required) | The ids of the entities to transfer or copy. |
| `campaign_id` | `integer`(required) | The id of the campaign the entity will be transfered or copied to. |
| `copy` | `boolean` | True if the entity will be copied, false if the entity will be transfered, defaults to false if left empty |

### Result

> {success} Code 200 with JSON.

<a name="deleted-entities"></a>
## Deleted Entities

You can view the recoverable deleted entities on the `/recovery` endpoint

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `recovery` | Default |

### Result

```json
{
 "data": [
        {
            "id": 2,
            "name": "Thaelia",
            "type": "location",
            "type_id": 3,
            "child_id": 2,
            "tags": [],
            "is_private": false,
            "is_template": false,
            "campaign_id": 1,
            "is_attributes_private": false,
            "tooltip": null,
            "header_image": null,
            "image_uuid": null,
            "created_at": "2023-08-22T20:01:48.000000Z",
            "created_by": null,
            "updated_at": "2023-08-22T23:19:07.000000Z",
            "updated_by": 1,
            "archived_at": null,
            "urls": {
                "view": "http://app.kanka.test:8081/w/1/entities/2",
                "api": "http://api.kanka.test:8081/1.0/campaigns/1/locations/2"
            }
        },
        {
            "id": 23,
            "name": "Middle Earth",
            "type": "location",
            "type_id": 3,
            "child_id": 16,
            "tags": [],
            "is_private": false,
            "is_template": false,
            "campaign_id": 1,
            "is_attributes_private": false,
            "tooltip": null,
            "header_image": null,
            "image_uuid": null,
            "created_at": "2023-08-22T20:22:21.000000Z",
            "created_by": null,
            "updated_at": "2023-08-22T23:19:07.000000Z",
            "updated_by": null,
            "archived_at": null,
            "urls": {
                "view": "http://app.kanka.test:8081/w/1/entities/23",
                "api": "http://api.kanka.test:8081/1.0/campaigns/1/locations/16"
            }
        }
    ],
}
```

<a name="recover-entities"></a>
## Recover Deleted Entities

You can post an array with the ids of the entities you want to recover to the `/recover` endpoint to undo the deletion (this is a premium only feature).

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `recover` | Default |

| Parameter | Type | Description
| :- | :- | :- |
| `entities` | `array` | The ids of the entities to recover. |

### Result

> {success} Code 200 with JSON.
