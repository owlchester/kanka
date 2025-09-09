# Bookmarks

---

- [All Bookmarks](#all-bookmarks)
- [Bookmark](#bookmark)
- [Create a Bookmark](#create-bookmark)
- [Update a Bookmark](#update-bookmark)
- [Delete a Bookmark](#delete-bookmark)

<a name="all-bookmarks"></a>
## All Bookmarks

You can get a list of all the bookmarks of a campaign by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI            | Headers |
| :- |:---------------|  :-  |
| GET/HEAD | `bookmarks` | Default |

### Results
```json
{
    "data": [
        {
           "id": 2,
           "name": "Random Chara",
           "entity_id": null,
           "filters": null,
           "icon": null,
           "is_private": 0,
           "is_active": 1,
           "menu": null,
           "random_entity_type": "character",
           "type": null,
           "tab": "",
           "target": null,
           "dashboard_id": null,
           "created_at": "2020-12-24T00:38:49.000000Z",
           "updated_at": "2020-12-24T00:41:20.000000Z",
           "created_by": 420,
           "updated_by": 422,
           "options": {"is_nested": "1"}
        }
    ]
}
```


<a name="bookmark"></a>
## Bookmark

To get the details of a single bookmark, use the following endpoint.

| Method | URI                          | Headers |
| :- |:-----------------------------|  :-  |
| GET/HEAD | `bookmarks/{bookmark.id}` | Default |

### Results
```json
{
    "data": {
        "id": 2,
        "name": "Random Chara",
        "entity_id": null,
        "filters": null,
        "icon": null,
        "is_private": 0,
        "is_active": 1,
        "menu": null,
        "random_entity_type": "character",
        "type": null,
        "tab": "",
        "target": null,
        "dashboard_id": null,
        "created_at": "2020-12-24T00:38:49.000000Z",
        "updated_at": "2020-12-24T00:41:20.000000Z",
        "created_by": 420,
        "updated_by": 422,
        "options": {"is_nested": "1"}
    }

}
```


<a name="create-bookmark"></a>
## Create a Bookmark

To create a bookmark, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `bookmarks` | Default |

### Body

| Parameter | Type | Detail                                                                                |
| :- |   :-   |:--------------------------------------------------------------------------------------|
| `name` | `string` (Required) | Name of the bookmark                                                                  |
| `entity_id` | `int` (Required without type, random_entity_type, dashboard_id) | Entity id of the bookmark                                                             |
| `type` | `int` (Required without entity_id, random_entity_type, dashboard_id) | The bookmark entity type id                                                           |
| `random_entity_type` | `string` (Required without entity_id, type, dashboard_id) | The entity type (singular) for a random entity of that type                           |
| `dashboard_id` | `int` (Required without entity_id, type, random_entity_type) | The dashboard id                                                                      |
| `icon` | `string` | Custom icon for premium campaigns                                                     |
| `tab` | `string` | Tab options for the link                                                              |
| `filters` | `string` | Filter options for the link                                                           |
| `menu` | `string` | Menu options for the link                                                             |
| `position` | `int` | Position of the link                                                                  |
| `is_private` | `boolean` | If the bookmark is only visible to admin members of the campaign                      |
| `is_active` | `boolean` | If the bookmark is visible                                                            |
| `options`| `object` | Key/Value pairs for optional parameters, currently allowed Keys : `is_nested:boolean` |

### Results

> {success} Code 200 with JSON body of the new bookmark.


<a name="update-bookmark"></a>
## Update a Bookmark

To update a bookmark, use the following endpoint.

| Method | URI                       | Headers |
| :- |:--------------------------|  :-  |
| PUT/PATCH | `bookmarks/{bookmark.id}` | Default |

### Body

The same body parameters are available as for when creating a bookmark.

### Results

> {success} Code 200 with JSON body of the updated bookmark.


<a name="delete-bookmark"></a>
## Delete a Bookmark

To delete a bookmark, use the following endpoint.

| Method | URI                            | Headers |
| :- |:-------------------------------|  :-  |
| DELETE | `bookmarks/{bookmark.id}` | Default |

### Results

> {success} Code 200 with JSON.
