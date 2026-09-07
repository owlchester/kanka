# Timelines Eras

---

- [All Timeline Eras](#all-timeline-eras)
- [Single Timeline Era](#timeline-era)
- [Create a Timeline Era](#create-timeline-era)
- [Update a Timeline Era](#update-timeline-era)
- [Delete a Timeline Era](#delete-timeline-era)

<a name="all-timeline-eras"></a>
## All Timeline Eras

You can get a list of all the eras of a timeline by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `timelines/{timeline.id}/timeline_eras` | Default |

### Results
```json
{
    "data": [
        {
            "id": 26,
            "name": "Anno Domani",
            "abbreviation": "AD",
            "start_year": null,
            "entry": "<p>Lorem ipsum dolor sit amet</p>",
            "entry_parsed": "<p>Lorem ipsum dolor sit amet</p>",
            "end_year": 0,
            "elements": [
                {
                    "id": 41,
                    "era_id": 26,
                    "timeline_id": 1,
                    "entity_id": 56,
                    "name": "Kemali Uprising",
                    "entry": "<p>An uprising begins.</p>",
                    "entry_parsed": "<p>An uprising begins.</p>",
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
            "is_collapsed": false,
            "position": 2
        }
    ],
    "links": {
        "first": "https://api.kanka.io/{{version}}/campaigns/1/timelines/1/timeline_eras?page=1",
        "last": "https://api.kanka.io/{{version}}/campaigns/1/timelines/1/timeline_eras?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "https://api.kanka.io/{{version}}/campaigns/1/timelines/1/timeline_eras",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```


<a name="timeline-era"></a>
## Timeline Era

To get the details of a single era, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `timelines/{timeline.id}/timeline_eras/{timeline_era.id}` | Default |

### Results
```json
{
    "data": {
        "id": 26,
        "name": "Third era",
        "abbreviation": null,
        "start_year": null,
        "entry": "<p>Lorem ipsum dolor sit amet</p>",
        "entry_parsed": "<p>Lorem ipsum dolor sit amet</p>",
        "end_year": null,
        "elements": [],
        "is_collapsed": false,
        "position": 2
    }

}
```


<a name="create-timeline-era"></a>
## Create a Timeline Era

To create a timeline era, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `timelines/{timeline.id}/timeline_eras` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the era |
| `entry` | `string` | HTML description of the era |
| `abbreviation` | `string` | Abbreviation of the era |
| `start_year` | `integer` | Year the era starts |
| `end_year` | `integer` | Year the era ends |
| `is_collapsed` | `boolean` | Whether the era is collapsed by default |


### Results

> {success} Code 201 with JSON body of the new timeline era.


<a name="update-timeline-era"></a>
## Update a Timeline Era

To update a timeline, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `timelines/{timeline.id}/timeline_eras/{timeline_era.id}` | Default |

### Body

The same body parameters are available as for when creating a timeline era.

### Results

> {success} Code 200 with JSON body of the updated timeline era.


<a name="delete-timeline-era"></a>
## Delete a Timeline Era

To delete a timeline era, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `timelines/{timeline.id}/timeline_eras/{timeline_era.id}` | Default |

### Results

> {success} Code 204 with no content.
