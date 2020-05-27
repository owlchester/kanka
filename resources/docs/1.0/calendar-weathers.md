# Calendars Weathers

---

- [All Calendar Weathers](#all-calendar-weathers)
- [Single Calendar Weather](#calendar-weather)
- [Create a Calendar Weather](#create-calendar-weather)
- [Update a Calendar Weather](#update-calendar-weather)
- [Delete a Calendar Weather](#delete-calendar-weather)

<a name="all-calendar-weathers"></a>
## All Calendar Weathers

You can get a list of all the weather effects of a calendar by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `calendars/{calendar.id}/calendar_weathers` | Default |

### Results
```json
{
    "data": [
        {
            "id": 2,
            "calendar_id": 3,
            "weather": "bolt",
            "temperature": "asdasd",
            "precipitation": "",
            "wind": "",
            "effect": "",
            "day": 3,
            "month": 2,
            "year": 110,
            "created_at": "2020-01-27 14:32:59",
            "updated_at": "2020-01-27 14:33:22"
        }
    ],
    "links": {
        "first": "https://kanka.io/api/{{version}}/campaigns/1/calendars/1/calendar_weathers?page=1",
        "last": "https://kanka.io/api/{{version}}/campaigns/1/calendars/1/calendar_weathers?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "https://kanka.io/api/{{version}}/campaigns/1/calendars/1/calendar_weathers",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```


<a name="calendar-weather"></a>
## Calendar Weather

To get the details of a single weather effect, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `calendars/{calendar.id}/calendar_weathers/{calendar_weather.id}` | Default |

### Results
```json
{
    "data": {
        "id": 2,
        "calendar_id": 3,
        "weather": "bolt",
        "temperature": "asdasd",
        "precipitation": "",
        "wind": "",
        "effect": "",
        "day": 3,
        "month": 2,
        "year": 110,
        "created_at": "2020-01-27 14:32:59",
        "updated_at": "2020-01-27 14:33:22"
    }
    
}
```


<a name="create-calendar-weather"></a>
## Create a Calendar Weather

To create a calendar weather, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `calendars/{calendar.id}/calendar_weathers` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `year` | `integer` (Required) | Year for the weather |
| `month` | `integer` (Required) | Month for the weather |
| `day` | `integer` (Required) | Day for the weather |
| `weather` | `string` (Required) | Weather type |
| `temperature` | `string` | The Temperature |
| `precipitation` | `string` | The precipitation |
| `wind` | `string` | The wind |
| `effect` | `string` | The effect |

### Results

> {success} Code 200 with JSON body of the new calendar weather.


<a name="update-calendar-weather"></a>
## Update a Calendar Weather

To update a calendar, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `calendars/{calendar.id}/calendar_weathers/{calendar_weather.id}` | Default |

### Body

The same body parameters are available as for when creating a calendar weather.

### Results

> {success} Code 200 with JSON body of the updated calendar weather.


<a name="delete-calendar-weather"></a>
## Delete a Calendar Weather

To delete a calendar weather, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `calendars/{calendar.id}/calendar_weathers/{calendar_weather.id}` | Default |

### Results

> {success} Code 200 with JSON.
