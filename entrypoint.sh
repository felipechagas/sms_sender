#!/bin/sh

apachectl start
tail -f /var/log/apache2/access.log -f /var/log/apache2/error.log
