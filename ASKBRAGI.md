# Ask Bragi

This is the documentation for the Ask Bragi prototype, including set-up and usage.

## Set-up

Bragi uses Prism to interact with the AI provider's api, and a postgres vector db to store vectorized embeds, both of which require some ENV variables to be set.


For the vector DB:
* `VECTOR_DB_HOST` should be set to the host of the vector DB.
* `VECTOR_DB_PORT` should be set to the port of the vector DB.
* `VECTOR_DB_DATABASE` should be set to the name of the vector DB.
* `VECTOR_DB_USERNAME` should be set to a valid username with access to the vector DB.
* `VECTOR_DB_PASSWORD` should be set to the password for the username.

For Prism:
* `PRISM_SERVER_ENABLED` should be set to true to enable the Prsim middleware.
* `OPENAI_API_KEY` should be set to a valid api key for OpenAI.

Extra config:
* `ASKBRAGI_SYSTEM_PROMPT` should be set to the system prompt, which sets up the behaviour of the AI, a valid example could be `"You are the lorekeeper of this campaign. You only answer questions, and answer based only on the following campaign content provided: "`
