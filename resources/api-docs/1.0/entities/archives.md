# Archives

---

- [All Archived entities](#all-archives)
- [Archive/Unarchive an entity](#switch-archive)

<a name="all-archives"></a>
## All Archives

You can get a list of entities marked as archived by calling the following API endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/archived` | Default |

### Results
```json
{
    "data": [
        {
            "id": 5,
            "name": "Dagger of Darkness",
            "type": "item",
            "child_id": 1,
            "tags": [],
            "is_private": false,
            "is_template": false,
            "campaign_id": 1,
            "is_attributes_private": false,
            "tooltip": "",
            "header_image": null,
            "image_uuid": null,
            "created_at": "2020-06-03T11:04:30.000000Z",
            "created_by": 1,
            "updated_at": "2021-06-16T08:01:02.000000Z",
            "updated_by": 1,
            "archived_at": "2022-03-11T08:02:02.000000Z",
        }
    ]
}
```


<a name="switch-archive"></a>
## Switch archival status

To change the archived status of an entity, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/archive/{entity.id}` | Default |

### Body

`empty`


### Results

> {success} Code 200 with JSON body of the entity.

