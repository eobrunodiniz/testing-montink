.PHONY: build up down logs composer-install npm-install artisan-migrate

build:
	docker-compose -f docker-compose.dev.yml build

up:
	docker-compose -f docker-compose.dev.yml up -d

down:
	docker-compose -f docker-compose.dev.yml down

logs:
	docker-compose -f docker-compose.dev.yml logs -f

composer-install:
	docker exec -it merp_app_dev composer install

npm-install:
	docker exec -it merp_app_dev npm install

artisan-migrate:
	docker exec -it merp_app_dev php artisan migrate
