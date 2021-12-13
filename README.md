# Backend-Test Danilo Brito

## Getting Started

#### Repository clone and configuration
    1 - git clone --branch development git@github.com:danilobol/backend-test.git
    2 - Rename .env.example to .env
    3 - Start the docker enviroment:
```
---------------------------------------
        docker-compose up -d
---------------------------------------
```

#### Setup Laravel project

```
---------------------------------------

        docker exec app-investment composer install
        docker exec app-investment php artisan key:generate
        docker exec app-investment php artisan optimize
        docker exec app-investment php artisan migrate
        docker exec app-investment php artisan db:seed

---------------------------------------

```
#### Use

The API will be available at `localhost:8100` and the database at `localhost:33062`

#### Documentation

Documentation is available at:

```
    localhost:8100/
```

####Tutorial

Read the authentication tutorial:  [`Tutorial.pdf`](/Tutorial.pdf)

#### Detalhes

    - php 8.0
    - laravel 8
    - Swagger
