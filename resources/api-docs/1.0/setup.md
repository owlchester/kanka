# Setup

---

- [API Request](#request)
- [Authentication](#authentication)
- [Endpoints](#endpoints)

<a name="request"></a>
## API Request

Before you can start interacting with the Kanka API, you need to generate a Key by navigating to your [Profile > API](https://app.kanka.io/settings/api) page in the app to generate a `key`.

> {warning} Tokens are valid for 365 days, after which they still show up in your keys but are no longer valid. Never share your tokens with anyone, not even the Kanka team!


<a name="authentication"></a>
## Authentication

Each request to the api requires an `oAuth 2.0` token to identify the user. Tokens can be generated in the user's [profile page](/settings/api).

When calling the API, add the following headers:

```json
    Authorization: Bearer user_token_here
    Content-type: application/json
```

<a name="endpoints"></a>
### Endpoints

> {warning} Please note that all endpoints documented here need to be prefixed with `{{version}}/`. For example, if an endpoint is listed as `campaigns`, you should use `https://api.kanka.io/{{version}}/campaigns`.

### Throttling

The API is set up to allow a maximum of `30` requests per minute per client. When you exceed this limit, you will be greeted with a `429` error code.

[Subscribers](https://kanka.io/pricing) automatically get their limit increased to `90` requests per minute per client..

---
Next up: [Profile](/api-docs/{{version}}/profile)
