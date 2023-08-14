# Templates

---

- [All Templates](#all-templates)
- [Switch a template](#switch-template)

<a name="all-templates"></a>
## All Templates

You can get a list of entities marked as templates by calling the following API endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/templates` | Default |

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
            "is_template": true,
            "campaign_id": 1,
            "is_attributes_private": false,
            "tooltip": "",
            "header_image": null,
            "image_uuid": null,
            "created_at": "2020-06-03T11:04:30.000000Z",
            "created_by": 1,
            "updated_at": "2021-06-16T08:01:02.000000Z",
            "updated_by": 1
        }
    ]
}
```


<a name="switch-template"></a>
## Switch Template

To change the template status of an entity, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/template/{entity.id}/switch` | Default |

### Body

`empty`


### Results

> {success} Code 200 with JSON body of the entity.

