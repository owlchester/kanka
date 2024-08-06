# Creatures

---

- [All Creatures](#all-creatures)

- [Single Creature](#creature)
- [Create a Creature](#create-creature)
- [Update a Creature](#update-creature)
- [Delete a Creature](#delete-creature)

<a name="all-creatures"></a>
## All Creatures

You can get a list of all the creatures of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `creatures` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Raven",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 7,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "creature_id": null,
            "type": "Bird",
            "is_extinct": true,
            "locations": [
                67,
                66,
                65
            ]
        }
    ]
}
```

<a name="creature"></a>
## Creature

To get the details of a single creature, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `creatures/{creature.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Raven",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 7,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "creature_id": null,
        "type": "Bird",
        "is_extinct": true,
        "locations": [
            67,
            66,
            65
        ]
    }

}
```


<a name="create-creature"></a>
## Create a Creature

To create a creature, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `creatures` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the creature |
| `entry` | `string` | The html description of the creature |
| `type` | `string` | The creature's type |
| `creature_id` | `string` | Parent creature of the creature |
| `tags` | `array` | Array of tag ids |
| `locations` | `array` | Array of location ids |
| `is_extinct` | `boolean` | If the creature is extinct |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (limited to premium campaigns) |
| `is_private` | `boolean` | If the creature is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new creature.


<a name="update-creature"></a>
## Update a Creature

To update a creature, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `creatures/{creature.id}` | Default |

### Body

The same body parameters are available as for when creating a creature.

### Results

> {success} Code 200 with JSON body of the updated creature.


<a name="delete-creature"></a>
## Delete a Creature

To delete a creature, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `creatures/{creature.id}` | Default |

### Results

> {success} Code 200 with JSON.
