# Rick and Morty Proxy API

A Laravel-based API that serves as a proxy for Rick and Morty show character data. This API returns JSON data and is designed to be accessible by various clients, including mobile applications.

## Features

The API provides the following functionality:
- Browse all characters from the show with pagination
- Load detailed information for a specific character
- Search for characters by name or status

## API Endpoints

| Endpoint                    | Method | Description                                           |
|-----------------------------|--------|-------------------------------------------------------|
| `/api/characters`           | GET    | Get a paginated list of all characters                |
| `/api/characters/{id}`      | GET    | Get detailed information about a specific character   |
| `/api/characters/search`    | GET    | Search for characters by name or status               |

## Technology Stack

- PHP 8.x
- Laravel Framework
- Docker via Laravel Sail

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/rick-and-morty-proxy-api.git
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
