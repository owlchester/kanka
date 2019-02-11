# Locations

---

- [All Locations](#all-locations)
- [Single Location](#location)
- [Location Map Points](#location-map-points)
- [Create a Location](#create-location)
- [Update a Location](#update-location)
- [Delete a Location](#delete-location)

<a name="all-locations"></a>
## All Locations

You can get a list of all the locations of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaign/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `locations` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Mordor",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "is_private": true,
            "entity_id": 5,
            "tags": [],
            "created_at": {
                "date": "2017-10-31 10:55:08.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "created_by": 1,
            "updated_at": {
                "date": "2018-09-20 09:18:58.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_by": 1,
            "parent_location_id": 4,
            "map": "{url}",
            "type": "Kingdom"
        }
    ]
}
```


<a name="location"></a>
## Location

To get the details of a single location, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `locations/{location.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Mordor",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "is_private": true,
        "entity_id": 5,
        "tags": [],
        "created_at": {
            "date": "2017-10-31 10:55:08.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "created_by": 1,
        "updated_at": {
            "date": "2018-09-20 09:18:58.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_by": 1,
        "parent_location_id": 4,
        "map": "{url}",
        "type": "Kingdom"
    }
    
}
```


<a name="location-map-points"></a>
## Location Map Points

To get the map points of a location, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `locations/{location.id}/map_points` | Default |

### Results
```json
{
    "data": {
        "target_id": 58,
        "axis_x": 1356,
        "axis_y": 788,
        "colour": "red",
        "name": null,
        "created_at": {
            "date": "2018-03-21 12:47:19.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2018-11-02 18:18:27.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
}
```

> {info} Additional note: `target_id` represents an `entities`.`id`.

#### Other endpoints
> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) a member from an organisation can also be done using the same patterns as for other endpoints.


<a name="create-location"></a>
## Create a Location

To create a location, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `locations/` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the location |
| `type` | `string` | Type of location |
| `parent_location_id` | `integer` | The parent location id (where this location is located)|
| `tags` | `array` | Array of tag ids |
| `is_private` | `boolean` | If the location is only visible to `admin` members of the campaign |
| `image` | `stream` | Stream to file uploaded to the location |
| `image_url` | `string` | URL to a picture to be used for the location |
| `map` | `stream` | Stream to file uploaded as the location's map |
| `map_url` | `string` | URL to a picture to be used for the location's map |

### Results

> {success} Code 200 with JSON body of the new location.


<a name="update-location"></a>
## Update a Location

To update a location, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `locations/{location.id}` | Default |

### Body

The same body parameters are available as for when creating a location.

### Results

> {success} Code 200 with JSON body of the updated location.


<a name="delete-location"></a>
## Delete a Location

To delete a location, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `locations/{location.id}` | Default |

### Results

> {success} Code 200 with JSON.
