# Permission Tests

---

- [Test Permissions](#test-permissions)


<a name="test-permissions"></a>
## Test Permissions

You can test a campaign user's permissions for an entity or an entity type by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `permissions/test` | Default |


### Body

A JSON body containing multiple objects.

```
[
    {
        //Read a specific entity
        "user_id": 3,
        "entity_id": 52,
        "action": 1
    },
    {
        // Create a new character
        "user_id": 3,
        "entity_type_id": 1,
        "action": 3
    }
]
```

| Parameter | Type | Details |
| :- |   :-   |  :-  |
| `user_id` | `integer` | The ID number of the user |
| `entity_type_id` | `integer` | The ID of the entity type, required only when there's no `entity_id` |
| `entity_id` | `integer` | The entity's ID, required only when there's no `entity_type_id` |
| `action` | `integer` | ID of the action to test |

### Actions

| Action | Details |
| :- |  :-  |
| `1` | The user is able to `read` the entity/entity type  |
| `2` | The user is able to `edit` the entity/entity type  |
| `3` | The user is able to `create` the entity type |
| `4` | The user is able to `delete` the entity/entity type |


### Results

```json
{
    "data": [
        {
            "entity_type_id": 1,
            "entity_id": 273,
            "user_id": 30,
            "action": 2,
            "can": 1
        },
        {
            "entity_type_id": 1,
            "entity_id": 273,
            "user_id": 30,
            "action": 1,
            "can": 1
        },
        {
            "entity_type_id": 1,
            "entity_id": null,
            "user_id": 30,
            "action": 1,
            "can": false
        }
    ],
}
```
