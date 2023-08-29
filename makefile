exec_php = docker-compose exec php

build:
	docker-compose up -d --build

migration:
	$(exec_php) bin/console doctrine:migrations:migrate -n

fixtures:
	$(exec_php) bin/console doctrine:fixtures:load -n

composer:
	$(exec_php) composer install

init_db: migration fixtures

up:
	docker-compose up -d
	docker-compose ps

init: build composer init_db

down:
	docker-compose down