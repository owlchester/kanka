# Map Layers

---

- [All Map Layers](#all-map-layers)
- [Create a Map Layer](#create-map-layer)
- [Update a Map Layer](#update-map-layer)
- [Delete a Map Layer](#delete-map-layer)

<a name="all-map-layers"></a>
## All Map-layers

You can get a list of all the map-layers of a map by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `maps/{map.id}/map_layers` | Default |

### Results
```json
{
    "data": [
        {
            "created_at": "2020-07-03T14:12:45.000000Z",
            "created_by": 1,
            "height": 1080,
            "id": 2,
            "is_private": false,
            "map_id": 1,
            "name": "Prague",
            "position": 0,
            "type": "standard",
            "type_id": false,
            "updated_at": "2020-07-03T14:12:45.000000Z",
            "updated_by": null,
            "visibility": "all",
            "width": 1920
        }
    ]
}
```


<a name="create-map-layer"></a>
## Create a Map Layer

To create a map layer, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `maps/{map.id}/map-layers` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required without `entity_id`) | Name of the map layer |
| `map_id` | `int` (Required) | The parent map |
| `image` | `stream` (Required without `image_url`) | Stream to file uploaded to the map |
| `image_url` | `string` (Required) without `image`) | URL to a picture to be used for the map |
| `entry` | `string` | Entry of the layer |
| `type_id` | `int` | `null` and 0 for `standard`, 1 for `overlay`, 2 for `overlay_shown` |
| `position` | `int` | Position in the list of layers |
| `visibility` | `string` | `all`, `admin`, `admin-self` or `self` |


### Results

> {success} Code 200 with JSON body of the new map.


<a name="update-map"></a>
## Update a Map

To update a map, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `maps/{map.id}/map-layers/{map.id}` | Default |

### Body

The same body parameters are available as for when creating a map.

### Results

> {success} Code 200 with JSON body of the updated map.


<a name="delete-map"></a>
## Delete a Map

To delete a map, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `maps/{map.id}/map-layers/{map.id}` | Default |

### Results

> {success} Code 200 with JSON.
