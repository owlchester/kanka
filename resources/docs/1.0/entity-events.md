# Entity Events

---

- [All Entity Events](#all-entity-events)
- [Single Entity Event](#entity-event)
- [Create an Entity Event](#create-entity-event)
- [Update an Entity Event](#update-entity-event)
- [Delete an Entity Event](#delete-entity-event)

<a name="all-entity-events"></a>
## All Entity Events

You can get a list of all the entity-events of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_events` | Default |

### Results
```json
{
    "data": [
        {
            "calendar_id": 7,
            "comment": "Recurring event",
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": null,
            "date": "2-1-5",
            "entity_id": 1085,
            "id": 60,
            "is_private": false,
            "is_recurring": true,
            "length": 1,
            "recurring_until": null,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": null
        }
    ]
}
```


<a name="entity-event"></a>
## Entity Event

To get the details of a single entity-event, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_events/{entity_event.id}` | Default |

### Results
```json
{
    "data": {
        "calendar_id": 7,
        "comment": "Recurring event",
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": null,
        "date": "2-1-5",
        "entity_id": 1085,
        "id": 60,
        "is_private": false,
        "is_recurring": true,
        "length": 1,
        "recurring_until": null,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null
    }
}
```


<a name="create-entity-event"></a>
## Create an Entity Event

To create an entity-event, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_events` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the entity event |
| `day` | `integer` (Required) | Day on which the event takes place |
| `month` | `integer` (Required) | Month (id) on which the event takes place |
| `year` | `integer` (Required) | Year on which the event takes place |
| `length` | `integer` (Required) | Duration in days of the event |
| `is_recurring` | `boolean` | True if the event is recurring |
| `recurring_until` | `integer` | Year until the event reoccurs |
| `colour` | `string` | Colour of the entity event in the calendar |
| `comment` | `string` | Comment of the entity event |
| `entity_id` | `integer` (Required) | The entity event's parent entity |
| `is_private` | `boolean` | If the entity event is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new entity-event.


<a name="update-entity-event"></a>
## Update an Entity Event

To update an entity-event, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/entity_events/{entity_event.id}` | Default |

### Body

The same body parameters are available as for when creating an entity-event.

### Results

> {success} Code 200 with JSON body of the updated entity-event.


<a name="delete-entity-event"></a>
## Delete an Entity Event

To delete an entity-event, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_events/{entity_event.id}` | Default |

### Results

> {success} Code 200 with JSON.
