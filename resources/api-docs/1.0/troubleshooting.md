# Troubleshooting

---

- [HTML instead of JSON](#html-response)
- [Unauthorized](#unauthorized)
- [Validation errors](#validation)
- [Rate limits](#rate-limits)
- [Reporting an issue](#reporting)

For the complete list of HTTP statuses, see [Errors](/api-docs/{{version}}/misc/errors).

<a name="html-response"></a>
## HTML instead of JSON

If an API request returns HTML instead of JSON, check the following:

- The URL starts with `https://api.kanka.io/1.0`.
- The request includes `Accept: application/json`.
- The request includes `Authorization: Bearer YOUR_TOKEN`.
- JSON request bodies include `Content-Type: application/json`.
- The token has not expired or been revoked.

The browser address bar cannot send the required bearer header. Use an API client such as `curl`, Postman, or application code.

<a name="unauthorized"></a>
## Unauthorized

If the token is missing, invalid, expired, or malformed, the API returns `401`:

```json
{
    "message": "Unauthenticated."
}
```

Generate a new token from [Profile > API](https://app.kanka.io/settings/api). Check that the token is copied completely and that the request uses `Authorization: Bearer YOUR_TOKEN`.

Tokens expire after 365 days. Revoke a token from the same page if it has been exposed.

<a name="validation"></a>
## Validation errors

`POST`, `PUT`, and `PATCH` requests return `422` when required fields are missing or invalid. The response identifies the fields that need attention:

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ]
    }
}
```

<a name="rate-limits"></a>
## Rate limits

Rate limits are applied per authenticated user. All tokens belonging to the same user share the limit. The current limit is returned by `/profile` as `rate_limit`.

The default is 30 requests per minute and subscribers receive 90. When the limit is exceeded, the API returns `429`. Wait and retry with backoff rather than sending requests in a tight loop.

<a name="reporting"></a>
## Reporting an issue

For other issues, join [Discord](https://discord.gg/rhsyZJ4) and ask in `#development-talk`. Include the HTTP method, endpoint, status code, request body with secrets removed, and response body. Never include your API token.
