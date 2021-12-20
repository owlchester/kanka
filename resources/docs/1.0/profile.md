# Profile

---

The following endpoint provides simple data about the current user.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `profile` | Default |

### Results

```json
{
    "data": {
        "id": 1,
        "name": "User Name",
        "avatar": "{url}",
        "avatar_thumb": "{url}",
        "locale": "en",
        "timezone": "UTC",
        "date_format": "d.m.Y",
        "default_pagination": 15,
        "last_campaign_id": 1,
        "is_patreon": true
    }
}
```

---
Next up: [Campaigns](/docs/{{version}}/campaigns)
