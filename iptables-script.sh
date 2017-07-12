#!/bin/bash

# Add to user 'root' crontab :

# @reboot  /var/www/ceofesa/prod/current/iptables-script.sh >/dev/null 2>&1
# 0 * * * * /var/www/ceofesa/prod/current/iptables-script.sh >/dev/null 2>&1

# RENITIALISER LES IPTABLES
# Flush iptables
iptables -F
iptables -X

# POLITIQUES PAR DEFAULT EN ACCEPT
iptables -P INPUT ACCEPT
iptables -P FORWARD ACCEPT
iptables -P OUTPUT ACCEPT

# Autorise localhost
iptables -A INPUT -p tcp -s localhost --destination-port 3306 -j ACCEPT

# Autorise Widop
iptables -A INPUT -p tcp -s 185.31.148.150 --destination-port 3306 -j ACCEPT

# Autorise Old ip
iptables -A INPUT -p tcp -s vps302194.ovh.net --destination-port 3306 -j ACCEPT
iptables -A INPUT -p tcp -s 176.154.50.188 --destination-port 3306 -j ACCEPT
iptables -A INPUT -p tcp -s 89.92.145.29 --destination-port 3306 -j ACCEPT

# Allow public ip
HOST=cqp.ceintranet.org
IP=$(getent hosts ${HOST} | awk '{ print $1 }')

if [ "${#IP}" != "0" ]; then
    echo "iptables -A INPUT -p tcp -s ${IP} --destination-port 3306 -j ACCEPT"
    iptables -A INPUT -p tcp -s ${IP} --destination-port 3306 -j ACCEPT
fi

# Bloque toutes les autres connexions sur le port 3306
iptables -A INPUT -p tcp --destination-port 3306 -j DROP
