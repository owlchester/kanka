- [All statuses](#all-statuses)

# Statuses

Entries of some categories have a status_id property, which designates which status they have.


<a name="all-statuses"></a>
## All Statuses

Campaigns can define statuses for their categories.

| Method | URI                                    | Headers |
| :- |:---------------------------------------|  :-  |
| GET | `campaigns/{campaign.id}/category_statuses` | Default |


### Results
```json
{
    "data": [
        {
            "id": 1,
            "key": "alive",
            "is_default": true,
            "category_id": 1
        },
        {
            "id": 2,
            "key": "missing",
            "is_default": false,
            "category_id": 1
        },
        {
            "id": 3,
            "key": "dead",
            "is_default": false,
            "category_id": 1
        },
        {
            "id": 4,
            "key": "dead",
            "is_default": false,
            "category_id": 20
        },
        {
            "id": 5,
            "key": "extinct",
            "is_default": false,
            "category_id": 20
        },
        {
            "id": 6,
            "key": "destroyed",
            "is_default": false,
            "category_id": 3
        }
    ]
}
```
