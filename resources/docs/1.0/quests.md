# Quests

---

- [All Quests](#all-quests)
- [Single Quest](#quest)
- [Quest Members](#quest-members)
- [Create a Quest](#create-quest)
- [Update a Quest](#update-quest)
- [Delete a Quest](#delete-quest)

<a name="all-quests"></a>
## All Quests

You can get a list of all the quests of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `quests` | Default |

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
            "character_id": 4,
            "date": "2020-04-20",
            "type": "Main",
            "is_completed": false,
            "quest_id": null,
            "characters": 2,
            "locations": 1
        }
    ]
}
```


<a name="quest"></a>
## Quest

To get the details of a single quest, use the following endpoint.

| Method | Endpoint| Headers |
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
        "entity_id": 164,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "character_id": 4,
        "type": "Main",
        "date": "2020-04-20",
        "is_completed": false,
        "quest_id": null,
        "characters": 2,
        "locations": 1
    }

}
```


<a name="quest-characters"></a>
## Quest Characters

To get the characters of an quest, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `quests/{quest.id}/quest_characters` | Default |

### Results
```json
{
    "data": {
        "character_id": 70,
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": null,
        "description": "Lorem Ipsum",
        "id": 5,
        "is_private": true,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null
    }
}
```

> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) a character from an quest can also be done using the same patterns as for other endpoints.


<a name="quest-locations"></a>
## Quest Locations

To get the locations of an quest, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `quests/{quest.id}/quest_locations` | Default |

### Results
```json
{
    "data": {
        "location_id": 33,
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": null,
        "description": "Lorem Ipsum",
        "id": 2,
        "is_private": true,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null
    }
}
```

> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) a location from an quest can also be done using the same patterns as for other endpoints.

<a name="quest-items"></a>
## Quest Items

To get the items of an quest, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `quests/{quest.id}/quest_items` | Default |

### Results
```json
{
    "data": {
        "item_id": 33,
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": null,
        "description": "Lorem Ipsum",
        "id": 2,
        "is_private": true,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null
    }
}
```

> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) a item from an quest can also be done using the same patterns as for other endpoints.


<a name="quest-organisations"></a>
## Quest Organisations

To get the organisations of an quest, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `quests/{quest.id}/quest_organisations` | Default |

### Results
```json
{
    "data": {
        "organisation_id": 33,
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": null,
        "description": "Lorem Ipsum",
        "id": 2,
        "is_private": true,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null
    }
}
```

> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) a organisation from an quest can also be done using the same patterns as for other endpoints.


<a name="create-quest"></a>
## Create a Quest

To create a quest, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `quests` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the quest |
| `type` | `string` | Type of quest |
| `quest_id` | `integer` | The parent quest |
| `character_id` | `integer` | The quest's character (quest giver) |
| `tags` | `array` | Array of tag ids |
| `is_private` | `boolean` | If the quest is only visible to `admin` members of the campaign |
| `image` | `stream` | Stream to file uploaded to the quest |
| `image_url` | `string` | URL to a picture to be used for the quest |

### Results

> {success} Code 200 with JSON body of the new quest.


<a name="update-quest"></a>
## Update a Quest

To update a quest, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `quests/{quest.id}` | Default |

### Body

The same body parameters are available as for when creating a quest.

### Results

> {success} Code 200 with JSON body of the updated quest.


<a name="delete-quest"></a>
## Delete a Quest

To delete a quest, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `quests/{quest.id}` | Default |

### Results

> {success} Code 200 with JSON.
