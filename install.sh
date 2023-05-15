#!/bin/bash

cd /root/joele
echo "Deploy"
ls
git pull --rebase
docker-compose exec -T app composer install
# docker-compose exec app php artisan db:create
# docker-compose exec app php artisan db:wipe
# docker-compose exec app php artisan migrate:refresh --seed
yes | docker-compose exec -T app php  artisan db:create
yes | docker-compose exec -T app php  artisan migrate
yes | docker-compose exec -T app php artisan storage:link
yes | docker-compose exec -T app php artisan config:cache
yes | docker-compose exec -T app php  artisan cache:clear
yes | docker-compose exec -T app php  artisan view:clear
yes | docker-compose exec -T app php  artisan config:clear
