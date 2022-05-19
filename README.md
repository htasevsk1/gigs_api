# Gigs API
This is a basic [Laravel](https://laravel.com/) API build using [Laravel Sail](https://laravel.com/docs/9.x/sail), with ```mysql``` and ```devcontainer``` containers.

It consists of: `users`, `companies` and `gigs`.

[Laravel Sanctum](https://laravel.com/docs/9.x/sanctum) is used for token based authentication.

[Laravel Scout](https://laravel.com/docs/9.x/scout) database engine is used for full text search on gigs.

## Local installation
1. Inside the project's root directory, run ```./vendor/bin sail up -d```. This will build the docker containers.
2. Go inside the devcontainer
3. ```cp .env.example .env``` and set your env variables.
4. Run ```php artisan key:generate```
5. Run the migrations ```php artisan migrate:fresh ``` (make sure you have created the DB scheme before running this)

You are all set and ready to go. Have fun!
