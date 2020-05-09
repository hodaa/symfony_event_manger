# Event Manager App
The App has its own RESTful API backend and a modern frontend.

## Installation

```
docker-compose build 
docker-compose up -d
docker-compose exec php sh
docker-compose exec php composer install
docker-compose exec php bin/console doctrine:schema:create
docker-compose run php php bin/console assets:install
docker-compose exec php bin/console doctrine:fixtures:load

```
 

## Dashboard
```
http://localhost/admin

Email:hoda.hussin@gmail
Password :123456

```

##  APi Collection
```
https://www.getpostman.com/collections/b33a43f32a43e683a603
```

## Test
```
php bin/console doctrine:schema:create --env=test
docker-compose exec php  bin/phpunit
```

