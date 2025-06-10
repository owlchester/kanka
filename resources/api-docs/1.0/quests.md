# Quests

---

- [All Quests](#all-quests)

- [Single Quest](#quest)
- [Quest Elements](#quest-elements)
- [Create a Quest](#create-quest)
- [Update a Quest](#update-quest)
- [Delete a Quest](#delete-quest)

<a name="all-quests"></a>
## All Quests

You can get a list of all the quests of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `quests` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Pelor's Quest",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 164,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "date": "2020-04-20",
            "type": "Main",
            "is_completed": false,
            "quest_id": null,
            "elements": [],
            "calendar_id": 102,
            "calendar_year": 2020,
            "calendar_month": "Novus",
            "calendar_day": 2,
            "calendar_event_length": 3,
        }
    ]
}
```

<a name="quest"></a>
## Quest

To get the details of a single quest, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `quests/{quest.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Pelor's Quest",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "instigator_id": null,
        "location_id": null,
        "entity_id": 164,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "type": "Main",
        "date": "2020-04-20",
        "is_completed": false,
        "quest_id": null,
        "elements": [],
        "calendar_id": 102,
        "calendar_year": 2020,
        "calendar_month": "Novus",
        "calendar_day": 2,
        "calendar_event_length": 3,
    }

}
```

<a name="quest-elements"></a>
## Quest Elements

To get the elements of a quest, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `quests/{quest.id}/quest_elements` | Default |

### Results
```json
{
    "data": {
        "entity_id": 33,
        "name": null,
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": null,
        "instigator_id": null,
        "location_id": null,
        "role": "Target",
        "description": "Lorem Ipsum",
        "description_parsed": "Lorem Ipsum",
        "id": 2,
        "visibility_id": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null
    }
}
```

> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) an element from a quest can also be done using the same patterns as for other endpoints.
>
> The `entity_id` or `name` field has to be provided when creating a quest element.


<a name="create-quest"></a>
## Create a Quest

To create a quest, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `quests` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the quest |
| `entry` | `string` | The html description of the quest |
| `type` | `string` | Type of quest |
| `quest_id` | `integer` | The parent quest |
| `instigator_id` | `integer` | The quest's instigator (entity) |
| `location_id` | `integer` | The quest's starting location (location) |
| `tags` | `array` | Array of tag ids |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The quest's tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the quest is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new quest.


<a name="update-quest"></a>
## Update a Quest

To update a quest, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `quests/{quest.id}` | Default |

### Body

The same body parameters are available as for when creating a quest.

### Results

> {success} Code 200 with JSON body of the updated quest.


<a name="delete-quest"></a>
## Delete a Quest

To delete a quest, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `quests/{quest.id}` | Default |

### Results

> {success} Code 200 with JSON.
