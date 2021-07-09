# Troubleshooting

When working wit the Kanka API, several issues can arrise. We've detailed the most common ones on this page.

Please note that the API can't be accessed through your browser by calling the endpoints.

## HTML response instead of JSON

When requesting an endpoint, you will sometimes get HTML instead of a Json response.

```html
<!DOCTYPE html>
<html lang="en">

...
```

The most common case is missing the `content-type: application/json` header.

Another one is if the `Authorization: Bearer <token>` header is missing.

If your request has both of these headers, and you still get HTML as a response, add `accept: application/json` as a header. This might lead to the following `unauthorized` error.

## Unauthorized

If your token is invalid or malformed, you will get the following response.

```json
{
    "message": "Unauthenticated."
}
```

Generate a new token in your [Api settings](https://kanka.io/en/settings/api) and use that new token for your request.

### What causes an invalid token?

Kanka tokens are valid for 100 years by default, but when we update our servers, all tokens get invalidated. This happens about once a year on average.

## 422 Unprocessable Entity
If your `POST`, `PUT` or `PATCH` requests to the API are returning something about a missing required field, even when your body has a the field:
```json
{"message":"The given data was invalid.",
  "errors":{
    "name":["The name field is required."]
  }
}
```

You are probably hitting the kanka.io domain in `http` instead of `https`. For example, the Postman application defaults to http when no scheme is provided.

## Image upload not working

Image upload using a stream currently doesn't work.

## Other issues

For all other issues, join us on [Discord](http://discord.gg/rhsyZJ4) and ask in the `#development-talk` channel where someone from the team or the community will help you out.
