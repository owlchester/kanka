# Entity Permissions

---

- [All Entity Permissions](#all-entity-permissions)
- [Create an Entity Permission](#create-entity-permissions)

<a name="all-entity-permissions"></a>
## All Entity Permissions

You can get a list of all the entity-permissions of an entity by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_permissions` | Default |

### Results
```json
{
    "data": [
        {
            "id": 37,
            "campaign_role_id": 115,
            "user_id": null,
            "action": 1,
            "access": true,
            "created_at": "2022-07-25T16:21:38.000000Z",
            "updated_at": "2022-07-25T17:36:21.000000Z"
        },
}
```
<a name="create-entity-permissions"></a>
## Creating entity permissions

To create an entity permission, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_permissions` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `campaign_role_id` | `integer` (Required) | The campaign role id affected by the permission, only required when there's no user id |
| `user_id` | `integer` (Required) | The id of the user affected by the permission, only required when there's no campaign role id|
| `action` | `integer` (Required) | The code of the action controller by the permission |
| `access` | `boolean` (Required) | Determines if the permission is allowed or forbidden |

### Actions

| ID | Action |
| :- |   :-   |
| `1` | `Read` | 
| `2` | `Edit` | 
| `3` | `Add` | 
| `4` | `Delete` | 
| `5` | `Posts` | 
| `6` | `Perms` |
### Results

> {success} Array with all the newly created permissions.

```json
{
    "data": [
        {
            "id": 37,
            "campaign_role_id": 115,
            "user_id": null,
            "action": 1,
            "access": true,
            "created_at": "2022-07-25T16:21:38.000000Z",
            "updated_at": "2022-07-25T17:36:21.000000Z"
        }
    ],
}
```
