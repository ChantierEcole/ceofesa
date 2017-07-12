#!/usr/bin/env bash

# Add to user 'root' crontab :
# @reboot  /home/admin/update_dyndns_access.sh >/dev/null 2>&1
# 0 * * * * /home/admin/update_dyndns_access.sh >/dev/null 2>&1

# execute `
/sbin/iptables -N ip_chantier_ecole
/sbin/iptables -I INPUT 1 -j ip_chantier_ecole
/sbin/iptables -A ip_chantier_ecole -s localhost -p tcp --dport 3306 -j ACCEPT
/sbin/iptables -A ip_chantier_ecole -s 127.0.0.1 -p tcp --dport 3306 -j ACCEPT
/sbin/iptables -A ip_chantier_ecole -s vps302194.ovh.net -p tcp --dport 3306 -j ACCEPT
/sbin/iptables -A ip_chantier_ecole -s 185.31.148.150 -p tcp --dport 3306 -j ACCEPT
/sbin/iptables -A ip_chantier_ecole -s 176.154.50.188 -p tcp --dport 3306 -j ACCEPT
/sbin/iptables -A ip_chantier_ecole -s 89.92.145.29 -p tcp --dport 3306 -j ACCEPT
/sbin/iptables -A INPUT -p tcp --destination-port 3306 -j DROP
# ` on command line

# Configuration
dyndns_hostname='cqp.ceintranet.org'
ipfile=/home/alex/www/ceofesa/ipfile
servicePort=3306

# Script
IP=`getent hosts cqp.ceintranet.org | awk '{ print $1 }'`
if [ "${#IP}" = "0" ]; then
    echo "Fail to get the IP"
    exit
fi

OLD_IP=""
if [ -a $ipfile ]; then
    OLD_IP=`cat $ipfile`
fi

# on enregistrer la nouvelle ip
    echo $IP>$ipfile

echo "Updates Iptable"
if [ "${#OLD_IP}" != "0" ]; then
    echo "Remove the old rule($OLD_IP)"
    /sbin/iptables -D ip_chantier_ecole -s $OLD_IP/32 -p tcp --dport $servicePort -j ACCEPT
fi
echo "Add the new rule($IP)"
    /sbin/iptables -A ip_chantier_ecole -s $IP/32 -p tcp --dport $servicePort -j ACCEPT
