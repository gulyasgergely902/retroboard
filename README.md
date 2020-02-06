# Retro Board

Retro Board is an essential tool for retrospective ceremonies.

  - Create boards for the teams
  - Write sticky notes
  - Have fun looking back at your last sprint!

### New Features (2020. 02. 05.)

  - Created a separate repository for the laravel version, from now on this is the only live code!

### Installation
  
  - Requirements: LEMP Stack (Linux, nginx, MySql, PHP)
  - Clone the repository into the nginx public folder (/var/www/html/)
  - `sudo chown username:username retroboard -R`
  - Run composer in the folder: `composer install --optimize-autoloader --no-dev`
  - Edit the sample .env file (`.env`) and fill in the required spaces (marked with <edit>)
  - Run: `php artisan migrate`
  - Make sure the folders have the right rights: `sudo chgrp -R www-data storage bootstrap/cache` & `sudo chmod -R ug+rwx storage bootstrap/cache`
  - Generate a key for your deployment: `php artisan key:generate`
  - Reload nginx `sudo systemctl reload nginx`

