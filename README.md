# Building and Running with Docker
* docker-compose build app && docker-compose up -d
## Building the Docker Image
* Run `docker-compose exec app php artisan key:generate`
* Remove `vendor`, `composer.lock` and re-run `composer install` by running `docker-compose exec app rm -rf vendor composer.lock && docker-compose exec app composer install`
