# Map Groups

---

- [All Map Groups](#all-map-groups)
- [Create a Map Group](#create-map-group)
- [Update a Map Group](#update-map-group)
- [Delete a Map Group](#delete-map-group)

<a name="all-map-groups"></a>
## All Map-groups

You can get a list of all the map-groups of a map by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `maps/{map.id}/map_groups` | Default |

### Results
```json
{
    "data": [
        {
            "created_at": "2020-07-25T16:24:34.000000Z",
            "created_by": 1,
            "id": 3,
            "parent_id": 43,
            "is_private": false,
            "is_shown": true,
            "map_id": 1,
            "name": "Spoon",
            "position": 1,
            "updated_at": "2020-07-25T16:24:34.000000Z",
            "updated_by": null,
            "visibility_id": 1
        }
    ]
}
```


<a name="create-map-group"></a>
## Create a Map Group

To create a map group, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `maps/{map.id}/map-groups` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required without `entity_id`) | Name of the map group |
| `map_id` | `int` (Required) | The parent map |
| `parent_id` | `int` | The parent map group, must be different than self |
| `is_shown` | `boolean` | If the layer is shown on map load |
| `position` | `int` | Position in the list of groups |
| `visibility_id` | `integer` | The visibility: 1 for `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`. |

### Results

> {success} Code 200 with JSON body of the new map.


<a name="update-map-group"></a>
## Update a Map Group

To update a map, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `maps/{map.id}/map-groups/{map.id}` | Default |

### Body

The same body parameters are available as for when creating a map.

### Results

> {success} Code 200 with JSON body of the updated map.


<a name="delete-map-group"></a>
## Delete a Map Group

To delete a map, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `maps/{map.id}/map-groups/{map.id}` | Default |

### Results

> {success} Code 200 with JSON.
