# Maps

---

- [All Maps](#all-maps)
- [Single Map](#map)
- [Create a Map](#create-map)
- [Update a Map](#update-map)
- [Delete a Map](#delete-map)
- [Map Markers](/docs/{{version}}/map_markers)
- [Map Layers](/docs/{{version}}/map_layers)
- [Map Groups](/docs/{{version}}/map_groups)

<a name="all-maps"></a>
## All Maps

You can get a list of all the maps of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `maps` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Pelor's Map",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "entry_parsed": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 164,
            "tags": [],
            "created_at":  "2020-09-18T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2020-09-18T13:48:54.000000Z",
            "updated_by": 1,
            "location_id": 4,
            "type": "Continent",
            "height": 1080,
            "width": 1920,
            "map_id": null,
            "grid": 0,
            "min_zoom": -1,
            "max_zoom": 10,
            "initial_zoom": -1,
            "center_x": null,
            "center_y": null,
            "layers": "<array of map Map Layers>",
            "groups": "<array of map Map Groups>"
        }
    ]
}
```


<a name="map"></a>
## Map

To get the details of a single map, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `maps/{map.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Pelor's Map",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "entry_parsed": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 164,
        "tags": [],
        "created_at":  "2020-09-18T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2020-09-18T13:48:54.000000Z",
        "updated_by": 1,
        "location_id": 4,
        "type": "Continent",
        "height": 1080,
        "width": 1920,
        "map_id": null,
        "grid": 0,
        "min_zoom": -1,
        "max_zoom": 10,
        "initial_zoom": -1,
        "center_x": null,
        "center_y": null,
        "layers": "<array of map Map Layers>",
        "groups": "<array of map Map Groups>"
    }

}
```

<a name="create-map"></a>
## Create a Map

To create a map, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `maps` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the map |
| `type` | `string` | Type of map |
| `map_id` | `integer` | The parent map |
| `location_id` | `integer` | The related location id |
| `center_x` | `integer` | The custom longitude on page load |
| `center_y` | `integer` | The custom latitude on page load |
| `tags` | `array` | Array of tag ids |
| `is_private` | `boolean` | If the map is only visible to `admin` members of the campaign |
| `image` | `stream` (Required without `image_url`) | Stream to file uploaded to the map |
| `image_url` | `string` (Required) without `image`) | URL to a picture to be used for the map |

### Results

> {success} Code 200 with JSON body of the new map.


<a name="update-map"></a>
## Update a Map

To update a map, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `maps/{map.id}` | Default |

### Body

The same body parameters are available as for when creating a map.

### Results

> {success} Code 200 with JSON body of the updated map.


<a name="delete-map"></a>
## Delete a Map

To delete a map, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `maps/{map.id}` | Default |

### Results

> {success} Code 200 with JSON.
