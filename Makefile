# Laravel Sail Makefile
# Helper commands to work with Laravel Sail

.PHONY: up down ssh build restart pint

# Default command when just running 'make'
default: help

# Start the Sail environment
up:
	./vendor/bin/sail up -d

# Stop the Sail environment
down:
	./vendor/bin/sail down

# SSH into the application container
ssh:
	./vendor/bin/sail shell

# Restart the containers
restart: down up

pint:
	./vendor/bin/pint -v

phpstan:
	./vendor/bin/phpstan analyse --memory-limit=2G

test-workflow:
	# Run the GitHub Actions workflow locally using act
	# Ensure you have the act tool installed:
	# https://nektosact.com/installation/index.html
	./bin/act  -P ubuntu-latest=kirschbaumdevelopment/laravel-test-runner:8.4 --env-file .env.ci

render-documentation:
	php artisan scribe:generate

test:
	php artisan test --parallel --coverage --min=80

# Display help information
help:
	@echo ""
	@echo "Available commands:"
	@echo "make up        - Start the Sail environment (-d detached mode)"
	@echo "make down      - Stop the Sail environment"
	@echo "make ssh       - SSH into the application container"
	@echo "make build     - Rebuild the containers"
	@echo "make pint      - Run Laravel Pint - opinionated PHP code style fixer"
	@echo "make help      - Display this help information"
	@echo "make test-workflow - Run the GitHub Actions workflow locally"
	@echo "make render-documentation - Render the API documentation"
	@echo "make test      - Run the tests"
	@echo ""