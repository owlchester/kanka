# Calendars

---

- [All Calendars](#all-calendars)
- [Single Calendar](#calendar)
- [Create a Calendar](#create-calendar)
- [Update a Calendar](#update-calendar)
- [Delete a Calendar](#delete-calendar)
- [Weather](#weather)

<a name="all-calendars"></a>
## All Calendars

You can get a list of all the calendars of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `calendars` | Default |

### Results
```json
{
    "data": [
        {
            "id": 3,
            "name": "Georgian Calendar",
            "entry": "\n<p>Lorem Ipsum</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": false,
            "entity_id": 78,
            "tags": [],
            "created_at": "2019-01-28T06:29:29.000000Z",
            "created_by": 1,
            "updated_at": "2020-01-30T17:30:52.000000Z",
            "updated_by": 1,
            "type": "Primary",
            "date": "311-2-3",
            "parameters": null,
            "months": [
              {
                "name": "January",
                "length": 31,
                "type": "standard"
              },
              {
                "name": "February",
                "length": 5,
                "type": "intercalary"
              }
            ],
            "start_offset": 0,
            "weekdays": [
                "Sul",
                "Mol",
                "Zol",
                "Wir",
                "Zor",
                "Far",
                "Sar"
            ],
            "years": {
                "299": "Year of Blood and Fire",
                "300": "Year of Water and Bone"
            },
            "seasons": [
              {
                  "name": "Spring",
                  "month": 1,
                  "day": 1
              },
              {
                  "name": "Summer",
                  "month": 4,
                  "day": 1
              },
            ],
            "moons": [
              {
                  "name": "Zarantyr",
                  "fullmoon": "13",
                  "offset": 0,
                  "colour": "aqua"
              },
              {
                  "name": "Olarune",
                  "fullmoon": "17",
                  "offset": 0,
                  "colour": "brown"
              },
            ],
            "suffix": "BC",
            "has_leap_year": true,
            "leap_year_amount": 4,
            "leap_year_month": 2,
            "leap_year_offset": 3,
            "leap_year_start": 233
        }
    ],
    "links": {
        "first": "https://kanka.io/api/{{version}}/campaigns/1/calendars?page=1",
        "last": "https://kanka.io/api/{{version}}/campaigns/1/calendars?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "https://kanka.io/api/{{version}}/campaigns/1/calendars",
        "per_page": 100,
        "to": 1,
        "total": 1
    }
}
```


<a name="calendar"></a>
## Calendar

To get the details of a single calendar, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `calendars/{calendar.id}` | Default |

### Results
```json
{
    "data": {
        "id": 3,
        "name": "Georgian Calendar",
        "entry": "\n<p>Lorem Ipsum</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": false,
        "entity_id": 78,
        "tags": [],
        "created_at": "2019-01-28T06:29:29.000000Z",
        "created_by": 1,
        "updated_at": "2020-01-30T17:30:52.000000Z",
        "updated_by": 1,
        "type": "Primary",
        "date": "311-2-3",
        "parameters": null,
        "months": [
          {
            "name": "January",
            "length": 31,
            "type": "standard"
          },
          {
            "name": "February",
            "length": 5,
            "type": "intercalary"
          }
        ],
        "start_offset": 0,
        "weekdays": [
            "Sul",
            "Mol",
            "Zol",
            "Wir",
            "Zor",
            "Far",
            "Sar"
        ],
        "years": {
            "299": "Year of Blood and Fire",
            "300": "Year of Water and Bone"
        },
        "seasons": [
          {
              "name": "Spring",
              "month": 1,
              "day": 1
          },
          {
              "name": "Summer",
              "month": 4,
              "day": 1
          },
        ],
        "moons": [
          {
              "name": "Zarantyr",
              "fullmoon": "13",
              "offset": 0,
              "colour": "aqua"
          },
          {
              "name": "Olarune",
              "fullmoon": "17",
              "offset": 0,
              "colour": "brown"
          },
        ],
        "suffix": "BC",
        "has_leap_year": true,
        "leap_year_amount": 4,
        "leap_year_month": 2,
        "leap_year_offset": 3,
        "leap_year_start": 233
    }
    
}
```


<a name="create-calendar"></a>
## Create a Calendar

To create a calendar, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `calendars` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the calendar |
| `type` | `string` | The calendar's type |
| `current_year` | `integer` | The current calendar year |
| `current_month` | `integer` | The current calendar month |
| `current_day` | `integer` | The current calendar day |
| `tags` | `array` | Array of tag ids |
| `month_name` | `array` (required, min 2) | Array of month names |
| `month_length` | `array` | Array of month lengths |
| `month_type` | `array` | Array of month types (standard or intercalary) |
| `weekday` | `array` (required, min 2) | Array of weekday names |
| `year_name` | `array` | Array of year names |
| `year_number` | `array` | Array of year numbers |
| `moon_name` | `array` | Array of moon names |
| `moon_fullmoon` | `array` | Array of when (every how many days) a full moon occurs |
| `epoch_name` | `array` | Array of epoch names |
| `season_name` | `array` | Array of season names |
| `season_month` | `array` | Array of seasons month start |
| `season_day` | `array` | Array of seasons day start |
| `has_leap_year` | `boolean` | Whether the calendar has leap years |
| `leap_year_amount` | `integer` | The amount of leap days |
| `leap_year_offset` | `integer` | Every how many years the leap days occur |
| `leap_year_start` | `integer` | The year from which the leap days start occurring  |
| `tags` | `array` | Array of tag ids |
| `is_private` | `boolean` | If the calendar is only visible to `admin` members of the campaign |
| `image` | `stream` | Stream to file uploaded to the calendar |
| `image_url` | `string` | URL to a picture to be used for the calendar |

### Results

> {success} Code 200 with JSON body of the new calendar.


<a name="update-calendar"></a>
## Update a Calendar

To update a calendar, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `calendars/{calendar.id}` | Default |

### Body

The same body parameters are available as for when creating a calendar.

### Results

> {success} Code 200 with JSON body of the updated calendar.


<a name="delete-calendar"></a>
## Delete a Calendar

To delete a calendar, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `calendars/{calendar.id}` | Default |

### Results

> {success} Code 200 with JSON.

<a name="weather"></a>
## Weather

You can control the weather of the calendar with the following docs: [Calendar Weather](/docs/{{version}}/calendar-weathers)