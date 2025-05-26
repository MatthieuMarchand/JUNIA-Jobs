git fetch
git reset --hard origin/release/main
composer install
php artisan migrate --force
