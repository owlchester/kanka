# Last Sync

---

Instead of calling the API several times with each execution, it is recommended to cache the results in your application and use the `lastSync` parameter on API calls.

### Saving the last sync time

Each API result on `index` endpoints contains a `sync` attribute.

```json
{
  "data": [],
  "sync": {
        "date": "2019-03-21 19:17:42.207577",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "links": {
    },
    "meta": {
    }
}
```

### lastSync Parameter

When calling an `index` enpoint, for example the `items` endpoint, you can provide the `lastSync` parameter and only get items which have been changed since your last call.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET | `items/?lastSync=2019-03-21T19:17:42.207577` | Default |

### Results

```json
{
    "data": [
        {
            "id": "4",
            "updated_at":  "2019-08-29T13:48:54.000000Z"
        }
    ],
    "sync": {
        "date": "2019-03-21 19:32:42.44021",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "links": {
    },
    "meta": {
    }
}
```