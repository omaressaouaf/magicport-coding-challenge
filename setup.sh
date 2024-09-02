#!/bin/bash
echo "Building containers..."
docker-compose up -d --build

echo "Copying .env.example to .env..."
touch .env
cp .env.example .env

echo "Running composer install..."
docker-compose run --rm composer install

echo "Running php artisan key:generate..."
docker-compose run --rm artisan key:generate

echo "Running php artisan migrate:fresh --seed"
docker-compose run --rm artisan migrate:fresh --seed

echo "Running npm install..."
docker-compose run --rm npm install

echo "Setup script executed successfully. you can access the app in http://localhost:8088"
