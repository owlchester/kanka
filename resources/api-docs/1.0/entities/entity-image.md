## Entity Image

To upload or replace an image of an entity, use the following endpoints.

- [Get Images](#get-image)
- [Upload Image](#upload-image)
- [Remove Image](#remove-image)

<a name="get-image"></a>
## Get an entity's images

To get an entity's images.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
|:-------|   :-   |  :-  |
| GET    | `entities/{entity.id}/image` | Default |


### Results

```json
{
    "image": {
        "uuid": "aaaa-bbbb-0000",
        "full": "{url}",
        "thumbnail": "{40x40 url}"
    },
    "header": {
        "uuid": "aaaa-bbbb-0000",
        "full": "{url}",
        "thumbnail": "{40x40 url}"
    }
}
```

<a name="upload-image"></a>
## Upload an image

Uploading an image to the entity will store it in the campaign's [Gallery](/api-docs/{{version}}/campaigns/images).


| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/image` | Default |


### Body

| Parameter | Type | Detail |
|:----------|   :-   |  :-  |
| `file`    | `stream` | Stream to file uploaded to the timeline |
| `is_header` | `boolean` | If set to `true`, will save the image as the entity's header (premium campaign feature) |

### Example

```
curl --location --request POST 'https://api.kanka.io/1.0/campaigns/{campaign.id}/entities/{entity.id}/image' \
--header 'accept: application/json' \
-- header 'content-type: multipart/form-data' \
--header 'Authorization: Bearer {bearer-token}' \
--form 'file=@"/path/to/image.png"'
```

### Results

```json
{
    "image": {
        "uuid": "aaaa-bbbb-0000",
        "full": "{url}",
        "thumbnail": "{40x40 url}"
    },
    "header": {
        "uuid": "aaaa-bbbb-0000",
        "full": "{url}",
        "thumbnail": "{40x40 url}"
    }
}
```


<a name="remove-image"></a>
## Remove an image

You can unlink an entity from its image. This won't delete the image from the gallery.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/image` | Default |

### Parameters

| Parameter | Type | Detail                                         |
|:----------|   :-   |:-----------------------------------------------|
| `is_header` | `boolean` | If set to `true`, will unlink the header image |


### Results

> {success} Code 200 with JSON body containing the new path to the image and thumbnail
>
