# Last Sync

---

Instead of calling the API several times with each execution, it is recommended to cache the results in your application and use the `lastSync` parameter on API calls.

### Saving the last sync time

Each API result on `index` endpoint of entities contain a `sync` attribute. This value is based on the Kanka server times (UTC+0).

```json
{
    "data": [],
    "sync": "2020-12-24T19:17:42.207577Z",
    "links": {
    },
    "meta": {
    }
}
```

### lastSync Parameter

When calling an `index` enpoint, for example the `items` endpoint, you can provide the `lastSync` parameter and only get items which have been changed since your last call.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `items/?lastSync=2019-03-21T19:17:42.207577Z` | Default |

### Results

```json
{
    "data": [
        {
            "id": "4",
            "updated_at":  "2019-08-29T13:48:54.000000Z"
        }
    ],
    "sync": "2020-12-24T19:32:42.222036Z",
    "links": {
    },
    "meta": {
    }
}
```
