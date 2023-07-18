# Pagination

---

All endpoint which give a list of entities are automatically paginated. For example, when asking for all [Locations](/api-docs/{{version}}/locations) of a campaign, 15 locations are sent back. A `links` property in the response give you information about the pagination options.

```json
{
  "data": [
      // up to 15 locations
  ],
   "links": {
        "first": "/{{version}}/campaigns/123/locations?page=1",
        "last": "/{{version}}/campaigns/123/locations?page=5",
        "prev": null,
        "next": "/{{version}}/campaigns/123/locations?page=2"
    }
}
```
