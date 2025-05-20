# Map Markers

---

- [All Map Markers](#all-map-markers)
- [Create a Map Marker](#create-map-marker)
- [Update a Map Marker](#update-map-marker)
- [Delete a Map Marker](#delete-map-marker)

<a name="all-map-markers"></a>
## All Map-markers

You can get a list of all the map-markers of a map by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `maps/{map.id}/map_markers` | Default |

### Results
```json
{
    "data": [
        {
            "circle_radius": null,
            "colour": "#008000",
            "created_at": "2020-07-25T10:10:30.000000Z",
            "created_by": null,
            "custom_icon": null,
            "custom_shape": "500,500 500,600, 600,600 600,500",
            "entity_id": null,
            "font_colour": null,
            "icon": "1",
            "id": 31,
            "is_draggable": false,
            "is_private": false,
            "is_popupless": false,
            "latitude": "422.857",
            "longitude": "499.000",
            "map_id": 2,
            "name": "Shape",
            "opacity": 100,
            "polygon_style": array,
            "shape_id": 5,
            "size_id": 1,
            "updated_at": "2020-07-25T10:10:30.000000Z",
            "updated_by": null,
            "visibility_id": 1
        }
    ]
}
```


<a name="create-map-marker"></a>
## Create a Map Marker

To create a map marker, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `maps/{map.id}/map_markers` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required without `entity_id`) | Name of the map marker |
| `entity_id` | `string` (Required without `name`) | Entity linked to the map marker |
| `map_id` | `integer` (Required) | The parent map |
| `latitude` | `float` (Required) | Latitude of the marker |
| `longitude` | `float` (Required) | Longitude of the marker |
| `shape_id` | `int` (Required) | Shape of the marker (`1` for Marker, `2` for Label, `3` for Circle, `4` for Polygon) |
| `icon` | `int` (Required) | `1` for Marker, `2` for Exclamation, `3` for Interrogation, `4` for Entity |
| `group_id` | `int` | ID of the marker group |
| `is_draggable` | `boolean` | If the marker is draggable on the map |
| `is_popupless` | `boolean` | Disable the marker tooltip popping up on mouse hover |
| `custom_shape` | `string` | Polygon coordinates |
| `custom_icon` | `string` | HTML of the custom icon |
| `size_id` | `int` | 1 to 6 for size (used by circles, 6 being custom) |
| `opacity` | `int` | 0 to 100 opacity |
| `visibility_id` | `integer` | The visibility: 1 for `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`. |
| `colour` | `string` | Hex colour code with leading `#` |
| `font_colour` | `string` | Hex colour code with leading `#` |
| `circle_radius` | `null` or `int` | If the shape_id is 3 (circle) and size_id is 6 (cursom), can provide a custom circle radius size |
| `polygon_style` | `null` or `array` | Polygon rendering options include `stroke`, `stroke-width` and `stroke-opacity` |


### Results

> {success} Code 200 with JSON body of the new map.


<a name="update-map-marker"></a>
## Update a Map Marker

To update a map, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `maps/{map.id}/map_markers/{map.id}` | Default |

### Body

The same body parameters are available as for when creating a map.

### Results

> {success} Code 200 with JSON body of the updated map.


<a name="delete-map-marker"></a>
## Delete a Map Marker

To delete a map, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `maps/{map.id}/map_markers/{map.id}` | Default |

### Results

> {success} Code 200 with JSON.
