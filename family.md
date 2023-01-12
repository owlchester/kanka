# Json
```json
{
    "entities": [
        {
            "id": 1,
            "name": "Adam morley",
            "thumb": "url.png",
            "link": "link/to/entity"
        },
        {
            "id": 2,
            "name": "Sophie Morley",
            "thumb": "url.png",
            "link": "link/to/entity"
        },
        {
            "id": 3,
            "name": "Barbara Morley",
            "thumb": "url.png",
            "link": "link/to/entity"
        },
        {
            "id": 4,
            "name": "Mathew Morley",
            "thumb": "url.png",
            "link": "link/to/entity"
        },
        {
            "id": 5,
            "name": "Lorena Morley",
            "thumb": "url.png",
            "link": "link/to/entity"
        }
    ],
    "nodes": {
        "entity_id": 1,
        "siblings": [
            {
                "entity_id": 2,
                "role": "Wife"
            },
            {
                "entity_id": 3,
                "role": "Ex-wife"
            }
        ],
        "nodes": {
            "entity_id": 3,
            "siblings": [
                {
                    "entity_id": 5,
                    "role": "Husband"
                }
            ],
            "nodes": {
                "entity_id": 4
            }
        }
    }
}
```


# Render

Adam Morley | Sophie Morley (Wife) | Barbara Morley (Ex-wife)

