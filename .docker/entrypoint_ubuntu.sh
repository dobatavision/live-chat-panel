#!/bin/bash

cd /mnt/live-chat-panel

if [ ! -f "composer.phar" ]; then
    wget https://getcomposer.org/download/2.8.6/composer.phar
fi

cp .env.example .env

service php8.3-fpm start
service nginx start
sleep 2
php composer.phar install

wget -qO- https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

node -v
npm -v

npm install

# Generate application key
php artisan key:generate

chmod -R 777 /mnt/live-chat-panel/storage
chmod -R 777 /mnt/live-chat-panel/bootstrap/cache

sleep 2
echo "date.timezone = Europe/Sofia" >> /etc/php/8.3/fpm/php.ini

# Restart PHP-FPM to apply the changes
service php8.3-fpm restart

#To be sure that the database is up and running
sleep 10

npm run build

# sleep 2

php artisan migrate
php artisan cache:clear
php artisan view:clear
php artisan route:clear

php artisan db:seed --class=DatabaseSeeder

sleep 5

php artisan reverb:start &
php artisan queue:listen &

tail -f /dev/null &


