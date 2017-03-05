== production ==
1. composer install --no-plugins --no-scripts --no-dev
2. php -r "file_exists('.env') || copy('.env.example', '.env');"
3. php artisan key:generate
4. php artisan migrate
5. php artisan db:seed
6. npm install
7. npm run production

== dev ==
1. composer install
2. php artisan migrate
3. php artisan db:seed
4. npm install
5. npm run dev
