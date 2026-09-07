# Timelines Elements

---

- [All Timeline Elements](#all-timeline-elements)
- [Single Timeline Element](#timeline-element)
- [Create a Timeline Element](#create-timeline-element)
- [Update a Timeline Element](#update-timeline-element)
- [Delete a Timeline Element](#delete-timeline-element)

<a name="all-timeline-elements"></a>
## All Timeline Elements

You can get a list of all the elements of a timeline by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `timelines/{timeline.id}/timeline_elements` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "timeline_id": 1,
            "era_id": 1,
            "name": "Kemali Uprising",
            "entity_id": 56,
            "entry": "...",
            "entry_parsed": "...",
            "date": "3rd of Appen 114",
            "colour": "blue",
            "position": 1,
            "visibility_id": 1,
            "icon": "fa-solid fa-star",
            "is_collapsed": false,
            "use_entity_entry": true,
            "use_event_date": false
        }
    ],
    "links": {
        "first": "https://api.kanka.io/{{version}}/campaigns/1/timelines/1/timeline_elements?page=1",
        "last": "https://api.kanka.io/{{version}}/campaigns/1/timelines/1/timeline_elements?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "https://api.kanka.io/{{version}}/campaigns/1/timelines/1/timeline_elements",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```


<a name="timeline-element"></a>
## Timeline Element

To get the details of a single element, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `timelines/{timeline.id}/timeline_elements/{timeline_element.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "timeline_id": 1,
        "era_id": 1,
        "name": "Kemali Uprising",
        "entity_id": 56,
        "entry": "...",
        "entry_parsed": "...",
        "date": "3rd of Appen 114",
        "colour": "blue",
        "position": 1,
        "visibility_id": 1,
        "icon": "fa-solid fa-star",
        "is_collapsed": false,
        "use_entity_entry": true,
        "use_event_date": false
    }

}
```


<a name="create-timeline-element"></a>
## Create a Timeline Element

To create a timeline element, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `timelines/{timeline.id}/timeline_elements` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required if no entity) | Name of the element |
| `entity_id` | `int` (Required if no name) | Entity ID |
| `era_id` | `int` (Required) | Timeline Era ID |
| `entry` | `string` | Entry of the element |
| `date` | `string` | Free-form date displayed for the element, up to 45 characters |
| `colour` | `string` | Colour of the element, up to 12 characters |
| `position` | `int` | Position in the list of elements of the era |
| `visibility_id` | `int` | The visibility ID: 1 for `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`. |
| `icon` | `string` | Font Awesome or RPG Awesome CSS classes, for example `fa-solid fa-star` |
| `is_collapsed` | `boolean` | Whether the element is collapsed by default |
| `use_entity_entry` | `boolean` | Whether to display the linked entity's entry instead of the element's entry |
| `use_event_date` | `boolean` | Whether to display the linked event's calendar date instead of `date` |

The `date` field is a free-form display value, not a structured calendar date. When `use_event_date` is `true` and the linked entity is an event, Kanka displays that event's calendar date instead.


### Results

> {success} Code 201 with JSON body of the new timeline element.


<a name="update-timeline-element"></a>
## Update a Timeline Element

To update a timeline, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `timelines/{timeline.id}/timeline_elements/{timeline_element.id}` | Default |

### Body

The same body parameters are available as for when creating a timeline element.

### Results

> {success} Code 200 with JSON body of the updated timeline element.


<a name="delete-timeline-element"></a>
## Delete a Timeline Element

To delete a timeline element, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `timelines/{timeline.id}/timeline_elements/{timeline_element.id}` | Default |

### Results

> {success} Code 204 with no content.
