month_length# Calendars

---

- [All Calendars](#all-calendars)
- [Single Calendar](#calendar)
- [Create a Calendar](#create-calendar)
- [Update a Calendar](#update-calendar)
- [Delete a Calendar](#delete-calendar)
- [Reminders](#reminders)
- [Advance Date](#advance)
- [Retreat Date](#retreat)
- [Weather](#weather)

<a name="all-calendars"></a>
## All Calendars

You can get a list of all the calendars of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI            | Headers |
| :- |:---------------|  :-  |
| GET/HEAD | `calendars` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

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
              }
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
              }
            ],
            "suffix": "BC",
            "format": "d M, y s",
            "has_leap_year": true,
            "leap_year_amount": 4,
            "leap_year_month": 2,
            "leap_year_offset": 3,
            "leap_year_start": 233,
            "skip_year_zero": true
        }
    ],
    "links": {
        "first": "https://api.kanka.io/{{version}}/campaigns/1/calendars?page=1",
        "last": "https://api.kanka.io/{{version}}/campaigns/1/calendars?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "https://api.kanka.io/{{version}}/campaigns/1/calendars",
        "per_page": 100,
        "to": 1,
        "total": 1
    }
}
```

<a name="calendar"></a>
## Calendar

To get the details of a single calendar, use the following endpoint.

| Method | URI                          | Headers |
| :- |:-----------------------------|  :-  |
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
          }
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
          }
        ],
        "suffix": "BC",
        "format": "d M, y s",
        "has_leap_year": true,
        "leap_year_amount": 4,
        "leap_year_month": 2,
        "leap_year_offset": 3,
        "leap_year_start": 233,
        "skip_year_zero": true
    }

}
```


<a name="create-calendar"></a>
## Create a Calendar

To create a calendar, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `calendars` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the calendar |
| `entry` | `string` | The html description of the calendar |
| `type` | `string` | The calendar's type |
| `current_year` | `integer` | The current calendar year |
| `current_month` | `integer` | The current calendar month |
| `current_day` | `integer` | The current calendar day |
| `tags` | `array` | Array of tag ids |
| `month_name` | `array` | Array of month names |
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
| `format` | `string` | The rendering format for the calendar dates |
| `has_leap_year` | `boolean` | Whether the calendar has leap years |
| `leap_year_amount` | `integer` | The amount of leap days |
| `leap_year_offset` | `integer` | Every how many years the leap days occur |
| `leap_year_start` | `integer` | The year from which the leap days start occurring  |
| `tags` | `array` | Array of tag ids |
| `skip_year_zero` | `boolean` | Whether the calendar skips year zero to start in year one |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The ability\'s tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the calendar is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new calendar.


<a name="update-calendar"></a>
## Update a Calendar

To update a calendar, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `calendars/{calendar.id}` | Default |

### Body

The same body parameters are available as for when creating a calendar.

### Results

> {success} Code 200 with JSON body of the updated calendar.


<a name="delete-calendar"></a>
## Delete a Calendar

To delete a calendar, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `calendars/{calendar.id}` | Default |

### Results

> {success} Code 200 with JSON.


<a name="reminders"></a>
## Reminders

You can get a list of all the reminders of a calendar by using the following endpoint.

| Method | URI                                    | Headers |
| :- |:---------------------------------------|  :-  |
| GET/HEAD | `calendars/{calendar.id}/reminders` | Default |

### Results
```json
{
"data": [
        {
            "calendar_id": 2,
            "colour": "#cccccc",
            "comment": null,
            "created_at": "2022-08-25T20:24:40.000000Z",
            "created_by": 2,
            "date": "1-3-1",
            "day": 1,
            "entity_id": 299,
            "id": 9,
            "is_private": false,
            "is_recurring": false,
            "length": 1,
            "month": 3,
            "recurring_periodicity": null,
            "recurring_until": null,
            "type_id": 4,
            "updated_at": "2023-04-19T18:40:16.000000Z",
            "updated_by": null,
            "visibility_id": 1,
            "year": 1
        },
        {
            "calendar_id": 2,
            "colour": "#ff8000",
            "comment": "Harvest Season",
            "created_at": "2022-12-12T22:12:54.000000Z",
            "created_by": 2,
            "date": "1-1-5",
            "day": 5,
            "entity_id": 298,
            "id": 13,
            "is_private": false,
            "is_recurring": true,
            "length": 8,
            "month": 1,
            "recurring_periodicity": "month",
            "recurring_until": "2",
            "type_id": null,
            "updated_at": "2023-02-14T21:38:13.000000Z",
            "updated_by": null,
            "visibility_id": 1,
            "year": 1
        },
}
```

<a name="advance"></a>
## Advance Date

You can advance the date of the calendar by one day using the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `calendars/{calendar.id}/advance` | Default |

### Results

> {success} Code 200 with JSON.

<a name="retreat"></a>
## Retreat Date

You can turn back the date of the calendar by one day using the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `calendars/{calendar.id}/retreat` | Default |

### Results

> {success} Code 200 with JSON.

<a name="weather"></a>
## Weather

You can control the weather of the calendar with the following docs: [Calendar Weather](/api-docs/{{version}}/calendar-weathers)
