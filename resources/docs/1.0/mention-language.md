# Mention Language

When getting an entity from the API, the `parsed_entry` field will translate an entity mention to a Kanka Link. By default, the locale in the URL will be the user's locale property.

You can change this option by providing the following header.

> `kanka-locale`: `en-US`, `fr`, `es` or another
