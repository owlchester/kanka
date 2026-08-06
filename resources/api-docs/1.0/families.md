# Families

---

- [All Families](#all-families)

- [Single Family](#family)
- [Create a Family](#create-family)
- [Update a Family](#update-family)
- [Delete a Family](#delete-family)
- [Family Tree](#family-tree)
- [Create a Family Tree](#create-family-tree)
- [Update a Family Tree](#update-family-tree)
- [Delete a Family Tree](#delete-family-tree)

<a name="all-families"></a>
## All Families

You can get a list of all the families of a campaign by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `families` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/misc/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Adams",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 5,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "status_id": 1,
            "type": "",
            "members": [
              "3"
            ],
            "locations": [
                4
            ]
        }
    ]
}
```

<a name="family"></a>
## Family

To get the details of a single family, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `families/{family.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Adams",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 5,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "status_id": 1,
        "type": "",
        "members": [
          "3"
        ],
        "locations": [
            1
        ]
    }

}
```

> {info} Additional note: `members` represents an array of `characters`.`id`.



<a name="create-family"></a>
## Create a Family

To create a family, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `families` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the family |
| `entry` | `string` | The html description of the family |
| `type` | `string` | The type of family |
| `locations` | `array` | Array of location ids |
| `parent_id` | `integer` | The parent family entityid |
| `status_id` | `integer` | The id of the entity's status from `category_statuses` |
| `tags` | `array` | Array of tag ids |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The family's tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the family is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new family.


<a name="update-family"></a>
## Update a Family

To update a family, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `families/{family.id}` | Default |

### Body

The same body parameters are available as for when creating a family.

### Results

> {success} Code 200 with JSON body of the updated family.


<a name="delete-family"></a>
## Delete a Family

To delete a family, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `families/{family.id}` | Default |

### Results

> {success} Code 200 with JSON.


<a name="family-tree"></a>
## Family Tree

To get the details of a family tree, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `families/{family.id}/tree` | Default |

### Results
```json
{
    "data": {
        "nodes": [
            {
                "id": "7d06c3b9-31d3-4131-b7a9-da4e3b62099f",
                "entity_id": 76,
                "isUnknown": false
            },
            {
                "id": "c1aa22cd-c2e1-47c3-ad3b-d8b09ad60dd9",
                "entity_id": 188,
                "isUnknown": false
            },
            {
                "id": "2d42132a-f95b-41f4-9668-37f76b6f6c01",
                "entity_id": 185,
                "isUnknown": false
            }
        ],
        "edges": [
            {
                "id": "d6af7644-e70d-43ef-a327-79a1f60c75d9",
                "source": "7d06c3b9-31d3-4131-b7a9-da4e3b62099f",
                "target": "c1aa22cd-c2e1-47c3-ad3b-d8b09ad60dd9",
                "type": "partner",
                "role": "Former partner"
            },
            {
                "id": "15119f77-559b-4b95-9db6-9839783b5358",
                "source": "c1aa22cd-c2e1-47c3-ad3b-d8b09ad60dd9",
                "target": "2d42132a-f95b-41f4-9668-37f76b6f6c01",
                "type": "parent",
                "parentage": "unspecified"
            }
        ]
    }
}
```


<a name="create-family-tree"></a>
## Create a Family Tree

To create a family tree, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT | `families/{family.id}/tree` | Default |

### Body

Family trees use a flat graph. Nodes represent people and edges represent relationships. A parent edge is directed from parent to child; a partner edge connects two people without implying parentage. This allows single parents, previous partners, adopted children, and other independent relationships.

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `tree` | `object` (Required) | Object containing `nodes` and `edges` |
| `tree.nodes` | `array` (Required) | People displayed in the tree |
| `tree.nodes.*.id` | `string` (Required) | UUID identifying the node occurrence |
| `tree.nodes.*.entity_id` | `int` or `null` | Character entity represented by the node |
| `tree.nodes.*.isUnknown` | `bool` | If the node represents an unknown person |
| `tree.nodes.*.role` | `string` | Optional node label |
| `tree.nodes.*.colour` | `string` | Optional hex colour |
| `tree.nodes.*.cssClass` | `string` | Optional graph class |
| `tree.nodes.*.visibility` | `integer` | Visibility id: 1 for all, 2 for admins, or 5 for campaign members |
| `tree.edges` | `array` (Required) | Relationships between nodes |
| `tree.edges.*.id` | `string` (Required) | UUID identifying the relationship |
| `tree.edges.*.source` | `string` (Required) | Source node UUID |
| `tree.edges.*.target` | `string` (Required) | Target node UUID |
| `tree.edges.*.type` | `string` (Required) | `partner` or directed `parent` |
| `tree.edges.*.parentage` | `string` | Optional parentage type such as `biological`, `adoptive`, or `foster` |
| `tree.edges.*.role` | `string` | Optional relationship label |
| `tree.edges.*.colour` | `string` | Optional hex colour |
| `tree.edges.*.cssClass` | `string` | Optional graph class |
| `tree.edges.*.visibility` | `integer` | Visibility id |

### Example
```json
{
    "tree": {
        "nodes": [
            {"id": "00000000-0000-4000-8000-000000000001", "entity_id": 76},
            {"id": "00000000-0000-4000-8000-000000000002", "entity_id": 24},
            {"id": "00000000-0000-4000-8000-000000000003", "entity_id": 20},
            {"id": "00000000-0000-4000-8000-000000000004", "entity_id": 14},
            {"id": "00000000-0000-4000-8000-000000000005", "entity_id": null, "isUnknown": true}
        ],
        "edges": [
            {"id": "00000000-0000-4000-8000-000000000006", "source": "00000000-0000-4000-8000-000000000001", "target": "00000000-0000-4000-8000-000000000002", "type": "partner", "role": "Former partner"},
            {"id": "00000000-0000-4000-8000-000000000007", "source": "00000000-0000-4000-8000-000000000001", "target": "00000000-0000-4000-8000-000000000003", "type": "parent"},
            {"id": "00000000-0000-4000-8000-000000000008", "source": "00000000-0000-4000-8000-000000000002", "target": "00000000-0000-4000-8000-000000000003", "type": "parent", "parentage": "adoptive"},
            {"id": "00000000-0000-4000-8000-000000000009", "source": "00000000-0000-4000-8000-000000000003", "target": "00000000-0000-4000-8000-000000000004", "type": "partner"},
            {"id": "00000000-0000-4000-8000-000000000010", "source": "00000000-0000-4000-8000-000000000004", "target": "00000000-0000-4000-8000-000000000005", "type": "parent", "parentage": "foster"}
        ]
    }
}
```
### Results

> {success} Code 200 with JSON body of the new family tree.

<a name="update-family-tree"></a>
## Update a Family Tree

To update a family tree, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `families/{family.id}/tree` | Default |

### Body

The update endpoint for the family tree follows the same rules as the creation endpoint.

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `tree` | `object` (Required) | Object containing `nodes` and `edges`, with the same fields as the create endpoint |

### Results

> {success} Code 200 with JSON body of the new family tree.

<a name="delete-family-tree"></a>
## Delete a Family Tree

To delete a family tree, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `families/{family.id}/tree` | Default |

### Results

> {success} Code 200 with JSON.
