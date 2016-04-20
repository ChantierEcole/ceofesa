Docker
======

Installation
------------
Follow the instructions on:
- https://docs.docker.com/linux/ for linux (recommanded)
- https://docs.docker.com/mac/ for mac

Don't forget to install docker-compose: https://docs.docker.com/compose/install/

Configuration
-------------
A `parameters.yml.docker` file containing the necessary parameters is available in `app/config`, you can copy it to `parameters.yml`
You can then run:

``` bash
$ make all
```

This will 
- configure your container with the correct UID&GID for your host system, 
- run `composer install`
- launch our images in the background (`docker-compose up -d`)

Usage
-----

`docker-compose run --rm tools php bin/console YOURCOMMAND` to launch a symfony command (as www-data)
`docker-compose run --rm tools bash` to get a bash session (as www-data)
`docker-compose run --rm tools su YOURCOMMAND` to launch a command (as root)
`docker-compose run --rm tools su` to get a bash session (as root)

`docker-compose run --rm tools mysql` to get a mysql session

(put `alias dc='docker-compose'` in your `~/.bash_aliases` to shorten your commands :) 
