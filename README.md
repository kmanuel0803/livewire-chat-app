# Chat application built with Laravel Livewiere

## Installation & Quickstart
1. Clone the repository: `git clone https://github.com/kmanuel0803/livewire-chat-app`
2. Navigate to the project directory: `cd livewire-chat-app`
3. Install the dependencies: `composer install` and `npm install`
4. Create your .env file or run `cp .env.example .env`
5. Run `php artisan key:generate` to sets the APP_KEY value
6. Run `php artisan migrate --seed` to create the tables and run the seeders
7. Run `npm run build` to compile the assets

## Prerequisites
1. Before starting the application, create the database and update the .env for your database and Pusher credentials.
2. Ensure that your PHP version is >= 8.1
2. Ensure that Node.js is installed on your system (must be version 15.0.0 or higher) 

## Usage
To start the service, run the following command:
### `php artisan serve`
