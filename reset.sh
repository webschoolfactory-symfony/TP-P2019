#!/usr/bin/env bash

docker-compose run --entrypoint=php cli bin/console doctrine:schema:drop --force
docker-compose run --entrypoint=php cli bin/console doctrine:schema:create
docker-compose run --entrypoint=php cli bin/console hautelook_alice:doctrine:fixtures:load --no-interaction
