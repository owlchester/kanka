# Running kanka

You can start kanka with docker. The only prerequisite is [docker](https://www.docker.com/).  
Copy the docker env file and update it according to your specific needs:

```bash
cp .docker/env .env
chmod -R a+w public
```

Start the containers with the following command:

```bash
docker-compose up --build
```

Open the url <http://localhost:8001> (8001 is the port by environment variable DOCKER_WEB_PORT).
