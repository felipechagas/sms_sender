#!/bin/sh

echo 'Starting the cron daemon...'
service cron start
echo 'Starting the apache server...'
apachectl start
tail -f /var/log/apache2/access.log -f /var/log/apache2/error.log
