# Vue and Laravel Challenge

## Usage
Copy `.env.example`, renaming to `.env`. That example configuration uses a local sqlite database, so there's no need for any credentials.

Bring the containers up:
```
docker-compose up -d
```

That starts up two service containers suitable for development. "laravel" runs the backend and a basic server, while "vue" handles (re)building the frontend.

You can seed the database using:
```
docker-compose run laravel php artisan migrate:refresh --seed
```
Note that this clears any existing products and quotes data.

You should now be able to access the site at `localhost:8004/products`. If that port is already in use, edit `docker-compose.yml` to publish a different port, and run `docker-compose up -d` again to make that change take effec.

To bring the containers down:
```
docker-compose down
```
