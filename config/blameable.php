<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Guard
    |--------------------------------------------------------------------------
    |
    | Please specify your default authentication guard to be used by blameable
    | service. You can leave this to null if you're using the default Laravel
    | authentication guard.
    |
    | You can also override this value in model classes to use a different
    | authentication guard for your specific models.
    | IE: Some of your models can only be created / updated by specific users
    | who logged in from a specific authentication guard.
    |
    */

    'guard' => null,

    /*
    |--------------------------------------------------------------------------
    | User Model Definition
    |--------------------------------------------------------------------------
    |
    | Please specify a user model that should be used to setup `creator`
    | and `updater` relationship.
    |
    */

    'user' => \App\User::class,

    /*
    |--------------------------------------------------------------------------
    | The `createdBy` attribute
    |--------------------------------------------------------------------------
    |
    | Please define an attribute to use when recording the creator
    | identifier.
    |
    */

    'createdBy' => 'created_by',

    /*
    |--------------------------------------------------------------------------
    | The `updatedBy` attribute
    |--------------------------------------------------------------------------
    |
    | Please define an attribute to use when recording the updater
    | identifier.
    |
    */

    'updatedBy' => 'updated_by',

    /*
    |--------------------------------------------------------------------------
    | The `deletedBy` attribute
    |--------------------------------------------------------------------------
    |
    | Please define an attribute to use when recording the user
    | identifier who deleted the record. This feature would only work
    | if you are using SoftDeletes in your model.
    |
    */

    'deletedBy' => 'deleted_by',
];
