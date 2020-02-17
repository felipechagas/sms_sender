#!/bin/sh

echo 'Starting the cron daemon...'
cron
echo 'Starting the apache server...'
apachectl start
tail -f /var/log/apache2/access.log -f /var/log/apache2/error.log
