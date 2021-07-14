# Menu links

---

- [Menu links](#menu-links)
  - [All Menu links](#all-menu-links)
    - [Results](#results)
  - [Menu link](#menu-link)
    - [Results](#results-1)
  - [Create a Menu link](#create-a-menu-link)
    - [Body](#body)
    - [Results](#results-2)
  - [Update a Menu link](#update-a-menu-link)
    - [Body](#body-1)
    - [Results](#results-3)
  - [Delete a Menu link](#delete-a-menu-link)
    - [Results](#results-4)

<a name="all-menu-links"></a>
## All Menu links

You can get a list of all the menu links of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `menu_links` | Default |

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
           "menu": null,
           "random_entity_type": "character",
           "type": null,
           "tab": "",
           "target": null,
           "dashboard_id": null,
           "created_at": "2020-12-24T00:38:49.000000Z",
           "updated_at": "2020-12-24T00:41:20.000000Z",
           "options": {"is_nested": "1"}
        }
    ]
}
```


<a name="menu-link"></a>
## Menu link

To get the details of a single menu link, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `menu_links/{menu-link.id}` | Default |

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
        "menu": null,
        "random_entity_type": "character",
        "type": null,
        "tab": "",
        "target": null,
        "dashboard_id": null,
        "created_at": "2020-12-24T00:38:49.000000Z",
        "updated_at": "2020-12-24T00:41:20.000000Z",
        "options": {"is_nested": "1"}
    }

}
```


<a name="create-menu-link"></a>
## Create a Menu link

To create a menu link, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `menu_links` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the menu link |
| `entity_id` | `int` (Required without type, random_entity_type, dashboard_id) | Entity id of the menu link |
| `type` | `int` (Required without entity_id, random_entity_type, dashboard_id) | The menu link entity type id |
| `random_entity_type` | `string` (Required without entity_id, type, dashboard_id) | The entity type (singular) for a random entity of that type |
| `dashboard_id` | `int` (Required without entity_id, type, random_entity_type) | The dashboard id |
| `icon` | `string` | Custom icon for boosted campaigns |
| `tab` | `string` | Tab options for the link |
| `filters` | `string` | Filter options for the link |
| `menu` | `string` | Menu options for the link |
| `position` | `int` | Position of the link |
| `is_private` | `boolean` | If the menu link is only visible to admin members of the campaign |
| `options`| `object` | Key/Value pairs for optional parameters, currently allowed Keys : `is_nested:boolean` |

### Results

> {success} Code 200 with JSON body of the new menu link.


<a name="update-menu-link"></a>
## Update a Menu link

To update a menu link, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `menu_links/{menu-link.id}` | Default |

### Body

The same body parameters are available as for when creating a menu link.

### Results

> {success} Code 200 with JSON body of the updated menu link.


<a name="delete-menu-link"></a>
## Delete a Menu link

To delete a menu link, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `menu_links/{menu-link.id}` | Default |

### Results

> {success} Code 200 with JSON.
