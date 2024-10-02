# Coding assessment

The solution includes :

- WolfItem.php : Item.php wrapper, and refactored WolfService
- All required command line
- Dockerized web service (set up guide below)
- Unit test for WolfService
- For database, we use sqlite
- For performance : Image upload is stored locally first, then upload to Cloud asynchronously

## Requirement: PHP 8.2+
## Set up
### Install libs :
````
composer install
````
### Set up test DB
````
php artisan migrate
php artisan db:seed
````
To completely reset DB, can use `php artisan migrate:fresh`
This include a test user account : `admin@example.com / Passwords : admin`

### Run web server
Via docker - this should be enough
````
docker-compose up --build
````
Or run locally (in case something went wrong with docker), run 2 command in separated window :

- Web server : `php artisan serve`
- Background Worker : `php artisan queue:work`

Web server will be running on `localhost:8000`
## Command 
These command can be run on host or inside docker
### Simple test 
Create fake item and apply update on them, then print result to check logic
````
php artisan app:simple-check
````
### Import from URL
````
php artisan app:import-from-url
````
### Update all item in DB by 1 day
````
php artisan app:update-all-items
````

## Web server endpoint

### Get list item
`/api/products`
### Add image
`localhost:8000/api/products/{id}/upload-image`

Only 1 body field: image

