# Event Manager App
The App has its own RESTful API backend and a modern frontend.

## Installation

```
docker-compose build 
docker-compose up -d
docker-compose exec php bin/console doctrine:schema:create
docker-compose run php php bin/console assets:install
docker-compose exec php bin/console doctrine:fixtures:load

```
 
##usage

## Dashboard
```
http://localhost/admin
```

## Test
```
docker-compose exec php  bin/phpunit

```

