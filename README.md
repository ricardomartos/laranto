----------

# Laranto ( LARAvel + MageNTO )

## Requirements

In Laravel 9 using PHP 8.1 and MySQL8. 

#### A postman collection and environment is included with the endpoints to play arround.

    postman/Laranto.postman_environment.json
    postman/RESTAPI.postman_collection.json

- ### Create a product-catalog REST api

- ### Create two types of products

  - #### Simple
    - Product Name  
    - Description  
    - SKU  
    - In stock  
    - Price  
    - Tags

  - #### Configurable product that consist of simple products
    - Name
    - Description
    - SKU
    - In Stock
    - Price
    - Tags

- ### Create CRUD endpoints for products

- ### Create endpoint that returns all products in stock

- ### It should be possible to add the same tags to multiple products

- ### Create tests if possible  

  - #### SOLID + RESTful principles should be followed and the code must be PSR-12 compliant

## Installation

Clone the repository

    git clone git@github.com:ricardomartos/laranto.git

Switch to the repo folder

    cd laranto && git checkout main

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Create a host with the name of http://laranto.test and point it to the root directory ( *we'll use laravel [Laravel Valet](https://laravel.com/docs/9.x/valet) for this example* )

    cd <your-repo-path> && valet link laranto.test

You can now access the server at http://laranto.test

    http://laranto.test

**TL;DR command list**

    git clone git@github.com:ricardomartos/laranto.git
    cd laranto
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    cd <your-repo-path> && valet link laranto.test

**Run Tests**

    vendor/bin/phpunit
