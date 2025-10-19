include .env

first-time-setup:
	$(MAKE) up-build
	docker compose exec app composer install

up:
	docker compose up -d

up-build:
	docker compose up -d --build

down:
	docker compose down

down-volumes:
	docker compose down -v

exec-php:
	docker compose exec app sh

connect-to-db:
	docker compose exec database mysql -u ${DATABASE_USER} -p${DATABASE_PASSWORD} ${MYSQL_DATABASE}

seed-db:
	docker compose cp ./database/seed/dump.sql database:/tmp/dump.sql
	docker compose exec database sh -c "mysql -u root -p\$$MYSQL_ROOT_PASSWORD \$$MYSQL_DATABASE < /tmp/dump.sql"

