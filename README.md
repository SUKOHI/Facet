# Facet
A Larave package to show accessor, mutator and scope of a specific model.  
(This package is for Laravel 5+.)  

# Installation

Execute the following composer command.

    composer require sukohi/facet:2.*

Register the service provider in app.php

    'providers' => [
        ...Others...,  
        Sukohi\Facet\FacetServiceProvider::class,
    ]

Now you can use `facet` command.

# Usage

    php artisan facet User

with namespace

    php artisan facet User App

# License

This package is licensed under the MIT License.

Copyright 2016 Sukohi Kuhoh