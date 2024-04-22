.DEFAULT_GOAL := help

up: ## up development environment
	if ! [ -f .env ];then cp .env.example .env;fi
	docker-compose up -d

init-app: ## init php app
	docker-compose run --rm app composer install
	docker-compose run --rm app php artisan key:generate
	docker-compose run --rm app php artisan migrate
	docker-compose run --rm app php artisan db:seed
	docker-compose run --rm app php artisan config:clear
	docker-compose run --rm app php artisan cache:clear
	docker-compose run --rm app npm install
	docker-compose run --rm app npm run build

down: ## down project
	docker-compose down

build: ## build/rebuild development environment
	if ! [ -f .env ];then cp .env.example .env;fi
	docker-compose build

test: ## run tests
	docker-compose run --rm app php artisan test

tinker: ## Run tinker
	docker-compose run --rm php php artisan tinker

helper: ## Run ide-helper for model | example: make helper model="User"
	docker-compose run --rm app php artisan ide-helper:models "App\Models\$(model)" --write

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
