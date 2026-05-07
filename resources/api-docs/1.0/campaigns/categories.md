- [All Categories](#all-categories)
- [Create a Category](#create-category)
- [Update a Category](#update-category)
- [Delete a Category](#delete-category)
- [Category entries](#category-entries)

# Categories

Categories, previously known as Modules or Entity Types, are how data is stored in Kanka. Characters is a category. Locations is a category. Gods is a custom categoriy.



<a name="all-categories"></a>
## Campaign categories

Since campaigns have their own configuration, enabling/disabling categories, renaming them, and adding custom categories, you need to pass the campaign ID in the URL.

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
            "is_custom": false,
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
            "is_custom": true,
            "is_enabled": true,
            "is_nested": true,
            "has_table": true
        }
    ]
}
```

If the campaign has given a category a custom name, it will appear in the Singular and Plural fields. Same for a custom icon (`""` if none is set).

The `is_custom` field is used to determine if the category is a custom category.

The `is_enabled` field is a Kanka internal field, unrelated to if a category is enabled.

The `is_nested` field is used to determine if entries in the category have a `parent` nesting concept.

<a name="create-category"></a>
## Create a Category

To create a category, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entity_types` | Default |

### Body

| Parameter            | Type                | Detail                                                                            |
|:---------------------|:--------------------|:----------------------------------------------------------------------------------|
| `singular`           | `string` (Required) | Singular name of entities in this category                                          |
| `plural`             | `string` (Required) | Plural name of entities in this category                                            |
| `icon`               | `string` (Required) | FontAwesome icon for entities in this category                                      |
| `roles`              | `array`   | Pass a bunch of campaign role IDs that get read access to entities of this category |

### Results

> {success} Code 200 with JSON body of the new category.


<a name="update-category"></a>
## Update a category

To update a category, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entity_types/{entity_type.id}` | Default |

### Body

The same body parameters are available as for when creating a category.

### Results

> {success} Code 200 with JSON body of the updated category.


<a name="delete-category"></a>
## Delete a category

To delete a category, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entity_types/{entity_type.id}` | Default |

### Results

> {success} Code 200 with JSON.



<a name="category-entries"></a>
## Category entries

To get a list of entries belongs to the category, call the entities endpoint with the [correct filtering](/api-docs/{{version}}/entities#filtering).

| Method | URI                                   | Headers |
| :- |:--------------------------------------|  :-  |
| DELETE | `entities?type_id[]={entity_type.id}` | Default |

