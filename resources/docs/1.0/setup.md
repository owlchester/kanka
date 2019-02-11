# Setup

---

- [API Request](#request)
- [Authentication](#authentication)
- [Endpoints](#endpoints)

<a name="request"></a>
## API Request

Before you can start interacting with the Kanka API, you need to request access to it by contacting the team. This can be done through [Discord](https://discord.gg/rhsyZJ4).

Once your account has been given access to the API, you can navigate to your `Profile > API` in the app to generate a `key`.

![Api Request](/images/docs/api-request.png)

<a name="authentication"></a>
## Authentication

Each request to the api requires an `oAuth 2.0` token to identify the user. Tokens can be generated in the user's profile page (`/en/settings/api`).

When calling the API, add the following headers:

```json
    Authorization: Bearer user_token_here
    Accept: application/json
```

<a name="endpoints"></a>
### Endpoints

> {warning} Please note that all endpoints documented here need to be prefixed with `api/{{version}}/`. For example, if an endpoint is listed as `campaigns`, you should use `kanka.io/api/{{version}}/campaigns`.

--- 
Next up: [Profile](/docs/{{version}}/profile)