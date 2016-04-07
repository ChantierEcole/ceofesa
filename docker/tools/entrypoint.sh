#!/bin/bash
set -e

: ${WWW_DATA_UID:=`stat -c %u /var/www`}
: ${WWW_DATA_GUID:=`stat -c %g /var/www`}
: ${XDEBUG:=0}
: ${LOCAL_IP:=none}

#export PATH=$PATH:/var/www/html/node_modules/.bin

# Change www-data's uid & guid to be the same as directory in host or the configured one
# Fix cache problems
usermod -u $WWW_DATA_UID www-data || true
groupmod -g $WWW_DATA_GUID www-data || true

# Disable Xdebug if needed
if [ "$XDEBUG" = "0" -o "$1" = "composer" ]; then
    rm /usr/local/etc/php/conf.d/xdebug.ini
elif [ ! "$LOCAL_IP" = "none" ]; then
    export XDEBUG_CONFIG="remote_host=${LOCAL_IP}"
fi

# Execute all commands with user www-data except for superuser access 'su'
if [ "$1" = "composer" ]; then
    su www-data -s /bin/bash -c "`which php` -d memory_limit=-1 `which composer` ${*:2}"
elif [ "$*" = "su" ]; then
    /bin/bash
elif [ "$1" = "su" ]; then
    /bin/bash -c "${*:2}"
elif [ "$1" = "mysql" ]; then
    mysql -u$MYSQL_USER -p$MYSQL_PASSWORD -hdb $MYSQL_DATABASE
elif [ "$1" = "bash" ]; then
    su www-data
else
    su www-data -s /bin/bash -c "$*"
fi
