# Campaign Members

---

- [Campaign Members](#campaign-members)
- [Campaign Member](#campaign-member)
- [Add Role To Member](#add-role-to-member)
- [Remove Role From Member](#remove-role-from-member)

<a name="campaign-members"></a>
## Campaign Members

To get a list of all the members of a campaign, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `{{version}}/campaigns/{id}/users` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Ilestis",
            "avatar": "{url}"
        },
        {
            "id": 2,
            "name": "Ilestis Jr.",
            "avatar": "{url}"
        }
    ]
}
```

<a name="campaign-member"></a>
## Campaign Member

To get the info of an specific member of a campaign, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `{{version}}/campaigns/{id}/users/{user_id}` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Ilestis",
            "avatar": "{url}"
        }
    ]
}
```
<a name="add-role-to-member"></a>
## Add Role To Member

To add a role to a member of the campaign, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `{{version}}/campaigns/{id}/users` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `user_id` | `integer` (Required) | The user's id |
| `role_id` | `integer` (Required) | The role's id |


### Results
```json
{
    "data": "role successfully added to user"
}
```

<a name="remove-role-from-member"></a>
## Remove Role From Member

To remove a role from a member of the campaign, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `{{version}}/campaigns/{id}/users` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `user_id` | `integer` (Required) | The user's id |
| `role_id` | `integer` (Required) | The role's id |

### Results
```json
{
    "data": "role successfully removed from user"
}
```
