# slim-rest-boilerplate

A PHP-based user-authenticated REST API boilerplate, using:
* [Slim 4 Framework](https://www.slimframework.com/docs/)
* [Doctrine ORM](https://www.doctrine-project.org/)
* [JWT Authentication](https://github.com/tuupola/slim-jwt-auth)
* [JSON Schema Validator] (https://packagist.org/packages/justinrainbow/json-schema)

## Installation
* `git clone https://github.com/gucarletto/slim-rest-boilerplate.git` clone git repo
* `cd slim-rest-boilerplate` change working directory to root project folder
* `composer install` install dependencies
*  create .env file from .env.example with your configurations
* ./vendor/bin/doctrine-migrations diff & ./vendor/bin/doctrine-migrations migrate run initial database migration