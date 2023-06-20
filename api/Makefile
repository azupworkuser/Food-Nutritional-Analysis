CONTAINER_NAME := NUTRITIONS_PHP
DB_CONTAINER_NAME := NUTRITIONS_DB

init: env build up composer-install migrate

env:
	cat .env.example >> .env

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

composer-install:
	docker exec -it $(CONTAINER_NAME) composer i -v

migrate:
	docker exec -it $(CONTAINER_NAME) php bin/console doctrine:migrations:migrate

sync-fruits:
	docker exec -it $(CONTAINER_NAME) php bin/console app:fruits-fetch

logs:
	docker logs -f $(CONTAINER_NAME)

shell:
	docker exec -it $(CONTAINER_NAME) bash

shell.db:
	docker exec -it $(DB_CONTAINER_NAME) mysql -uroot -proot nutrition_finder
