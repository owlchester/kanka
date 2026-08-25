# Errors

---

API errors are returned as JSON when the request includes `Accept: application/json`. The exact error fields can vary by failure type, but the HTTP status is the most reliable way to classify the result.

| Status | Meaning | Typical cause |
|:-------|:--------|:--------------|
| `401` | Unauthenticated | Missing, expired, malformed, or revoked token |
| `403` | Forbidden | The authenticated user lacks the required permission |
| `404` | Not found | The resource does not exist or is not visible to the user |
| `405` | Method not allowed | The URL exists but does not support the HTTP method used |
| `422` | Unprocessable entity | A request field is missing or invalid |
| `429` | Too many requests | The authenticated user's rate limit was exceeded |
| `500` | Server error | An unexpected server-side failure |

## Authentication errors

```json
{
    "message": "Unauthenticated."
}
```

Generate a new token from [Profile > API](https://app.kanka.io/settings/api), check that the `Authorization` header uses the `Bearer` scheme, and ensure the request uses `https://`.

## Validation errors

Validation responses include the invalid fields. For example:

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

The required fields and accepted values are listed on each endpoint page.

## Rate-limit errors

When a user exceeds the per-minute limit, the API returns `429`. Stop sending requests, wait, and retry with backoff. Do not retry immediately in a tight loop.

## HTML instead of JSON

If an API request returns an HTML page, check all of the following:

- The URL starts with `https://api.kanka.io/1.0`.
- The request includes `Accept: application/json`.
- The request includes `Authorization: Bearer YOUR_TOKEN`.
- JSON request bodies include `Content-Type: application/json`.
- The token has not expired or been revoked.

Browser address-bar navigation is not a substitute for an authenticated API request because it cannot send the required bearer header.

For further help, join [Discord](https://discord.gg/rhsyZJ4) and include the endpoint, HTTP method, status code, and a redacted response. Never include your token.
