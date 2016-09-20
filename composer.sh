#!/usr/bin/env bash

docker run --rm --volume "$PWD:/www" tpp2019_cli php composer.phar $*
