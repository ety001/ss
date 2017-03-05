== production ==
1. composer install --no-plugins --no-scripts --no-dev
2. php -r "file_exists('.env') || copy('.env.example', '.env');"
3. php artisan key:generate
4. php artisan migrate
5. npm install
6. npm run production

== dev ==
1. composer install
2. php artisan migrate
3. npm install
4. npm run dev
