# Running kanka

## Preface

Kanka is built to run on an Nginx and MariaDB stack with the help of Docker. If you have troubles or issues, contact us on the Kanka [Discord](https://discord.gg/rhsyZJ4) #development-talk channel.

> :warning: **Warning**
>
> This docker setup is meant for developers working on Kanka. **Do not use** this docker setup to host Kanka on the web! It come with 0 security (no root password and all ports open). It is also slower than the normal Kanka as it doesn't include any performance improvements and advanced caching.
>
> This setup works as is for our team running with Docker on MacOS. We only provide limited support for helping people host Kanka locally on Discord from Monday to Friday 9am-4pm (GMT-5).


## Docker

Kanka is setup to run with Docket and [Laravel Sail](https://laravel.com/8.x/sail). It comes with four machines.
* Kanka for running the Kanka PHP application
* Mariadb for the database
* Redis for the cache
* Minio for file storage

### Prerequisite
You need [docker](https://www.docker.com/) installed on your machine.

This Github repository needs to be installed (`git clone`) on your local machine. All commands are to be executed in the kanka folder.

### Set up your config

The first step is to copy `.env.example` to `.env`. This will set up Kanka's default config to run with docker.

Optionally, if you want to change some configs, edit the new `.env` file. In most cases, you don't need to touch anything

### Installing dependencies

Run the following command to install all the depenencies to run Kanka needs to run. This command will start up a small docker to install everthing through [composer](https://getcomposer.org).

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

#### Easier life

To make your life easier, we recommend setting an aslias to the `sail` command.
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

Otherwise, whenever this setup mentions a sail command, replace it with `./vendor/bin/sail`.

### Running Kanka

Everything should now be ready to run all those docker images.

```bash
sail up
```

This will start the docker images. You can use the `-d` command to run the docker images in the background.


#### Bucket setup

First, go to [localhost:9000](http://localhost:9000). This is where your files will be stored. Login with `sail` as the user and `password` as the password.

Create a new bucket called `kanka`. This will redirect you to the new `kanka` bucket. Click on the top right cogwheel icon to access the bucket's config interface. On this page, change the `Access Policy` from `private` to `public`. Without this, uploaded file won't be visible in the browser.

#### Database setup

Now that the bucket is setup, go back to your console run the following commands. The first will set up your security key used to encode session cookies.

```bash
sail artisan key:generate
```

Next is creating the whole database. This database is persistant and survives each time the docker image is restarted.

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


### Shutting down

To stop the docker images, run the following.

```bash
sail down
```

## Debugging

If you're having issues with your local instance, these two methods are your best bet.

### Debug mode

If you're having 500 errors on (localhost:8081)[http://localhost:8081], try the following.

Enable debug mode by editing the `.env` file and replacing `APP_DEBUG=false` with `APP_DEBUG=true`. This will now show the error in the browser.

### Error logs

If you want access to the detailed error logs, execute the following commands.

```bash
sail shell
tail -f storage/logs/laravel.log
```

## Updates

We recommend always running from the `main` branch. You can check which branch you are on by going `git branch` in the kanka root folder on your machine (not in docker). If you want to test new features, you can use the `develop` branch, but it tends to come with bugs and errors, and potential loss of data.

When a new version of kanka is released, from your host machine you want to do `git pull` to get the newest updates. Updates usually include changes to the database, so run the following to run the migrations:

```bash
sail artisan migrate
```

## Sharing your local Kanka

Do not make your Kanka instance accessible to the web! To share your Kanka instance with your friends, use the `sail share` command. Follow the [official documentation](https://laravel.com/docs/8.x/sail#sharing-your-site).

## Differences compared to kanka.io

These developer docker instances are quite different from [kanka.io](https://kanka.io/en-US) that we've listed below.

* No security, no backups
* No support for boosted/superboosted campaigns and subscriber bonuses
* No advanced caching, meaning that as the data grows, the app will become much slower
* No image server that creates thumbnails, meaning the images you uploaded are used by default
* No third-party setup like discord, google/meta/twitter logins, stripe, or analytics
* No support from the Kanka team to debug your local setup
* No emails and no campaign exports are generated
