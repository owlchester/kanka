# Entity Notes

---

- [All Entity Notes](#all-entity-notes)
- [Single Entity Note](#entity-note)
- [Create an Entity Note](#create-entity-note)
- [Update an Entity Note](#update-entity-note)
- [Delete an Entity Note](#delete-entity-note)

<a name="all-entity-notes"></a>
## All Entity Notes

You can get a list of all the entity-notes of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_notes` | Default |

### Results
```json
{
    "data": [
        {
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "entity_id": 69,
            "entry": "Lorem Ipsum",
            "entry_parsed": "Lorem Ipsum",
            "id": 31,
            "position": null,
            "visibility": "all",
            "name": "Secret Note",
            "settings": [],
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": null
        }
    ]
}
```


<a name="entity-note"></a>
## Entity Note

To get the details of a single entity-note, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_notes/{entity_note.id}` | Default |

### Results
```json
{
    "data": {
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "entity_id": 69,
        "entry": "Lorem Ipsum",
        "entry_parsed": "Lorem Ipsum",
        "id": 31,
        "position": null,
        "visibility": "all",
        "name": "Secret Note",
        "settings": [],
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null
    }
}
```


<a name="create-entity-note"></a>
## Create an Entity Note

To create an entity-note, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_notes` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the entity-note |
| `entry` | `string` | The entity-note's entry (html) |
| `entity_id` | `integer` (Required) | The entity-note's parent entity |
| `visibility` | `string` | The visibility: `all` (default), `self`, `member`, `admin` or `self-admin`. |
| `position` | `int|null` (optional) | Position for ordering pinned entity notes |
| `settings` | `object` (optional) | `collapsed:1` if the pinned entity note should be collapsed on page load |

### Results

> {success} Code 200 with JSON body of the new entity-note.


<a name="update-entity-note"></a>
## Update an Entity Note

To update an entity-note, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/entity_notes/{entity_note.id}` | Default |

### Body

The same body parameters are available as for when creating an entity-note.

### Results

> {success} Code 200 with JSON body of the updated entity-note.


<a name="delete-entity-note"></a>
## Delete an Entity Note

To delete an entity-note, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_notes/{entity_note.id}` | Default |

### Results

> {success} Code 200 with JSON.
