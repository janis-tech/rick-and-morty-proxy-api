# Rick and Morty Proxy API

A Laravel-based API that serves as a proxy for Rick and Morty show character data. This API returns JSON data and is designed to be accessible by various clients, including mobile applications.

## Features

The API provides the following functionality:
- Browse all characters from the show with pagination (includes search by name and status)
- Load detailed information for a specific character

## API Endpoints

| Endpoint                    | Method | Description                                           |
|-----------------------------|--------|-------------------------------------------------------|
| `/api/v1/characters`           | GET    | Get a paginated list of all characters (supports filtering by name and status)  |
| `/api/v1/characters/{id}`      | GET    | Get detailed information about a specific character   |

## Technology Stack

- PHP 8.4
- Laravel Framework
- Docker via Laravel Sail

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/janis-tech/rick-and-morty-proxy-api.git
   cd rick-and-morty-proxy-api
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Start the Docker containers using Laravel Sail:
   ```bash
   ./vendor/bin/sail up -d
   ```

## Make Commands

This project includes a Makefile with helpful commands to simplify your workflow:

| Command                 | Description                                           |
|-------------------------|-------------------------------------------------------|
| `make up`               | Start the Sail environment in detached mode           |
| `make down`             | Stop the Sail environment                             |
| `make ssh`              | SSH into the application container                    |
| `make restart`          | Restart the containers (shorthand for down + up)      |
| `make pint`             | Run Laravel Pint - opinionated PHP code style fixer   |
| `make phpstan`          | Run PHPStan static analysis with 2GB memory limit     |
| `make test-workflow`    | Run the GitHub Actions workflow locally using act     |
| `make render-documentation` | Generate API documentation with Scribe            |
| `make test`             | Run tests with parallel execution and 80% coverage minimum |
| `make help`             | Display all available make commands                   |

Using these commands helps standardize development workflows and simplifies common tasks.

## API Documentation

API documentation is available after running:
```bash
./vendor/bin/sail artisan scribe:generate
```

After running this command, the documentation will be available at `/docs` endpoint.

## Testing

Run the automated tests:
```bash
./vendor/bin/sail artisan test --parallel --coverage --min=80
```

## Development

This project uses Laravel Sail for local development. To start development, use the following command:
```bash
./vendor/bin/sail up -d
```
