# Posts

---

- [All Post Layouts](#post-layouts)

<a name="post-layouts"></a>
## All Post Layouts

You can get a list of all the available post layouts by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `post-layouts` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "code": "abilities",
            "entity_type_id": null,
            "config": null
        },
        {
            "id": 2,
            "code": "assets",
            "entity_type_id": null,
            "config": null
        }
    ]
}
```
