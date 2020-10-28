# Timelines Eras

---

- [All Timeline Eras](#all-timeline-eras)
- [Single Timeline Era](#timeline-era)
- [Create a Timeline Era](#create-timeline-era)
- [Update a Timeline Era](#update-timeline-era)
- [Delete a Timeline Era](#delete-timeline-era)

<a name="all-timeline-eras"></a>
## All Timeline Eras

You can get a list of all the era effects of a timeline by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `timelines/{timeline.id}/timeline_eras` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "timeline_id": 1,
            "name": "Anno Domani",
            "abbreviation": "AD",
            "start_year": null,
            "end_year": 0,
            "visibility": "all",
            "elements": [],,
            "created_by": 1,
            "created_at": "2020-08-05 14:32:59",
            "updated_at": "2020-08-05 14:33:22"
        }
    ],
    "links": {
        "first": "https://kanka.io/api/{{version}}/campaigns/1/timelines/1/timeline_eras?page=1",
        "last": "https://kanka.io/api/{{version}}/campaigns/1/timelines/1/timeline_eras?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "https://kanka.io/api/{{version}}/campaigns/1/timelines/1/timeline_eras",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```


<a name="timeline-era"></a>
## Timeline Era

To get the details of a single era effect, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `timelines/{timeline.id}/timeline_eras/{timeline_era.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "timeline_id": 1,
        "name": "Anno Domani",
        "abbreviation": "AD",
        "start_year": null,
        "end_year": 0,
        "visibility": "all",
        "elements": [],,
        "created_by": 1,
        "created_at": "2020-08-05 14:32:59",
        "updated_at": "2020-08-05 14:33:22"
    }

}
```


<a name="create-timeline-era"></a>
## Create a Timeline Era

To create a timeline era, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `timelines/{timeline.id}/timeline_eras` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `timeline_id` | `int` (Required) | Timeline ID |
| `era` | `string` (Required) | Name of the era |
| `abbreviation` | `string` | Abbreviation of the era |
| `start_year` | `integer` | Year the era starts |
| `end_year` | `integer` | Year the era ends |
| `visiblity` | `string` | `all`, `admin`, `self` Who can view |


### Results

> {success} Code 200 with JSON body of the new timeline era.


<a name="update-timeline-era"></a>
## Update a Timeline Era

To update a timeline, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `timelines/{timeline.id}/timeline_eras/{timeline_era.id}` | Default |

### Body

The same body parameters are available as for when creating a timeline era.

### Results

> {success} Code 200 with JSON body of the updated timeline era.


<a name="delete-timeline-era"></a>
## Delete a Timeline Era

To delete a timeline era, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `timelines/{timeline.id}/timeline_eras/{timeline_era.id}` | Default |

### Results

> {success} Code 200 with JSON.
