#!/bin/bash

rm -rf node_modules package-lock.json
npm install

php artisan serve &
yarn run serve &