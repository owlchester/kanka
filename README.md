# Miscellany

Miscellany is a collaborative world building and campaign management tool tailored for tabletop RPG players and game masters.

## Installation

After cloning the project, execute the following commands.

```
php artisan voyager:install
php artisan migrate
```

That should cover you. You can now create an account. If you have errors on the dashboard, check that your `roles` table has entries, and that your user has a valid `role_id` value.

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

Assets can be compiled by following the [Laravel Documentation](https://laravel.com/docs/5.5/mix)

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

Development should be done in the `develop` branch, with substaintial new features done in a separate branch.

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
php artisan translations:export
```
