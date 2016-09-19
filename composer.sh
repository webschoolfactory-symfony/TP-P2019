#!/usr/bin/env bash

docker-compose run --entrypoint=php -d cli composer.phar $*
