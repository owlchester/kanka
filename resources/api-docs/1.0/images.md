# Images

---

- [All Images](#all-images)
- [Single Image](#image)
- [Create a Image](#create-image)
- [Update a Image](#update-image)
- [Delete a Image](#delete-image)
- [Create a folder](#create-folder)

<a name="all-images"></a>
## All Images

You can get a list of all the images of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `images` | Default |

### Results
```json
{
    "data": [
        {
            "id": "037494f8-1875-4e88-9de9-72efa4bfae11",
            "name": "attr",
            "is_folder": false,
            "folder_id": null,
            "path": "{url}",
            "ext": "png",
            "size": 1147,
            "created_at": "2020-11-15T10:42:38.000000Z",
            "created_by": 1,
            "updated_at": "2020-11-15T10:42:38.000000Z",
            "focus_x": 473,
            "focus_y": 17
        },
        {
            "id": "0acd32f5-3286-4ffe-b82a-4e1e61c455c4",
            "name": "Blablabla Q&amp;A",
            "is_folder": false,
            "folder_id": null,
            "path": "{url}",
            "ext": "jpeg",
            "size": 7201,
            "created_at": "2020-11-15T10:39:11.000000Z",
            "created_by": 1,
            "updated_at": "2020-11-15T10:39:20.000000Z",
            "focus_x": null,
            "focus_y": null
        }
    ]
}
```


<a name="image"></a>
## Image

To get the details of a single image, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `images/{image.id}` | Default |

### Results
```json
{
    "data":
    {
        "id": "0acd32f5-3286-4ffe-b82a-4e1e61c455c4",
        "name": "Blablabla Q&amp;A",
        "is_folder": false,
        "folder_id": null,
        "path": "{url}",
        "ext": "jpeg",
        "size": 7201,
        "created_at": "2020-11-15T10:39:11.000000Z",
        "created_by": 1,
        "updated_at": "2020-11-15T10:39:20.000000Z",
        "focus_x": null,
        "focus_y": null
    }

}
```


<a name="create-image"></a>
## Create a Image

To create a image, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `images` | Default |

### Body

| Parameter         | Type     | Detail                   |
|:------------------|:---------|:-------------------------|
| `folder_id`       | `int`    | The image's folder id    |
| `file[]`          | `stream` | Stream to file uploaded  |
| `visibility_id` | `int`    | Visibility of the image  |


### Results

> {success} Code 200 with JSON body of the new image.


<a name="update-image"></a>
## Update a Image

To update a image, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `images/{image.id}` | Default |

### Body


| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `folder_id` | `integer` | The image's folder id |
| `name` | `string` | The image's name |

### Results

> {success} Code 200 with JSON body of the updated image.


<a name="delete-image"></a>
## Delete a Image

To delete a image, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `images/{image.id}` | Default |

### Results

> {success} Code 200 with JSON.


<a name="create-folder"></a>
## Create a folder

Creating a folder is currently not supported by the Kanka API.
