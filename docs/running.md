# Running kanka

## Preface

Kanka is built to run on an Nginx and MariaDB stack with the help of Docker. If you have troubles or issues, contact us on the Kanka [Discord](https://discord.gg/rhsyZJ4) #development-talk channel.


## Docker

Kanka is setup to run with Docket and [Laravel Sail](https://laravel.com/8.x/sail). It comes with four machines.
* Kanka for running the Kanka PHP application
* Mariadb for the database
* Redis for the cache
* Minio for file storage

### Prerequisite
You need [docker](https://www.docker.com/) installed on your machine.

To make your life easier, we recommend setting an aslias to the `sail` command.
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

Otherwise, whenever this setup mentions a sail command, replace it with `./vendor/bin/sail`.


### Set up your config

Before running anything, copy `.env.example` to `.env`. This will set up Kanka's default config to run with docker.

Optionally, if you want to change some configs, edit the new `.env` file.

### Running Kanka

Everything should now be ready to run all those docker images.

```bash
sail up
```

This will start the docker images. You can use the `-d` command to run the docker images in the background.


#### Set up dependencies

Navigate to the Kanka folder on your local machine and run the following command. This will install all the depenencies to run Kanka in the docker image.

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```


#### Bucket setup

First, go to [localhost:9000](http://localhost:9000). This is where your files will be stored. Login with `sail` as the user and `password` as the password.

Create a new bucket called `kanka`. This will redirect you to the new `kanka` bucket. Click on the top right cogwheel icon to access the bucket's config interface. On this page, change the `Access Policy` from `private` to `public`. Without this, uploaded file won't be visible in the browser.

#### Database setup

Now that the bucket is setup, go back to your console and set up the database.

```bash
sail artisan migrate
```

Next up is setting up the application boilerplates.

```bash
sail artisan db:seed
```

Last optional command is to allow your local env to generate API tokens.

```bash
sail artisan passport:install
```

### Testing

You're now ready to test your app. Navigate to (localhost:8081)[http://localhost:8081] and you should see the Kanka application.



### Updates

We recommend always running from the `main` branch. You can check which branch you are on by going `git branch` in the kanka root folder on your machine (not in docker). If you want to test new features, you can use the `develop` branch, but it tends to come with bugs and errors, and potential loss of data.

When a new version of kanka is released, from your host machine you want to do `git pull` to get the newest updates. Updates usually include changes to the database, so run the following to run the migrations:

```bash
sail artisan migrate
```


### Finishing up

To stop the docker images, run the following.

```bash
sail down
```

