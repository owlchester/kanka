# Entity Assets

---

- [Introduction](#introduction)
- [All Entity Assets](#all-entity-assets)
- [Create an Entity Asset](#create-entity-asset)
- [Delete an Entity Asset](#delete-entity-asset)

<a name="introduction"></a>
## Introduction

This new endpoint and model merges the previous `entity files`, `entity links` and `entity aliases` endpoints and models into a single unit.

Alias unique IDs keep their same IDs in this new endpoint, but files and links all get a new one.

### Type IDs

To differenciate between the three types of assets, use the following reference
| Type | Type ID |
| :- | :- |
| File | 1 |
| Link | 2 |
| Alias | 3 |

<a name="all-entity-assets"></a>
## All Entity Assets

You can get a list of all the assets of an entity by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_assets` | Default |

### Results
```json
{
    "data": [
        {
            "created_at":  "2022-01-30T00:01:44.000000Z",
            "created_by": 1,
            "entity_id": 309,
            "id": 2,
            "is_pinned": false,
            "visibility_id": "1",
            "name": "The BEST",
            "metadata": [],
            "type_id": 3,
            "updated_at":  "2022-01-31T13:48:54.000000Z",
            "updated_by": null
        }
    ]
}
```

## Virtual properties

Assets also contain the following virtual properties provided by the API.

| Property | Type | Value |
| :- |   :-   |  :-  |
|`_file` | `boolean` | If the asset is of the file type |
|`_link` | `boolean` | If the asset is of the link type |
|`_alias` | `boolean` | If the asset is of the alias type |
|`_url` | `null|string` | If it's a file, the fullpath URL |


<a name="entity-asset"></a>
## Entity Asset

To get the details of a single entity-asset, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_assets/{entity_asset.id}` | Default |

### Results
```json
{
    "data": {
        "created_at":  "2022-01-30T00:01:44.000000Z",
        "created_by": 1,
        "entity_id": 309,
        "id": 2,
        "is_pinned": false,
        "visibility_id": "1",
        "name": "The BEST",
        "updated_at":  "2022-01-31T13:48:54.000000Z",
        "updated_by": null
    }
}
```


<a name="create-entity-asset"></a>
## Create an Entity Asset

To create an asset, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_assets` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` | The name of the asset (max 45) |
| `type_id` | `int`  (Required) | The type of asset being created.
| `files` | `file` | The file or files to be uploaded as an asset/assets, exclusive and required for file assets (`type_id: 1`). |
| `visibility_id` | `int` | The visibility id: 1 `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`. |
| `metadata` | `array` | `metadata.icon` and `metadata.url` are required for `links`. |
| `is_pinned` | `bool` | Controls wether or not an asset is shown and linked to on the pins tab in the overview of the entity, exclusive to file assets (`type_id: 1`). |

### Results

> {success} Code 200 with JSON body of the new entity-asset.


<a name="delete-entity-asset"></a>
## Delete an Entity Asset

To delete an entity-asset, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_assets/{entity_asset.id}` | Default |

### Results

> {success} Code 200 with JSON.
