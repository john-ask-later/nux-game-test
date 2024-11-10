#!/bin/sh

cp .env.example .env

docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v .:/var/www/html \
  -w /var/www/html \
  laravelsail/php82-composer:latest \
  composer install --ignore-platform-reqs

./vendor/bin/sail build

./vendor/bin/sail up -d

until [ "$(docker inspect -f {{.State.Health.Status}} 'nux-gaming-database')" = "healthy" ]
do
    sleep 3;
    echo "Waiting for database initialization...";
done

./vendor/bin/sail artisan migrate
