#!/bin/sh

service cron start

/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf &

echo "Mixpost has started!"

tail -f /dev/null