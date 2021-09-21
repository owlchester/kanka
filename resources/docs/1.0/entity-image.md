## Entity Image

To upload or replace an image of an entity, use the following endpoints.

- [Upload Image](#upload-image)
- [Remove Image](#remove-image)


<a name="upload-image"></a>
## Upload an image

To upload an entity's image to Kanka.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/image` | Default |


### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `image` | `stream` | Stream to file uploaded to the timeline |

### Example

```
curl --location --request POST 'https://kanka.io/api/1.0/campaigns/{campaign.id}/entities/{entity.id}/image' \
--header 'accept: application/json' \
--header 'Authorization: Bearer {bearer-token}' \
--form 'image=@"/Users/kanka/Pics/Releases/1_2.png"'
```

### Results

> {success} Code 200 with JSON body containing the new path to the image and thumbnail


<a name="remove-image"></a>
## Remove an image

To remove an entity's image from Kanka.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/image` | Default |


### Results

> {success} Code 200 with JSON body containing the new path to the image and thumbnail
>
