# Docker Ubuntu and MySQL
# PHP 8.3.17 / Laravel 12.0.1

## Setup Instructions

1. Clone the repository and navigate to the `.docker` directory:
   ```bash
   git clone https://github.com/dobatavision/live-chat-panel
   cd live-chat-panel/.docker
   ```

2. Build and start the Docker containers:
   ```bash
   cd live-chat-panel/.docker
   docker-compose up --build -d
   ```
    docker-compose version 1.29.2, build unknown

    docker-py version: 5.0.3

    CPython version: 3.12.3

    OpenSSL version: OpenSSL 3.0.13 30 Jan 2024


3. Access the application at [http://localhost:8081](http://localhost:8081)
   You can login from two browsers with different users and open chat beetween them and fun :)
   Automatic open chat modal view when someone send message to you.
   Only Admin can change the data of users 'role' with middleware Spatie.


4. View the logs of the Ubuntu container:
   ```bash
   docker container logs -f ubuntu
   ```

## Useful Commands

Remove all containers, images, networks, and volumes:
```bash
docker rm -f $(docker ps -a -q) && docker rmi $(docker images -q) && docker network prune && docker system prune -a -y && docker volume prune -a -y

service php8.3-fpm restart

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload

```





