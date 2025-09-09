# Events

---

- [All Events](#all-events)

- [Single Event](#event)
- [Create a Event](#create-event)
- [Update a Event](#update-event)
- [Delete a Event](#delete-event)

<a name="all-events"></a>
## All Events

You can get a list of all the events of a campaign by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `events` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Battle of Hadish",
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
            "location_id": "4",
            "date": "44-3-16",
            "type": "Battle",
            "calendar_id": 2,
            "calendar_year": 2,
            "calendar_month": 4,
            "calendar_day": 3
        }
    ]
}
```

<a name="event"></a>
## Event

To get the details of a single event, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `events/{event.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Battle of Hadish",
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
        "location_id": "4",
        "date": "44-3-16",
        "type": "Battle",
        "calendar_id": 2,
        "calendar_year": 2,
        "calendar_month": 4,
        "calendar_day": 3
    }

}
```


<a name="create-event"></a>
## Create a Event

To create a event, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `events` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the event |
| `entry` | `string` | The html description of the event |
| `type` | `string` | The event's type |
| `date` | `string` | Fictional date at which the event took place |
| `location_id` | `string` | Location of the event |
| `tags` | `array` | Array of tag ids |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The event's tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the event is only visible to `admin` members of the campaign |
### Results

> {success} Code 200 with JSON body of the new event.


<a name="update-event"></a>
## Update a Event

To update a event, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `events/{event.id}` | Default |

### Body

The same body parameters are available as for when creating a event.

### Results

> {success} Code 200 with JSON body of the updated event.


<a name="delete-event"></a>
## Delete a Event

To delete a event, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `events/{event.id}` | Default |

### Results

> {success} Code 200 with JSON.
