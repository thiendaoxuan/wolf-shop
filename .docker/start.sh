php artisan storage:link

# Start Laravel built-in server in the background
php artisan serve --host=0.0.0.0 --port=8000 &

# Start the Laravel queue worker in the foreground
php artisan queue:work