#!/bin/bash

UID = $(shell id -u)
DOCKER_PHP = docker-ranking-php
DOCKER_NETWORK = docker-ranking-network

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

init: ## First setup
	$(MAKE) build && $(MAKE) start && $(MAKE) composer-install && $(MAKE) cache-clear && $(MAKE) serve-run

dev: ## Start containers and Symfony server
	$(MAKE) start && $(MAKE) serve-run

stop-all: ## Stop Symfony server and containers
	$(MAKE) serve-stop && $(MAKE) stop

rebuild: ## Rebuild containers and start
	$(MAKE) stop && $(MAKE) build && $(MAKE) start

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

start: ## Start the containers
	docker network create $(DOCKER_NETWORK) || true
	cp --update=none docker-compose.yml.dist docker-compose.yml || true
	cp --update=none .env.dist .env || true
	U_ID=$(UID) docker compose up -d

stop: ## Stop the containers
	U_ID=$(UID) docker compose stop

build: ## Rebuilds all the containers
	docker network create $(DOCKER_NETWORK) || true
	cp --update=none docker-compose.yml.dist docker-compose.yml || true
	cp --update=none .env.dist .env || true
	U_ID=$(UID) docker compose build

bash: ## Bash into the php container
	U_ID=$(UID) docker exec -it --user ${UID} $(DOCKER_PHP) bash

composer-install: ## Installs composer dependencies
	U_ID=$(UID) docker exec --user ${UID} $(DOCKER_PHP) composer install --no-interaction

cache-clear:
	U_ID=$(UID) docker exec -it $(DOCKER_PHP)  php bin/console cache:clear

serve-run: ## Starts the Symfony development server
	U_ID=$(UID) docker exec -it --user ${UID} $(DOCKER_PHP) symfony serve -d --no-tls --allow-all-ip --port=1000

serve-stop: ## Starts the Symfony development server
	U_ID=$(UID) docker exec -it --user ${UID} $(DOCKER_PHP) symfony server:stop

logs: ## Show Symfony logs in real time
	U_ID=$(UID) docker exec -it --user ${UID} $(DOCKER_PHP) symfony server:log

test: ## Run PHPUnit tests
	U_ID=$(UID) docker exec -it --user ${UID} $(DOCKER_PHP) php ./vendor/bin/phpunit --testdox

