<p align="center">Booking System</p>

## About Booking System

Booking system build using laravel framework.

## requirements

    php 7.4
    mysql 
    appcache server
    SQLite for testing
## Laravel installations
    clone repository 
    create local database 
    copy .env, example with name .env add 
    chenge database config on .env DB_DATABASE, DB_USERNAME, DB_PASSWORD
    run the following commands
    cd bus_booking
    composer install
    php artisan jwt:secret
    php artisan migrate
    php artisan test to see unit test result and every thing is okay
    run migration
    php artisan db:seed //to get som dummy data on database .
## Endpoints
`login :`
    http://127.0.0.1:8002/api/v1/login`

        {
        "email" : "test@example.com",
        "password" : "password"
        }

`reserve seat on trip:`
        http://127.0.0.1:8002/api/v1/trips/reservations/1

        {
            "trip_id": 1,
            "seat_id" : 1,
            "departure_line_station_id": 1,
            "arrival_line_station_id" :2
            }`

