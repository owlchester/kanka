# Reminders

---

- [All Reminders](#all-reminders)
- [Single Reminder](#reminder)
- [Create a Reminder](#create-reminder)
- [Update a Reminder](#update-reminder)
- [Delete a Reminder](#delete-reminder)

<a name="all-reminders"></a>
## All Reminders

You can get a list of all reminders for an entity by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/reminders` | Default |

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
            "remindable_id": 1085,
            "remindable_type": "App/Models/Entity",
            "id": 60,
            "is_recurring": true,
            "recurring_periodicity": "yearly",
            "length": 1,
            "recurring_until": null,
            "type_id": null,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": null,
            "visibility_id": 1,
            "year": 1
        }
    ]
}
```


<a name="reminder"></a>
## Reminder

To get the details of a single reminder, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/reminders/{reminder.id}` | Default |

### Results
```json
{
    "data": {
        "calendar_id": 7,
        "comment": "Recurring event",
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": null,
        "date": "2-1-5",
        "remindable_id": 1085,
        "remindable_type": "App/Models/Entity",
        "id": 60,
        "is_recurring": true,
        "recurring_periodicity": "yearly",
        "length": 1,
        "recurring_until": null,
        "type_id": null,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null,
        "visibility_id": 1,
        "year": 1
    }
}
```


<a name="create-reminder"></a>
## Create a Reminder

To create a reminder, use the following endpoint. The reminder is attached to the entity in the URL.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/reminders` | Default |

### Body

| Parameter               | Type | Detail                                                                                 |
|:------------------------|   :-   |:---------------------------------------------------------------------------------------|
| `day`                   | `integer` (Required) | Day on which the event takes place                                                     |
| `month`                 | `integer` (Required) | Month (id) on which the event takes place                                              |
| `year`                  | `integer` (Required) | Year on which the event takes place                                                    |
| `length`                | `integer` | Duration in days of the event                                                          |
| `recurring_periodicity` | `string` | Null if the event isn't recurring. `yearly`, `monthly`, or `{moon.id}_{phase}` where `phase` is `f` (full), `n` (new), `waning_gibbous`, `last_quarter`, `waning_crescent`, `waxing_crescent`, `first_quarter`, or `waxing_gibbous` |
| `recurring_until`       | `integer` | Year until the event reoccurs                                                          |
| `colour`                | `string` | Colour of the reminder in the calendar                                             |
| `comment`               | `string` | Comment of the reminder                                                            |
| `calendar_id`           | `integer` (Required) | The calendar\'s id                                                                     |
| `type_id`               | `null` or `int` | Special field for calculating the age of a character. `2` for birthday, `3` for death. |
| `visibility_id`         | `int` | The visibility ID: 1 for `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`.    |

### Results

> {success} Code 201 with JSON body of the new reminder under `data`.


<a name="update-reminder"></a>
## Update a Reminder

To update a reminder, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/reminders/{reminder.id}` | Default |

### Body

The same body parameters are available as for when creating a reminder.

### Results

> {success} Code 200 with JSON body of the updated reminder under `data`.


<a name="delete-reminder"></a>
## Delete a Reminder

To delete a reminder, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/reminders/{reminder.id}` | Default |

### Results

> {success} Code 204 with no body.
