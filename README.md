# Miscellany

[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![Patreon](https://img.shields.io/badge/Patreon-Support-orange.svg)](https://patreon.com/kankaio)
[![Discord](https://img.shields.io/discord/413623253366603777.svg)](https://discord.gg/rhsyZJ4)

Miscellany is a collaborative world building and campaign management tool tailored for tabletop RPG players and game masters.

## Installation

After cloning the project, create the following files.

* `.env`
  * `cp .env.example .env`
  * You'll need to fill it out to your needs.
* `public/.htaccess`
  * If on Apache. You can run `cp .htaccess.example public/.htaccess` for quick development on docker.


## Using Vagrant
Make sure you have [composer](https://getcomposer.org), [Vagrant](https://www.vagrantup.com/) and their dependencies installed and walk through the next steps:

Run command `composer install` - This will install all PHP-dependencies of the project

Then for Mac/Linux users, run:

`php vendor/bin/homestead make`

For Windows users, run:

`vendor\\bin\\homestead make`

Now you can run `vagrant up` to start your virtualized local dev environment.

_For more information on Laravel Homestead check [this](https://laravel.com/docs/5.8/homestead) link. We currently use the per-project installation._

You should now be able to `vagrant ssh` into your virtual machine.

Run the commands below after changing directory to `code`.

```
php artisan key:generate
php artisan storage:link
php artisan voyager:install
php artisan migrate
php artisan db:seed
```

That should cover you. You can now create an account. If you have errors on the dashboard, check that your `roles` table has entries, and that your user has a valid `role_id` value.

## Using Docker
follow the step given above for creating the .env file, then modify it by deleting the following:
```bash
DB_HOST=mysql
```
Now add the following lines to your .env file:
```bash
# Docker
DOCKER_WEB_PORT=8000
DOCKER_MYSQL_PORT=3306
```
Start he containers by issuing the following command:
```bash
> docker-compose up -d --build
```
Note that the output stops before the web container is finished with everything that it needs to do so it may appear that everything is ready before you'll get a response from localhost in your browser. You can check the logs to see the status of the scripts that are run once the container is up.
```bash
docker-container logs -t
```


## Concepts

The app revolves around the concept of `Entities`. This are for example:

* Characters
* Items
* Locations

## Structure

Each entity is split between two tables: 

* The `entity` table which contains some generic information available to all entities (name, id)
* A table for the specific data of the entity.

### Sub content
Most entities can have n-to-n relations to other entities.

For example, there are `Relations` that link two entities together, as well as `Attributes` which contains n-to-1 custom data of an entity.

## Assets

Assets can be compiled by following the [Laravel Documentation](https://laravel.com/docs/5.6/mix)

You'll need to install the various npm packages first.
> npm install

Select2 needs to be forced to 4.0.5 because newer builds (4.0.7) break

> npm install select2@4.0.5 --save

The following will produce assets for development

> npm run dev

The following will produce assets for production

> npm run prod  

# Development

The following rules apply when developing the application.

## Issues

All improvement, feature or bug must be related to a ticket on github. Each commit must contain on the first row the name and ticket id of the issue related to the change.

## Standards

Code must follow PSR-4 recommendations.

## Migrations

All migrations should have a working `down()` function. Exceptions are allowed for migrations that alter lots of content.

## GIT

Development should be done on your own fork of the repository in the `develop` branch, with substantial new features done in a separate branch.

**Tagging** is only done on the master branch.

## Production

Once a feature is ready and tested, the admin will merge it into the master branch. There is no auto-deploy to the servers.

# Translations

To work on translations, execute the following command to clean you translations and re-import them.

```php
php artisan translations:reset
php artisan translations:import
```

In the database, change your user's `is_translator` to `true`._Navigate to `/translations` to start working on your translations. Add your new language to `app/config/laravel-translation-manager.php` if needed.

When you are finished, export your changes.

```php
php artisan translations:export *
```


# Database Backup

To backup your database in a gzip file, Kanka uses the [laravel backup manager](https://github.com/backup-manager/larave) execute the following command (adapt to your config)

    php artisan db:backup --database=mysql --destination=s3 --compression=gzip --destinationPath=prod/ --timestamp="d-m-Y"


To restore a db, use the following

    php artisan db:restore

# Testing

The configuration for PHPUnit-Tests is in the file /phpunit.xml. 
Before the first run you have to run
```php
php artisan setupTestDB --env=testing
``` 
to create and setUp the TestDatabase. Also if the Database-Schema changes or new migrations are added, you have to reset the Testing Database with this command.

The Configuration for the TestEnvironment can be found in the File /phpunit.xml and .env.testing.
The Environment-Variables in both files need to be the same.
 
If everything is setup correctly you can run the tests by just calling
```php
phpunit
``` 
in the project directory.
