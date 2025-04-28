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

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `families` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

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
            "location_id": 4,
            "is_extinct": true,
            "type": "",
            "family_id": 2,
            "members": [
              "3"
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
        "location_id": 1,
        "is_extinct": true,
        "type": "",
        "family_id": 2,
        "members": [
          "3"
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
| `location_id` | `integer` | The family's location id |
| `family_id` | `integer` | The parent family id |
| `is_extinct` | `boolean` | If the family is extinct |
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
    "data": [
        {
            "entity_id": 76,
            "uuid": "7d06c3b9-31d3-4131-b7a9-da4e3b62099f",
            "relations": [
                {
                    "entity_id": 188,
                    "uuid": "c1aa22cd-c2e1-47c3-ad3b-d8b09ad60dd9",
                    "children": [
                        {
                            "entity_id": 185,
                            "colour": "#af5454",
                            "uuid": "2d42132a-f95b-41f4-9668-37f76b6f6c01"
                        }
                    ]
                },
                {
                    "entity_id": 26,
                    "role": "Wife",
                    "colour": "#731515",
                    "visibility": "1",
                    "uuid": "d6af7644-e70d-43ef-a327-79a1f60c75d9",
                    "children": [
                        {
                            "entity_id": 7,
                            "uuid": "15119f77-559b-4b95-9db6-9839783b5358"
                        },
                        {
                            "entity_id": 13,
                            "uuid": "5df4f99c-a192-4b02-a0de-6380a0dbd99a"
                        }
                    ]
                }
            ]
        }
    ]
}
```


<a name="create-family-tree"></a>
## Create a Family Tree

To create a family tree, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT | `families/{family.id}/tree` | Default |

### Body

Because of the recursive nature of the family trees, they work differently than the rest of the entities in Kanka, a tree consists of an array of nodes which in turn can contain an array of child nodes, for offsprings, and relation nodes.

A family tree has to have a parent node, which in turn contains an array with with its related nodes, this nodes can have their respective relations arrays and child arrays, that also contain nodes.

Its worth noting that children can only come from a relation, meaning that only relation nodes can have children arrays, and that only the founder and children can have relations, meaning that only the founder and children nodes can have relations.

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `tree` | `array` (Required) | Array containing all the nodes for the family tree|
| `*.entity_id` | `int` (Required) | The id of the entity represented by the node |
| `*.uuid` | `string` (Required) | A string that identifies the node, this can be left empty or filled with a string, but the array key is required |
| `*.role` | `string` | The relation role of the node |
| `*.colour` | `string` | The hex value of the node's colour |
| `*.cssClass` | `string` | The CSS class for the node |
| `*.visibility` | `integer` | The visibility id for the node, 1 for all, 2 for admins, 3 for admins and self, 4 for self, 5 for campaign members, note that the visibility of the node also applies to all its descendant relations and children |
| `*.isUnknown` | `bool` | If the node shows "Unknown" instead of its entity |
| `*.relations` | `array` (Exclusive to children/founder nodes) | Array containing a node's related nodes |
| `*.children` | `array` (Exclusive to relation nodes) | Array containing the child nodes of a relation |

### Example
```json
{
    "tree": [
        {
            "entity_id": 76,
            "uuid": "1",
            "relations": [
                {
                    "entity_id": 24,
                    "role": "Partner",
                    "uuid": "2",
                    "cssClass": "classname",
                    "children": [
                        {
                            "entity_id": 20,
                            "uuid": "3",
                            "role": "Husband",
                            "relations": [
                                {
                                    "entity_id": 14,
                                    "uuid": "string",
                                    "role": "Partner",
                                    "children": [
                                        {
                                            "entity_id": 26,
                                            "uuid": ""
                                        },
                                        {
                                            "entity_id": 108,
                                            "uuid": ""
                                        }
                                    ]
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]
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
| `tree` | `array` (Required) | Array containing all the nodes for the family tree|
| `*.entity_id` | `int` (Required) | The id of the entity represented by the node |
| `*.uuid` | `string` (Required) | A string that identifies the node, this can be left empty or filled with a string, but the array key is required |
| `*.role` | `string` | The relation role of the node |
| `*.colour` | `string` | The hex value of the node's colour |
| `*.cssClass` | `string` | The CSS class for the node |
| `*.visibility` | `integer` | The visibility id for the node, 1 for all, 2 for admins, 3 for admins and self, 4 for self, 5 for campaign members, note that the visibility of the node also applies to all its descendant relations and children |
| `*.isUnknown` | `bool` | If the node shows "Unknown" instead of its entity |
| `*.relations` | `array` (Exclusive to children/founder nodes) | Array containing a node's related nodes |
| `*.children` | `array` (Exclusive to relation nodes) | Array containing the child nodes of a relation |

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
