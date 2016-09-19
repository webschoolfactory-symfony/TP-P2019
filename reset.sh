#!/usr/bin/env bash

docker run --rm -v $PWD:/www --link tpp2019_mysql_1:mysql tpp2019_cli bin/console doctrine:schema:drop --force
docker run --rm -v $PWD:/www --link tpp2019_mysql_1:mysql tpp2019_cli bin/console doctrine:schema:create
docker run --rm -v $PWD:/www --link tpp2019_mysql_1:mysql tpp2019_cli bin/console hautelook_alice:doctrine:fixtures:load --no-interaction
