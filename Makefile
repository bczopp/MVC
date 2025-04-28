.PHONY: up down build exec-bash test routes composer-install composer-update composer-require

APP_CONTAINER=app

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build
	docker-compose up -d
	docker-compose exec $(APP_CONTAINER) composer install

exec-bash:
	 docker-compose exec app bash

test:
	docker-compose exec app ./vendor/bin/phpunit

# Composer commands
composer-install:
	docker-compose exec $(APP_CONTAINER) composer install

composer-update:
	docker-compose exec $(APP_CONTAINER) composer update


# simply check if its working
call-home:
	curl http://localhost:8080/home
call-home-user:
	curl http://localhost:8080/home/1