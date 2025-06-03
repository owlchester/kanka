# Campaign Roles

---

- [Campaign Roles](#campaign-roles)

<a name="campaign-roles"></a>
## Campaign roles

To get a list of all the roles of a campaign, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `{{version}}/campaigns/{id}/roles` | Default |

### Results
```json
{
    "data": [
        {
            "id": 114,
            "name": "Admin",
            "is_admin": true
        },
        {
            "id": 115,
            "name": "Public",
            "is_admin": false
        },
        {
            "id": 116,
            "name": "Player",
            "is_admin": false
        }
    ]
}
```
