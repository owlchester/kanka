# Entity Permissions

---

- [All Entity Permissions](#all-entity-permissions)
- [Create an Entity Permission](#create-entity-permissions)

<a name="all-entity-permissions"></a>
## All Entity Permissions

You can get a list of all the entity-permissions of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_permissions` | Default |

### Results
```json
{
    "data": [
        {
            "access": 1,
            "action": 1,
            "created_at": "2022-07-25T16:21:38.000000Z",
            "created_by": null,
            "entity_id": 273,
            "id": 37,
            "is_private": false,
            "role": 115,
            "updated_at": "2022-07-25T17:36:21.000000Z",
            "updated_by": null,
            "user": null
        },
}
```
<a name="create-entity-tag"></a>
## Create an Entity Tag

To create an entity-tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_permissions` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `campaign_role_id` | `integer` (Required) | The campaign role id affected by the permission, only required when theres no user id |
| `user_id` | `integer` (Required) | The id of the user affected by the permission, only required when theres no campaign role id|
| `action` | `integer` (Required) | The code of the action controller by the permission |
| `access` | `boolean` (Required) | Determines if the permission is allowed or forbidden |


### Results

> {success} Code 200 with JSON.
