# Pagination

---

All endpoints that return collections are paginated. The API uses the authenticated user's pagination setting, with API-specific limits:

- Standard users receive 45 records per page.
- Subscribers receive at least 45 records per page and can receive up to 100, depending on their account pagination setting.
- The available account pagination settings are 15, 25, 45, and 100. The API minimum means that 15 and 25 become 45 for API requests.

The current account setting is returned by `/profile` as `default_pagination`. The effective API limit can therefore be inferred from the response's `meta.per_page` value.

Use the `page` query parameter or follow the `links.next` URL until it is `null`. Do not assume that the last page has the same number of records as the first page.

```json
{
  "data": [
      // up to 45 or 100 locations
  ],
  "links": {
    "first": "https://api.kanka.io/1.0/campaigns/123/locations?page=1",
    "last": "https://api.kanka.io/1.0/campaigns/123/locations?page=5",
    "prev": null,
    "next": "https://api.kanka.io/1.0/campaigns/123/locations?page=2"
  },
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 45,
    "total": 201
  }
}
```

Pagination applies to recovery lists and most related-resource collections as well. The response's `meta` object is authoritative for the page size returned by that request.
