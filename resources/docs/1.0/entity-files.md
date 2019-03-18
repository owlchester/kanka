# Entity Files

---

- [All Entity Files](#all-entity-files)
- [Single Entity File](#entity-file)
- [Create an Entity File](#create-entity-file)
- [Delete an Entity File](#delete-entity-file)

<a name="all-entity-files"></a>
## All Entity Files

You can get a list of all the entity-files of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaign/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_files` | Default |

### Results
```json
{
    "data": [
        {
            "created_at": {
                "date": "2019-01-28 19:42:33.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "created_by": 1,
            "entity_id": 69,
            "entry": "Lorem Ipsum",
            "id": 31,
            "is_private": true,
            "name": "Secret File",
            "path": "{url}",
            "size": "44420",
            "type": "image/jpeg",
            "updated_at": {
                "date": "2019-01-28 19:42:33.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_by": null
        }
    ]
}
```


<a name="entity-file"></a>
## Entity File

To get the details of a single entity-file, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_files/{entity_file.id}` | Default |

### Results
```json
{
    "data": {
        "created_at": {
            "date": "2019-01-28 19:42:33.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "created_by": 1,
        "entity_id": 69,
        "entry": "Lorem Ipsum",
        "id": 31,
        "is_private": true,
        "name": "Secret File",
        "path": "{url}",
        "size": "44420",
        "type": "image/jpeg",
        "updated_at": {
            "date": "2019-01-28 19:42:33.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_by": null
    }
}
```


<a name="create-entity-file"></a>
## Create an Entity File

To create an entity-file, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_files` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `file` | `stream` | The uploaded file (max 2mb or 8mb for Patreons) |
| `is_private` | `boolean` | If the entity-file is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new entity-file.


<a name="delete-entity-file"></a>
## Delete an Entity File

To delete an entity-file, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_files/{entity_file.id}` | Default |

### Results

> {success} Code 200 with JSON.
