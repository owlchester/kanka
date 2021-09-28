# Maps

---

- [Maps](#maps)
  - [All Maps](#all-maps)
    - [Results](#results)
    - [Filters](#filters)
  - [Map](#map)
    - [Results](#results-1)
  - [Create a Map](#create-a-map)
    - [Body](#body)
    - [Results](#results-2)
  - [Update a Map](#update-a-map)
    - [Body](#body-1)
    - [Results](#results-3)
  - [Delete a Map](#delete-a-map)
    - [Results](#results-4)

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
            "center_marker_id": null,
            "center_x": null,
            "center_y": null,
            "layers": "<array of map Map Layers>",
            "groups": "<array of map Map Groups>"
        }
    ]
}
```

<a name="filters"></a>
## Filters

The list of returned maps can be filters. The available filters are available here: <a href="/en/helpers/api-filters?type=map" target="_blank">API filters</a>.


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

| Method | Endpoint| Headers |
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
| `is_private` | `boolean` | If the map is only visible to `admin` members of the campaign |
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
