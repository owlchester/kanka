# Requests and Responses

---

- [Base URL](#base-url)
- [Headers](#headers)
- [Request bodies](#request-bodies)
- [Response format](#response-format)
- [HTTP methods](#http-methods)
- [Permissions](#permissions)

<a name="base-url"></a>
## Base URL

Authenticated API requests use:

```text
https://api.kanka.io/1.0
```

The `1.0` segment is the API version. Endpoint pages show paths relative to this base URL unless they include the full prefix.

<a name="headers"></a>
## Headers

Send these headers with every authenticated request:

```http
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

For a JSON request body, add `Content-Type: application/json`. Do not manually set the multipart boundary for file uploads; your HTTP client should set it when sending `multipart/form-data`.

<a name="request-bodies"></a>
## Request bodies

JSON request bodies must be valid JSON and use the field names shown on the endpoint page. `POST`, `PUT`, and `PATCH` requests can return `422 Unprocessable Entity` when required fields are missing or invalid.

Use `PUT` or `PATCH` as documented for each resource. Unless a page says otherwise, `PATCH` is the better choice when changing only some fields.

<a name="response-format"></a>
## Response format

Successful responses generally return JSON. A single resource is normally under `data`:

```json
{
    "data": {
        "id": 123,
        "name": "Example"
    }
}
```

Collections use a `data` array and include `links` and `meta` when paginated. A successful delete may return an empty `204 No Content` response; follow the endpoint page if its response differs.

Dates are returned as ISO 8601 timestamps in UTC unless the endpoint documents another format.

<a name="http-methods"></a>
## HTTP methods

| Method | Typical use |
|:-------|:------------|
| `GET` | Read a collection or resource |
| `POST` | Create a resource or perform an action |
| `PUT` | Replace or update a resource |
| `PATCH` | Partially update a resource |
| `DELETE` | Delete a resource |

Some resource pages list `HEAD` alongside `GET`. The API documentation focuses on the JSON response from `GET`.

<a name="permissions"></a>
## Permissions

Requests are evaluated as the user represented by the bearer token. Tokens do not bypass campaign membership, campaign roles, visibility settings, or entity permissions. See [Permissions and security](/api-docs/{{version}}/setup#permissions-and-security) and [Permissions Test](/api-docs/{{version}}/misc/permissions-test).

See [Errors](/api-docs/{{version}}/misc/errors) when a request does not return the expected response.
