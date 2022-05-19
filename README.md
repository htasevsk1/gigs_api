# Gigs API
This is a basic [Laravel](https://laravel.com/) API build using [Laravel Sail](https://laravel.com/docs/9.x/sail), with ```mysql``` and ```devcontainer``` containers.

## Local testing
1. Inside the project's root directory, run ```./vendor/bin sail up -d```. This will build the docker containers.
2. Go inside the devcontainer
3. ```cp .env.example .env``` and set your env variables.
4. Run ```php artisan key:generate```
5. Run the migrations ```php artisan migrate:fresh --seed```
