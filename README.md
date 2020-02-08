# Retro Board

Retro Board is an essential tool for retrospective ceremonies.

  - Create boards for the teams
  - Write sticky notes
  - Have fun looking back at your last sprint!

### Changelog/New Features (2020. 02. 06.)

  - On the display page, clear all button have confirmation dialog to prevent accidental board clearing.

### Installation
  
  - Requirements: LEMP Stack (Linux, nginx, MySql, PHP)
  - Clone the repository into the nginx public folder (/var/www/html/)
  - `sudo chown username:username retroboard -R`
  - Create a `.env` file for your deployment based on the given template.
  - Run composer in the folder: `composer install --optimize-autoloader --no-dev`
  - Edit the sample .env file (`.env`) and fill in the required spaces (marked with <edit>)
  - Run: `php artisan migrate`
  - Make sure the folders have the right rights: `sudo chgrp -R www-data storage bootstrap/cache` & `sudo chmod -R ug+rwx storage bootstrap/cache`
  - Generate a key for your deployment: `php artisan key:generate`
  - Reload nginx `sudo systemctl reload nginx`

### .env file to use
```
APP_NAME=retroboard
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://<edit: your-domain-name, eg. example.com>

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=<edit: mysql-server-address>
DB_PORT=3306
DB_DATABASE=<edit: mysql-db-name>
DB_USERNAME=<edit: mysql-db-username>
DB_PASSWORD=<edit: mysql-db-password>

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```