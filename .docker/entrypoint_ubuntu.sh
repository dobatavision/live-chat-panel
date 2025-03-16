#!/bin/bash

cd /mnt/live-chat-panel

if [ ! -f "composer.phar" ]; then
    wget https://getcomposer.org/download/2.8.6/composer.phar
fi

# cp .env.example .env

service php8.3-fpm start
service nginx start
sleep 2
php composer.phar install

sleep 2

php artisan key:generate

chmod -R 777 /mnt/live-chat-panel/storage
chmod -R 777 /mnt/live-chat-panel/bootstrap/cache

sleep 2
echo "date.timezone = Europe/Sofia" >> /etc/php/8.3/fpm/php.ini

# Restart PHP-FPM to apply the changes
service php8.3-fpm restart

#To be sure that the database is up and running
sleep 10

php artisan migrate
php artisan cache:clear
php artisan view:clear
php artisan route:clear


# echo "* * * * * cd /mnt/live-chat-panel && php artisan schedule:run >> /dev/null 2>&1" | crontab -
# service cron start

sleep 5

# php artisan queue:work --tries=3 --timeout=300 --memory=512

tail -f /dev/null


