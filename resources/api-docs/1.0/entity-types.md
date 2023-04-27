# Entity Types

---

- [All Entity Types](#all-entity-types)

<a name="all-entity-types"></a>
## All Entity Types

You can get a list of all the entity types an entity can be by using the following endpoint.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entity-types` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "code": "character"
        },
        {
            "id": 2,
            "code": "family"
        },
    ]
}
```
