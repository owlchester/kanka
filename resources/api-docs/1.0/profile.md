# Profile

---

The following endpoint provides simple data about the current user.


| Method | URI                   | Headers |
| :- |:----------------------|  :-  |
| GET/HEAD | `{{version}}/profile` | Default |

### Results

```json
{
    "data": {
        "id": 1,
        "name": "User Name",
        "avatar": "{url}",
        "avatar_thumb": "{40x40 url}",
        "locale": "en",
        "timezone": "UTC",
        "date_format": "d.m.Y",
        "default_pagination": 15,
        "last_campaign_id": 1,
        "is_subscriber": true,
        "rate_limit": 30
    }
}
```

---
Next up: [Campaigns](/api-docs/{{version}}/campaigns)
