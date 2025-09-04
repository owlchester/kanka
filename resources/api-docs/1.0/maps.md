# Maps

---

- [All Maps](#all-maps)
- [Single Map](#map)
- [Create a Map](#create-map)
- [Update a Map](#update-map)
- [Delete a Map](#delete-map)

<a name="all-maps"></a>
## All Maps

You can get a list of all the maps of a campaign by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `maps` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

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
            "is_real": false,
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
            "center_marker_id": null,
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

| Method | URI | Headers |
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
        "is_real": false,
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
        "center_marker_id": null,
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

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `maps` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the map |
| `entry` | `string` | The html description of the map |
| `type` | `string` | Type of map |
| `map_id` | `integer` | The parent map |
| `location_id` | `integer` | The related location id |
| `center_marker_id` | `integer` | The map marker the map will center on page load |
| `center_x` | `float` | The custom longitude on page load |
| `center_y` | `float` | The custom latitude on page load |
| `tags` | `array` | Array of tag ids |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The map's tooltip (premium campaign feature)                   |
| `is_real` | `boolean` | If the map uses openmaps (the real world) |
| `is_private` | `boolean` | If the map is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new map.


<a name="update-map"></a>
## Update a Map

To update a map, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `maps/{map.id}` | Default |

### Body

The same body parameters are available as for when creating a map.

### Results

> {success} Code 200 with JSON body of the updated map.


<a name="delete-map"></a>
## Delete a Map

To delete a map, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `maps/{map.id}` | Default |

### Results

> {success} Code 200 with JSON.
