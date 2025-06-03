# Races

---

- [All Races](#all-races)

- [Single Race](#race)
- [Create a Race](#create-race)
- [Update a Race](#update-race)
- [Delete a Race](#delete-race)

<a name="all-races"></a>
## All Races

You can get a list of all the races of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `races` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Goblin",
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
            "race_id": 3,
            "type": null,
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

<a name="race"></a>
## Race

To get the details of a single race, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `races/{race.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Goblin",
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
        "race_id": 3,
        "type": "Humanoid",
        "is_extinct": true,
        "locations": [
            67,
            66,
            65
        ]
    }

}
```


<a name="create-race"></a>
## Create a Race

To create a race, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `races` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the race |
| `entry` | `string` | The html description of the race |
| `type` | `string` | The race's type |
| `is_extinct` | `boolean` | If the race is extinct |
| `race_id` | `string` | Parent race of the race |
| `tags` | `array` | Array of tag ids |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The race's tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the race is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new race.


<a name="update-race"></a>
## Update a Race

To update a race, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `races/{race.id}` | Default |

### Body

The same body parameters are available as for when creating a race.

### Results

> {success} Code 200 with JSON body of the updated race.


<a name="delete-race"></a>
## Delete a Race

To delete a race, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `races/{race.id}` | Default |

### Results

> {success} Code 200 with JSON.
