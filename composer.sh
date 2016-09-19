#!/usr/bin/env bash

docker run --rm -v $PWD:/www tpp2019_cli php composer.phar $*
