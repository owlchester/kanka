- [All Campaign modules](#all-modules)
- [Create a Module](#create-module)
- [Update a Module](#update-module)
- [Delete a Module](#delete-module)

# Entity Types

Entity types, also called `Modules`, are how data is stored in Kanka. Characters are a module. Locations are a module. Gods are a custom module.



<a name="all-modules"></a>
## Campaign modules

Since campaigns have their own configuration, enabling/disabling modules, renaming them, and adding custom modules, you need to pass the campaign ID in the URL.


| Method | URI                                    | Headers |
| :- |:---------------------------------------|  :-  |
| GET/HEAD | `campaigns/{campaign.id}/entity_types` | Default |


### Results
```json
{
    "data": [
        {
            "id": 1,
            "code": "character",
            "singular": "Character",
            "plural": "Characters",
            "icon": "",
            "is_special": false,
            "is_enabled": true,
            "is_nested": false,
            "has_table": false
        },
        {
            "id": 25,
            "code": "god",
            "singular": "God",
            "plural": "Gods",
            "icon": "fa-duotone fa-user-beard-bolt",
            "is_special": true,
            "is_enabled": true,
            "is_nested": true,
            "has_table": true
        }
    ]
}
```

If the campaign has given a module a custom name, it will appear in the Singular and Plural fields. Same for a custom icon (`""` if none is set).

The `is_special` field is used to determine if the module is a custom module.

The `is_nested` field is used to determine if entities in the module have a `parent` nesting concept.

<a name="create-module"></a>
## Create a Module

To create a module, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entity_types` | Default |

### Body

| Parameter            | Type                | Detail                                                                            |
|:---------------------|:--------------------|:----------------------------------------------------------------------------------|
| `singular`           | `string` (Required) | Singular name of entities in this module                                          |
| `plural`             | `string` (Required) | Plural name of entities in this module                                            |
| `icon`               | `string` (Required) | FontAwesome icon for entities in this module                                      |
| `roles`              | `array`   | Pass a bunch of campaign role IDs that get read access to entities of this module |

### Results

> {success} Code 200 with JSON body of the new module.


<a name="update-module"></a>
## Update a Module

To update a module, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entity_types/{entity_type.id}` | Default |

### Body

The same body parameters are available as for when creating a module.

### Results

> {success} Code 200 with JSON body of the updated module.


<a name="delete-module"></a>
## Delete a Module

To delete a module, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entity_types/{entity_type.id}` | Default |

### Results

> {success} Code 200 with JSON.
