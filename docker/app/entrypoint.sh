#!/bin/bash
set -e

: ${WWW_DATA_UID:=`stat -c %u /var/www/html`}
: ${WWW_DATA_GUID:=`stat -c %g /var/www/html`}
: ${XDEBUG:=0}
: ${LOCAL_IP:=none}

# Change www-data's uid & guid to be the same as directory in host
# Fix cache problems
if [ "`id -u www-data`" != "$WWW_DATA_UID" ]; then
    usermod -u $WWW_DATA_UID www-data || true
fi

if [ "`id -u www-data`" != "$WWW_DATA_GUID" ]; then
    groupmod -g $WWW_DATA_GUID www-data || true
fi

# Disabled Xdebug if needed
if [ "$XDEBUG" = "0" ]; then
    rm /usr/local/etc/php/conf.d/xdebug.ini
elif [ ! "$LOCAL_IP" = "none" ]; then
    export XDEBUG_CONFIG="remote_host=${LOCAL_IP}"
fi

php-fpm
